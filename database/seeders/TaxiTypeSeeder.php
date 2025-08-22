<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxiTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('taxi_types')->insert([
            [
                'name' => 'Standard',
                'description' => 'Regular car, 4 passengers',
                'passenger_capacity' => 4,
                'luggage_capacity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'People Carrier',
                'description' => 'Larger car for 6–8 passengers',
                'passenger_capacity' => 8,
                'luggage_capacity' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Large People Carrier',
                'description' => 'More than 8 passengers',
                'passenger_capacity' => 12,
                'luggage_capacity' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minibus',
                'description' => '12–20 passengers',
                'passenger_capacity' => 20,
                'luggage_capacity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Executive',
                'description' => 'Premium sedan, luxury for business passengers',
                'passenger_capacity' => 4,
                'luggage_capacity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luxury',
                'description' => 'High-end luxury cars (Mercedes, BMW, etc.)',
                'passenger_capacity' => 4,
                'luggage_capacity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
