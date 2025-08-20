<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarType;

class CarTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Small', 'Medium', 'Large', 'SUV', 'People Carrier'];

        foreach ($types as $type) {
            CarType::firstOrCreate(['name' => $type]);
        }
    }
}
