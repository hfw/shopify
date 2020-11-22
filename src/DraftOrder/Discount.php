<?php

namespace Helix\Shopify\DraftOrder;

use Helix\Shopify\Base\Data;
use Helix\Shopify\DraftOrder;

/**
 * A {@link DraftOrder} discount.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/draftorder#applied-discount-property-2020-04
 * @see https://shopify.dev/docs/admin-api/rest/reference/orders/draftorder#create-a-draft-order-with-a-discount-2020-04
 *
 * @method number   getAmount       ()
 * @method string   getDescription  ()
 * @method string   getTitle        ()
 * @method string   getValue        ()
 * @method string   getValueType    ()
 *
 * @method $this    setAmount       (number $amount)
 * @method $this    setDescription  (string $text)
 * @method $this    setTitle        (string $title)
 * @method $this    setValue        (string $value)
 * @method $this    setValueType    (string $type)
 * @todo checked
 */
class Discount extends Data {

    const VALUE_TYPE_FIXED_AMOUNT = 'fixed_amount';
    const VALUE_TYPE_PERCENTAGE = 'percentage';

}