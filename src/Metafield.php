<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;

/**
 * A metafield.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/metafield
 *
 * @see MetafieldTrait::newMetafield()
 *
 * @method $this    setNamespace        (string $ns)    @depends create-only
 * @method $this    setKey              (string $key)   @depends create-only
 *
 * @method string   getCreatedAt    ()
 * @method string   getDescription  ()
 * @method string   getKey          ()
 * @method string   getNamespace    ()
 * @method string   getOwnerId      () injected
 * @method string   getOwnerResource() injected
 * @method string   getUpdatedAt    ()
 * @method string   getValueType    ()
 *
 * @method $this    setDescription  (string $description)
 */
class Metafield extends AbstractEntity {

    use CrudTrait;

    const TYPE = 'metafield';
    const DIR = 'metafields';

    const TYPE_INT = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_JSON = 'json_string';

    /**
     * @var AbstractEntity
     */
    protected $container;

    /**
     * @param AbstractEntity $container
     * @param array $data
     */
    public function __construct (AbstractEntity $container, array $data = []) {
        $this->container = $container;
        parent::__construct($container, $data);
    }

    final public function __toString (): string {
        return "metafields/{$this->getId()}";
    }

    protected function _container () {
        return $this->container;
    }

    protected function _dir (): string {
        if ($this->container instanceof Shop) {
            return 'metafields';
        }
        return "{$this->container}/metafields";
    }

    /**
     * @return AbstractEntity
     */
    public function getResource () {
        return $this->container;
    }

    /**
     * @return mixed
     */
    public function getValue () {
        if ($this->isJson()) {
            return json_decode($this->data['value'] ?? 'null', true, JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR);
        }
        return $this->data['value'] ?? null;
    }

    /**
     * @return bool
     */
    final public function isInt (): bool {
        return $this->getValueType() === self::TYPE_INT;
    }

    /**
     * @return bool
     */
    final public function isJson (): bool {
        return $this->getValueType() === self::TYPE_JSON;
    }

    /**
     * @return bool
     */
    final public function isString (): bool {
        return $this->getValueType() === self::TYPE_STRING;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue ($value) {
        if (is_int($value)) {
            $this->_set('value_type', self::TYPE_INT);
            return $this->_set('value', $value);
        }
        if (is_string($value)) {
            $this->_set('value_type', self::TYPE_STRING);
            return $this->_set('value', $value);
        }
        $this->_set('value_type', self::TYPE_JSON);
        return $this->_set('value', json_encode($value, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
    }
}