<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

echo "Checking Users and Roles...\n";

$users = User::all();
foreach ($users as $user) {
    try {
        $roles = implode(', ', $user->getRoleNames()->toArray());
        echo "ID: {$user->id} | Email: {$user->email} | Roles: [{$roles}]\n";
    } catch (\Exception $e) {
        echo "ID: {$user->id} | Email: {$user->email} | Error: Roles not setup correctly\n";
    }
}

// Make sure 'admin' role exists
if (!Role::where('name', 'admin')->exists()) {
    echo "Creating 'admin' role...\n";
    Role::create(['name' => 'admin']);
}

// Assign 'admin' role to admin@gmail.com if it doesn't have it
$admin = User::where('email', 'admin@gmail.com')->first();
if ($admin) {
    echo "Assigning 'admin' role to admin@gmail.com...\n";
    $admin->assignRole('admin');
}
