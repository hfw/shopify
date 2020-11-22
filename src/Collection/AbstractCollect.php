<?php

namespace Helix\Shopify\Collection;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Base\AbstractEntity\DeleteTrait;
use Helix\Shopify\Base\AbstractEntity\ImmutableInterface;
use Helix\Shopify\Product;

/**
 * A link between a collection and a product.
 *
 * @immutable Collects can only be created and deleted.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/collect
 *
 * @method string   getCollectionId () injected
 * @method string   getCreatedAt    ()
 * @method string   getPosition     ()
 * @method string   getProductId    () injected
 * @method string   getSortValue    ()
 * @method string   getUpdatedAt    ()
 */
abstract class AbstractCollect extends AbstractEntity implements ImmutableInterface {

    use CreateTrait;
    use DeleteTrait;

    const TYPE = 'collect';
    const DIR = 'collects';

    /**
     * @return AbstractCollection
     */
    abstract public function getCollection ();

    /**
     * @return Product
     */
    public function getProduct () {
        return Product::load($this, $this->getProductId());
    }
}