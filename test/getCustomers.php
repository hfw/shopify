<?php

use Helix\Shopify\Customer;

require_once 'init.php';

foreach (Customer::search($api, []) as $customer) {
    echo "{$customer->getId()}: {$customer->getEmail()}\n";
}

echo "\n";