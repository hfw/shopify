<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Order;
use Helix\Shopify\Order\Transaction\Payment;

/**
 * A transaction.
 *
 * @see https://help.shopify.com/en/api/reference/orders/transaction
 *
 * @method string       getAmount       ()
 * @method string       getAuthorization()
 * @method string       getCreatedAt    ()
 * @method string       getCurrency     ()
 * @method string       getDeviceId     ()
 * @method string       getErrorCode    ()
 * @method string       getGateway      ()
 * @method string       getKind         ()
 * @method string       getLocationId   ()
 * @method string       getMessage      ()
 * @method string       getOrderId      () injected
 * @method string       getParentId     ()
 * @method null|Payment getPaymentDetails()
 * @method string       getProcessedAt  ()
 * @method array        getReceipt      ()
 * @method string       getSourceName   ()
 * @method string       getStatus       ()
 * @method bool         isTest          ()
 * @method string       getUserId       ()
 *
 * @method $this        setAmount       (string $amount)    @when new
 * @method $this        setAuthorization(string $auth)      @when new
 * @method $this        setCurrency     (string $iso4217)   @when new
 * @method $this        setKind         (string $kind)      @when new
 * @method $this        setParentId     (string $id)        @when new
 * @method $this        setProcessedAt  (string $iso8601)   @when new
 * @method $this        setTest         (bool $test)        @when new
 * @method $this        setUserId       (string $id)        @when new
 */
class Transaction extends AbstractEntity {

    use CreateTrait;

    const TYPE = 'transaction';
    const DIR = 'transactions';

    const MAP = [
        'payment_details' => Payment::class
    ];

    const KIND_AUTH = 'authorization';
    const KIND_CAPTURE = 'capture';
    const KIND_REFUND = 'refund';
    const KIND_SALE = 'sale';
    const KIND_VOID = 'void';

    protected function _container () {
        return $this->getOrder();
    }

    public function getOrder () {
        return Order::load($this, $this->getOrderId());
    }
}