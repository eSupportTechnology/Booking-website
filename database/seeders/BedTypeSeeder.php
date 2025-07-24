<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('bed_types')->insert([
            ['name' => 'Twin'],
            ['name' => 'Full'],
            ['name' => 'Queen'],
            ['name' => 'King'],
            ['name' => 'Bunk'],
            ['name' => 'Sofa Bed'],
            ['name' => 'Futon'],
        ]);
    }
}
