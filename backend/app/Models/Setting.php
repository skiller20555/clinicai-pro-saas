<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'clinic_id',
        'key',
        'value',
        'group_name',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
