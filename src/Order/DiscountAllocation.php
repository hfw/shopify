<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;

/**
 * Discount amounts allocated to an order item.
 *
 * @method string   getAmount                   ()
 * @method Funds    getAmountSet                ()
 * @method int      getDiscountApplicationIndex ()
 */
class DiscountAllocation extends Data
{

    const MAP = [
        'amount_set' => Funds::class
    ];
}