<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Country\Province;

/**
 * Country settings.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/store-properties/country
 *
 * @method string       getCode         () injected
 * @method string       getName         ()
 * @method Province[]   getProvinces    ()
 * @method number       getTax          ()
 *
 * @method $this        setTax          (number $rate)
 */
class Country extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'country';
    const DIR = 'countries';

    const MAP = [
        'provinces' => [Province::class]
    ];

}