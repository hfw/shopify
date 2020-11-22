<?php

namespace Helix\Shopify\Collection;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\CustomCollection;
use Helix\Shopify\Product;
use Helix\Shopify\SmartCollection;

/**
 * Abstract for collections.
 *
 * @see CustomCollection
 * @see SmartCollection
 *
 * @method string       getBodyHtml         ()
 * @method string       getHandle           ()
 * @method null|Image   getImage            ()
 * @method null|string  getPublishedAt      ()
 * @method string       getPublishedScope   () `web|global`, read-only for custom collections.
 * @method string       getSortOrder        () See the sort constants.
 * @method string       getTemplateSuffix   ()
 * @method string       getTitle            ()
 * @method string       getUpdatedAt        ()
 *
 * @method $this        setBodyHtml         (string $html)
 * @method $this        setHandle           (string $handle)
 * @method $this        setImage            (?Image $image)
 * @method $this        setSortOrder        (string $order) See the sort constants.
 * @method $this        setTemplateSuffix   (string $suffix)
 * @method $this        setTitle            (string $title)
 */
abstract class AbstractCollection extends AbstractEntity {

    use CrudTrait;
    use MetafieldTrait;

    const SCOPE_WEB = 'web';
    const SCOPE_GLOBAL = 'global';

    const SORT_ALPHA_ASC = 'alpha-asc';
    const SORT_ALPHA_DESC = 'alpha-desc'; // shopify docs have a typo. it's desc.
    const SORT_BEST_SELLING = 'best-selling';
    const SORT_CREATED = 'created';
    const SORT_CREATED_DESC = 'created-desc';
    const SORT_MANUAL = 'manual';
    const SORT_PRICE_ASC = 'price-asc';
    const SORT_PRICE_DESC = 'price-desc';

    const MAP = [
        'image' => Image::class,
    ];

    /**
     * @param Product $product
     * @return AbstractCollect
     */
    abstract public function newCollect (Product $product);

    /**
     * @return Product[]
     */
    public function getProducts () {
        return Product::loadAll($this, "collections/{$this->getId()}/products");
    }
}