<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\ImmutableInterface;

/**
 * A Shopify+ store staff account.
 *
 * @immutable Cannot be modified via the API.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/plus/user
 *
 * @method bool     isAccountOwner          ()
 * @method string   getBio                  ()
 * @method string   getEmail                ()
 * @method string   getFirstName            ()
 * @method string   getIm                   ()
 * @method string   getLastName             ()
 * @method string   getLocale               ()
 * @method string[] getPermissions          ()
 * @method string   getPhone                ()
 * @method int      getReceiveAnnouncements () `0|1`
 * @method string   getUrl                  ()
 * @method string   getUserType             ()
 *
 * @method bool hasPermissions  ()
 */
class User extends AbstractEntity implements ImmutableInterface {

    const PERM_APPLICATIONS = 'applications';
    const PERM_CUSTOMERS = 'customers';
    const PERM_DASHBOARD = 'dashboard';
    const PERM_FULL = 'full';
    const PERM_GIFT_CARDS = 'gift_cards';
    const PERM_LINKS = 'links';
    const PERM_MARKETING = 'marketing';
    const PERM_ORDERS = 'orders';
    const PERM_PAGES = 'pages';
    const PERM_PREFERENCES = 'preferences';
    const PERM_PRODUCTS = 'products';
    const PERM_REPORTS = 'reports';
    const PERM_THEMES = 'themes';

    const TYPE_COLLABORATOR = 'collaborator';
    const TYPE_INVITED = 'invited';
    const TYPE_REGULAR = 'regular';
    const TYPE_RESTRICTED = 'restricted';

}