<?php

namespace Helix\Shopify\Collection;

use Helix\Shopify\Base\Data;
use Helix\Shopify\CustomCollection;
use Helix\Shopify\SmartCollection;

/**
 * A collection image.
 *
 * @see CustomCollection
 * @see SmartCollection
 *
 * @method $this    setAttachment   (string $base64)
 * @method string   getCreatedAt    ()
 * @method string   getAlt          ()
 * @method $this    setAlt          (string $alt)
 * @method int      getWidth        ()
 * @method int      getHeight       ()
 * @method string   getSrc          ()
 * @method $this    setSrc          ()
 */
class Image extends Data {

}