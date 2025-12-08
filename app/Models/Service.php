<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'location',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke time slots
     */
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * Relasi ke bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get available time slots for a specific date
     */
    public function availableSlots($date)
    {
        return $this->timeSlots()
            ->where('date', $date)
            ->where('is_available', true)
            ->whereRaw('booked < capacity')
            ->get();
    }
}
