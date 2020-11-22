<?php

use Helix\Shopify\Customer;

require_once 'init.php';

($customer = new Customer($api))
    ->setEmail(getenv('SHOPIFY_TEST_CUSTOMER_EMAIL'))
    ->setPassword(getenv('SHOPIFY_TEST_CUSTOMER_PASSWORD'))
    ->setFirstName('Test')
    ->setLastName('Customer')
    ->setTags('test')
    ->setAcceptsMarketing(false)
    ->setAcceptsMarketingUpdatedAt(date(DateTime::ISO8601))
    ->setNote('A test customer made via API')
    ->setPhone('+1.8558163857')
    ->setTaxExempt(true)
    ->setSendEmailInvite(false)
    ->setSendEmailWelcome(false);

$customer->newAddress()
    ->setCountry('US')
    ->setState('CA')
    ->setCity('Sacramento')
    ->setZip('95814')
    ->setAddress1('1315 10th St')
    ->setAddress2('Room B-27');

$customer->create();

$defaultAddress = $customer->newAddress()
    ->setCountry('CA')
    ->setProvince('ON')
    ->setCity('Ottawa')
    ->setZip('K2P 1L4')
    ->setAddress1('150 Elgin Street')
    ->setAddress2('8th Floor')
    ->create();

$customer->setDefaultAddress($defaultAddress);
assert($customer->getDefaultAddress() === $defaultAddress);