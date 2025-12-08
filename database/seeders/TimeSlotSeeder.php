<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = \App\Models\Service::all();
        
        // Generate slots untuk 7 hari ke depan
        for ($day = 0; $day < 7; $day++) {
            $date = now()->addDays($day)->format('Y-m-d');
            
            foreach ($services as $service) {
                // Generate 6 slot per hari (09:00 - 17:00)
                $slots = [
                    ['start' => '09:00', 'end' => '10:00'],
                    ['start' => '10:30', 'end' => '11:30'],
                    ['start' => '13:00', 'end' => '14:00'],
                    ['start' => '14:30', 'end' => '15:30'],
                    ['start' => '16:00', 'end' => '17:00'],
                    ['start' => '17:30', 'end' => '18:30'],
                ];
                
                foreach ($slots as $slot) {
                    \App\Models\TimeSlot::create([
                        'service_id' => $service->id,
                        'date' => $date,
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                        'capacity' => rand(2, 5),
                        'booked' => 0,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}
