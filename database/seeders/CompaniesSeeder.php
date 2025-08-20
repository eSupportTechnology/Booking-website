<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesSeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Hertz',
                'reg_number' => 'HZ123',
                'rating' => 4.5,
                'cancellation_policy' => 'Free cancellation up to 48 hours before pickup.'
            ],
            [
                'name' => 'Avis',
                'reg_number' => 'AV456',
                'rating' => 4.3,
                'cancellation_policy' => 'Cancellation fee applies within 24 hours of pickup.'
            ],
            [
                'name' => 'Enterprise',
                'reg_number' => 'EN789',
                'rating' => 4.7,
                'cancellation_policy' => 'Flexible cancellation anytime before pickup.'
            ],
            [
                'name' => 'Budget',
                'reg_number' => 'BG321',
                'rating' => 4.1,
                'cancellation_policy' => 'Non-refundable if canceled within 24 hours.'
            ],
        ];

        foreach ($companies as $company) {
            Company::firstOrCreate(['reg_number' => $company['reg_number']], $company);
        }
    }
}
