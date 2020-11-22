<?php

namespace Helix\Shopify\Base\AbstractEntity;

use Helix\Shopify\Base\AbstractEntity;

/**
 * @mixin AbstractEntity
 */
trait DeleteTrait {

    public function delete (): void {
        assert($this->hasId());
        $this->api->delete($this);
        $this->_onDelete();
    }
}