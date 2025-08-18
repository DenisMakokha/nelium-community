<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

echo "=== TESTING MEMBERS API ENDPOINT ===\n\n";

// Create a mock request
$request = new Request();

// Create controller instance
$controller = new AdminController();

try {
    // Call the members method
    $response = $controller->members($request);
    
    echo "API Response Status: " . $response->getStatusCode() . "\n";
    echo "API Response Content:\n";
    echo $response->getContent() . "\n";
    
} catch (Exception $e) {
    echo "Error calling members API: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
