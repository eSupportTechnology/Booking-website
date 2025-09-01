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
                $businessData = $dto->business_entity;
                $accommodation->businessEntities()->updateOrCreate(
                    [
                        'business_name' => $businessData['business_name'] ?? null,
                    ],
                    $businessData
                );
            }

            if ($dto->ownership_type === 'individual' && $dto->individuals) {
                foreach ($dto->individuals as $individualData) {
                    $attrs = [
                        'first_name' => $individualData['first_name'] ?? null,
                        'last_name' => $individualData['last_name'] ?? null,
                        'date_of_birth' => $individualData['date_of_birth'] ?? null,
                    ];
                    $individual = $accommodation->individuals()->updateOrCreate($attrs, $attrs);
                    if (!empty($individualData['alt_names']) && is_array($individualData['alt_names'])) {
                        $cleanAltNames = array_values(array_filter($individualData['alt_names'], function ($name) {
                            return is_string($name) && strlen(trim($name)) > 0;
                        }));
                        foreach ($cleanAltNames as $altName) {
                            $individual->altNames()->create(['alt_name' => trim($altName)]);
                        }
                    }
                }
            }

            return $accommodation;
        });
    }
} 