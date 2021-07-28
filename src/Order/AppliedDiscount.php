<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Order;

/**
 * A discount application.
 *
 * @see Order
 *
 * @immutable
 *
 * @method string   getAllocationMethod ()
 * @method string   getCode             ()
 * @method string   getDescription      ()
 * @method string   getTargetSelection  ()
 * @method string   getTargetType       ()
 * @method string   getTitle            ()
 * @method string   getType             ()
 * @method number   getValue            ()
 * @method string   getValueType        ()
 */
class AppliedDiscount extends Data
{

    const ALLOCATE_ACROSS = 'across';
    const ALLOCATE_EACH = 'each';
    const ALLOCATE_ONE = 'one';

    const TARGET_SELECT_ALL = 'all';
    const TARGET_SELECT_ENTITLED = 'entitled';
    const TARGET_SELECT_EXPLICIT = 'explicit';

    const TARGET_TYPE_LINE_ITEM = 'line_item';
    const TARGET_TYPE_SHIPPING_LINE = 'shipping_line';

    const TYPE_DISCOUNT_CODE = 'discount_code';
    const TYPE_SCRIPT = 'script';

    const VALUE_TYPE_FIXED_AMOUNT = 'fixed_amount';
    const VALUE_TYPE_PERCENTAGE = 'percentage';
}