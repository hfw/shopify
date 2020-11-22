<?php

namespace Helix\Shopify\Product;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Base\Money;

/**
 * @method Money getCompareAtPrice  ()
 * @method Money getPrice           ()
 *
 * @method $this setCompareAtPrice  (Money $price)
 * @method $this setPrice           (Money $price)
 */
class Price extends Data {

    const MAP = [
        'price' => Money::class,
        'compare_at_price' => Money::class
    ];
}