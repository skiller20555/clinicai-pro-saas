<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->clinic_id === $invoice->clinic_id && in_array($user->role, ['super_admin', 'clinic_owner', 'receptionist'], true);
    }
}
