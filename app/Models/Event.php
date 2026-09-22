<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'registration_fee',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_fee' => 'decimal:2',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    protected static function booted()
    {
        static::retrieved(function ($event) {
            $changed = false;
            
            if ($event->status === 'coming_soon' && $event->start_date && !$event->start_date->startOfDay()->isFuture()) {
                $event->status = 'active';
                $changed = true;
            }
            
            if ($event->status === 'active' && $event->start_date && $event->start_date->startOfDay()->isFuture()) {
                $event->status = 'coming_soon';
                $changed = true;
            }
            
            if ($event->status === 'active' && $event->end_date && $event->end_date->endOfDay()->isPast()) {
                $event->status = 'completed';
                $changed = true;
            }

            if ($changed) {
                $event->saveQuietly();
            }
        });
    }
}
