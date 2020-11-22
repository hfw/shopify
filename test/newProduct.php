<?php

use Helix\Shopify\Product;

require_once 'init.php';

($product = new Product($api))
    ->setBodyHtml('Lorem ipsum.')
    ->setHandle('test-' . uniqid())
    ->setProductType('Test Type')
    ->setTags('foo,bar')
    ->setTitle('Thing')
    ->setVendor('Test Vendor');

$sizes = $product->newOption('Size', ['Small', 'Medium', 'Large']);
$swatch = [
    'Red' => 'ff0000',
    'Green' => '00ff00',
    'Blue' => '0000ff',
];
$colors = $product->newOption('Color', array_keys($swatch));

foreach ($sizes as $i => $size) {
    foreach ($colors as $j => $color) {
        $sku = "{$size}-{$color}";
        $price = ($i + 1) * ($j + 1);
        $product->newVariant()
            ->setBarcode(uniqid())
            ->setCompareAtPrice($price + 1)
            ->setCountryCodeOfOrigin('US')
            ->setCost($price - 1)
            ->setGrams($i + 1)
            ->setInventoryManagement(Product\Variant::MANAGED_BY_SHOPIFY)
            ->setInventoryPolicy(Product\Variant::POLICY_CONTINUE)
            ->setInventoryQuantity(999)
            ->setOption1($size)
            ->setOption2($color)
            ->setPrice($price)
            ->setSku($sku)
            ->setTaxable(true)
            ->setTitle("{$size} {$color} Thing");
        $product->newImage()
            ->setSrc("https://ipsumimage.appspot.com/500x500,{$swatch[$color]}?l={$size}")
            ->setAlt($sku);
    }
}

// POST
$product->save();

// Assign images to variants.
$imageMap = [];
foreach ($product->getImages() as $image) {
    $imageMap[$image->getAlt()] = $image->getId();
}
foreach ($product->getVariants() as $variant){
    $variant->setImageId($imageMap[$variant->getSku()]);
}

// Add some metafields.
$product->newMetafield('test', 'foo')->setValue('bar');
$product->save();
foreach ($product->getVariants() as $variant) {
    $variant->newMetafield('test', 'foo')->setValue('bar');
    $variant->save();
}

echo "Created: {$product->getId()}\n\n";