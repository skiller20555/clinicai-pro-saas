<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $clinic_id = $request->user()->clinic_id;

        $logs = AuditLog::where('clinic_id', $clinic_id)
            ->orderByDesc('created_at')
            ->paginate(25);

        return response()->json([
            'data' => $logs,
            'message' => 'Audit trail retrieved successfully.',
        ]);
    }
}
