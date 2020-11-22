<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Theme\Asset;

/**
 * A theme.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/theme
 *
 * @method $this setSrc (string $src) @depends create-only
 *
 * @method string   getCreatedAt    () read-only
 * @method string   getName         ()
 * @method bool     isPreviewable   () read-only
 * @method bool     isProcessing    () read-only
 * @method string   getRole         ()
 * @method string   getSrc          ()
 * @method string   getThemeStoreId () read-only
 * @method string   getUpdatedAt    () read-only
 *
 * @method $this setName (string $name)
 * @method $this setRole (string $role)
 */
class Theme extends AbstractEntity {

    use CrudTrait;

    const TYPE = 'theme';
    const DIR = 'themes';

    const ROLE_MAIN = 'main';
    const ROLE_UNPUBLISHED = 'unpublished';
    const ROLE_DEMO = 'demo';

    /**
     * @return Asset[]
     */
    public function getAssets () {
        return Asset::loadAll($this, "{$this}/assets");
    }

    /**
     * @return Asset
     */
    public function newAsset () {
        return $this->api->factory($this, Asset::class, [
            'theme_id' => $this->getId()
        ]);
    }
}