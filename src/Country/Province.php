<?php

namespace Helix\Shopify\Country;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\UpdateTrait;
use Helix\Shopify\Country;

/**
 * Country province settings.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/store-properties/province
 *
 * @method string       getCode             ()
 * @method string       getCountryId        () injected
 * @method string       getName             ()
 * @method string       getShippingZoneId   ()
 * @method string       getTax              ()
 * @method string       getTaxName          ()
 * @method string       getTaxPercentage    ()
 * @method null|string  getTaxType          ()
 *
 * @method $this        setCode             (string $code)
 * @method $this        setName             (string $name)
 * @method $this        setShippingZoneId   (string $id)
 * @method $this        setTax              (string $tax)
 * @method $this        setTaxName          (string $name)
 * @method $this        setTaxPercentage    (string $percentage)
 * @method $this        setTaxType          (?string $type)
 * @todo checked
 */
class Province extends AbstractEntity
{

    use UpdateTrait;

    const TYPE = 'province';
    const DIR = 'provinces';

    const TAX_TYPE_NONE = null;
    const TAX_TYPE_NORMAL = 'normal';
    const TAX_TYPE_HARMONIZED = 'harmonized';
    const TAX_TYPE_COMPOUNDED = 'compounded';

    protected function _container()
    {
        return $this->getCountry();
    }

    public function getCountry()
    {
        return Country::load($this, $this->getCountryId());
    }

}