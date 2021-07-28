<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;

/**
 * A report.
 *
 * @see https://help.shopify.com/en/api/reference/analytics/report
 *
 * @method string   getCategory     ()
 * @method string   getName         ()
 * @method string   getShopifyQl    ()
 *
 * @method $this    setName         (string $name)
 * @method $this    setShopifyQl    (string $ql)
 * @method string   getUpdatedAt    ()
 */
class Report extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'report';
    const DIR = 'reports';
}