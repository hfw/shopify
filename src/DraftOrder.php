<?php

namespace Helix\Shopify;

use Helix\Shopify\DraftOrder\Discount;
use Helix\Shopify\DraftOrder\Invoice;
use Helix\Shopify\Order\AbstractOrder;
use Helix\Shopify\Order\OrderItem;
use Helix\Shopify\Order\Shipping;

/**
 * A draft order.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/draftorder
 *
 * @method $this setUseCustomerDefaultAddress   (bool $flag) @depends create-only
 *
 * @method null|Discount    getAppliedDiscount  ()
 * @method string           getCompletedAt      ()
 * @method string           getCustomerId       () injected
 * @method string           getInvoiceSentAt    ()
 * @method $this            setInvoiceSentAt    (string $iso8601)
 * @method string           getInvoiceUrl       ()
 * @method string           getOrderId          ()
 * @method null|Shipping    getShippingLine     ()
 * @method $this            setShippingLine     (?Shipping $shipping)
 * @method string           getStatus           ()
 * @method bool             isTaxExempt         ()
 *
 * @method $this setTaxExempt   (bool $exempt)
 * @method $this setLineItems   (OrderItem[] $items)
 */
class DraftOrder extends AbstractOrder
{

    const TYPE = 'draft_order';
    const DIR = 'draft_orders';

    const MAP = parent::MAP + [
        'applied_discount' => Discount::class,
        'discount' => Discount::class,
        'shipping_line' => Shipping::class,
    ];

    const STATUS_OPEN = 'open';
    const STATUS_INVOICED = 'invoice_sent';
    const STATUS_COMPLETE = 'completed';

    const SEARCH_STATUS_OPEN = 'open';
    const SEARCH_STATUS_INVOICED = 'invoice_sent';
    const SEARCH_STATUS_COMPLETE = 'completed';

    /**
     * @param bool $paymentPending
     * @return $this
     */
    public function complete(bool $paymentPending = false)
    {
        assert($this->hasId());
        $remote = $this->api->put("{$this}/complete", [
            'payment_pending' => ['false', 'true'][$paymentPending]
        ]);
        $this->_setData($remote[self::TYPE]);
        $this->_onSave();
        return $this;
    }

    /**
     * @param Invoice|null $invoice
     * @return $this
     */
    public function sendInvoice(Invoice $invoice = null)
    {
        assert($this->hasId());
        $this->api->post("{$this}/send_invoice", [
            'draft_order_invoice' => $invoice ? $invoice->toArray() : (object)[]
        ]);
        return $this->reload();
    }
}