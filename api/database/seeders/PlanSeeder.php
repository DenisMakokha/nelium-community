<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'code' => 'FREE_MONTHLY',
                'name' => 'Free Membership',
                'price_cents' => 0,
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Access to public announcements',
                    'Limited event access',
                    'Basic community features'
                ],
                'is_active' => true
            ],
            [
                'code' => 'IND_MONTHLY',
                'name' => 'Individual Membership',
                'price_cents' => 800000, // KES 8,000
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Full access to resources',
                    'All events and RSVP',
                    'Member directory access',
                    'Priority support'
                ],
                'is_active' => true
            ],
            [
                'code' => 'IND_ANNUAL',
                'name' => 'Individual Membership (Annual)',
                'price_cents' => 8000000, // KES 80,000
                'currency' => 'KES',
                'billing_cycle' => 'annual',
                'features' => [
                    'Full access to resources',
                    'All events and RSVP',
                    'Member directory access',
                    'Priority support',
                    '2 months free'
                ],
                'is_active' => true
            ],
            [
                'code' => 'INST_MONTHLY',
                'name' => 'Institutional Membership',
                'price_cents' => 3500000, // KES 35,000
                'currency' => 'KES',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Multi-seat access',
                    'Analytics and reporting',
                    'Priority event listings',
                    'Dedicated support',
                    'Custom branding options'
                ],
                'is_active' => true
            ],
            [
                'code' => 'INST_ANNUAL',
                'name' => 'Institutional Membership (Annual)',
                'price_cents' => 35000000, // KES 350,000
                'currency' => 'KES',
                'billing_cycle' => 'annual',
                'features' => [
                    'Multi-seat access',
                    'Analytics and reporting',
                    'Priority event listings',
                    'Dedicated support',
                    'Custom branding options',
                    '2 months free'
                ],
                'is_active' => true
            ]
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::firstOrCreate(
                ['code' => $plan['code']],
                $plan
            );
        }
    }
}
