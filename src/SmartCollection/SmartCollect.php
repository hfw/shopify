<?php

namespace Helix\Shopify\SmartCollection;

use Helix\Shopify\Collection\AbstractCollect;
use Helix\Shopify\Product;
use Helix\Shopify\SmartCollection;

/**
 * A link between a {@link SmartCollection} and a {@link Product}.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/collect
 *
 * @see SmartCollection::newCollect()
 */
class SmartCollect extends AbstractCollect {

    /**
     * @return SmartCollection
     */
    public function getCollection () {
        return SmartCollection::load($this, $this->getCollectionId());
    }
}