<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

ob_start();
echo "--- ORDER_PRODUCTS TABLE COLUMNS ---\n";
$columns = DB::getSchemaBuilder()->getColumnListing('order_products');
print_r($columns);

echo "\n--- SAMPLE ORDER_PRODUCT ---\n";
$sample = DB::table('order_products')->latest()->first();
print_r($sample);

echo "\n--- LAST 5 ORDERS ---\n";
$orders = \App\Models\Order::latest()->take(5)->get();
foreach($orders as $o) {
    echo "ID: {$o->id} | OrderID: {$o->order_id} | Type: " . ($o->payment_type ?? 'N/A') . " | Status: {$o->payment_status}\n";
}

echo "\n--- ORDER PRODUCTS FOR LAST ORDER ---\n";
if($orders->count() > 0) {
    $last = $orders->first();
    $items = \App\Models\OrderProduct::where('order_id', $last->id)->get();
    echo "Items Count for Order {$last->id}: " . $items->count() . "\n";
    foreach($items as $i) {
        echo "  - Product ID: {$i->product_id} | Amount: {$i->amount} | Option: {$i->option}\n";
    }
}
$output = ob_get_clean();
file_put_contents('debug_output.txt', $output);
echo "Output saved to debug_output.txt";
