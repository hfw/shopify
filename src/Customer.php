<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Customer\Address;
use Helix\Shopify\Customer\Invite;

/**
 * A customer.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/customers/customer
 *
 * @see Shop::newCustomer()
 *
 * @method $this        setState                    (string $status) @depends create-only, see the constants
 * @method $this        setSendEmailInvite          (bool $invite) @depends create-only
 * @method $this        setSendEmailWelcome         (bool $welcome) @depends create-only
 * @method $this        setAddresses                (Address[] $addresses) @depends create-only, bulk
 * @method $this        setEmail                    (string $email) required, unique
 * @method $this        setFirstName                (string $name) required
 * @method $this        setLastName                 (string $name) required
 *
 * @method bool         getAcceptsMarketing         ()
 * @method string       getAcceptsMarketingUpdatedAt()
 * @method Address[]    getAddresses                ()
 * @method string       getCurrency                 () read-only
 * @method string       getCreatedAt                () ISO8601
 * @method string       getEmail                    ()
 * @method string       getFirstName                ()
 * @method string       getLastName                 ()
 * @method string       getLastOrderId              () read-only
 * @method string       getLastOrderName            () read-only
 * @method string       getMarketingOptInLevel      () read-only
 * @method null|string  getMultipassIdentifier      ()
 * @method string       getNote                     ()
 * @method int          getOrdersCount              () read-only
 * @method string       getPhone                    ()
 * @method string       getTags                     ()
 * @method bool         isTaxExempt                 ()
 * @method string[]     getTaxExemptions            () @depends canada-only
 * @method bool         hasTaxExemptions            () @depends canada-only
 * @method string       getTotalSpent               ()
 * @method string       getUpdatedAt                ()
 * @method bool         isVerifiedEmail             ()
 *
 * @method bool         hasAddresses                ()
 * @method bool         hasPhone                    ()
 *
 * @method $this        setAcceptsMarketing         (bool $opted)
 * @method $this        setAcceptsMarketingUpdatedAt(string $iso8601)
 * @method $this        setMultipassIdentifier      (?string $ident)
 * @method $this        setNote                     (string $note)
 * @method $this        setPhone                    (string $e164) unique
 * @method $this        setTags                     (string $csv)
 * @method $this        setTaxExempt                (bool $exempt)
 *
 * @method Address[]    selectAddresses (callable $filter) `fn( Address $address ): bool`
 */
class Customer extends AbstractEntity
{

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'customer';
    const DIR = 'customers';

    const MAP = [
        'addresses' => [Address::class],
    ];

    /**
     * Customer can't log in. This is the default.
     */
    const IS_DISABLED = 'disabled';

    /**
     * Customer needs to activate their account via invite link before logging in.
     */
    const IS_INVITED = 'invited';

    /**
     * Customer can log in and shop.
     */
    const IS_ENABLED = 'enabled';

    /**
     * Customer declined the invite, has no account.
     */
    const IS_DECLINED = 'declined';

    /**
     * @var string
     */
    protected $activationUrl;

    protected function _setData(array $data)
    {
        // redundant
        unset($data['default_address']);

        return parent::_setData($data);
    }

    /**
     * @return string
     */
    public function getActivationUrl(): string
    {
        assert($this->hasId());
        return $this->activationUrl
            ?? $this->activationUrl = $this->api->post("{$this}/account_activation_url")['account_activation_url'];
    }

    /**
     * @return null|Address
     */
    public function getDefaultAddress()
    {
        return $this->selectAddresses(function (Address $address) {
                return $address->isDefault();
            })[0] ?? null;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        assert($this->hasId());
        return Order::loadAll($this, "{$this}/orders");
    }

    /**
     * @return string[]
     */
    public function getPoolKeys()
    {
        $keys = parent::getPoolKeys();
        $keys[] = $this->data['email'] ?? null;
        $keys[] = $this->data['phone'] ?? null;
        $keys[] = $this->data['multipass_identifier'] ?? null;
        return array_filter($keys);
    }

    /**
     * @return bool
     */
    final public function isDeclined(): bool
    {
        return $this->data['state'] === self::IS_DECLINED;
    }

    /**
     * @return bool
     */
    final public function isDisabled(): bool
    {
        return $this->data['state'] === self::IS_DISABLED;
    }

    /**
     * @return bool
     */
    final public function isEnabled(): bool
    {
        return $this->data['state'] === self::IS_ENABLED;
    }

    /**
     * @return bool
     */
    final public function isInvited(): bool
    {
        return $this->data['state'] === self::IS_INVITED;
    }

    /**
     * @return Address
     */
    public function newAddress()
    {
        return $this->api->factory($this, Address::class, [
            'customer_id' => $this->getId()
        ]);
    }

    /**
     * Creates an invite for an existing customer.
     *
     * @return Invite
     */
    public function newInvite()
    {
        return new Invite($this);
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->_set('password', $password);
        $this->_set('password_confirmation', $password);
        return $this;
    }
}
