<?php

namespace Helix\Shopify\InventoryItem;

use Helix\Shopify\Base\Data;

/**
 * @see https://shopify.dev/docs/admin-api/rest/reference/inventory/inventoryitem
 *
 * @method string   getCountryCode          ()
 * @method string   getHarmonizedSystemCode ()
 *
 * @method $this    setCountryCode          (string $code)
 * @method $this    setHarmonizedSystemCode (string $code)
 */
class CHSCode extends Data {

    /**
     * The system code.
     *
     * @return string
     */
    final public function __toString (): string {
        return $this->getHarmonizedSystemCode();
    }
}