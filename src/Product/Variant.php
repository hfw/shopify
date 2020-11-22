<?php

namespace Helix\Shopify\Product;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Product;

/**
 * A product variant.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/product-variant
 *
 * @method string   getBarcode              ()
 * @method number   getCompareAtPrice       ()
 * @method string   getCreatedAt            ()
 * @method string   getFulfillmentService   ()
 * @method int      getGrams                ()
 * @method string   getImageId              ()
 * @method string   getInventoryItemId      ()
 * @method string   getInventoryManagement  ()
 * @method string   getInventoryPolicy      ()
 * @method int      getInventoryQuantity    ()
 * @method string   getOption               ()
 * @method int      getPosition             ()
 * @method Price[]  getPresentmentPrices    ()
 * @method number   getPrice                ()
 * @method string   getProductId            () injected
 * @method string   getSku                  ()
 * @method string   getTaxCode              ()
 * @method bool     isTaxable               ()
 * @method string   getTitle                ()
 * @method string   getUpdatedAt            ()
 * @method int      getWeight               ()
 * @method string   getWeightUnit           ()
 *
 * @method bool hasPresentmentPrices ()
 *
 * @method $this setBarcode             (string $barcode)
 * @method $this setCompareAtPrice      (number $price)
 * @method $this setCreatedAt           (string $iso8601)
 * @method $this setFulfillmentService  (string $service)
 * @method $this setGrams               (int $grams)
 * @method $this setImageId             (string $id)
 * @method $this setInventoryItemId     (string $id)
 * @method $this setInventoryManagement (string $management)
 * @method $this setInventoryPolicy     (string $policy)
 * @method $this setOption              (string $option)
 * @method $this setPresentmentPrices   (Price[] $prices)
 * @method $this setPrice               (number $price)
 * @method $this setSku                 (string $sku)
 * @method $this setTaxCode             (string $code)
 * @method $this setTaxable             (bool $taxable)
 * @method $this setTitle               (string $title)
 * @method $this setUpdatedAt           (string $iso8601)
 * @method $this setWeight              (int $weight)
 * @method $this setWeightUnit          (string $unit)
 *
 * @method Price[] selectPresentmentPrices (callable $filter) `fn( Price $price ): bool`
 */
class Variant extends AbstractEntity {

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'variant';
    const DIR = 'variants';

    const MAP = [
        'presentment_prices' => [Price::class]
    ];

    const MANAGED_BY_SHOPIFY = 'shopify';

    const POLICY_CONTINUE = 'continue';
    const POLICY_DENY = 'deny';

    protected function _container () {
        return $this->getProduct();
    }

    final protected function _metafieldType (): string {
        return 'product_variant';
    }

    /**
     * @return Product
     */
    public function getProduct () {
        return Product::load($this, $this->getProductId());
    }

}