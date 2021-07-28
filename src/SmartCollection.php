<?php

namespace Helix\Shopify;

use Helix\Shopify\Collection\AbstractCollection;
use Helix\Shopify\Collection\Image;
use Helix\Shopify\SmartCollection\Rule;
use Helix\Shopify\SmartCollection\SmartCollect;

/**
 * A smart collection.
 *
 * @see  SmartCollection
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/smartcollection
 *
 * @method string   isDisjunctive                   ()
 * @method int      getProductsManuallySortedCount  ()
 * @method Rule[]   getRules                        ()
 *
 * @method $this    setDisjunctive                  (bool $disjunctive)
 * @method $this    setPublishedScope               (string $scope) `web|global`
 * @method $this    setRules                        (Rule[] $rules)
 */
class SmartCollection extends AbstractCollection
{

    const TYPE = 'smart_collection';
    const DIR = 'smart_collections';

    const MAP = [
        'image' => Image::class,
        'rules' => [Rule::class],
    ];

    /**
     * @param Product $product
     * @return SmartCollect
     */
    public function newCollect(Product $product)
    {
        return $this->api->factory($this, SmartCollect::class, [
            'collection_id' => $this->getId(),
            'product_id' => $product->getId()
        ]);
    }

    /**
     * @return Rule
     */
    public function newRule()
    {
        return $this->api->factory($this, Rule::class);
    }
}