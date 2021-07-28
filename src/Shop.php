<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\ImmutableInterface;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Base\Data;
use LogicException;

/**
 * The shop.
 *
 * @immutable Cannot be modified via the API.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/store-properties/shop
 *
 * @method string   getAddress1                     ()
 * @method string   getAddress2                     ()
 * @method bool     isCheckoutApiSupported          ()
 * @method string   getCity                         ()
 * @method string   getCountry                      ()
 * @method string   getCountryCode                  ()
 * @method string   getCountryName                  ()
 * @method string   getCountyTaxes                  ()
 * @method string   getCreatedAt                    ()
 * @method string   getCustomerEmail                ()
 * @method string   getCurrency                     ()
 * @method string   getDomain                       ()
 * @method string   getEnabledPresentmentCurrencies ()
 * @method bool     isEligibleForCardReaderGiveaway ()
 * @method bool     isEligibleForPayments           ()
 * @method string   getEmail                        ()
 * @method bool     isForceSsl                      ()
 * @method string   getGoogleAppsDomain             ()
 * @method bool     isGoogleAppsLoginEnabled        ()
 * @method bool     getHasDiscounts                 ()
 * @method bool     getHasGiftCards                 ()
 * @method bool     getHasStorefront                ()
 * @method string   getIanaTimezone                 ()
 * @method string   getLatitude                     ()
 * @method string   getLongitude                    ()
 * @method string   getMoneyFormat                  ()
 * @method string   getMoneyInEmailsFormat          ()
 * @method string   getMoneyWithCurrencyFormat      ()
 * @method string   getMoneyWithCurrencyInEmailsFormat()
 * @method bool     isMultiLocationEnabled          ()
 * @method string   getMyshopifyDomain              ()
 * @method string   getName                         ()
 * @method bool     isPasswordEnabled               ()
 * @method string   getPhone                        ()
 * @method string   getPlanDisplayName              ()
 * @method string   getPrimaryLocale                ()
 * @method string   getProvince                     ()
 * @method string   getProvinceCode                 ()
 * @method bool     getRequiresExtraPaymentsAgreement()
 * @method bool     isSetupRequired                 ()
 * @method string   getShopOwner                    ()
 * @method string   getSource                       ()
 * @method bool     getTaxesIncluded                ()
 * @method bool     getTaxShipping                  ()
 * @method string   getTimezone                     ()
 * @method string   getUpdatedAt                    ()
 * @method string   getWeightUnit                   ()
 * @method string   getZip                          ()
 */
class Shop extends AbstractEntity implements ImmutableInterface
{

    use MetafieldTrait;

    const TYPE = 'shop';

    /**
     * The shop is a special entity that isn't loaded by its id.
     *
     * @param Api|Data $caller
     * @param string $id ignored
     * @param array $query ignored
     * @internal Use {@link Api::getShop()} instead.
     */
    final public static function load($caller, string $id, array $query = [])
    {
        throw new LogicException;
    }

    /**
     * @param Api|Data $caller
     * @param string $path ignored
     * @param array $query ignored
     * @internal Use {@link Api::getShop()} instead.
     */
    final public static function loadAll($caller, string $path, array $query = [])
    {
        throw new LogicException;
    }

    /**
     * @return string
     */
    final public function __toString(): string
    {
        return 'shop';
    }

    /**
     * @param array $query
     * @return AbandonedCheckout[]
     */
    public function getAbandonedCheckouts(array $query = [])
    {
        $checkouts = $this->api->get('checkouts', $query)['checkouts'] ?? [];
        return $this->api->factoryAll($this, AbandonedCheckout::class, $checkouts);
    }

    /**
     * @return int
     */
    public function getAbandonedCheckoutsCount(): int
    {
        return $this->api->get('checkouts/count')['count'];
    }

    /**
     * @param string $code
     * @return Country
     */
    public function newCountry(string $code)
    {
        return $this->api->factory($this, Country::class, [
            'code' => $code
        ]);
    }

    /**
     * @return Customer
     */
    public function newCustomer()
    {
        return $this->api->factory($this, Customer::class);
    }
}