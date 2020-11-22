<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Order;
use Helix\Shopify\Order\Fulfillment\Receipt;

/**
 * A fulfillment.
 *
 * @see https://help.shopify.com/en/api/reference/shipping-and-fulfillment/fulfillment
 *
 * @method string       getCreatedAt                    ()
 * @method OrderItem[]       getLineItems                    ()
 * @method string       getLocationId                   ()
 * @method string       getName                         ()
 * @method bool         isNotifyCustomer                ()
 * @method $this        setNotifyCustomer               (bool $notify)
 * @method string       getOrderId                      () injected
 * @method null|Receipt getReceipt                      ()
 * @method string       getService                      ()
 * @method string       getShipmentStatus               ()
 * @method string       getStatus                       ()
 * @method string       getTrackingCompany              ()
 * @method $this        setTrackingCompany              (string $company)
 * @method string[]     getTrackingNumbers              ()
 * @method $this        setTrackingNumbers              (string[] $numbers)
 * @method string[]     getTrackingUrls                 ()
 * @method $this        setTrackingUrls                 (string[] $urls)
 * @method string       getUpdatedAt                    ()
 * @method string       getVariantInventoryManagement   ()
 */
class Fulfillment extends AbstractEntity {

    use CreateTrait;

    const TYPE = 'fulfillment';
    const DIR = 'fulfillments';

    const MAP = [
        'line_items' => [OrderItem::class],
        'receipt' => Receipt::class
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_OPEN = 'open';
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_ERROR = 'error';
    const STATUS_FAILURE = 'failure';

    const SHIPMENT_LABEL_PRINTED = 'label_printed';
    const SHIPMENT_LABEL_PURCHASED = 'label_purchased';
    const SHIPMENT_READY = 'confirmed';
    const SHIPMENT_FREIGHTING = 'in_transit';
    const SHIPMENT_DELIVERING = 'out_for_delivery';
    const SHIPMENT_UNDELIVERED = 'attempted_delivery';
    const SHIPMENT_PICKUP = 'ready_for_pickup';
    const SHIPMENT_COMPLETE = 'delivered';
    const SHIPMENT_FAILURE = 'failure';

    protected function _container () {
        return $this->getOrder();
    }

    /**
     * @return $this
     */
    public function cancel () {
        assert($this->hasId());
        $remote = $this->api->post("{$this}/cancel", []);
        return $this->_setData($remote[self::TYPE]);
    }

    /**
     * @return $this
     */
    public function complete () {
        assert($this->hasId());
        $remote = $this->api->post("{$this}/complete", []);
        return $this->_setData($remote[self::TYPE]);
    }

    /**
     * @return Order
     */
    public function getOrder () {
        return Order::load($this, $this->getOrderId());
    }

    /**
     * @param string $orderItemId
     * @return OrderItem
     */
    public function newItem (string $orderItemId) {
        return $this->api->factory($this, OrderItem::class, [
            'id' => $orderItemId
        ]);
    }

    /**
     * @return $this
     */
    public function open () {
        assert($this->hasId());
        $remote = $this->api->post("{$this}/open", []);
        return $this->_setData($remote[self::TYPE]);
    }
}