<?php

namespace App\Providers;

use App\Models\Clinic;
use App\Policies\BillingPolicy;
use App\Policies\ClinicPolicy;
use App\Policies\PatientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Clinic::class => ClinicPolicy::class,
        \App\Models\Patient::class => PatientPolicy::class,
        \App\Models\Invoice::class => BillingPolicy::class,
    ];

    public function register(): void
    {
        // Register application-level services here.
    }

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user && $user->role === 'super_admin') {
                return true;
            }

            return null;
        });
    }
}
