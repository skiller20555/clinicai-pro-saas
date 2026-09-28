<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class ClinicalDemoSeeder extends Seeder
{
    public function run(): void
    {
        $clinic = Clinic::first();

        if (! $clinic) {
            return;
        }

        Patient::firstOrCreate(
            [
                'clinic_id' => $clinic->id,
                'email' => 'john.doe@example.com',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'date_of_birth' => '1990-04-18',
                'gender' => 'male',
                'phone' => '+1234567890',
                'address' => '123 Wellness Ave',
                'city' => 'Smalltown',
                'state' => 'CA',
                'postal_code' => '90001',
                'country' => 'USA',
                'status' => 'active',
            ]
        );
    }
}
