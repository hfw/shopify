<?php

namespace Helix\Shopify\Base;

use Base\Data\JsonSerializableTrait;
use Base\Data\MagicMethodTrait;
use Helix\Shopify\Api;
use Helix\Shopify\Api\Pool;
use JsonSerializable;
use Serializable;

/**
 * A data-object supporting annotated magic access.
 */
class Data extends \Base\Data implements JsonSerializable, Serializable {

    use MagicMethodTrait;
    use JsonSerializableTrait;

    /**
     * @var array
     */
    const MAP = [];

    /**
     * Fields always added to diffs.
     *
     * @var string[]
     */
    const PATCH = [];

    /**
     * @var Api
     */
    protected $api;

    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @param mixed $caller
     * @return Api
     * @internal
     */
    final protected static function _getApi ($caller) {
        if ($caller instanceof self) {
            return $caller->api;
        }
        assert($caller instanceof Api);
        return $caller;
    }

    /**
     * @param Api|Data $caller
     * @param array $data
     */
    public function __construct ($caller, array $data = []) {
        parent::__construct();
        $this->api = self::_getApi($caller);
        $this->pool = $this->api->getPool();
        $this->_setData($data);
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call (string $method, array $args) {
        static $magic = [];
        if (!$call =& $magic[$method]) {
            preg_match('/^([a-z]+)(.+)$/', $method, $call);
            $call[1] = '_' . $call[1];
            if ($call[1] !== '_select') { // _select() calls getters
                $call[2] = preg_replace_callback('/[A-Z]/', function(array $match) {
                    return '_' . lcfirst($match[0]);
                }, lcfirst($call[2]));
            }
        }
        return $this->{$call[1]}($call[2], ...$args);
    }

    /**
     * A factory that also hydrates / caches entities.
     *
     * @param string $class
     * @param mixed $item
     * @return mixed
     */
    protected function _hydrate (string $class, $item) {
        if (!isset($item) or $item instanceof self) {
            return $item;
        }
        // hydrate entities
        if (is_subclass_of($class, AbstractEntity::class)) {
            if (is_string($item)) { // convert ids to lazy stubs
                $item = ['id' => $item];
            }
            return $this->pool->get($item['id'], $this, function() use ($class, $item) {
                return $this->api->factory($this, $class, $item);
            });
        }
        // hydrate simple
        return $this->api->factory($this, $class, $item);
    }

    /**
     * Magic method: `selectField(callable $filter)`
     *
     * Where `Field` has an accessor at `getField()`, either real or magic.
     *
     * This can also be used to select from an arbitrary iterable.
     *
     * @see __call()
     *
     * @param string|iterable $subject
     * @param callable $filter `fn( Data $object ): bool`
     * @param array $args
     * @return array
     */
    protected function _select ($subject, callable $filter, ...$args) {
        if (is_string($subject)) {
            $subject = $this->{'get' . $subject}(...$args) ?? [];
        }
        $selected = [];
        foreach ($subject as $item) {
            if (call_user_func($filter, $item)) {
                $selected[] = $item;
            }
        }
        return $selected;
    }

    /**
     * Clears all diffs and sets all data, hydrating mapped fields.
     *
     * @param array $data
     * @return $this
     */
    protected function _setData (array $data) {
        $this->data = $this->diff = [];
        foreach ($data as $field => $value) {
            $this->_setField($field, $value);
        }
        return $this;
    }

    /**
     * Sets a value, hydrating if mapped, and clears the diff.
     *
     * @param string $field
     * @param mixed $value
     * @return $this
     */
    protected function _setField (string $field, $value) {
        if (isset(static::MAP[$field])) {
            $class = static::MAP[$field];
            if (is_array($class)) {
                $value = array_map(function($each) use ($class) {
                    return $this->_hydrate($class[0], $each);
                }, $value);
            }
            elseif (isset($value)) {
                $value = $this->_hydrate($class, $value);
            }
        }
        $this->data[$field] = $value;
        unset($this->diff[$field]);
        return $this;
    }

    /**
     * Dehydrated JSON encode.
     *
     * @return string
     */
    public function serialize (): string {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array
     */
    public function toArray (): array {
        return array_map(function($value) {
            if ($value instanceof self) {
                return $value->toArray();
            }
            return $value;
        }, $this->data);
    }

    /**
     * @param $serialized
     */
    public function unserialize ($serialized): void {
        $this->data = json_decode($serialized, true);
    }
}