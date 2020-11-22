<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;

/**
 * A redirect.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/redirect
 *
 * @method string   getPath     ()
 * @method string   getTarget   ()
 *
 * @method $this    setPath     (string $path)
 * @method $this    setTarget   (string $target)
 */
class Redirect extends AbstractEntity {

    use CrudTrait;

    const TYPE = 'redirect';
    const DIR = 'redirects';

}