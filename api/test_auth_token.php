<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== TESTING AUTHENTICATION TOKEN ===\n\n";

// Find admin user
$admin = User::where('role', 'admin')->first();

if (!$admin) {
    echo "No admin user found!\n";
    exit(1);
}

echo "Admin user found: {$admin->name} ({$admin->email})\n";

// Create a token for testing
$token = $admin->createToken('admin-test')->plainTextToken;
echo "Generated token: {$token}\n\n";

echo "You can use this token to test the API:\n";
echo "Authorization: Bearer {$token}\n\n";

// Test the members endpoint with this token
echo "Testing members endpoint...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/admin/members');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json',
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: {$httpCode}\n";
echo "Response: " . substr($response, 0, 500) . "...\n";
