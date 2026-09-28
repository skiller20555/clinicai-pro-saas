<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'description' => 'Platform-wide administrator'],
            ['name' => 'clinic_owner', 'description' => 'Clinic owner and medical lead'],
            ['name' => 'receptionist', 'description' => 'Appointment and billing operations'],
            ['name' => 'assistant_staff', 'description' => 'Support and patient workflow tasks'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['guard_name' => 'web', 'description' => $roleData['description']]
            );
        }

        $permissions = [
            'manage_clinics',
            'manage_patients',
            'manage_appointments',
            'manage_billing',
            'manage_ai_assistance',
            'view_reports',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName],
                ['guard_name' => 'web', 'description' => ucfirst(str_replace('_', ' ', $permissionName))]
            );
        }

        $clinic = Clinic::firstOrCreate([
            'slug' => 'demo-clinic',
        ], [
            'name' => 'Demo Clinic',
            'status' => 'active',
            'owner_user_id' => null,
            'timezone' => 'UTC',
        ]);

        User::firstOrCreate([
            'email' => 'admin@clinicai.local',
        ], [
            'clinic_id' => $clinic->id,
            'name' => 'ClinicAI Admin',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }
}
