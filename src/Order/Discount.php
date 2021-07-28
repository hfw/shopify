<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Order;

/**
 * An order discount.
 *
 * @see Order::newDiscount()
 *
 * @method number getAmount ()
 * @method string getCode   ()
 * @method string getType   ()
 *
 * @method $this setAmount  (number $amount)
 * @method $this setCode    (string $code)
 * @method $this setType    (string $type)
 */
class Discount extends Data
{

    const TYPE_FIXED_AMOUNT = 'fixed_amount';
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_SHIPPING = 'shipping';
}