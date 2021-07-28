<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Base\AbstractEntity\ImmutableInterface;
use Helix\Shopify\Order;
use Helix\Shopify\Order\Refund\Adjustment;
use Helix\Shopify\Order\Refund\RefundItem;

/**
 * A refund.
 *
 * @immutable Refunds can only be created.
 *
 * @see https://help.shopify.com/en/api/reference/orders/refund
 *
 * @method $this setCurrency            (string $currency) @depends create-only
 * @method $this setDiscrepancyReason   (string $reason) @depends create-only
 * @method $this setNote                (string $note) @depends create-only
 * @method $this setNotify              (bool $notify) @depends create-only
 * @method $this setProcessedAt         (string $iso8601) @depends create-only
 * @method $this setRefundLineItems     (RefundItem[] $items) @depends create-only
 * @method $this setTransactions        (Transaction[] $transactions) @depends create-only
 * @method $this setUserId              (string $id) @depends create-only
 *
 * @method string           getCreatedAt        ()
 * @method string           getId               ()
 * @method string           getNote             ()
 * @method Adjustment[]     getOrderAdjustments ()
 * @method string           getProcessedAt      ()
 * @method RefundItem[]     getRefundLineItems  ()
 * @method Transaction[]    getTransactions     ()
 * @method string           getUserId           ()
 *
 * @method bool hasOrderAdjustments ()
 * @method bool hasRefundLineItems  ()
 * @method bool hasTransactions     ()
 */
class Refund extends AbstractEntity implements ImmutableInterface
{

    use CreateTrait;

    const TYPE = 'refund';
    const DIR = 'refunds';

    const REASON_CUSTOMER = 'customer';
    const REASON_DAMAGE = 'damage';
    const REASON_OTHER = 'other';
    const REASON_RESTOCK = 'restock';

    const MAP = [
        'order_adjustments' => [Adjustment::class],
        'refund_line_items' => [RefundItem::class],
        'transactions' => [Transaction::class]
    ];

    /**
     * @var Order
     */
    protected $order;

    public function __construct(Order $order, array $data = [])
    {
        $this->order = $order;
        parent::__construct($order, $data);
    }

    protected function _container()
    {
        return $this->order;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return Order::load($this, $this->order->getId());
    }

    /**
     * @return RefundItem
     */
    public function newItem()
    {
        return $this->api->factory($this, RefundItem::class);
    }

    /**
     * @return Transaction
     */
    public function newTransaction()
    {
        return $this->api->factory($this, Transaction::class, [
            'kind' => Transaction::KIND_REFUND
        ]);
    }

    /**
     * @depends create-only
     * @return $this
     */
    public function setFullShipping()
    {
        return $this->_set('shipping', ['full_refund' => true]);
    }

    /**
     * @depends create-only
     * @param string $amount
     * @return $this
     */
    public function setShippingAmount(string $amount)
    {
        return $this->_set('shipping', ['amount' => $amount]);
    }
}