<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'registration_number',
        'status',
        'payment_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function detail()
    {
        return $this->hasOne(RegistrationDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
