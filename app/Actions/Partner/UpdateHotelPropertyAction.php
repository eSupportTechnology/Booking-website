<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\Room;
use App\Models\PropertyFacility;
use App\Models\PropertyService;
use App\Models\PropertyPricing;
use App\Models\PropertyPolicy;
use App\Models\PropertyHostProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateHotelPropertyAction
{
    public function execute(Property $property, array $data): array
    {
        DB::beginTransaction();
        
        try {
            // Update basic property details
            $this->updateBasicDetails($property, $data);
            
            // Update amenities
            if (isset($data['amenities'])) {
                $this->updateAmenities($property, $data['amenities']);
            }
            
            // Update facilities
            if (isset($data['facilities'])) {
                $this->updateFacilities($property, $data['facilities']);
            }
            
            // Update services
            if (isset($data['services'])) {
                $this->updateServices($property, $data['services']);
            }
            
            // Update pricing
            if (isset($data['pricing'])) {
                $this->updatePricing($property, $data['pricing']);
            }
            
            // Update policies
            if (isset($data['policies'])) {
                $this->updatePolicies($property, $data['policies']);
            }
            
            // Update host profile
            if (isset($data['host_profile'])) {
                $this->updateHostProfile($property, $data['host_profile']);
            }
            
            // Update photos
            if (isset($data['photos'])) {
                $this->updatePhotos($property, $data['photos']);
            }
            
            // Update rooms
            if (isset($data['rooms'])) {
                $this->updateRooms($property, $data['rooms']);
            }
            
            DB::commit();
            
            return [
                'success' => true,
                'message' => 'Hotel property updated successfully',
                'property' => $property->fresh()
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Failed to update hotel property: ' . $e->getMessage()
            ];
        }
    }
    
    private function updateBasicDetails(Property $property, array $data): void
    {
        $property->update([
            'title' => $data['title'] ?? $property->title,
            'description' => $data['description'] ?? $property->description,
            'address' => $data['address'] ?? $property->address,
            'city' => $data['city'] ?? $property->city,
            'country' => $data['country'] ?? $property->country,
            'zipcode' => $data['zipcode'] ?? $property->zipcode,
            'latitude' => $data['latitude'] ?? $property->latitude,
            'longitude' => $data['longitude'] ?? $property->longitude,
            'stars' => $data['stars'] ?? $property->stars,
        ]);
    }
    
    private function updateAmenities(Property $property, array $amenities): void
    {
        $property->amenities()->sync($amenities);
    }
    
    private function updateFacilities(Property $property, array $facilities): void
    {
        PropertyFacility::where('property_id', $property->id)->delete();
        
        foreach ($facilities as $facility) {
            PropertyFacility::create([
                'property_id' => $property->id,
                'name' => $facility['name'],
                'description' => $facility['description'] ?? null,
                'is_available' => $facility['is_available'] ?? true,
            ]);
        }
    }
    
    private function updateServices(Property $property, array $services): void
    {
        $property->services()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'breakfast_available' => $services['breakfast_available'] ?? false,
                'breakfast_price' => $services['breakfast_price'] ?? null,
                'parking_available' => $services['parking_available'] ?? false,
                'wifi_available' => $services['wifi_available'] ?? false,
                'pet_friendly' => $services['pet_friendly'] ?? false,
            ]
        );
    }
    
    private function updatePricing(Property $property, array $pricing): void
    {
        $property->pricing()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'base_price' => $pricing['base_price'] ?? 0,
                'currency' => $pricing['currency'] ?? 'USD',
                'tax_rate' => $pricing['tax_rate'] ?? 0,
                'cleaning_fee' => $pricing['cleaning_fee'] ?? 0,
                'service_fee' => $pricing['service_fee'] ?? 0,
            ]
        );
    }
    
    private function updatePolicies(Property $property, array $policies): void
    {
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'check_in_time' => $policies['check_in_time'] ?? '15:00',
                'check_out_time' => $policies['check_out_time'] ?? '11:00',
                'cancellation_policy' => $policies['cancellation_policy'] ?? 'flexible',
                'house_rules' => $policies['house_rules'] ?? null,
                'smoking_allowed' => $policies['smoking_allowed'] ?? false,
                'pets_allowed' => $policies['pets_allowed'] ?? false,
                'parties_allowed' => $policies['parties_allowed'] ?? false,
            ]
        );
    }
    
    private function updateHostProfile(Property $property, array $hostProfile): void
    {
        $property->hostProfile()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'host_name' => $hostProfile['host_name'] ?? null,
                'host_description' => $hostProfile['host_description'] ?? null,
                'response_time' => $hostProfile['response_time'] ?? null,
                'response_rate' => $hostProfile['response_rate'] ?? null,
            ]
        );
    }
    
    private function updatePhotos(Property $property, array $photos): void
    {
        foreach ($photos as $photo) {
            if ($photo instanceof UploadedFile) {
                $path = $photo->store('property-photos', 'public');
                
                PropertyPhoto::create([
                    'property_id' => $property->id,
                    'photo_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }
    }
    
    private function updateRooms(Property $property, array $rooms): void
    {
        foreach ($rooms as $roomData) {
            if (isset($roomData['id'])) {
                // Update existing room
                $room = Room::find($roomData['id']);
                if ($room && $room->property_id === $property->id) {
                    $room->update([
                        'name' => $roomData['name'] ?? $room->name,
                        'max_guests' => $roomData['max_guests'] ?? $room->max_guests,
                        'bed_count' => $roomData['bed_count'] ?? $room->bed_count,
                        'bathroom_type' => $roomData['bathroom_type'] ?? $room->bathroom_type,
                        'price_per_night' => $roomData['price_per_night'] ?? $room->price_per_night,
                        'currency' => $roomData['currency'] ?? $room->currency,
                    ]);
                }
            } else {
                // Create new room
                Room::create([
                    'property_id' => $property->id,
                    'room_type_id' => $roomData['room_type_id'],
                    'name' => $roomData['name'],
                    'max_guests' => $roomData['max_guests'],
                    'bed_count' => $roomData['bed_count'],
                    'bathroom_type' => $roomData['bathroom_type'],
                    'price_per_night' => $roomData['price_per_night'],
                    'currency' => $roomData['currency'] ?? 'USD',
                ]);
            }
        }
    }
}