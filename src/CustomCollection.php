<?php

namespace Helix\Shopify;

use Helix\Shopify\Collection\AbstractCollection;
use Helix\Shopify\CustomCollection\CustomCollect;

/**
 * A custom collection.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/customcollection
 *
 * @method bool     isPublished     ()
 * @method $this    setPublished    (bool $published)
 */
class CustomCollection extends AbstractCollection {

    const TYPE = 'custom_collection';
    const DIR = 'custom_collections';

    /**
     * @param Product $product
     * @return CustomCollect
     */
    public function newCollect (Product $product) {
        return $this->api->factory($this, CustomCollect::class, [
            'collection_id' => $this->getId(),
            'product_id' => $product->getId()
        ]);
    }
}