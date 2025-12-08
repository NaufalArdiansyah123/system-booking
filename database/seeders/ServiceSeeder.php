<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Lapangan Futsal A (Vinyl)',
                'description' => 'Lapangan futsal ukuran standar dengan lantai vinyl berkualitas tinggi. Dilengkapi lampu LED terang, gawang resmi, dan ruang tunggu ber-AC. Cocok untuk pertandingan dan latihan tim.',
                'price' => 150000,
                'duration' => 60,
                'location' => 'Arena Futsal Indoor Lt.1',
                'is_active' => true,
            ],
            [
                'name' => 'Lapangan Futsal B (Rumput Sintetis)',
                'description' => 'Lapangan outdoor dengan rumput sintetis premium, memberikan pengalaman bermain seperti di rumput asli. Dilengkapi dengan net pembatas dan pencahayaan malam yang optimal.',
                'price' => 120000,
                'duration' => 60,
                'location' => 'Arena Futsal Outdoor',
                'is_active' => true,
            ],
            [
                'name' => 'Lapangan Futsal VIP (Premium)',
                'description' => 'Lapangan futsal premium dengan lantai interlock terbaik, sound system, area tribun untuk penonton, shower room, dan free Wi-Fi. Ideal untuk turnamen dan acara special.',
                'price' => 200000,
                'duration' => 60,
                'location' => 'Arena Futsal VIP Lt.2',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }
    }
}
