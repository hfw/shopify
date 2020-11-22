<?php

namespace Helix\Shopify;

use Generator;
use Helix\Shopify\Api\Pool;
use Helix\Shopify\Api\ShopifyError;
use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\Data;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * API access.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference
 */
class Api {

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @param string $domain
     * @param string $key
     * @param string $password
     * @param null|Pool $pool
     */
    public function __construct (string $domain, string $key, string $password, Pool $pool = null) {
        $this->domain = $domain;
        $this->key = $key;
        $this->password = $password;
        $this->pool = $pool ?? new Pool();
    }

    /**
     * @param string $class
     * @param array $query
     * @return Generator|mixed|AbstractEntity[]
     */
    public function advancedSearch (string $class, array $query) {
        $continue = !isset($query['limit']);
        $query['limit'] += ['limit' => 250];
        do {
            $remote = $this->get($class::TYPE . '/search', $query);
            foreach ($remote[$class::DIR] as $data) {
                yield $this->factory($this, $class, $data);
                $query['since_id'] = $data['id'];
            }
        } while ($continue and count($remote) == $query['limit']);
    }

    /**
     * @param string $path
     * @param array $query
     */
    public function delete (string $path, array $query = []): void {
        $path .= '.json';
        if ($query) {
            $path .= '?' . http_build_query($query);
        }
        $this->exec('DELETE', $path);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $curlOpts
     * @return null|array
     */
    public function exec (string $method, string $path, array $curlOpts = []) {
        $this->getLogger()->log(LOG_DEBUG, "{$method} {$path}", $curlOpts);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_URL => "https://{$this->key}:{$this->password}@{$this->domain}/admin/api/2020-04/{$path}",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'hfw/shopify'
        ]);
        $curlOpts[CURLOPT_HTTPHEADER][] = 'Accept: application/json';
        $curlOpts[CURLOPT_HTTPHEADER][] = 'Expect:'; // prevent http 100
        curl_setopt_array($ch, $curlOpts);
        RETRY:
        $res = explode("\r\n\r\n", curl_exec($ch), 2);
        $info = curl_getinfo($ch);
        switch ($info['http_code']) {
            case 0:
                throw new ShopifyError(curl_errno($ch), curl_error($ch), $info);
            case 200:
            case 201:
            case 202:
                return json_decode($res[1], true, 512, JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR);
            case 404:
                return null;
            case 429:
                preg_match('/^Retry-After:\h*(\d+)/im', $res[0], $retry);
                $this->getLogger()->log(LOG_DEBUG, $retry[0]);
                sleep($retry[1]);
                goto RETRY;
            default:
                $error = new ShopifyError($info['http_code'], $res[1], $info);
                $this->getLogger()->log(LOG_ERR, "Shopify {$info['http_code']}: {$error->getMessage()}");
                throw $error;
        }
    }

    /**
     * @param Api|Data $caller
     * @param string $class
     * @param array $data
     * @return mixed
     */
    public function factory ($caller, string $class, array $data = []) {
        return new $class($caller, $data);
    }

    /**
     * @param Api|Data $caller
     * @param string $class
     * @param array[] $list
     * @return array
     */
    public function factoryAll ($caller, string $class, array $list) {
        return array_map(function(array $each) use ($caller, $class) {
            return $this->factory($caller, $class, $each);
        }, $list);
    }

    /**
     * @param string $path
     * @param array $query
     * @return null|array
     */
    public function get (string $path, array $query = []) {
        $path .= '.json';
        if ($query) {
            $path .= '?' . http_build_query($query);
        }
        return $this->exec('GET', $path);
    }

    /**
     * @param string $id
     * @return null|Location
     */
    public function getLocation (string $id) {
        return $this->load($this, Location::class, "locations/{$id}");
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger (): LoggerInterface {
        return $this->logger ?? $this->logger = new NullLogger();
    }

    /**
     * @return User
     */
    public function getMe () {
        return $this->load($this, User::class, 'users/current');
    }

    /**
     * @return Pool
     */
    public function getPool () {
        return $this->pool;
    }

    /**
     * @return Shop
     */
    public function getShop () {
        return $this->load($this, Shop::class, 'shop');
    }

    /**
     * @param Api|Data $caller
     * @param string $class
     * @param string $path
     * @param array $query
     * @return null|mixed|AbstractEntity
     */
    public function load ($caller, string $class, string $path, array $query = []) {
        return $this->pool->get($path, $caller, function($caller) use ($class, $path, $query) {
            if ($remote = $this->get($path, $query)) {
                return $this->factory($caller, $class, $remote[$class::TYPE]);
            }
            return null;
        });
    }

    /**
     * @param Api|Data $caller
     * @param string $class
     * @param string $path
     * @param array $query
     * @return array|Data[]
     */
    public function loadAll ($caller, string $class, string $path, array $query = []) {
        return array_map(function(array $each) use ($caller, $class) {
            return $this->pool->get($each['id'], $caller, function($caller) use ($class, $each) {
                return $this->factory($caller, $class, $each);
            });
        }, $this->get($path, $query)[$class::DIR] ?? []);
    }

    /**
     * @param string $path
     * @param array $data
     * @return null|array
     */
    public function post (string $path, array $data = []) {
        return $this->exec('POST', "{$path}.json", [
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)
        ]);
    }

    /**
     * @param string $path
     * @param array $data
     * @return null|array
     */
    public function put (string $path, array $data = []) {
        return $this->exec('PUT', "{$path}.json", [
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)
        ]);
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    final public function setLogger (LoggerInterface $logger) {
        $this->logger = $logger;
        return $this;
    }

}