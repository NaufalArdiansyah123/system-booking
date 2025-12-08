<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'booked',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    /**
     * Relasi ke service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relasi ke bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot_id');
    }

    /**
     * Check if slot is full
     */
    public function isFull(): bool
    {
        return $this->booked >= $this->capacity;
    }

    /**
     * Check if slot is available
     */
    public function isAvailable(): bool
    {
        return $this->is_available && !$this->isFull();
    }
}
