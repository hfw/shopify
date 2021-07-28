<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\ImmutableInterface;

/**
 * A location.
 *
 * @immutable Cannot be modified via the API.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/inventory/location
 *
 * @method bool     isActive                    ()
 * @method string   getAddress1                 ()
 * @method string   getAddress2                 ()
 * @method string   getCity                     ()
 * @method string   getCountryCode              ()
 * @method string   getCreatedAt                ()
 * @method bool     isLegacy                    ()
 * @method string   getLocalizedCountryName     ()
 * @method string   getLocalizedProvinceName    ()
 * @method string   getName                     ()
 * @method string   getPhone                    ()
 * @method string   getProvince                 ()
 * @method string   getProvinceCode             ()
 * @method string   getUpdatedAt                ()
 * @method string   getZip                      ()
 *
 * @method InventoryLevel[] selectInventoryLevels (callable $filter) `fn( InventoryLevel $level ): bool`
 */
class Location extends AbstractEntity implements ImmutableInterface
{

    const TYPE = 'location';
    const DIR = 'locations';

    /**
     * @return InventoryLevel[]
     */
    public function getInventoryLevels()
    {
        $remote = $this->api->get("{$this}/inventory_levels")['inventory_levels'] ?? [];
        return $this->api->factoryAll($this, InventoryLevel::class, $remote);
    }

    /**
     * Factory.
     *
     * @param InventoryItem $item
     * @return InventoryLevel
     */
    public function newInventoryLevel(InventoryItem $item)
    {
        return $this->api->factory($this, InventoryLevel::class, [
            'location_id' => $this->getId(),
            'inventory_item_id' => $item->getId()
        ]);
    }
}