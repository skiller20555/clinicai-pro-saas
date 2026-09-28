<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClinicPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }

    public function view(User $user, Clinic $clinic): bool
    {
        return $user->clinic_id === $clinic->id || $user->role === 'super_admin';
    }

    public function update(User $user, Clinic $clinic): bool
    {
        return $user->role === 'super_admin' || ($user->role === 'clinic_owner' && $user->clinic_id === $clinic->id);
    }
}
