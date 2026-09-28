<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tooth;
use App\Models\TreatmentPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DentalController extends Controller
{
    public function index(Request $request)
    {
        $clinic_id = $request->user()->clinic_id;
        $patient_id = $request->query('patient_id');

        $teeth = Tooth::query();
        $plans = TreatmentPlan::query();

        if ($patient_id) {
            $teeth->where('patient_id', $patient_id);
            $plans->where('patient_id', $patient_id);
        }

        return response()->json([
            'data' => [
                'teeth' => $teeth->where('clinic_id', $clinic_id)->get(),
                'treatment_plans' => $plans->where('clinic_id', $clinic_id)->with('doctor')->get(),
            ],
            'message' => 'Dental records retrieved successfully.',
        ]);
    }

    public function storeTooth(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tooth_number' => 'required|integer|min:1|max:32',
            'tooth_position' => 'required|string|max:50',
            'condition' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $tooth = Tooth::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
        ]);

        return response()->json([
            'data' => $tooth,
            'message' => 'Dental chart entry created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function storeTreatmentPlan(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'estimated_cost' => 'required|numeric|min:0',
            'planned_date' => 'required|date',
        ]);

        $plan = TreatmentPlan::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'status' => 'draft',
        ]);

        return response()->json([
            'data' => $plan,
            'message' => 'Treatment plan created successfully.',
        ], Response::HTTP_CREATED);
    }
}
