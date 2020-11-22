<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;

/**
 * A page.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/page
 *
 * @method string       getAuthor           ()
 * @method string       getBodyHtml         ()
 * @method string       getCreatedAt        ()
 * @method string       getHandle           ()
 * @method null|string  getPublishedAt      ()
 * @method string       getShopId           () injected
 * @method string       getTemplateSuffix   ()
 * @method string       getTitle            ()
 * @method string       getUpdatedAt        ()
 *
 * @method $this setAuthor          (string $author)
 * @method $this setBodyHtml        (string $html)
 * @method $this setHandle          (string $handle)
 * @method $this setId              (string $id)
 * @method $this setPublishedAt     (?string $iso8601)
 * @method $this setTemplateSuffix  (string $suffix)
 * @method $this setTitle           (string $title)
 */
class Page extends AbstractEntity {

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'page';
    const DIR = 'pages';

}