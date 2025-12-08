<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'slot_id',
        'booking_code',
        'start_time',
        'end_time',
        'status',
        'payment_status',
        'note',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    /**
     * Boot method to generate booking code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_code) {
                $booking->booking_code = 'BK-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relasi ke time slot
     */
    public function slot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }

    /**
     * Booking can have multiple slot associations for multi-hour bookings
     */
    public function bookingSlots()
    {
        return $this->hasMany(\App\Models\BookingSlot::class);
    }

    /**
     * Relasi ke payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Check if booking is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }

    /**
     * Check if booking is confirmed
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}
