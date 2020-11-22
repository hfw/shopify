<?php

namespace Helix\Shopify\PriceRule;

use Helix\Shopify\Base\Data;
use Helix\Shopify\PriceRule;

/**
 * A {@link PriceRule} prerequisite-to-entitlement-quantity ratio.
 *
 * @method int      getEntitledQuantity     ()
 * @method int      getPrerequisiteQuantity ()
 *
 * @method $this    setEntitledQuantity     (int $quantity)
 * @method $this    setPrerequisiteQuantity (int $quantity)
 */
class QuantityRatio extends Data {

}