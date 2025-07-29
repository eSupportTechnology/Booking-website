<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveAddressMultipleDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SaveAddressMultipleAction
{
    public function execute(SaveAddressMultipleDTO $dto): void
    {
        Log::info('SaveAddressMultipleAction::execute called', [
            'first_property_id' => $dto->first_property_id,
            'addresses_count' => count($dto->addresses),
            'dto_data' => $dto->toArray()
        ]);

        $addresses = $dto->addresses;

        Property::findOrFail($dto->first_property_id)->update([
            'address' => $addresses[0]
        ]);

        for ($i = 1; $i < count($addresses); $i++) {
            Property::create([
                'address' => $addresses[$i],
                'category_id' => session('category_id'),
                'subcategory_id' => session('subcategory_id'),
                'apartment_type' => session('apartment_type'),
            ]);
        }

        Log::info('Multiple addresses saved successfully', [
            'first_property_id' => $dto->first_property_id,
            'total_addresses' => count($addresses)
        ]);
    }
} 