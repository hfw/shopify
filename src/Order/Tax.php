<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;

/**
 * A tax.
 *
 * @method string   getPrice    ()
 * @method $this    setPrice    (string $price)
 * @method Funds    getPriceSet ()
 * @method string   getRate     ()
 * @method $this    setRate     (number $rate)
 * @method string   getTitle    ()
 * @method $this    setTitle    (string $title)
 */
class Tax extends Data
{

    const MAP = [
        'price_set' => Funds::class
    ];

}