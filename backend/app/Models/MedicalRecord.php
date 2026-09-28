<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'clinic_id',
        'doctor_id',
        'visit_date',
        'symptoms',
        'diagnosis',
        'treatment',
        'medical_history',
        'allergies',
        'notes',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function attachments()
    {
        return $this->hasMany(PatientAttachment::class, 'medical_record_id');
    }
}
