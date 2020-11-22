<?php

namespace Helix\Shopify\Product;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Product;

/**
 * A product image.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/product-image
 *
 * @method $this setAttachment  (string $base64) @depends create-only
 * @method $this setFilename    (string $filename) @depends create-only
 * @method $this setSrc         (string $url) @depends create-only
 *
 * @method string   getCreatedAt    () read-only
 * @method string   getFilename     ()
 * @method int      getHeight       ()
 * @method int      getPosition     ()
 * @method string   getProductId    () injected, read-only
 * @method string   getUpdatedAt    () read-only
 * @method string[] getVariantIds   ()
 * @method int      getWidth        ()
 *
 * @method bool hasVariantIds   ()
 *
 * @method $this setHeight      (int $height)
 * @method $this setPosition    (int $position)
 * @method $this setVariantIds  (string[] $ids)
 * @method $this setWidth       (int $width)
 */
class Image extends AbstractEntity {

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'image';
    const DIR = 'images';

    protected function _container () {
        return $this->getProduct();
    }

    final protected function _metafieldType (): string {
        return 'product_image';
    }

    public function getProduct () {
        return Product::load($this, $this->getProductId());
    }

}