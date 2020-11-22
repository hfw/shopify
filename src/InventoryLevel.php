<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\Data;

/**
 * An inventory level, which acts as a join between a location and an inventory item.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/inventory/inventorylevel
 *
 * @see Location::newInventoryLevel()
 *
 * @method null|int getAvailable            ()
 * @method string   getInventoryItemId      () injected
 * @method string   getLocationId           () injected
 * @method string   getUpdatedAt            ()
 */
class InventoryLevel extends Data {

    /**
     * @param int $qty +/-
     * @return $this
     */
    public function adjustAvailable (int $qty) {
        $remote = $this->api->post('inventory_levels', [
            'inventory_item_id' => $this->getInventoryItemId(),
            'location_id' => $this->getLocationId(),
            'available_adjustment' => $qty
        ]);
        return $this->_setData($remote['inventory_level']);
    }

    /**
     * @param bool $relocate
     * @return $this
     */
    public function connect (bool $relocate = false) {
        $remote = $this->api->post('inventory_levels/connect', [
            'inventory_item_id' => $this->getInventoryItemId(),
            'location_id' => $this->getLocationId(),
            'relocate_if_necessary' => $relocate
        ]);
        return $this->_setData($remote['inventory_level']);
    }

    public function disconnect (): void {
        $this->api->delete('inventory_levels', [
            'inventory_item_id' => $this->getInventoryItemId(),
            'location_id' => $this->getLocationId()
        ]);
    }

    /**
     * @return InventoryItem
     */
    public function getInventoryItem () {
        return InventoryItem::load($this, $this->getInventoryItemId());
    }

    /**
     * @return Location
     */
    public function getLocation () {
        return Location::load($this, $this->getLocationId());
    }

    /**
     * @param int $qty
     * @return InventoryLevel
     */
    public function setAvailable (int $qty) {
        $remote = $this->api->post('inventory_levels', [
            'inventory_item_id' => $this->getInventoryItemId(),
            'location_id' => $this->getLocationId(),
            'available' => $qty
        ]);
        return $this->_setData($remote['inventory_level']);
    }
}