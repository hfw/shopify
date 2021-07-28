<?php

namespace Helix\Shopify\Base\AbstractEntity;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Metafield;

/**
 * Adds metafields to an entity.
 *
 * @see https://help.shopify.com/en/api/reference/metafield
 *
 * @mixin AbstractEntity
 */
trait MetafieldTrait
{

    /**
     * @return string
     */
    protected function _metafieldType(): string
    {
        return static::TYPE;
    }

    /**
     * @return Metafield[]
     */
    public function getMetafields()
    {
        assert($this->hasId());
        // the endpoints are all over the place.
        // querying the main directory works for all entities.
        $remote = $this->api->get('metafields', [
            'metafield[owner_id]' => $this->getId(),
            'metafield[owner_resource]' => $this->_metafieldType()
        ]);
        /** @var AbstractEntity $that */
        $that = $this;
        return $this->api->factoryAll($that, Metafield::class, $remote['metafields']);
    }

    /**
     * Factory.
     *
     * @return Metafield
     */
    public function newMetafield()
    {
        assert($this->hasId());
        /** @var AbstractEntity $that */
        $that = $this;
        return $this->api->factory($that, Metafield::class, [
            'owner_resource' => $this->_metafieldType(),
            'owner_id' => $this->getId()
        ]);
    }
}