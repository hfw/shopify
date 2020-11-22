<?php

use Helix\Shopify\Customer;

require_once 'init.php';

for ($i = 1; $i <= 200; $i++) {
    echo "{$i}/200: Bucket = {$api->getBucket()}\n";
    iterator_to_array(Customer::search($api, []));
}