<?php

namespace Helix\Shopify\Product;

use Helix\Shopify\Base\Data;
use IteratorAggregate;
use Traversable;

/**
 * @method string   getId       ()
 * @method string   getName     ()
 * @method $this    setName     (string $name)
 * @method int      getPosition ()
 * @method string   getProductId()
 * @method string[] getValues   ()
 * @method $this    setValues   (string[] $values)
 */
class Option extends Data implements IteratorAggregate {

    /**
     * @return Traversable|string[]
     */
    public function getIterator () {
        yield from $this->_get('values', []);
    }
}