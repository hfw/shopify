<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CreateTrait;
use Helix\Shopify\Base\AbstractEntity\UpdateTrait;

/**
 * A Shopify+ gift card.
 *
 * Gift cards cannot be deleted.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/plus/giftcard
 *
 * @method $this setCode            (string $code) @depends create-only, write-only
 * @method $this setInitialValue    (number $value) @depends create-only
 *
 * @method string       getApiClientId      ()
 * @method number       getBalance          ()
 * @method string       getCreatedAt        ()
 * @method string       getCurrency         ()
 * @method string       getCustomerId       ()
 * @method string       getDisabledAt       ()
 * @method null|string  getExpiresOn        ()
 * @method number       getInitialValue     ()
 * @method string       getLastCharacters   () read-only
 * @method string       getLineItemId       ()
 * @method string       getNote             ()
 * @method string       getOrderId          ()
 * @method null|string  getTemplateSuffix   ()
 * @method string       getUpdatedAt        ()
 * @method string       getUserId           ()
 *
 * @method $this setApiClientId     (string $id)
 * @method $this setBalance         (number $balance)
 * @method $this setCreatedAt       (string $iso8601)
 * @method $this setCurrency        (string $currency)
 * @method $this setCustomerId      (string $id)
 * @method $this setDisabledAt      (string $iso8601)
 * @method $this setExpiresOn       (?string $date)
 * @method $this setLineItemId      (string $id)
 * @method $this setNote            (string $note)
 * @method $this setOrderId         (string $id)
 * @method $this setTemplateSuffix  (?string $suffix)
 * @method $this setUpdatedAt       (string $iso8601)
 * @method $this setUserId          (string $id)
 */
class GiftCard extends AbstractEntity {

    use CreateTrait;
    use UpdateTrait;

    const TYPE = 'gift_card';
    const DIR = 'gift_cards';

    const SEARCH_STATUS_DISABLED = 'disabled';
    const SEARCH_STATUS_ENABLED = 'enabled';

    /**
     * @return Customer
     */
    public function getCustomer () {
        return Customer::load($this, $this->getCustomerId());
    }

    /**
     * @return Order
     */
    public function getOrder () {
        return Order::load($this, $this->getOrderId());
    }

    /**
     * @return User
     */
    public function getUser () {
        return User::load($this, $this->getUserId());
    }

}