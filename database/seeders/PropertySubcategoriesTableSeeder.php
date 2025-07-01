<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('property_subcategories')->insert([
            // For Apartment (assuming category_id = 1)
            ['category_id' => 1, 'name' => 'One'],
            ['category_id' => 1, 'name' => 'Multiple'],
            // Add more for other categories if needed
        ]);
    }
}
