<?php
include 'vendor/autoload.php';
$app = include_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = Illuminate\Support\Facades\DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $name = array_values((array)$table)[0];
    if (str_contains($name, 'review') || str_contains($name, 'feedback') || str_contains($name, 'contact') || str_contains($name, 'page') || str_contains($name, 'post') || str_contains($name, 'blog')) {
        echo $name . PHP_EOL;
    }
}
