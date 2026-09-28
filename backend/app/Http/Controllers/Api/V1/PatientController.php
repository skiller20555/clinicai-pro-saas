<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $clinic_id = $request->user()->clinic_id;
        $patients = Patient::where('clinic_id', $clinic_id)
            ->paginate(20);

        return response()->json([
            'data' => $patients,
            'message' => 'Patients retrieved successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $patient = Patient::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'status' => 'active',
        ]);

        return response()->json([
            'data' => $patient,
            'message' => 'Patient created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function show(Patient $patient, Request $request)
    {
        if ($patient->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $patient->load(['medicalRecords', 'appointments', 'invoices', 'attachments']);

        return response()->json([
            'data' => $patient,
            'message' => 'Patient details retrieved.',
        ]);
    }

    public function update(Patient $patient, Request $request)
    {
        if ($patient->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'date_of_birth' => 'sometimes|date',
            'gender' => 'sometimes|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'status' => 'sometimes|in:active,inactive,archived',
        ]);

        $patient->update($validated);

        return response()->json([
            'data' => $patient,
            'message' => 'Patient updated successfully.',
        ]);
    }

    public function destroy(Patient $patient, Request $request)
    {
        if ($patient->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully.']);
    }
}
