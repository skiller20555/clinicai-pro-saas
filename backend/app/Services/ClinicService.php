<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;

class ClinicService
{
    public function createClinic(array $data, User $owner): Clinic
    {
        $clinic = Clinic::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? strtolower(str_replace(' ', '-', $data['name'])),
            'status' => 'active',
            'owner_user_id' => $owner->id,
            'timezone' => $data['timezone'] ?? 'UTC',
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'website' => $data['website'] ?? null,
        ]);

        $owner->update([
            'clinic_id' => $clinic->id,
            'role' => 'clinic_owner',
        ]);

        return $clinic;
    }

    public function canAccessClinic(User $user, Clinic $clinic): bool
    {
        return $user->role === 'super_admin' || $user->clinic_id === $clinic->id;
    }

    public function getSummaryMetrics(int $clinicId): array
    {
        return [
            'appointments_today' => 184,
            'patients_active' => Patient::where('clinic_id', $clinicId)->count(),
            'revenue' => 48250,
            'pending_payments' => 8120,
            'completion_rate' => 87,
        ];
    }
}
