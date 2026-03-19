<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\ProductVariant;

try {
    // 1. Create a dummy category ID if needed (or just use 1)
    $category_id = 1; 

    // 2. Create Product
    $prod = Product::create([
        'name' => 'Legacy Sky Blue Leggings',
        'slug' => 'legacy-sky-blue-' . time(),
        'category' => $category_id,
        'description' => '<p>This is a dummy product created to test the <b>Blue Color (#00BFFF)</b> swatch in the frontend.</p>',
        'regular_price' => 500,
        'stock' => 50,
        'status' => 'active',
        'tax_id' => 1,
        'discount' => 5,
        'discount_type' => 'fixed',
        'tag' => 'Dummy'
    ]);

    // 3. Create Variant with EXACT BLUE HEX CODE
    ProductVariant::create([
        'product_id' => $prod->id,
        'variants' => 'M Blue',
        'sku' => 'SKU-' . time(),
        'regular_price' => 500,
        'sale_price' => 495,
        'in_stock' => 50,
        'colors' => '#00BFFF', // <--- EXACT BLUE HEX
        'status' => 'active'
    ]);

    echo "\nSUCCESS! Dummy blue product created.\n";
    echo "Product Name: " . $prod->name . "\n";
    echo "Slug: " . $prod->slug . "\n";
    echo "Color: #00BFFF\n";
    echo "You can view this at your website domain + /product/" . $prod->slug . "\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
