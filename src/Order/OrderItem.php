<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\DraftOrder;
use Helix\Shopify\Order;

/**
 * An order item.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/order
 *
 * @see Order::getLineItems()
 * @see DraftOrder::getLineItems()
 * @see Fulfillment::getLineItems()
 *
 * @todo dookies
 *
 * @method DiscountAllocation[] getDiscountAllocations  ()
 * @method int                  getFulfillableQuantity  ()
 * @method string               getFulfillmentService   ()
 * @method string               getFulfillmentStatus    ()
 * @method string               getGiftCard             ()
 * @method string               getGrams                ()
 * @method string               getId                   ()
 * @method string               getName                 ()
 * @method Funds                getPriceSet             ()
 * @method string               getProductId            ()
 * @method array[]              getProperties           () "hash"
 * @method int                  getQuantity             ()
 * @method string               getRequiresShipping     ()
 * @method string               getSku                  ()
 * @method Tax[]                getTaxLines             ()
 * @method string               getTaxable              ()
 * @method string               getTitle                ()
 * @method string               getTotalDiscount        ()
 * @method Funds                getTotalDiscountSet     ()
 * @method string               getVariantId            ()
 * @method string               getVariantTitle         ()
 * @method string               getVendor               ()
 *
 * @method bool hasDiscountAllocations  ()
 * @method bool hasDuties               ()
 * @method bool hasProperties           ()
 * @method bool hasTaxLines             ()
 *
 * @method $this setDiscountAllocations (DiscountAllocation[] $allocations)
 * @method $this setFulfillableQuantity (int $qty)
 * @method $this setFulfillmentService  (string $service)
 * @method $this setFulfillmentStatus   (string $status)
 * @method $this setGiftCard            (string $card)
 * @method $this setGrams               (string $grams)
 * @method $this setId                  (string $id)
 * @method $this setName                (string $name)
 * @method $this setPriceSet            (Funds $set)
 * @method $this setProductId           (string $id)
 * @method $this setProperties          (array[] $hash)
 * @method $this setQuantity            (int $qty)
 * @method $this setRequiresShipping    (string $shipping)
 * @method $this setSku                 (string $sku)
 * @method $this setTaxLines            (Tax[] $lines)
 * @method $this setTaxable             (string $taxable)
 * @method $this setTitle               (string $title)
 * @method $this setTotalDiscount       (string $discount)
 * @method $this setTotalDiscountSet    (Funds $set)
 * @method $this setVariantId           (string $id)
 * @method $this setVariantTitle        (string $title)
 * @method $this setVendor              (string $vendor)
 */
class OrderItem extends Data
{

    const MAP = [
        'discount_allocations' => [DiscountAllocation::class],
        'price_set' => Funds::class,
        'properties' => [self::class],
        'tax_lines' => [Tax::class],
        'total_discount_set' => Funds::class
    ];

}