<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'application' => 'ClinicAI Pro SaaS',
        'status' => 'operational',
        'message' => 'API ready for clinic operations.',
    ]);
});
