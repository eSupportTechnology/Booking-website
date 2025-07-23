<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('room_types')->insert([
            ['name' => 'Single Room'],
            ['name' => 'Double Room'],
            ['name' => 'Deluxe Room'],
            ['name' => 'Suite'],
            ['name' => 'Family Room'],
        ]);
    }
}

