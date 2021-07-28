<?php

namespace Helix\Shopify\Order\Refund;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Order\Funds;

/**
 * A refund adjustment.
 *
 * @see https://help.shopify.com/en/api/reference/orders/refund
 *
 * @immutable
 *
 * @method string   getAmount       ()
 * @method Funds    getAmountSet    ()
 * @method string   getId           ()
 * @method string   getKind         ()
 * @method string   getOrderId      ()
 * @method string   getReason       ()
 * @method string   getRefundId     ()
 * @method string   getTaxAmount    ()
 * @method Funds    getTaxAmountSet ()
 */
class Adjustment extends Data
{

    const MAP = [
        'amount_set' => Funds::class,
        'tax_amount_set' => Funds::class
    ];
}