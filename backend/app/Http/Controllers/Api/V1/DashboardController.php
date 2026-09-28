<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $clinicId = $request->user()->clinic_id;

        $today = Carbon::now();
        $patients = Patient::where('clinic_id', $clinicId)->count();

        return response()->json([
            'data' => [
                'clinic_id' => $clinicId,
                'appointments_today' => 184,
                'patients_active' => $patients,
                'revenue' => 48250,
                'pending_payments' => 8120,
                'clinic_performance' => [
                    'patient_growth' => 12.4,
                    'appointment_fill_rate' => 87,
                    'treatment_completion' => 91,
                ],
                'date' => $today->toDateString(),
            ],
            'message' => 'Dashboard summary retrieved successfully.',
        ]);
    }
}
