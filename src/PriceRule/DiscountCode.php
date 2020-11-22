<?php

namespace Helix\Shopify\PriceRule;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\PriceRule;

/**
 * A price rule discount code.
 *
 * @see https://help.shopify.com/en/api/reference/discounts/discountcode
 *
 * @method string   getCode         ()
 * @method string   getCreatedAt    ()
 * @method string   getPriceRuleId  () injected
 * @method string   getUpdatedAt    ()
 * @method int      getUsageCount   ()
 *
 * @method $this    setCode         (string $code)
 */
class DiscountCode extends AbstractEntity {

    use CrudTrait;

    const TYPE = 'discount_code';
    const DIR = 'discount_codes';

    protected function _container () {
        return $this->getPriceRule();
    }

    /**
     * @return PriceRule
     */
    public function getPriceRule () {
        return PriceRule::load($this, $this->getPriceRuleId());
    }
}