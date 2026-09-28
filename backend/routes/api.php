<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/v1')->group(function () {
    Route::post('/auth/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('/auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [\App\Http\Controllers\Api\V1\AuthController::class, 'me']);
        Route::get('/dashboard/summary', [\App\Http\Controllers\Api\V1\DashboardController::class, 'summary']);
        Route::get('/clinics', [\App\Http\Controllers\Api\V1\ClinicController::class, 'index']);
        Route::post('/clinics', [\App\Http\Controllers\Api\V1\ClinicController::class, 'store']);
        Route::get('/patients', [\App\Http\Controllers\Api\V1\PatientController::class, 'index']);
        Route::post('/patients', [\App\Http\Controllers\Api\V1\PatientController::class, 'store']);
        Route::get('/patients/{patient}', [\App\Http\Controllers\Api\V1\PatientController::class, 'show']);
        Route::put('/patients/{patient}', [\App\Http\Controllers\Api\V1\PatientController::class, 'update']);
        Route::delete('/patients/{patient}', [\App\Http\Controllers\Api\V1\PatientController::class, 'destroy']);

        Route::get('/appointments', [\App\Http\Controllers\Api\V1\AppointmentController::class, 'index']);
        Route::post('/appointments', [\App\Http\Controllers\Api\V1\AppointmentController::class, 'store']);
        Route::get('/appointments/{appointment}', [\App\Http\Controllers\Api\V1\AppointmentController::class, 'show']);
        Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\Api\V1\AppointmentController::class, 'updateStatus']);

        Route::get('/medical-records', [\App\Http\Controllers\Api\V1\MedicalRecordController::class, 'index']);
        Route::post('/medical-records', [\App\Http\Controllers\Api\V1\MedicalRecordController::class, 'store']);
        Route::patch('/medical-records/{record}', [\App\Http\Controllers\Api\V1\MedicalRecordController::class, 'update']);

        Route::get('/billing', [\App\Http\Controllers\Api\V1\BillingController::class, 'index']);
        Route::post('/billing/invoices', [\App\Http\Controllers\Api\V1\BillingController::class, 'createInvoice']);
        Route::post('/billing/payments', [\App\Http\Controllers\Api\V1\BillingController::class, 'createPayment']);
        Route::post('/billing/expenses', [\App\Http\Controllers\Api\V1\BillingController::class, 'storeExpense']);

        Route::get('/dental', [\App\Http\Controllers\Api\V1\DentalController::class, 'index']);
        Route::post('/dental/teeth', [\App\Http\Controllers\Api\V1\DentalController::class, 'storeTooth']);
        Route::post('/dental/treatment-plans', [\App\Http\Controllers\Api\V1\DentalController::class, 'storeTreatmentPlan']);

        Route::post('/ai/assist', [\App\Http\Controllers\Api\V1\AiController::class, 'assist']);

        Route::get('/plans', [\App\Http\Controllers\Api\V1\SaasController::class, 'plans']);
        Route::post('/subscriptions', [\App\Http\Controllers\Api\V1\SaasController::class, 'createSubscription']);

        Route::get('/audit-logs', [\App\Http\Controllers\Api\V1\AuditController::class, 'index']);
    });
});
