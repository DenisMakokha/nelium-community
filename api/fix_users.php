<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Fixing user credentials...\n";

// Update admin user
$admin = User::where('email', 'admin@nelium.com')->first();
if ($admin) {
    $admin->update([
        'name' => 'Admin User',
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
        'role' => 'admin'
    ]);
    echo "✅ Updated admin user\n";
}

// Update member user  
$member = User::where('email', 'member@nelium.com')->first();
if ($member) {
    $member->update([
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
        'role' => 'member'
    ]);
    echo "✅ Updated member user\n";
}

// Update john user
$john = User::where('email', 'john@example.com')->first();
if ($john) {
    $john->update([
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
        'role' => 'member'
    ]);
    echo "✅ Updated john user\n";
}

echo "Testing login for admin@nelium.com...\n";
$testUser = User::where('email', 'admin@nelium.com')->first();
$passwordCheck = Hash::check('password123', $testUser->password);
echo "Password check: " . ($passwordCheck ? "✅ Success" : "❌ Failed") . "\n";
echo "Email verified: " . ($testUser->email_verified_at ? "✅ Yes" : "❌ No") . "\n";

echo "\nCredentials ready:\n";
echo "Admin: admin@nelium.com / password123\n";
echo "Member: member@nelium.com / password123\n";
echo "Member 2: john@example.com / password123\n";
