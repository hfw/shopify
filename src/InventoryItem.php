<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Base\AbstractEntity\UpdateTrait;
use Helix\Shopify\InventoryItem\CHSCode;

/**
 * An inventory item.
 *
 * Inventory items cannot be deleted.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/inventory/inventoryitem
 *
 * @method number       getCost                         ()
 * @method string       getCountryCodeOfOrigin          ()
 * @method string       getCreatedAt                    ()
 * @method string       getHarmonizedSystemCode         ()
 * @method CHSCode[]    getCountryHarmonizedSystemCodes ()
 * @method string       getProvinceCodeOfOrigin         () @depends canada-only
 * @method bool         isRequiresShipping              ()
 * @method string       getSku                          ()
 * @method bool         isTracked                       ()
 * @method string       getUpdatedAt                    ()
 *
 * @method $this        setCountryCodeOfOrigin          (string $code)
 * @method $this        setCountryHarmonizedSystemCodes (CHSCode[] $codes)
 * @method $this        setCost                         (number $cost)
 * @method $this        setHarmonizedSystemCode         (string $code)
 * @method $this        setProvinceCodeOfOrigin         (string $code) @depends canada-only
 * @method $this        setSku                          (string $sku)
 * @method $this        setTracked                      (string $tracked)
 */
class InventoryItem extends AbstractEntity {

    use CreateTrait;
    use UpdateTrait;

    const TYPE = 'inventory_item';
    const DIR = 'inventory_items';

    const MAP = [
        'country_harmonized_system_codes' => [CHSCode::class]
    ];

    /**
     * Factory.
     *
     * @return CHSCode
     */
    public function newCHSCode () {
        return $this->api->factory($this, CHSCode::class);
    }

}