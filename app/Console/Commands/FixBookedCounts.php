<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TimeSlot;
use App\Models\Booking;

class FixBookedCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booked:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate and fix booked counts for all time slots';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting recalculation...');

        $slots = TimeSlot::withCount(['bookings as bookings_count' => function ($q) {
            $q->whereNull('deleted_at');
        }])->get();

        $bar = $this->output->createProgressBar($slots->count());
        $bar->start();

        foreach ($slots as $slot) {
            $slot->booked = (int) $slot->bookings_count;
            $slot->save();
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nDone. Updated {$slots->count()} slots.");
        return 0;
    }
}
