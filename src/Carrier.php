<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;

/**
 * A carrier service.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/shipping-and-fulfillment/carrierservice
 *
 * @method bool     isActive                ()
 * @method string   getCallbackUrl          ()
 * @method string   getCarrierServiceType   ()
 * @method string   getFormat               ()
 * @method string   getName                 ()
 * @method bool     hasServiceDiscovery     ()
 *
 * @method $this    setActive               (bool $active)
 * @method $this    setCallbackUrl          (string $url)
 * @method $this    setCarrierServiceType   (string $type)
 * @method $this    setFormat               (string $format)
 * @method $this    setName                 (string $name)
 * @method $this    setServiceDiscovery     (bool $discovery)
 */
class Carrier extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'carrier_service';
    const DIR = 'carrier_services';

    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

}