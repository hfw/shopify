<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Customer;

/**
 * @see Order
 * @see DraftOrder
 *
 * @method $this setName    (string $name) @depends create-only
 * @method null|Address     getBillingAddress   ()
 * @method string           getCreatedAt        ()
 * @method string           getCurrency         ()
 * @method null|Customer    getCustomer         ()
 * @method string           getEmail            ()
 * @method OrderItem[]      getLineItems        ()
 * @method string           getName             ()
 * @method string           getNote             ()
 * @method array[]          getNoteAttributes   () name-value "hash"
 * @method null|Address     getShippingAddress  ()
 * @method string           getSubtotalPrice    ()
 * @method string           getTags             ()
 * @method Tax[]            getTaxLines         ()
 * @method bool             hasTaxesIncluded    ()
 * @method string           getTotalPrice       ()
 * @method string           getTotalTax         ()
 * @method string           getUpdatedAt        ()
 *
 * @method $this setBillingAddress  (?Address $address)
 * @method $this setCurrency        (string $iso4217)
 * @method $this setCustomer        (?Customer $customer)
 * @method $this setEmail           (string $email)
 * @method $this setNote            (string $note)
 * @method $this setNoteAttributes  (array[] $hash)
 * @method $this setShippingAddress (?Address $address)
 * @method $this setSubtotalPrice   (string $price)
 * @method $this setTags            (string $csv)
 * @method $this setTaxesIncluded   (bool $included)
 * @method $this setTaxLines        (Tax[] $taxes)
 * @method $this setTotalPrice      (string $price)
 * @method $this setTotalTax        (string $amount)
 */
abstract class AbstractOrder extends AbstractEntity {

    use MetafieldTrait;

    const MAP = [
        'billing_address' => Address::class,
        'customer' => Customer::class,
        'line_items' => [OrderItem::class],
        'shipping_address' => Address::class,
        'tax_lines' => [Tax::class]
    ];

}