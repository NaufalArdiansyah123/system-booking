<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TimeSlot;
use App\Models\Booking;

$slots = TimeSlot::all();
$cnt = 0;
foreach ($slots as $s) {
    // Count only non-cancelled bookings
    $count = Booking::where('slot_id', $s->id)->where('status', '!=', 'cancelled')->count();
    $s->booked = $count;
    $s->save();
    $cnt++;
}

echo "Updated $cnt slots\n";
