<?php

use Helix\Shopify\Product;

require_once __DIR__ . '/../init.php';

foreach (Product::search($api, []) as $product) {
    $product->delete();
}
