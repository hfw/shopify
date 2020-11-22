<?php

use Helix\Shopify\Customer;

require_once __DIR__ . '/../init.php';

foreach (Customer::search($api, []) as $customer) {
    $customer->delete();
}