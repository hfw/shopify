<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Base\Money;

/**
 * An amount of money in different currencies.
 *
 * @method Money getShopMoney ()
 * @method Money getPresentmentMoney ()
 */
class Funds extends Data {

    const MAP = [
        'shop_money' => Money::class,
        'presentment_money' => Money::class
    ];
}