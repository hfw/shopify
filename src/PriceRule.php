<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\PriceRule\DiscountCode;
use Helix\Shopify\PriceRule\QuantityRatio;

/**
 * A price rule.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/discounts/pricerule
 *
 * @method int          getAllocationLimit              ()
 * @method string       getAllocationMethod             () see the constants
 * @method string       getCreatedAt                    ()
 * @method string       getCustomerSelection            () see the constants
 * @method string       getEndsAt                       ()
 * @method string[]     getEntitledCollectionIds        ()
 * @method string[]     getEntitledCountryIds           ()
 * @method string[]     getEntitledProductIds           ()
 * @method string[]     getEntitledVariantIds           ()
 * @method bool         isOncePerCustomer               ()
 * @method string[]     getPrerequisiteCollectionIds    ()
 * @method string[]     getPrerequisiteCustomerIds      ()
 * @method string[]     getPrerequisiteProductIds       ()
 * @method string[]     getPrerequisiteSavedSearchIds   ()
 * @method string[]     getPrerequisiteVariantIds       ()
 * @method string       getStartsAt                     ()
 * @method string       getTargetSelection              () see the constants
 * @method string       getTargetType                   () see the constants
 * @method string       getTitle                        ()
 * @method string       getUpdatedAt                    ()
 * @method string       getUsageLimit                   ()
 * @method int          getValue                        ()
 * @method string       getValueType                    ()
 *
 * @method bool         hasEntitledCollectionIds        ()
 * @method bool         hasEntitledCountryIds           ()
 * @method bool         hasEntitledProductIds           ()
 * @method bool         hasEntitledVariantIds           ()
 * @method bool         hasPrerequisiteCollectionIds    ()
 * @method bool         hasPrerequisiteCustomerIds      ()
 * @method bool         hasPrerequisiteProductIds       ()
 * @method bool         hasPrerequisiteSavedSearchIds   ()
 * @method bool         hasPrerequisiteVariantIds       ()
 *
 * @method $this        setAllocationLimit              (int $limit)
 * @method $this        setAllocationMethod             (string $method) see the constants
 * @method $this        setCustomerSelection            (string $selection) see the constants
 * @method $this        setEndsAt                       (string $iso8601)
 * @method $this        setEntitledCollectionIds        (string[] $ids)
 * @method $this        setEntitledCountryIds           (string[] $ids)
 * @method $this        setEntitledProductIds           (string[] $ids)
 * @method $this        setEntitledVariantIds           (string[] $ids)
 * @method $this        setOncePerCustomer              (bool $once)
 * @method $this        setPrerequisiteCollectionIds    (string[] $ids)
 * @method $this        setPrerequisiteCustomerIds      (string[] $ids)
 * @method $this        setPrerequisiteProductIds       (string[] $ids)
 * @method $this        setPrerequisiteSavedSearchIds   (string[] $ids)
 * @method $this        setPrerequisiteVariantIds       (string[] $ids)
 * @method $this        setStartsAt                     (string $iso8601)
 * @method $this        setTargetSelection              (string $selection) see the constants
 * @method $this        setTargetType                   (string $type) see the constants
 * @method $this        setTitle                        (string $title)
 * @method $this        setUsageLimit                   (string $limit)
 * @method $this        setValue                        (int $value) negative
 * @method $this        setValueType                    (string $type)
 */
class PriceRule extends AbstractEntity
{

    const TYPE = 'price_rule';
    const DIR = 'price_rules';

    const ALLOCATE_EACH = 'each';
    const ALLOCATE_ACROSS = 'across';

    const CUSTOMER_SELECT_ALL = 'all';
    const CUSTOMER_SELECT_CONDITION = 'prerequisite';

    const TARGET_SELECT_ALL = 'all';
    const TARGET_SELECT_ENTITLED = 'entitled';

    const TARGET_TYPE_LINE_ITEM = 'line_item';
    const TARGET_TYPE_SHIPPING_LINE = 'shipping_line';

    const VALUE_FIXED = 'fixed';
    const VALUE_PERCENT = 'percentage';

    const MAP = [
        'prerequisite_to_entitlement_quantity_ratio' => QuantityRatio::class
    ];

    /**
     * @return DiscountCode[]
     */
    public function getDiscountCodes()
    {
        return DiscountCode::loadAll($this, "{$this}/discount_codes");
    }

    /**
     * @return null|number
     */
    public function getMaxShipping()
    {
        return $this->data['prerequisite_shipping_price_range']['less_than_or_equal_to'] ?? null;
    }

    /**
     * @return null|int
     */
    public function getMinQuantity()
    {
        return $this->data['prerequisite_quantity_range']['greater_than_or_equal_to'] ?? null;
    }

    /**
     * @return null|number
     */
    public function getMinSubtotal()
    {
        return $this->data['prerequisite_subtotal_range']['greater_than_or_equal_to'] ?? null;
    }

    /**
     * @return DiscountCode
     */
    public function newDiscountCode()
    {
        return $this->api->factory($this, DiscountCode::class, [
            'price_rule_id' => $this->getId()
        ]);
    }

    /**
     * @param null|number $max
     * @return $this
     */
    public function setMaxShipping($max)
    {
        return $this->_set('prerequisite_shipping_price_range', isset($max) ? ['less_than_or_equal_to' => $max] : null);
    }

    /**
     * @param null|int $min
     * @return $this
     */
    public function setMinQuantity(?int $min)
    {
        return $this->_set('prerequisite_quantity_range', isset($min) ? ['greater_than_or_equal_to' => $min] : null);
    }

    /**
     * @param null|number $min
     * @return $this
     */
    public function setMinSubtotal($min)
    {
        return $this->_set('prerequisite_subtotal_range', isset($min) ? ['greater_than_or_equal_to' => $min] : null);
    }
}