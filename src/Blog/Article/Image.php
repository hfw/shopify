<?php

namespace Helix\Shopify\Blog\Article;

use Helix\Shopify\Base\Data;

/**
 * An article's image.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/article
 *
 * @method $this    setAttachment   (string $base64)
 * @method string   getCreatedAt    ()
 * @method string   getAlt          ()
 * @method $this    setAlt          (string $alt)
 * @method int      getWidth        ()
 * @method int      getHeight       ()
 * @method string   getSrc          ()
 * @method $this    setSrc          (string $src)
 */
class Image extends Data
{

}