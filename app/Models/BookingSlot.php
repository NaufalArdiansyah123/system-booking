<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'slot_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function slot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }
}
