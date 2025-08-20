<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarBrand;

class CarBrandsSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Toyota',
            'Honda',
            'Nissan',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Volkswagen',
            'Ford',
            'Chevrolet',
            'Hyundai',
            'Kia',
            'Tesla',
            'Jaguar',
            'Land Rover',
            'Volvo'
            // ⚠️ Add more here or import from external dataset
        ];

        foreach ($brands as $brand) {
            CarBrand::firstOrCreate(['brand_name' => $brand]);
        }
    }
}
