<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\AccommodationDetailsDTO;
use App\Models\Accommodation;
use App\Models\BusinessEntity;
use App\Models\Individual;
use App\Models\IndividualAltName;
use Illuminate\Support\Facades\DB;

class StoreAccommodationDetailsAction
{
    public function execute(AccommodationDetailsDTO $dto): Accommodation
    {
        return DB::transaction(function () use ($dto) {
            $accommodation = Accommodation::updateOrCreate([
                'property_id' => $dto->property_id,
                'ownership_type' => $dto->ownership_type,
            ]);

            if ($dto->ownership_type === 'business_entity' && $dto->business_entity) {
                $business = $accommodation->businessEntities()->updateOrCreate($dto->business_entity);
            }

            if ($dto->ownership_type === 'individual' && $dto->individuals) {
                foreach ($dto->individuals as $individualData) {
                    $individual = $accommodation->individuals()->updateOrCreate([
                        'first_name' => $individualData['first_name'],
                        'last_name' => $individualData['last_name'],
                        'date_of_birth' => $individualData['date_of_birth'],
                    ]);
                    if (!empty($individualData['alt_names'])) {
                        foreach ($individualData['alt_names'] as $altName) {
                            $individual->altNames()->create(['alt_name' => $altName]);
                        }
                    }
                }
            }

            return $accommodation;
        });
    }
} 