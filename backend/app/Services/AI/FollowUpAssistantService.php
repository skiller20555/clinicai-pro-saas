<?php

namespace App\Services\AI;

class FollowUpAssistantService
{
    public function getFollowUpRecommendation(array $patientHistory): array
    {
        return [
            'label' => 'AI Generated Assistance - Requires Professional Review',
            'recommendation' => 'Schedule follow-up assessment based on treatment progress and previous missed visits.',
            'reminder_message' => 'Please contact the patient and confirm next visit timing.',
            'requires_review' => true,
        ];
    }
}
