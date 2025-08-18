<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== DEBUGGING MEMBERS SECTION ===\n\n";

// Check total users
$totalUsers = User::count();
echo "Total users in database: $totalUsers\n";

// Check users by role
$adminUsers = User::where('role', 'admin')->count();
$memberUsers = User::where('role', 'member')->count();
echo "Admin users: $adminUsers\n";
echo "Member users: $memberUsers\n\n";

// Show all users with their roles
echo "All users:\n";
$users = User::select('id', 'name', 'email', 'role')->get();
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

echo "\n=== TESTING MEMBERS API QUERY ===\n";

// Test the exact query from AdminController
$query = User::with(['subscription.plan'])
    ->where('role', 'member');

$members = $query->paginate(20);
echo "Members found: " . $members->total() . "\n";
echo "Current page: " . $members->currentPage() . "\n";
echo "Per page: " . $members->perPage() . "\n";

if ($members->count() > 0) {
    echo "\nMember details:\n";
    foreach ($members as $member) {
        echo "- {$member->name} ({$member->email})\n";
        if ($member->subscription) {
            echo "  Subscription: {$member->subscription->status} - Plan: " . ($member->subscription->plan->name ?? 'N/A') . "\n";
        } else {
            echo "  No subscription\n";
        }
    }
} else {
    echo "\nNo members found. Let's check what roles exist:\n";
    $roles = User::distinct()->pluck('role');
    foreach ($roles as $role) {
        echo "- Role: '$role'\n";
    }
}

echo "\n=== CHECKING SUBSCRIPTIONS ===\n";
$subscriptions = \App\Models\Subscription::with('plan', 'user')->get();
echo "Total subscriptions: " . $subscriptions->count() . "\n";
foreach ($subscriptions as $sub) {
    echo "- User: {$sub->user->name} - Status: {$sub->status} - Plan: " . ($sub->plan->name ?? 'N/A') . "\n";
}
