<?php

use Helix\Shopify\Product;

require_once 'init.php';

var_dump(Product::load($api, ['id' => $argv[1]]));