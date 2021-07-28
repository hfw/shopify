<?php

namespace Helix\Shopify\AbandonedCheckout;

use Helix\Shopify\AbandonedCheckout;
use Helix\Shopify\Base\Data;

/**
 * An applied discount in an {@link AbandonedCheckout}
 *
 * @method number   getAmount           ()
 * @method string   getCode             ()
 * @method string   getCreatedAt        () ISO8601
 * @method string   getType             () See the type constants.
 * @method string   getUpdatedAt        () ISO8601
 * @method string   getUsageCount       ()
 */
class Discount extends Data
{

    const TYPE_FIXED_AMOUNT = 'fixed_amount';
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_SHIPPING = 'shipping';

}