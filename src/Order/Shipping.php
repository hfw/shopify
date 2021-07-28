<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\DraftOrder;
use Helix\Shopify\Order;

/**
 * A shipping line.
 *
 * @see Order
 * @see DraftOrder
 *
 * @method string   getCarrierIdentifier            ()                  @only Order
 * @method string   getCode                         ()                  @only Order
 * @method $this    setCode                         (string $code)      @only Order
 * @method bool     isCustom                        ()                  @only DraftOrder
 * @method $this    setCustom                       (bool $custom)      @only DraftOrder
 * @method string   getDiscountedPrice              ()                  @only Order
 * @method $this    setDiscountedPrice              (string $price)     @only Order
 * @method Funds    getDiscountedPriceSet           ()                  @only Order
 * @method string   getHandle                       ()                  @only DraftOrder
 * @method $this    setHandle                       (string $handle)    @only DraftOrder
 * @method string   getPrice                        ()
 * @method $this    setPrice                        (string $price)
 * @method Funds    getPriceSet                     ()                  @only Order
 * @method string   getRequestedFulfillmentServiceId()                  @only Order
 * @method string   getSource                       ()                  @only Order
 * @method Tax[]    getTaxLines                     ()                  @only Order
 * @method string   getTitle                        ()
 * @method $this    setTitle                        (string $title)
 */
class Shipping extends Data
{

    const MAP = [
        'discounted_price_set' => Funds::class,
        'price_set' => Funds::class,
        'tax_lines' => Tax::class,
    ];
}