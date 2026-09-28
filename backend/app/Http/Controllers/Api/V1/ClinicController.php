<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClinicController extends Controller
{
    public function index(Request $request)
    {
        $clinicQuery = Clinic::query();

        if ($request->user()->role !== 'super_admin') {
            $clinicQuery->where('id', $request->user()->clinic_id);
        }

        return response()->json([
            'data' => $clinicQuery->get(),
            'message' => 'Clinics retrieved successfully.',
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Clinic::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:clinics,slug',
            'timezone' => 'nullable|string|max:64',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        $clinic = Clinic::create([
            ...$validated,
            'status' => 'active',
            'owner_user_id' => $request->user()->id,
        ]);

        return response()->json([
            'data' => $clinic,
            'message' => 'Clinic created successfully.',
        ], Response::HTTP_CREATED);
    }
}
