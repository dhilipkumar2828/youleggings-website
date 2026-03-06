<?php
$source = __DIR__ . '/public/premium_assets/images/Products/';
$destBase = __DIR__ . '/public/uploads/';

$dirs = ['banner', 'category', 'about', 'product', 'blog'];
foreach ($dirs as $d) {
    if (!is_dir($destBase . $d)) {
        mkdir($destBase . $d, 0777, true);
        echo "Created dir: $d\n";
    }
}

// Copy some files for the seeder
$files = [
    '_DSC8716-Edit.jpg' => 'banner',
    '_DSC8723-Edit.jpg' => 'banner',
    '_DSC7786-Edit.jpg' => 'category',
    '_DSC8065-Edit.jpg' => 'category',
    '_DSC8489-Edit.jpg' => 'category',
    '_DSC8832.jpg' => 'category',
    '_DSC8682-Edit.jpg' => 'about',
    '_DSC8510-Edit.jpg' => 'product',
    '_DSC8533-Edit.jpg' => 'product',
    '_DSC8541-Edit.jpg' => 'product',
    '_DSC8587-Edit.jpg' => 'product',
    '_DSC8752-Edit.jpg' => 'product',
    '_DSC8785-Edit.jpg' => 'product',
    '_DSC8789-Edit.jpg' => 'product',
    '_DSC8910.jpg' => 'product',
];

foreach ($files as $f => $d) {
    if (file_exists($source . $f)) {
        copy($source . $f, $destBase . $d . '/' . $f);
        echo "Copied $f to uploads/$d\n";
    } else {
        echo "Source file not found: $f\n";
    }
}
