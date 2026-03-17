<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$productId = 4;
$variants = DB::table('product_variants')->where('product_id', $productId)->get();
$output = "";
foreach($variants as $variant) {
    $output .= "ID: " . $variant->id . " | Photo: [" . $variant->photo . "]\n";
}
file_put_contents('photos_raw.txt', $output);
echo "Done\n";
