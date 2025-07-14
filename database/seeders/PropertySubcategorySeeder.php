<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('property_subcategories')->insert([
            ['category_id' => 1, 'name' => 'Entire Place', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'name' => 'Private Room', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
