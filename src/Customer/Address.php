<?php

namespace Helix\Shopify\Customer;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Customer;

/**
 * A customer's address.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/customers/customer-address
 *
 * @see Customer::newAddress()
 *
 * @method string   getAddress1     ()
 * @method string   getAddress2     ()
 * @method string   getCity         ()
 * @method string   getCompany      ()
 * @method string   getCountry      ()
 * @method string   getCountryCode  () read-only
 * @method string   getCountryName  ()
 * @method string   getCustomerId   () injected
 * @method bool     isDefault       ()
 * @method string   getName         ()
 * @method string   getPhone        () non-unique
 * @method string   getProvince     ()
 * @method string   getProvinceCode () read-only
 * @method string   getZip          ()
 *
 * @method bool     hasPhone        ()
 *
 * @method $this    setAddress1     (string $address1)
 * @method $this    setAddress2     (string $address2)
 * @method $this    setCity         (string $city)
 * @method $this    setCompany      (string $company)
 * @method $this    setCountry      (string $country)
 * @method $this    setCountryName  (string $name)
 * @method $this    setName         (string $name)
 * @method $this    setPhone        (string $phone)
 * @method $this    setProvince     (string $province)
 * @method $this    setZip          (string $zip)
 */
class Address extends AbstractEntity {

    use CrudTrait;

    const TYPE = 'customer_address';
    const DIR = 'addresses';

    protected function _container () {
        return $this->getCustomer();
    }

    protected function _onDelete (): void {
        parent::_onDelete();
        $this->getCustomer()->_reload('addresses');
    }

    protected function _onSave (): void {
        parent::_onSave();
        $customer = $this->getCustomer();
        $customer->_reload('addresses');
        if (!$customer->hasPhone() and $this->hasPhone()) {
            $customer->_reload('phone');
        }
    }

    /**
     * @return Customer
     */
    public function getCustomer () {
        return Customer::load($this, $this->getCustomerId());
    }

    /**
     * Alias for {@link getProvince()}
     *
     * @return string
     */
    final public function getState () {
        return $this->getProvince();
    }

    /**
     * Alias for {@link getProvinceCode()}
     *
     * @return string
     */
    final public function getStateCode () {
        return $this->getProvinceCode();
    }

    /**
     * Sets the address as the default.
     *
     * @return $this
     */
    public function setDefault () {
        assert($this->hasId());
        // tell the prior default address.
        if ($default = $this->getCustomer()->getDefaultAddress()) {
            $default->data['default'] = false;
            $this->pool->add($default);
        }
        return $this->_set('default', true)->update();
    }

    /**
     * Alias for {@link setProvince()}
     *
     * @param string $state
     * @return $this
     */
    final public function setState (string $state) {
        return $this->setProvince($state);
    }

}