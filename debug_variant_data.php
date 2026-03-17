<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$productId = 4;
$product = DB::table('products')->where('id', $productId)->first();
$variants = DB::table('product_variants')->where('product_id', $productId)->get();
$attributes = DB::table('product_attributes')->where('product_id', $productId)->get();

echo "Product: " . $product->name . "\n";
echo "Attributes:\n";
foreach($attributes as $attr) {
    echo " - " . $attr->attribute_name . ": " . $attr->attribute_value . "\n";
}
echo "Variants:\n";
foreach($variants as $variant) {
    echo " - ID: " . $variant->id . ", SKU: " . $variant->sku . ", Variants: " . $variant->variants . ", Photo: " . $variant->photo . "\n";
}
