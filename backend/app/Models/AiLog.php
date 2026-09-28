<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiLog extends Model
{
    protected $fillable = [
        'clinic_id',
        'user_id',
        'request_type',
        'input_summary',
        'output_summary',
        'status',
        'model_name',
        'requires_review',
    ];

    protected $casts = [
        'requires_review' => 'boolean',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
