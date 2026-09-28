<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $patient_id = $request->query('patient_id');
        $clinic_id = $request->user()->clinic_id;

        $query = MedicalRecord::where('clinic_id', $clinic_id);

        if ($patient_id) {
            $query->where('patient_id', $patient_id);
        }

        $records = $query->with(['patient', 'doctor', 'attachments'])->paginate(20);

        return response()->json([
            'data' => $records,
            'message' => 'Medical records retrieved successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|datetime',
            'symptoms' => 'nullable|string|max:2000',
            'diagnosis' => 'nullable|string|max:2000',
            'treatment' => 'nullable|string|max:2000',
            'medical_history' => 'nullable|string|max:2000',
            'allergies' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
        ]);

        $record = MedicalRecord::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'doctor_id' => $request->user()->id,
            'status' => 'draft',
        ]);

        return response()->json([
            'data' => $record,
            'message' => 'Medical record created successfully.',
        ], Response::HTTP_CREATED);
    }

    public function show(MedicalRecord $record, Request $request)
    {
        if ($record->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $record->load(['patient', 'doctor', 'attachments']);

        return response()->json([
            'data' => $record,
            'message' => 'Medical record details retrieved.',
        ]);
    }

    public function update(MedicalRecord $record, Request $request)
    {
        if ($record->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'symptoms' => 'sometimes|string|max:2000',
            'diagnosis' => 'sometimes|string|max:2000',
            'treatment' => 'sometimes|string|max:2000',
            'medical_history' => 'sometimes|string|max:2000',
            'allergies' => 'sometimes|string|max:1000',
            'notes' => 'sometimes|string|max:2000',
            'status' => 'sometimes|in:draft,finalized,archived',
        ]);

        $record->update($validated);

        return response()->json([
            'data' => $record,
            'message' => 'Medical record updated successfully.',
        ]);
    }

    public function destroy(MedicalRecord $record, Request $request)
    {
        if ($record->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $record->delete();

        return response()->json(['message' => 'Medical record deleted successfully.']);
    }
}
