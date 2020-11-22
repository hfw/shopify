<?php

namespace Helix\Shopify\Order\Refund;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Order\Funds;
use Helix\Shopify\Order\OrderItem as OrderItem;

/**
 * A refunded item.
 *
 * @see https://help.shopify.com/en/api/reference/orders/refund
 *
 * @method bool             isAlreadyStocked    ()              @when new
 * @method $this            setAlreadyStocked   (bool $stocked) @when new
 * @method string           getId               ()
 * @method null|OrderItem   getLineItem         ()
 * @method string           getLineItemId       ()
 * @method $this            setLineItemId       (string $id)    @when new
 * @method string           getLocationId       ()
 * @method $this            setLocationId       (string $id)    @when new
 * @method int              getQuantity         ()
 * @method $this            setQuantity         (int $quantity) @when new
 * @method string           getRestockType      ()
 * @method $this            setRestockType      (string $type)  @when new
 * @method number           getSubtotal         ()
 * @method Funds            getSubtotalSet      ()
 * @method number           getTotalTax         ()
 * @method Funds            getTotalTaxSet      ()
 */
class RefundItem extends Data {

    const RESTOCK_CANCEL = 'cancel';
    const RESTOCK_LEGACY = 'legacy_restock'; // unusable
    const RESTOCK_NONE = 'no_restock';
    const RESTOCK_RETURN = 'return';

    const MAP = [
        'line_item' => OrderItem::class,
        'subtotal_set' => Funds::class,
        'total_tax_set' => Funds::class
    ];
}