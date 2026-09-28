<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AI\ClinicalAssistantService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AiController extends Controller
{
    public function assist(Request $request, ClinicalAssistantService $assistant)
    {
        $validated = $request->validate([
            'prompt' => 'required|string|max:3000',
            'context' => 'nullable|array',
        ]);

        $summary = $assistant->summarizeMedicalNotes((string) $validated['prompt']);

        return response()->json([
            'data' => [
                'label' => $summary['label'],
                'summary' => $summary['summary'],
                'important_points' => $summary['important_points'],
                'requires_review' => true,
            ],
            'message' => 'AI Generated Assistance - Requires Professional Review',
        ], Response::HTTP_OK);
    }
}
