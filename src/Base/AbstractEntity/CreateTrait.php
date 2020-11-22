<?php

namespace Helix\Shopify\Base\AbstractEntity;

use Helix\Shopify\Base\AbstractEntity;

/**
 * @mixin AbstractEntity
 */
trait CreateTrait {

    /**
     * The `POST` directory. Defaults to including the container.
     *
     * @return string
     */
    protected function _dir (): string {
        if ($container = $this->_container()) {
            assert($container->hasId());
            return "{$container}/" . static::DIR;
        }
        return static::DIR;
    }

    /**
     * @return $this
     */
    public function create () {
        assert(!$this->hasId());
        $remote = $this->api->post($this->_dir(), [static::TYPE => $this->toArray()]);
        $this->_setData($remote[static::TYPE]);
        $this->_onSave();
        return $this;
    }
}