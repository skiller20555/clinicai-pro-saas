<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    protected $fillable = [
        'clinic_id',
        'patient_id',
        'tooth_number',
        'tooth_position',
        'condition',
        'status',
        'notes',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
