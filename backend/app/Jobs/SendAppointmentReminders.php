<?php

namespace App\Jobs;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue
SerializesModels;

class SendAppointmentReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::where('appointment_date', $tomorrow)
            ->where('reminder_sent', false)
            ->get();

        foreach ($appointments as $appointment) {
            if ($appointment->patient && $appointment->patient->email) {
                // Send reminder email logic here
                $appointment->update(['reminder_sent' => true]);
            }
        }
    }
}
