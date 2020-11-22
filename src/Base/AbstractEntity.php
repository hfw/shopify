<?php

namespace Helix\Shopify\Base;

use Helix\Shopify\Api;
use RuntimeException;

/**
 * An entity with an ID that can be saved, updated, and deleted.
 *
 */
abstract class AbstractEntity extends Data {

    /**
     * All subclasses must redeclare this to match their types.
     *
     * This is also the key used to wrap the instance singularly for API calls.
     */
    const TYPE = '';

    /**
     * All subclasses must redeclare this to match their REST directory (without container).
     *
     * This is also the key used to wrap instance lists for API calls.
     */
    const DIR = '';

    /**
     * @param Api|Data $caller
     * @param string $id
     * @param array $query
     * @return null|static
     */
    public static function load ($caller, string $id, array $query = []) {
        return self::_getApi($caller)->load($caller, static::class, self::DIR . '/' . $id, $query);
    }

    /**
     * @param Api|Data $caller
     * @param string $path
     * @param array $query
     * @return static[]
     */
    public static function loadAll ($caller, string $path, array $query = []) {
        return self::_getApi($caller)->loadAll($caller, static::class, $path, $query);
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     * @internal pool
     */
    final public function __merge (self $entity): bool {
        return false; // todo
    }

    /**
     * @return string
     */
    public function __toString (): string {
        $path = static::DIR . '/' . $this->getId();
        if ($container = $this->_container()) {
            return "{$container}/{$path}";
        }
        return $path;
    }

    /**
     * The container/owner object, if any.
     *
     * @return null|AbstractEntity
     */
    protected function _container () {
        return null;
    }

    /**
     * Lazy-loads missing fields.
     *
     * @param string $field
     * @return mixed
     */
    protected function _get (string $field) {
        if (!array_key_exists($field, $this->data) and $this->hasId()) {
            $this->_reload($field);
        }
        return parent::_get($field);
    }

    protected function _onDelete (): void {
        $this->pool->remove(...$this->getPoolKeys());
    }

    protected function _onSave (): void {
        $this->pool->add($this);
    }

    /**
     * @param string $field
     */
    protected function _reload (string $field): void {
        assert($this->hasId());
        $remote = $this->api->get($this, ['fields' => $field]);
        $this->_setField($field, $remote[static::TYPE][$field]);
        $this->pool->add($this);
    }

    /**
     * @return null|string
     */
    final public function getId (): ?string {
        return $this->data['id'] ?? null;
    }

    /**
     * @return string[]
     */
    public function getPoolKeys () {
        return [$this->getId(), (string)$this];
    }

    /**
     * @return bool
     */
    final public function hasId (): bool {
        return isset($this->data['id']);
    }

    /**
     * Fully reloads the entity from Shopify.
     *
     * @return $this
     */
    public function reload () {
        assert($this->hasId());
        $remote = $this->api->get($this);
        if (!isset($remote[static::TYPE]['id'])) { // deleted?
            $this->pool->remove(...$this->getPoolKeys());
            throw new RuntimeException("{$this} was deleted upstream.");
        }
        $this->_setData($remote[static::TYPE]);
        $this->pool->add($this);
        return $this;
    }
}