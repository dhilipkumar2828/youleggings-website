<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$productId = 4;
$variants = DB::table('product_variants')->where('product_id', $productId)->get();

foreach($variants as $variant) {
    echo "ID: " . $variant->id . " | Photo: [" . $variant->photo . "]\n";
}
