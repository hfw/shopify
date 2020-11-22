<?php

namespace Helix\Shopify\CustomCollection;

use Helix\Shopify\Collection\AbstractCollect;
use Helix\Shopify\CustomCollection;
use Helix\Shopify\Product;

/**
 * A link between a {@link CustomCollection} and a {@link Product}.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/collect
 *
 * @see CustomCollection::newCollect()
 *
 * @method $this setPosition (int $position) @depends create-only, the custom collection must be set to sort manually.
 * @method $this setSortValue (int $value) @depends create-only, the custom collection must be set to sort manually.
 */
class CustomCollect extends AbstractCollect {

    /**
     * @return CustomCollection
     */
    public function getCollection () {
        return CustomCollection::load($this, $this->getCollectionId());
    }

}