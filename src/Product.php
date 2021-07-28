<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Product\Image;
use Helix\Shopify\Product\Option;
use Helix\Shopify\Product\Variant;

/**
 * A product.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/products/product
 *
 * @method string       getBodyHtml         ()
 * @method string       getCreatedAt        ()
 * @method string       getHandle           ()
 * @method Image[]      getImages           ()
 * @method Option[]     getOptions          ()
 * @method string       getProductType      ()
 * @method null|string  getPublishedAt      ()
 * @method string       getPublishedScope   ()
 * @method string       getTags             ()
 * @method null|string  getTemplateSuffix   ()
 * @method string       getTitle            ()
 * @method string       getUpdatedAt        ()
 * @method Variant[]    getVariants         ()
 * @method string       getVendor           ()
 *
 * @method bool hasImages   ()
 * @method bool hasOptions  ()
 * @method bool hasVariants ()
 *
 * @method $this setBodyHtml        (string $html)
 * @method $this setHandle          (string $handle)
 * @method $this setImages          (Image[] $images)
 * @method $this setOptions         (Option[] $options)
 * @method $this setProductType     (string $type)
 * @method $this setPublishedAt     (?string $iso8601)
 * @method $this setPublishedScope  (string $scope)
 * @method $this setTags            (string $tags)
 * @method $this setTemplateSuffix  (?string $suffix)
 * @method $this setTitle           (string $title) @depends required
 * @method $this setVariants        (Variant[] $variants)
 * @method $this setVendor          (string $vendor)
 *
 * @method Image[]      selectImages    (callable $filter) `fn( Image $image ): bool`
 * @method Option[]     selectOptions   (callable $filter) `fn( Option $option ): bool`
 * @method Variant[]    selectVariants  (callable $filter) `fn( Variant $variant ): bool`
 */
class Product extends AbstractEntity
{

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'product';
    const DIR = 'products';

    const MAP = [
        'image' => Image::class,
        'images' => [Image::class],
        'options' => [Option::class],
        'variants' => [Variant::class]
    ];

    /**
     * @return Image
     */
    public function newImage()
    {
        return $this->api->factory($this, Image::class, [
            'product_id' => $this->getId()
        ]);
    }

    /**
     * @return Option
     */
    public function newOption()
    {
        return $this->api->factory($this, Option::class, [
            'product_id' => $this->getId()
        ]);
    }

    /**
     * @return Variant
     */
    public function newVariant()
    {
        return $this->api->factory($this, Variant::class, [
            'product_id' => $this->getId()
        ]);
    }

}