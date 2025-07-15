<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypesTableSeeder extends Seeder
{
    public function run()
    {
        $addressTypes = [
            ['name' => 'one'],
            ['name' => 'multiple_same_address'],
        ];

        foreach ($addressTypes as $type) {
            DB::table('address_types')->updateOrInsert(
                ['name' => $type['name']],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
