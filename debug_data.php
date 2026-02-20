<?php
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\CartTable;
use Illuminate\Support\Facades\DB;

echo "--- Products ---\n";
$product = Product::where('title', 'like', '%Test_product1%')->first();
if ($product) {
    echo "Product ID: " . $product->id . "\n";
    echo "Product Title: " . $product->title . "\n";
    
    echo "\n--- Variants ---\n";
    $variants = ProductVariant::where('product_id', $product->id)->get();
    foreach ($variants as $v) {
        echo "ID: " . $v->id . ", Variants: '" . $v->variants . "', Colors: '" . $v->colors . "'\n";
    }

    echo "\n--- Cart (All) ---\n";
    $carts = DB::table('cart_tables')->get();
    foreach ($carts as $c) {
        echo "Cart ID: " . $c->id . ", Product ID: " . $c->product_id . ", Attribute Name: '" . $c->arrtibute_name . "', Product Color: '" . $c->product_color . "'\n";
    }
} else {
    echo "Product not found.\n";
}
