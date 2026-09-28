<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist', 'assistant_staff'], true);
    }

    public function view(User $user, Patient $patient): bool
    {
        return $user->clinic_id === $patient->clinic_id || $user->role === 'super_admin';
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->clinic_id === $patient->clinic_id && in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->clinic_id === $patient->clinic_id && in_array($user->role, ['super_admin', 'clinic_owner'], true);
    }
}
