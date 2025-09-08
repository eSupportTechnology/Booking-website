<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Taxi;
use App\Models\TaxiType;
use App\Models\Driver;
use App\Models\CarRenter;

class TaxiSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample car renter if none exists
        $carRenter = CarRenter::first() ?? CarRenter::create([
            'email' => 'info@samplecarrental.com',
            'password' => 'password123',
            'account_type' => 'company',
            'company_name' => 'Sample Car Rental Company',
            'phone' => '+94771234567'
        ]);

        // Create sample taxi types if none exist
        $taxiTypes = [
            ['name' => 'Sedan', 'description' => 'Standard sedan vehicle', 'passenger_capacity' => 4, 'luggage_capacity' => 2],
            ['name' => 'SUV', 'description' => 'Sport utility vehicle', 'passenger_capacity' => 7, 'luggage_capacity' => 4],
            ['name' => 'Van', 'description' => 'Large passenger van', 'passenger_capacity' => 12, 'luggage_capacity' => 6]
        ];

        foreach ($taxiTypes as $typeData) {
            TaxiType::firstOrCreate(['name' => $typeData['name']], $typeData);
        }

        // Create sample taxis
        $taxis = [
            [
                'taxi_type_id' => TaxiType::where('name', 'Sedan')->first()->id,
                'car_renter_id' => $carRenter->id,
                'number_plate' => 'ABC-1234',
                'color' => 'White',
                'passenger_capacity' => 4,
                'luggage_capacity' => 2,
                'status' => 'Active'
            ],
            [
                'taxi_type_id' => TaxiType::where('name' , 'SUV')->first()->id,
                'car_renter_id' => $carRenter->id,
                'number_plate' => 'XYZ-5678',
                'color' => 'Black',
                'passenger_capacity' => 7,
                'luggage_capacity' => 4,
                'status' => 'Inactive'
            ],
            [
                'taxi_type_id' => TaxiType::where('name', 'Van')->first()->id,
                'car_renter_id' => $carRenter->id,
                'number_plate' => 'DEF-9012',
                'color' => 'Blue',
                'passenger_capacity' => 12,
                'luggage_capacity' => 6,
                'status' => 'On Trip'
            ]
        ];

        foreach ($taxis as $taxiData) {
            $taxi = Taxi::create($taxiData);

            // Create a driver for each taxi
            Driver::create([
                'taxi_id' => $taxi->id,
                'name' => 'Driver for ' . $taxi->number_plate,
                'contact_number' => '+94' . rand(700000000, 799999999),
                'email' => 'driver' . $taxi->id . '@example.com',
                'license_number' => 'DL' . str_pad($taxi->id, 6, '0', STR_PAD_LEFT)
            ]);
        }
    }
}