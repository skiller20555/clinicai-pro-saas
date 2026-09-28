<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class SaaSPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'For small clinics with essential patient and billing features.',
                'monthly_price' => 49,
                'annual_price' => 490,
                'trial_days' => 14,
                'features' => ['patient management', 'appointments', 'basic billing'],
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For clinics requiring AI assistance and expansion tools.',
                'monthly_price' => 99,
                'annual_price' => 990,
                'trial_days' => 21,
                'features' => ['advanced records', 'AI assistance', 'dental workflow'],
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For multi-clinic operations and broader platform controls.',
                'monthly_price' => 199,
                'annual_price' => 1990,
                'trial_days' => 30,
                'features' => ['multi-clinic management', 'priority support', 'advanced analytics'],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate([
                'slug' => $plan['slug'],
            ], $plan);
        }
    }
}
