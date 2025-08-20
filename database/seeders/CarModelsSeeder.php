<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;
use App\Models\CarBrand;

class CarModelsSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            'Toyota' => ['Corolla', 'Camry', 'Yaris', 'RAV4', 'Hilux'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Fit', 'HR-V'],
            'BMW'   => ['X5', 'X3', '3 Series', '5 Series', '7 Series'],
            'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
            'Ford'  => ['Focus', 'Mustang', 'Explorer', 'F-150', 'Escape']
        ];

        foreach ($models as $brandName => $brandModels) {
            $brand = CarBrand::where('brand_name', $brandName)->first();
            if ($brand) {
                foreach ($brandModels as $modelName) {
                    CarModel::firstOrCreate([
                        'model_name' => $modelName,
                        'brand_id'   => $brand->id
                    ]);
                }
            }
        }
    }
}
