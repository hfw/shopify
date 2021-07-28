<?php

namespace Helix\Shopify\Theme;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\DeleteTrait;
use Helix\Shopify\Base\AbstractEntity\UpdateTrait;

/**
 * A theme asset.
 *
 * TODO
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/asset
 *
 * @method string   getAttachment   ()
 * @method string   getContentType  () read-only
 * @method string   getCreatedAt    () read-only
 * @method string   getKey          ()
 * @method string   getPublicUrl    () read-only
 * @method int      getSize         () read-only
 * @method string   getSourceKey    ()
 * @method string   getSrc          ()
 * @method string   getThemeId      () injected, read-only
 * @method string   getUpdatedAt    () read-only
 * @method string   getValue        ()
 *
 * @method $this setAttachment  (string $attachment)
 * @method $this setKey         (string $key)
 * @method $this setSourceKey   (string $key)
 * @method $this setSrc         (string $src)
 * @method $this setValue       (string $value)
 */
class Asset extends AbstractEntity
{

    use UpdateTrait;
    use DeleteTrait;

    const TYPE = 'asset';

}