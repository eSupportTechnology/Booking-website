<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('address_types')->insert([
            [
                'name' => 'one',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'multiple_same_address', // or 'multiple' if you intend a simplified version
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
