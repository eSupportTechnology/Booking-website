<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Create a simple booking record for testing
        DB::table('bookings')->insert([
            'id' => 1,
            'property_id' => 1,
            'user_id' => 1,
            'room_id' => 1,
            'check_in' => '2024-01-01',
            'check_out' => '2024-01-03',
            'guest_count' => 2,
            'total_price' => 15000.00,
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}