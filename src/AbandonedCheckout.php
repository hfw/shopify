<?php

namespace Helix\Shopify;

use Helix\Shopify\AbandonedCheckout\Discount;
use Helix\Shopify\Base\Data;
use Helix\Shopify\Order\Address;
use Helix\Shopify\Order\OrderItem;
use Helix\Shopify\Order\Shipping;
use Helix\Shopify\Order\Tax;

/**
 * An abandoned checkout.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/abandoned-checkouts
 *
 * @method string       getAbandonedCheckoutUrl ()
 * @method Address      getBillingAddress       ()
 * @method bool         getBuyerAcceptsMarketing()
 * @method string       getCartToken            ()
 * @method string       getClosedAt             ()
 * @method string       getCreatedAt            ()
 * @method string       getCurrency             ()
 * @method Customer     getCustomer             ()
 * @method string       getCustomerLocale       ()
 * @method int          getDeviceId             ()
 * @method string       getEmail                ()
 * @method string       getLandingSite          ()
 * @method OrderItem[]  getLineItems            ()
 * @method int          getLocationId           ()
 * @method string       getNote                 ()
 * @method string       getPhone                ()
 * @method string       getPresentmentCurrency  ()
 * @method string       getReferringSite        ()
 * @method Address      getShippingAddress      ()
 * @method Shipping[]   getShippingLines        ()
 * @method string       getSourceName           ()
 * @method string       getSubtotalPrice        ()
 * @method Tax[]        getTaxLines             ()
 * @method bool         hasTaxesIncluded        ()
 * @method string       getToken                ()
 * @method string       getTotalDiscounts       ()
 * @method string       getTotalLineItemsPrice  ()
 * @method string       getTotalPrice           ()
 * @method string       getTotalTax             ()
 * @method number       getTotalWeight          ()
 * @method string       getUpdatedAt            ()
 * @method string       getUserId               ()
 */
class AbandonedCheckout extends Data
{

    const SEARCH_STATUS_CLOSED = 'closed';
    const SEARCH_STATUS_OPEN = 'open';

    const MAP = [
        'billing_address' => Address::class,
        'customer' => Customer::class,
        'line_items' => [OrderItem::class],
        'shipping_address' => Address::class,
        'shipping_lines' => Shipping::class,
        'tax_lines' => [Tax::class]
    ];

    protected function _setData(array $data)
    {
        // abandoned checkouts aren't entities.
        unset($data['id']);

        // always null
        unset($data['completed_at'], $data['gateway']);

        return parent::_setData($data);
    }

    /**
     * @return Discount[]
     */
    public function getDiscountCodes()
    {
        // the discounts are in an extra dimension for some reason.
        $discounts = array_column($this->data['discount_codes'], 'discount_code');
        return $this->api->factoryAll($this, Discount::class, $discounts);
    }
}