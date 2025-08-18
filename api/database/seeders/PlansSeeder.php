<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansSeeder extends Seeder
{
    public function run()
    {
        // Free Plan
        Plan::firstOrCreate(
            ['code' => 'free'],
            [
                'name' => 'Free',
                'price_cents' => 0,
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Access to public announcements',
                    'Limited event access',
                    'Basic community features'
                ]),
                'is_active' => true
            ]
        );

        // Individual Plan
        Plan::firstOrCreate(
            ['code' => 'individual'],
            [
                'name' => 'Individual',
                'price_cents' => 800000, // KES 8,000
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Full access to resources',
                    'All events and RSVP',
                    'Member directory access',
                    'Priority support'
                ]),
                'is_active' => true
            ]
        );

        // Institutional Plan
        Plan::firstOrCreate(
            ['code' => 'institutional'],
            [
                'name' => 'Institutional',
                'price_cents' => 3500000, // KES 35,000
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Multi-seat access',
                    'Analytics and reporting',
                    'Priority event listings',
                    'Dedicated support',
                    'Custom branding options'
                ]),
                'is_active' => true
            ]
        );

        $this->command->info('Plans created successfully!');
    }
}
