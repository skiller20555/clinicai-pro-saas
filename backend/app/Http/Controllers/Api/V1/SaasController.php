<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaasController extends Controller
{
    public function plans()
    {
        return response()->json([
            'data' => Plan::where('is_active', true)->get(),
            'message' => 'Subscription plans retrieved successfully.',
        ]);
    }

    public function createSubscription(Request $request)
    {
        $validated = $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $subscription = Subscription::create([
            ...$validated,
            'payment_provider' => 'manual',
            'renewal_count' => 0,
        ]);

        return response()->json([
            'data' => $subscription,
            'message' => 'Subscription created successfully.',
        ], Response::HTTP_CREATED);
    }
}
