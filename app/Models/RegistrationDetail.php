<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationDetail extends Model
{
    protected $fillable = [
        'registration_id',
        'gender',
        'birth_place',
        'birth_date',
        'identity_number',
        'phone',
        'scout_status',
        'faculty',
        'major',
        'tshirt_size',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'scout_status' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
