<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'clinic_id' => $this->clinic_id,
            'patient' => $this->patient ? new PatientResource($this->patient) : null,
            'doctor' => $this->doctor ? [
                'id' => $this->doctor->id,
                'name' => $this->doctor->name,
                'email' => $this->doctor->email,
            ] : null,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'duration_minutes' => $this->duration_minutes,
            'status' => $this->status,
            'notes' => $this->notes,
            'reminder_sent' => $this->reminder_sent,
            'follow_up_date' => $this->follow_up_date,
        ];
    }
}
