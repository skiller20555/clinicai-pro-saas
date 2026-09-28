<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $clinic_id = $request->user()->clinic_id;
        $filter_date = $request->query('date');
        $filter_status = $request->query('status');

        $query = Appointment::where('clinic_id', $clinic_id);

        if ($filter_date) {
            $query->whereDate('appointment_date', $filter_date);
        }

        if ($filter_status) {
            $query->where('status', $filter_status);
        }

        $appointments = $query->with(['patient', 'doctor'])->paginate(20);

        return response()->json([
            'data' => $appointments,
            'message' => 'Appointments retrieved successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create([
            ...$validated,
            'clinic_id' => $request->user()->clinic_id,
            'status' => Appointment::STATUS_SCHEDULED,
        ]);

        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment scheduled successfully.',
        ], Response::HTTP_CREATED);
    }

    public function show(Appointment $appointment, Request $request)
    {
        if ($appointment->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $appointment->load(['patient', 'doctor']);

        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment details retrieved.',
        ]);
    }

    public function updateStatus(Appointment $appointment, Request $request)
    {
        if ($appointment->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
        ]);

        $appointment->update($validated);

        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment status updated.',
        ]);
    }

    public function destroy(Appointment $appointment, Request $request)
    {
        if ($appointment->clinic_id !== $request->user()->clinic_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment cancelled.']);
    }
}
