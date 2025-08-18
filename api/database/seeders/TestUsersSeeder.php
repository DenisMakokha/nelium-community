<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestUsersSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@nelium.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'org' => 'Nelium Community',
                'country' => 'Kenya',
                'profession' => 'Administrator'
            ]
        );

        // Create Member User
        $member = User::firstOrCreate(
            ['email' => 'member@nelium.com'],
            [
                'name' => 'Test Member',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'member',
                'org' => 'Test Organization',
                'country' => 'Kenya',
                'profession' => 'Developer'
            ]
        );

        // Create another Member User
        $member2 = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'member',
                'org' => 'Example Corp',
                'country' => 'Kenya',
                'profession' => 'Designer'
            ]
        );

        $this->command->info('Test users created successfully!');
        $this->command->info('Admin: admin@nelium.com / password123');
        $this->command->info('Member: member@nelium.com / password123');
        $this->command->info('Member 2: john@example.com / password123');
    }
}
