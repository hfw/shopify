<?php

namespace Helix\Shopify\Base\AbstractEntity;

use Helix\Shopify\Base\AbstractEntity;

/**
 * @mixin AbstractEntity
 */
trait CrudTrait {

    use CreateTrait;
    use DeleteTrait;
    use UpdateTrait;
}