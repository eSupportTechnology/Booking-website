<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\AddressSameDTO;
use App\DTOs\Partner\PropertyDTO;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\DTOs\Partner\PropertyStep1DTO;
use App\DTOs\Partner\PropertyStep2DTO;
use App\Models\Languages;
use Illuminate\Support\Facades\Log;
use App\DTOs\Partner\UploadPropertyPhotosDTO;
use App\Services\FileUploadService;
use App\DTOs\Partner\SaveAmenitiesDTO;
use App\DTOs\Partner\SavePolicyDTO;
use App\DTOs\Partner\SaveRoomsDTO;
use App\DTOs\Partner\PartnerVerificationDTO;
use App\DTOs\Partner\SaveLanguagesDTO;
use App\DTOs\Partner\SaveAddressSameDTO;
use App\Models\PartnerVerification;
use App\Models\Room;
use Faker\Provider\ar_EG\Address;

class PropertyAction
{

    public function registerProperty(PropertyDTO $property): Property
    {
        return Property::create($property->toArray());
    }

    public function execute(): Collection
    {
        return PropertyCategory::all()->select('name');
    }
    public function getPropertiesByCategory(int $categoryId): Collection
    {
        return PropertySubcategory::where('category_id', $categoryId)->get();
    }
    public function getAmenities(): Collection
    {
        return \App\Models\Amenity::all()->map(function ($amenity) {
            return [
                'id' => $amenity->id,
                'name' => $amenity->name,
            ];
        });
    }

    public function getLanguages(): Collection
    {
        return \App\Models\Language::all()->map(function ($language) {
            return [
                'id' => $language->id,
                'name' => $language->name,
            ];
        });
    }

    public function getRoomTypes(): Collection
    {
        return \App\Models\RoomType::all()->map(function ($roomType) {
            return [
                'id' => $roomType->id,
                'name' => $roomType->name,
            ];
        });
    }

    public function getBedTypes(): Collection
    {
        return \App\Models\BedType::all()->map(function ($bedType) {
            return [
                'id' => $bedType->id,
                'name' => $bedType->name,
            ];
        });
    }

    public function getPropertiesBySubcategory(int $subcategoryId): Collection
    {
        return PropertySubtype::where('subcategory_id', $subcategoryId)->get()->map(function ($subtype) {
            return [
                'id' => $subtype->id,
                'title' => $subtype->name,
                'desc' => $subtype->description,
            ];
        });
    }

    public function createPropertyStep1(PropertyStep1DTO $dto)
    {
        Log::info('createPropertyStep1 called', [
            'dto_data' => $dto->toArray(),
            'address_type_id' => $dto->address_type_id,
        ]);
        
        $property = \App\Models\Property::create($dto->toArray());
        
        Log::info('Property created successfully', [
            'property_id' => $property->id,
            'property_data' => $property->toArray(),
        ]);
        
        return $property;
    }

    public function updatePropertyStep2(Property $property, PropertyStep2DTO $dto)
    {
        Log::info('PropertyStep2DTO received:', (array) $dto);
        $property->update(array_filter([
            'title' => $dto->title,
            'address' => $dto->address,
            'apartment' => $dto->apartment,
            'city' => $dto->city,
            'country' => $dto->country,
            'zipcode' => $dto->zipcode,
            'description' => $dto->description,
            'subtype_id' => $dto->subtype_id,
            'address_type_id' => $dto->address_type_id,
            'channel_manager' => $dto->channel_manager,
            'stars' => $dto->stars,
            'group' => $dto->group,
        ], fn($value) => !is_null($value)));

        // Save bedrooms if provided
        Log::info('Bedrooms array in DTO:', ['bedrooms' => $dto->bedrooms]);
        if (!empty($dto->bedrooms)) {
            $property->bedrooms()->delete();
            foreach ($dto->bedrooms as $bedroom) {
                Log::info('Creating bedroom:', $bedroom);
                $property->bedrooms()->create($bedroom);
            }
        }

        $property->additionalDetails()->updateOrCreate(
            [],
            [
                'guests' => $dto->guests,
                'bathrooms' => $dto->bathrooms,
                'allow_children' => $dto->allow_children,
                'offer_cribs' => $dto->offer_cribs,
                'apartment_size' => $dto->apartment_size,
                'apartment_unit' => $dto->apartment_unit,
            ]
        );

        Log::info('Amenities array in DTO:', ['amenities' => $dto->amenities]);
        Log::info('Languages array in DTO:', ['languages' => $dto->languages]);
        if (!empty($dto->amenities)) {
            $property->amenities()->sync($dto->amenities);
            Log::info('Amenities synced to property', ['property_id' => $property->id, 'amenity_ids' => $dto->amenities]);
        } else {
            Log::info('No amenities to sync for property', ['property_id' => $property->id]);
        }
        if (!empty($dto->languages)) {
            $property->languages()->sync($dto->languages);
            Log::info('Languages synced to property', ['property_id' => $property->id, 'language_ids' => $dto->languages]);
        } else {
            Log::info('No languages to sync for property', ['property_id' => $property->id]);
        }

        return $property;
    }

    public function updatePropertyPartial(Property $property, array $data, ?array $bedrooms = null)
    {
        $fields = [
            'title',
            'address',
            'apartment',
            'country',
            'city',
            'zipcode',
            'channel_manager',
            'description',
            'stars',
            'group',
        ];
        $property->update(array_intersect_key($data, array_flip($fields)));

        // Handle bedrooms data
        if ($bedrooms !== null && is_array($bedrooms)) {
            Log::info('Processing bedrooms data:', ['bedrooms' => $bedrooms]);
            $property->bedrooms()->delete();
            foreach ($bedrooms as $bedroom) {
                Log::info('Creating bedroom:', $bedroom);
                $property->bedrooms()->create($bedroom);
            }
        }
        return $property->fresh();
    }

    public function getGroupedAmenities()
    {
        return \App\Models\Amenity::all()->groupBy('category');
    }

    public function syncAmenities(Property $property, array $amenityIds)
    {
        $property->amenities()->sync($amenityIds);
    }

    public function uploadPhotos(UploadPropertyPhotosDTO $dto, FileUploadService $fileUploadService): void
    {
        $property_type = Property::find($dto->property_id)?->subtype_id ?? 'Property';

        foreach ($dto->photos as $photo) {
            $fileUploadService->uploadAndSave(
                file: $photo,
                fileType: 'image',
                propertyType: PropertySubtype::find($property_type)?->name ?? 'Property',
                propertyId: $dto->property_id,
                directory: 'property_photos'
            );
        }
    }

    public function saveAmenities(Property $property, SaveAmenitiesDTO $dto): void
    {
        Log::info('PropertyAction::saveAmenities called', [
            'property_id' => $property->id,
            'amenities' => $dto->amenities
        ]);
        
        $property->amenities()->sync($dto->amenities);
        
        Log::info('Amenities synced successfully', [
            'property_id' => $property->id,
            'amenity_count' => count($dto->amenities)
        ]);
    }

    public function saveLanguages(Property $property, SaveLanguagesDTO $dto): void
{
    $property->languages()->sync($dto->languages);
}


    public function savePolicy(Property $property, SavePolicyDTO $dto): void
    {
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            $dto->toArray()
        );
    }



    public function saveRooms(SaveRoomsDTO $dto): void
    {
        foreach ($dto->rooms as $roomData) {
            $room = Room::create([
                'property_id' => $dto->property_id,
                'room_type_id' => $roomData['room_type_id'],
                'name' => $roomData['name'] ?? null,
                'price_per_night' => $roomData['price_per_night'] ?? null,
                'max_guests' => $roomData['max_guests'] ?? null,
                'bathroom_count' => $roomData['bathroom_count'] ?? null,
                'size_sq_m' => $roomData['size_sq_m'] ?? null,
            ]);

            if (!empty($roomData['beds']) && is_array($roomData['beds'])) {
                foreach ($roomData['beds'] as $bedTypeId => $count) {
                    if ((int) $count > 0) {
                        $room->beds()->attach($bedTypeId, ['count' => $count]);
                    }
                }
            }
        }
    }


    public function partnerVerification(PartnerVerificationDTO $dto): void
    {
        PartnerVerification::updateOrCreate(
            ['property_id' => $dto->property_id],
            $dto->toArray()
        );
    }


    public function saveSameAddress(SaveAddressSameDTO $dto): void
    {
        $existingProperty = Property::findOrFail($dto->property_id);

        // Update the address of the given property
        $existingProperty->update([
            'address' => $dto->address,
            'address_type_id' => 2, // Keep the same address type
        ]);

        // Create new properties with the same address
        for ($i = 1; $i < $dto->count; $i++) {
            Property::create([
                'user_id' => Auth::id(),
                'category_id' => $existingProperty->category_id,
                'subcategory_id' => $existingProperty->subcategory_id,
                'subtype_id' => $existingProperty->subtype_id,
                'address' => $dto->address,
                'address_type_id' => 2, // Same address type
            ]);
        }
    }

    public function getSpecificAmenities(): Collection
    {
        // Get specific amenities by name that are used in the multiple apartment form
        $amenityNames = [
            'Sauna', 
            'Garden view',
            'Terrace',
            'Hot tub',
            'Heating',
            'Free WiFi',
            'Air conditioning',
            'Swimming Pool',
            'Minibar'
        ];
        
        $amenities = \App\Models\Amenity::whereIn('name', $amenityNames)->get();
        
        \Log::info('getSpecificAmenities called', [
            'requested_names' => $amenityNames,
            'found_amenities' => $amenities->toArray()
        ]);
        
        return $amenities->map(function ($amenity) {
            return [
                'id' => $amenity->id,
                'name' => $amenity->name,
            ];
        });
    }


}
