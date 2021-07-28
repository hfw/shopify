<?php

namespace Helix\Shopify\Order;

use Helix\Shopify\Base\Data;
use Helix\Shopify\DraftOrder;
use Helix\Shopify\Order;

/**
 * An order address.
 *
 * @see Order
 * @see DraftOrder
 *
 * @method string   getAddress1     ()
 * @method string   getAddress2     ()
 * @method string   getCity         ()
 * @method string   getCompany      ()
 * @method string   getCountry      ()
 * @method string   getCountryCode  () read-only
 * @method string   getCountryName  ()
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
class Address extends Data
{

}
