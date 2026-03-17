<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESC product_variants');
foreach($columns as $col) {
    if($col->Field == 'photo') {
        print_r($col);
    }
}
