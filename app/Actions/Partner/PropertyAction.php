<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SavePaymentMethodDTO;
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
use App\DTOs\Partner\ApartmentStep1DTO;
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
use App\DTOs\Partner\PropertyServiceDTO;
use App\DTOs\Partner\SaveServicesDTO;
use App\DTOs\Partner\SaveHouseRulesDTO;
use App\DTOs\Partner\SaveInvoicingDTO;
use App\DTOs\SaveAvailabilitySettingsDTO;
use App\Models\PartnerVerification;
use App\Models\PropertyService;
use App\Models\Room;
use App\Models\Accommodation;
use App\Models\Individual;
use App\Models\BusinessEntity;
use App\Models\PropertyAvailabilitySetting;
use App\DTOs\SaveFacilitiesDTO;
use App\Models\PropertyFacility;

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
        return \App\Models\Amenity::all();
    }

    public function getAmenitiesByContext(string $context): Collection
    {
        // For apartments, we'll use the specific multiple_apartment category
        return \App\Models\Amenity::where('category', 'multiple_apartment')->get();
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

        $property = \App\Models\Property::updateOrCreate(
            ['id' => $dto->property_id],
            [
                'user_id' => $dto->user_id ?? Auth::id(),
                'category_id' => $dto->category_id,
                'subcategory_id' => $dto->subcategory_id,
                'subtype_id' => null, // Set to null for step 1
                'property_count' => $dto->property_count,
                'address_type_id' => $dto->address_type_id,
            ]
        );

        // Store property ID in session for form navigation
        session(['current_property_id' => $property->id]);

        Log::info('Property created successfully', [
            'property_id' => $property->id,
            'property_data' => $property->toArray(),
        ]);

        return $property;
    }

    public function createApartmentStep1(ApartmentStep1DTO $dto)
    {
        Log::info('createApartmentStep1 called', [
            'dto_data' => $dto->toArray(),
            'address_type_id' => $dto->address_type_id,
        ]);

        // Create property data without subcategory_id
        $propertyData = $dto->toArray();
        $propertyData['subcategory_id'] = null; // Set to null for apartments

        $property = \App\Models\Property::create($propertyData);

        // Store property ID in session for form navigation
        session(['current_property_id' => $property->id]);

        Log::info('Apartment property created successfully', [
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

        // Store property ID in session for form navigation
        session(['current_property_id' => $property->id]);

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
        Log::info('Saving amenities for property', [
            'property_id' => $property->id,
            'amenities_count' => count($dto->amenities)
        ]);

        // Sync amenities (this will handle both adding and removing)
        $property->amenities()->sync($dto->amenities);
    }

    public function saveFacilities(Property $property, SaveFacilitiesDTO $dto): void
    {
        Log::info('Saving facilities for property', [
            'property_id' => $property->id,
            'facilities_count' => count($dto->facilities)
        ]);

        // Delete existing facilities for this property
        $property->facilities()->delete();

        // Insert new facilities
        $facilitiesData = array_map(function($facility) use ($property) {
            return [
                'property_id' => $property->id,
                'facility_name' => $facility,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $dto->facilities);

        PropertyFacility::insert($facilitiesData);
    }

    public function getFacilities(Property $property): array
    {
        return $property->facilities()->pluck('facility_name')->toArray();
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
        Log::info('PropertyAction::partnerVerification called', [
            'property_id' => $dto->property_id,
            'type' => $dto->type,
            'dto_data' => $dto->toArray()
        ]);

        // Debug owners data
        if ($dto->owners && is_array($dto->owners)) {
            foreach ($dto->owners as $index => $owner) {
                Log::info("Owner {$index} data:", [
                    'first_name' => $owner['first_name'] ?? 'null',
                    'last_name' => $owner['last_name'] ?? 'null',
                    'dob' => $owner['dob'] ?? 'null',
                    'dob_type' => gettype($owner['dob'] ?? null)
                ]);
            }
        }

        // Check if accommodation record already exists
        $accommodation = Accommodation::where('property_id', $dto->property_id)->first();
        
        if (!$accommodation) {
            // Create accommodation record only if it doesn't exist
            $accommodation = Accommodation::create([
                'property_id' => $dto->property_id,
                'ownership_type' => $dto->type === 'individual' ? 'individual' : 'business_entity'
            ]);
            
            Log::info('Created new accommodation record', [
                'accommodation_id' => $accommodation->id,
                'property_id' => $dto->property_id
            ]);
        } else {
            Log::info('Accommodation record already exists', [
                'accommodation_id' => $accommodation->id,
                'property_id' => $dto->property_id
            ]);
        }

        if ($dto->type === 'individual') {
            // Handle individual verification
            if ($dto->owners && is_array($dto->owners)) {
                foreach ($dto->owners as $owner) {
                    // Validate and format the date
                    $dateOfBirth = null;
                    if (!empty($owner['dob']) && $owner['dob'] !== '1') {
                        try {
                            $date = \DateTime::createFromFormat('Y-m-d', $owner['dob']);
                            if ($date && $date->format('Y-m-d') === $owner['dob']) {
                                $dateOfBirth = $owner['dob'];
                            }
                        } catch (\Exception $e) {
                            Log::warning('Invalid date format for DOB:', ['dob' => $owner['dob']]);
                        }
                    }
                    
                    $individual = Individual::updateOrCreate(
                        [
                            'accommodation_id' => $accommodation->id,
                            'first_name' => $owner['first_name'],
                            'last_name' => $owner['last_name'],
                        ],
                        [
                            'date_of_birth' => $dateOfBirth,
                        ]
                    );

                    Log::info('Saved individual owner', [
                        'individual_id' => $individual->id,
                        'owner_data' => $individual->toArray()
                    ]);
                }
            } else {
                // Create individual record without owners array
                $individual = Individual::updateOrCreate(
                    ['accommodation_id' => $accommodation->id],
                    [
                        'accommodation_id' => $accommodation->id,
                        'first_name' => $dto->full_name ? explode(' ', $dto->full_name)[0] : null,
                        'last_name' => $dto->full_name ? (explode(' ', $dto->full_name)[1] ?? '') : null,
                        'date_of_birth' => null, // This should be properly handled from the owners array
                    ]
                );

                Log::info('Saved individual without owners array', [
                    'individual_id' => $individual->id,
                    'individual_data' => $individual->toArray()
                ]);
            }
        } else {
            // Handle business entity verification
            // Check if required fields are present for business entity
            if ($dto->company_name && $dto->address && $dto->zip_code && $dto->city && $dto->country) {
                $businessEntity = BusinessEntity::updateOrCreate(
                    ['accommodation_id' => $accommodation->id],
                    [
                        'accommodation_id' => $accommodation->id,
                        'business_name' => $dto->company_name,
                        'trading_name' => $dto->trading_name,
                        'address' => $dto->address,
                        'zip_code' => $dto->zip_code,
                        'city' => $dto->city,
                        'country' => $dto->country,
                    ]
                );
                
                Log::info('Business entity verification saved', [
                    'accommodation_id' => $accommodation->id,
                    'business_entity_id' => $businessEntity->id,
                    'business_entity_data' => $businessEntity->toArray()
                ]);
            } else {
                Log::warning('Skipping business entity creation - missing required fields', [
                    'company_name' => $dto->company_name,
                    'address' => $dto->address,
                    'zip_code' => $dto->zip_code,
                    'city' => $dto->city,
                    'country' => $dto->country,
                ]);
            }
            
            if ($dto->owners && is_array($dto->owners)) {
                foreach ($dto->owners as $owner) {
                    $individual = Individual::updateOrCreate(
                        [
                            'accommodation_id' => $accommodation->id,
                            'first_name' => $owner['first_name'],
                            'last_name' => $owner['last_name'],
                        ],
                        [
                            'date_of_birth' => $owner['dob'],
                        ]
                    );

                    Log::info('Saved business owner', [
                        'individual_id' => $individual->id,
                        'owner_data' => $individual->toArray()
                    ]);
                }
            }
        }

        Log::info('Partner verification completed successfully', [
            'property_id' => $dto->property_id,
            'accommodation_id' => $accommodation->id
        ]);
    }

    public function saveAvailabilitySettings(Property $property, SaveAvailabilitySettingsDTO $dto): void
    {
        Log::info('PropertyAction::saveAvailabilitySettings called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        // Prepare the data for saving
        $availabilityData = [
            'property_id' => $property->id,
            'availability_mode' => $dto->availability_mode,
            'availability_days' => $dto->availability_days,
            'allow_long_stays' => $dto->allow_long_stays,
            'max_nights' => $dto->max_nights,
            'sync_tripadvisor' => $dto->sync_tripadvisor,
        ];

        // Remove null values
        $availabilityData = array_filter($availabilityData, function ($value) {
            return $value !== null;
        });

        // Update or create the property availability settings
        PropertyAvailabilitySetting::updateOrCreate(
            ['property_id' => $property->id],
            $availabilityData
        );

        Log::info('Availability settings saved successfully', [
            'property_id' => $property->id,
            'availability_data' => $availabilityData
        ]);
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

    public function saveServices(Property $property, SaveServicesDTO $dto): void
    {
        Log::info('PropertyAction::saveServices called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        // Prepare the data for saving
        $serviceData = [
            'serve_breakfast' => filter_var($dto->serve_breakfast, FILTER_VALIDATE_BOOLEAN),
            'breakfast_included' => $dto->breakfast_included,
            'breakfast_type' => $dto->breakfast_type,
            'breakfast_price' => $dto->breakfast_price,
            'parking_available' => $dto->parking_available,
            'parking_cost' => $dto->parking_cost,
            'parking_reservation' => $dto->parking_reservation,
            'parking_location' => $dto->parking_location,
            'parking_type' => $dto->parking_type,
        ];

        // Remove null values
        $serviceData = array_filter($serviceData, function ($value) {
            return $value !== null;
        });

        // Update or create the property service
        $property->services()->updateOrCreate(
            ['property_id' => $property->id],
            $serviceData
        );

        Log::info('Services saved successfully', [
            'property_id' => $property->id,
            'service_data' => $serviceData
        ]);
    }

    public function saveHouseRules(Property $property, SaveHouseRulesDTO $dto): void
    {
        Log::info('PropertyAction::saveHouseRules called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        // Prepare the data for saving to property_policies table
        $policyData = [
            'smoking_allowed' => $this->convertToBoolean($dto->smoking_allowed),
            'children_allowed' => $this->convertToBoolean($dto->children_allowed),
            'parties_allowed' => $this->convertToBoolean($dto->parties_allowed),
            'pets_allowed' => $dto->pets_allowed,
            'pets_fees' => $dto->pets_fees,
            'check_in_from' => $dto->check_in_from,
            'check_in_until' => $dto->check_in_until,
            'check_out_from' => $dto->check_out_from,
            'check_out_until' => $dto->check_out_until,
        ];

        // Remove null values
        $policyData = array_filter($policyData, function ($value) {
            return $value !== null;
        });

        // Update or create the property policies
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            $policyData
        );

        Log::info('House rules saved successfully to property_policies', [
            'property_id' => $property->id,
            'policy_data' => $policyData
        ]);
    }

    private function convertToBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_string($value)) {
            return in_array(strtolower($value), ['true', '1', 'yes', 'on']);
        }
        if (is_numeric($value)) {
            return (bool) $value;
        }
        return false;
    }
    public function savePaymentMethod(SavePaymentMethodDTO $dto): void
    {
        $property = Property::findOrFail($dto->property_id);
        $property->payment_method = $dto->payment_method;
        $property->save();
    }


    public function saveInvoicing(Property $property, SaveInvoicingDTO $dto): void
    {
        $property->update([
            'invoicing_info' => $dto->toArray(),
        ]);
    }

    public function openBooking(Property $property): void
    {
        $property->update([
            'open_for_booking' => true,
        ]);
    }
}
