<?php

namespace Helix\Shopify\MarketingEvent;

use Helix\Shopify\Base\Data;
use Helix\Shopify\MarketingEvent;

/**
 * A {@link MarketingEvent} resource.
 *
 * @method string   getId   ()
 * @method string   getType () See the type constants.
 *
 * @method $this    setId   (string $id) Not needed if `type` is `homepage`.
 * @method $this    setType (string $type) See the type constants.
 */
class Resource extends Data
{

    const TYPE_ARTICLE = 'article';
    const TYPE_COLLECTION = 'collection';
    const TYPE_HOMEPAGE = 'homepage';
    const TYPE_PAGE = 'page';
    const TYPE_PRICE_RULE = 'price_rule';
    const TYPE_PRODUCT = 'product';

}