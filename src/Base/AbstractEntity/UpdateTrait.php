<?php

namespace Helix\Shopify\Base\AbstractEntity;

use Helix\Shopify\Base\AbstractEntity;

/**
 * @mixin AbstractEntity
 */
trait UpdateTrait {

    /**
     * @return $this
     */
    public function update () {
        assert($this->hasId());
        if ($this->isDiff()) {
            $remote = $this->api->put($this, [static::TYPE => $this->toDiff()]);
            $this->_setData($remote[static::TYPE]);
            $this->_onSave();
        }
        return $this;
    }
}