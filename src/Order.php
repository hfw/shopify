<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Order\AbstractOrder;
use Helix\Shopify\Order\AppliedDiscount;
use Helix\Shopify\Order\Discount;
use Helix\Shopify\Order\Fulfillment;
use Helix\Shopify\Order\Refund;
use Helix\Shopify\Order\Shipping;
use Helix\Shopify\Order\Tax;

/**
 * An order.
 *
 * Orders cannot be placed through the REST API.
 *
 * Shopify allows order creation on the condition that it's for archival purposes,
 * like if you're migrating from somewhere. Only finalized orders can be created,
 * whether that finalization happened through fulfillment or cancellation.
 *
 * Open orders cannot be created through the API. Consider using a {@link DraftOrder} instead.
 *
 * Orders are mostly immutable except for a few things, which are documented here.
 *
 * - billing_address
 * - buyer_accepts_marketing
 * - email
 * - metafields
 * - note
 * - note_attributes
 * - phone
 * - shipping_address
 * - tags
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/order
 *
 * @method $this setInventoryBehavior       (string $behavior) @depends create-only
 * @method $this setSendFulfillmentReceipt  (bool $receipt) @depends create-only
 * @method $this setTest                    (bool $test) @depends create-only
 * @method $this setSendReceipt             (bool $receipt) @depends create-only
 * @method $this setSourceName              (string $name) @depends create-only
 * @method $this setPresentmentCurrency     (string $currency) @depends create-only
 * @method $this setFinancialStatus         (string $status) @depends create-only
 * @method $this setCancelReason            (string $reason) @depends create-only
 * @method $this setLocationId              (string $id) @depends create-only
 * @method $this setDiscountCodes           (Discount[] $codes) @depends create-only
 * @method $this setFulfillmentStatus       (string $status) @depends create-only
 * @method $this setFulfillments            (string[] $fulfillments) @depends create-only
 * @method $this setProcessedAt             (string $iso8601) @depends create-only, historical creation date
 * @method $this setShippingLines           (Shipping[] $lines) @depends create-only
 * @method $this setSubtotalPriceSet        (string $set) @depends create-only
 * @method $this setTaxLines                (Tax[] $taxes) @depends create-only
 * @method $this setTotalDiscounts          (string $discounts) @depends create-only
 * @method $this setTotalDiscountsSet       (string $set) @depends create-only
 * @method $this setTotalLineItemsPrice     (number $price) @depends create-only
 * @method $this setTotalLineItemsPriceSet  (string $set) @depends create-only
 * @method $this setTotalPriceSet           (string $set) @depends create-only
 * @method $this setTotalTaxSet             (string $set) @depends create-only
 * @method $this setTotalTipReceived        (string $received) @depends create-only
 * @method $this setTotalWeight             (string $weight) @depends create-only
 *
 * @method string               getAppId                    ()
 * @method string               getBrowserIp                ()
 * @method bool                 getBuyerAcceptsMarketing    ()
 * @method string               getCancelReason             ()
 * @method string               getCancelledAt              ()
 * @method string               getCartToken                ()
 * @method string               getClientDetails            ()
 * @method string               getClosedAt                 ()
 * @method string               getCurrentTotalDutiesSet    ()
 * @method string               getCustomerLocale           ()
 * @method AppliedDiscount[]    getDiscountApplications     ()
 * @method Discount[]           getDiscountCodes            ()
 * @method string               getFinancialStatus          ()
 * @method string               getFulfillmentStatus        ()
 * @method Fulfillment[]        getFulfillments             ()
 * @method string               getLandingSite              ()
 * @method string               getLocationId               ()
 * @method string               getNumber                   ()
 * @method string               getOrderNumber              ()
 * @method string               getOrderStatusUrl           ()
 * @method string               getOriginalTotalDutiesSet   ()
 * @method string[]             getPaymentGatewayNames      ()
 * @method string               getPhone                    ()
 * @method string               getPresentmentCurrency      ()
 * @method string               getProcessedAt              ()
 * @method string               getProcessingMethod         ()
 * @method string               getReferringSite            ()
 * @method Refund[]             getRefunds                  ()
 * @method Shipping[]           getShippingLines            ()
 * @method string               getSourceName               ()
 * @method string               getSubtotalPriceSet         ()
 * @method string               getTaxesIncluded            ()
 * @method bool                 isTest                      ()
 * @method string               getToken                    ()
 * @method string               getTotalDiscounts           ()
 * @method string               getTotalDiscountsSet        ()
 * @method number               getTotalLineItemsPrice      ()
 * @method string               getTotalLineItemsPriceSet   ()
 * @method string               getTotalPriceSet            ()
 * @method string               getTotalTaxSet              ()
 * @method string               getTotalTipReceived         ()
 * @method string               getTotalWeight              ()
 * @method string               getUserId                   () staff account id
 *
 * @method bool hasDiscountApplications ()
 * @method bool hasDiscountCodes        ()
 * @method bool hasFulfillments         ()
 * @method bool hasNoteAttributes       ()
 * @method bool hasPaymentGatewayNames  ()
 * @method bool hasRefunds              ()
 * @method bool hasShippingLines        ()
 * @method bool hasTaxLines             ()
 *
 * @method $this setBuyerAcceptsMarketing   (bool $marketing)
 * @method $this setPhone                   (string $phone)
 * @method $this setReferringSite           (string $site)
 */
class Order extends AbstractOrder
{

    use CrudTrait;

    const TYPE = 'order';
    const DIR = 'orders';

    const MAP = parent::MAP + [
        'discount_applications' => [AppliedDiscount::class],
        'discount_codes' => [Discount::class],
        'fulfillments' => [Fulfillment::class],
        'refunds' => [Refund::class],
        'shipping_lines' => [Shipping::class],
    ];

    const INVENTORY_BYPASS = 'bypass';
    const INVENTORY_DECREMENT_IGNORE = 'decrement_ignoring_policy';
    const INVENTORY_DECREMENT_OBEY = 'decrement_obeying_policy';

    const PAYMENT_AUTHORIZED = 'authorized';
    const PAYMENT_COMPLETE = 'paid';
    const PAYMENT_PARTIAL = 'partially_paid';
    const PAYMENT_PARTIAL_REFUND = 'partially_refunded';
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_REFUNDED = 'refunded';
    const PAYMENT_VOIDED = 'voided';

    const FULFILLMENT_COMPLETE = 'fulfilled';
    const FULFILLMENT_NONE = null;
    const FULFILLMENT_PARTIAL = 'partial';
    const FULFILLMENT_RESTOCKED = 'restocked';

    const SEARCH_STATUS_ANY = 'any';
    const SEARCH_STATUS_CANCELLED = 'cancelled';
    const SEARCH_STATUS_CLOSED = 'closed';
    const SEARCH_STATUS_OPEN = 'open';
    const SEARCH_PAYMENT_ANY = 'any';
    const SEARCH_PAYMENT_AUTHORIZED = 'authorized';
    const SEARCH_PAYMENT_COMPLETE = 'paid';
    const SEARCH_PAYMENT_INCOMPLETE = 'unpaid';
    const SEARCH_PAYMENT_PARTIAL = 'partially_paid';
    const SEARCH_PAYMENT_PARTIAL_REFUND = 'partially_refunded';
    const SEARCH_PAYMENT_PENDING = 'pending';
    const SEARCH_PAYMENT_REFUNDED = 'refunded';
    const SEARCH_PAYMENT_VOIDED = 'voided';
    const SEARCH_FULFILLMENT_ANY = 'any';
    const SEARCH_FULFILLMENT_PARTIAL = 'partial';
    const SEARCH_FULFILLMENT_SHIPPED = 'shipped';
    const SEARCH_FULFILLMENT_UNSHIPPED = 'unshipped';

    /**
     * Cancels the order.
     *
     * Applicable refunds must be issued before cancellation.
     *
     * @return $this
     */
    public function cancel()
    {
        assert($this->hasId());
        $this->api->post("{$this}/cancel");
        return $this->reload();
    }

    /**
     * Closes the order.
     *
     * @return $this
     */
    public function close()
    {
        assert($this->hasId());
        $this->api->post("{$this}/close");
        return $this->reload();
    }

    /**
     * @return Discount
     */
    public function newDiscount()
    {
        return $this->api->factory($this, Discount::class);
    }

    /**
     * @return Fulfillment
     */
    public function newFulfillment()
    {
        assert($this->hasId());
        return $this->api->factory($this, Fulfillment::class, [
            'order_id' => $this->getId()
        ]);
    }

    /**
     * @return Refund
     */
    public function newRefund()
    {
        assert($this->hasId());
        return $this->api->factory($this, Refund::class);
    }

    /**
     * @return Shipping
     */
    public function newShipping()
    {
        return $this->api->factory($this, Shipping::class);
    }

    /**
     * Reopens a closed order.
     *
     * @return $this
     */
    public function reopen()
    {
        assert($this->hasId());
        $this->api->post("{$this}/open");
        return $this->reload();
    }
}