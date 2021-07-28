<?php

namespace Helix\Shopify\Api;

use Closure;
use Helix\Shopify\Api;
use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\Data;

class Pool
{

    /**
     * @var AbstractEntity[]
     */
    protected $entities = [];

    /**
     * @var string[]
     */
    protected $ids = [];

    protected function _add(AbstractEntity $entity): void
    {
        assert($entity->hasId());
        $this->entities[$entity->getId()] = $entity;
    }

    /**
     * @param AbstractEntity $entity
     * @param string[] $keys
     */
    protected function _addKeys(AbstractEntity $entity, ...$keys): void
    {
        assert($entity->hasId());
        $this->ids += array_fill_keys($keys, $entity->getId());
    }

    /**
     * @param string $key
     * @param Api|Data $caller
     * @return null|AbstractEntity
     */
    protected function _get(string $key, $caller)
    {
        if (isset($this->ids[$key])) {
            return $this->entities[$this->ids[$key]];
        }
        unset($caller);
        return null;
    }

    final public function add(AbstractEntity $entity): void
    {
        if ($entity->hasId() and !$entity->isDiff()) {
            $this->_add($entity);
            $this->_addKeys($entity, $entity->getPoolKeys());
        }
    }

    /**
     * @param string $key
     * @param Api|Data $caller
     * @param Closure $factory `fn( $caller ): ?AbstractEntity`
     * @return null|AbstractEntity
     */
    final public function get(string $key, $caller, Closure $factory)
    {
        /** @var AbstractEntity $entity */
        if (!$entity = $this->_get($key, $caller) and $entity = $factory($caller)) {
            $id = $entity->getId();
            if ($this->has($id) and $pooled = $this->_get($id, $caller)) {
                if ($pooled->__merge($entity)) { // new data?
                    $this->add($pooled); // renew everything
                }
                $this->_addKeys($pooled, $key);
                return $pooled;
            }
            $this->add($entity);
            $this->_addKeys($entity, $key);
        }
        return $entity;
    }

    /**
     * Polls.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->ids[$key]);
    }

    /**
     * @param string[] $keys
     */
    public function remove(...$keys): void
    {
        foreach ($keys as $key) {
            unset($this->entities[$key]);
            unset($this->ids[$key]);
        }
    }
}