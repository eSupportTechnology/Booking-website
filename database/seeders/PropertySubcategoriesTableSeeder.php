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
        DB::table('property_subcategories')->updateOrCreate([
            ['category_id' => 2, 'name' => 'One'],
            ['category_id' => 2, 'name' => 'Multiple'],
        ]);
    }
}
