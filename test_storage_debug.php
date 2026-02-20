<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "APP_URL: " . config('app.url') . "\n";
echo "Storage Path: " . storage_path('app/public') . "\n";
echo "Public Path: " . public_path('storage') . "\n";
try {
    echo "Public Disk URL: " . Illuminate\Support\Facades\Storage::disk('public')->url('test.jpg') . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
