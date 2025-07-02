<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('property_categories')->insert([
            ['name' => 'Apartment'],
            ['name' => 'Homes'],
            ['name' => 'Hotel, B&Bs, and more'],
            ['name' => 'Alternative places'],
            // Add more if needed
        ]);
    }
}
