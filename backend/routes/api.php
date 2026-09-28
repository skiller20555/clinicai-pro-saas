<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/v1')->group(function () {
    Route::post('/auth/register', function (Request $request) {
        return response()->json([
            'message' => 'Register endpoint ready for implementation.',
            'data' => [
                'name' => $request->string('name')->value(),
                'email' => $request->string('email')->value(),
            ],
        ]);
    });

    Route::post('/auth/login', function (Request $request) {
        return response()->json([
            'message' => 'Login endpoint ready for implementation.',
            'email' => $request->string('email')->value(),
        ]);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', function (Request $request) {
            return response()->json([
                'user' => $request->user()->only(['id', 'name', 'email']),
            ]);
        });

        Route::get('/clinics', function (Request $request) {
            return response()->json([
                'data' => [],
                'message' => 'Clinic listing endpoint ready for implementation.',
            ]);
        });

        Route::get('/dashboard/summary', function (Request $request) {
            return response()->json([
                'data' => [
                    'appointments_today' => 184,
                    'patients_active' => 2430,
                    'revenue' => 48250,
                    'pending_payments' => 8120,
                ],
                'message' => 'Dashboard summary ready for implementation.',
            ]);
        });

        Route::post('/ai/assist', function (Request $request) {
            $prompt = (string) $request->input('prompt', '');

            return response()->json([
                'message' => 'AI Generated Assistance - Requires Professional Review',
                'content' => "AI-generated draft for: {$prompt}",
                'requires_review' => true,
            ]);
        });
    });
});
