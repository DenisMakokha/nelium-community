<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Testing authentication...\n";

// Check if user exists
$user = User::where('email', 'admin@nelium.com')->first();
if (!$user) {
    echo "❌ User not found\n";
    exit;
}

echo "✅ User found: {$user->name}\n";
echo "Email verified: " . ($user->email_verified_at ? "✅ Yes" : "❌ No") . "\n";

// Test password
$passwordCheck = Hash::check('password123', $user->password);
echo "Password check: " . ($passwordCheck ? "✅ Correct" : "❌ Wrong") . "\n";

// Test token creation
try {
    $token = $user->createToken('test-token')->plainTextToken;
    echo "✅ Token creation successful\n";
} catch (Exception $e) {
    echo "❌ Token creation failed: " . $e->getMessage() . "\n";
}

echo "\nAll users in database:\n";
$users = User::all(['id', 'name', 'email', 'email_verified_at']);
foreach ($users as $u) {
    echo "- {$u->name} ({$u->email}) - Verified: " . ($u->email_verified_at ? 'Yes' : 'No') . "\n";
}
