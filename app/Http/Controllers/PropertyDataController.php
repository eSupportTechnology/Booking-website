<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Actions\Partner\PropertyAction;
use Illuminate\Support\Facades\Log;
use App\Models\Language;

class PropertyDataController extends Controller
{
    public function getFacilities(Request $request, Property $property, PropertyAction $propertyAction)
    {
        try {
            $facilities = $propertyAction->getFacilities($property);
            
            return response()->json([
                'success' => true,
                'facilities' => $facilities
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting facilities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting facilities: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getServices(Request $request, Property $property, PropertyAction $propertyAction)
    {
        try {
            $services = $propertyAction->getServices($property);
            
            return response()->json([
                'success' => true,
                'services' => $services
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting services: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting services: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPropertyLanguages(Request $request, Property $property, PropertyAction $propertyAction)
    {
        try {
            $languages = $propertyAction->getLanguages($property);
            
            return response()->json([
                'success' => true,
                'languages' => $languages
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting languages: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting languages: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getVerification(Request $request, Property $property)
    {
        try {
            $verification = $property->partnerVerification;
            
            if (!$verification) {
                return response()->json([
                    'success' => true,
                    'verification' => null
                ]);
            }
            
            $verificationData = [
                'type' => $verification->type,
                'individual' => null,
                'business' => null
            ];
            
            if ($verification->type === 'individual' && $verification->individual) {
                $verificationData['individual'] = [
                    'firstName' => $verification->individual->first_name,
                    'lastName' => $verification->individual->last_name,
                    'dob' => $verification->individual->date_of_birth,
                    'altNames' => [$verification->individual->alternative_names]
                ];
            }
            
            if ($verification->type === 'business' && $verification->businessEntity) {
                $verificationData['business'] = [
                    'businessName' => $verification->businessEntity->business_name,
                    'tradingName' => $verification->businessEntity->trading_name,
                    'address' => $verification->businessEntity->address,
                    'zipCode' => $verification->businessEntity->zip_code,
                    'city' => $verification->businessEntity->city,
                    'country' => $verification->businessEntity->country,
                    'owners' => []
                ];
                
                // Load business owners
                $owners = \App\Models\Individual::where('business_entity_id', $verification->businessEntity->id)->get();
                foreach ($owners as $owner) {
                    $verificationData['business']['owners'][] = [
                        'firstName' => $owner->first_name,
                        'lastName' => $owner->last_name,
                        'dob' => $owner->date_of_birth,
                        'altNames' => [$owner->alternative_names]
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'verification' => $verificationData
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting verification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting verification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPropertyDetails(Request $request, Property $property)
    {
        try {
            $propertyData = [
                'title' => $property->title,
                'description' => $property->description,
                'address' => $property->address,
                'city' => $property->city,
                'country' => $property->country,
                'zip_code' => $property->zip_code,
                'property_count' => $property->property_count ?? 1
            ];
            
            return response()->json([
                'success' => true,
                'property' => $propertyData
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting property details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting property details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAmenities(Request $request, Property $property)
    {
        try {
            $amenities = $property->amenities()->pluck('amenity_id')->toArray();
            
            return response()->json([
                'success' => true,
                'amenities' => $amenities
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting amenities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting amenities: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getHostProfile(Request $request, Property $property)
    {
        try {
            $hostProfile = [
                'host_name' => $property->host_name,
                'about_property' => $property->about_property,
                'about_host' => $property->about_host,
                'about_neighborhood' => $property->about_neighborhood,
                'show_property' => $property->show_property ?? false,
                'show_host' => $property->show_host ?? false,
                'show_neighborhood' => $property->show_neighborhood ?? false
            ];
            
            return response()->json([
                'success' => true,
                'hostProfile' => $hostProfile
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting host profile: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting host profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPricing(Request $request, Property $property)
    {
        try {
            $pricing = [
                'price_per_night' => $property->price_per_night,
                'currency' => $property->currency ?? 'USD',
                'booking_type' => $property->booking_type ?? 'instant',
                'discount_enabled' => $property->discount_enabled ?? false,
                'discount_percent' => $property->discount_percent
            ];
            
            return response()->json([
                'success' => true,
                'pricing' => $pricing
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting pricing: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting pricing: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getHouseRules(Request $request, Property $property)
    {
        try {
            $houseRules = [
                'smoking_allowed' => $property->smoking_allowed ?? false,
                'parties_allowed' => $property->parties_allowed ?? false,
                'pets_allowed' => $property->pets_allowed ?? 'no',
                'pets_fees' => $property->pets_fees,
                'check_in_from' => $property->check_in_from ?? '15:00',
                'check_in_until' => $property->check_in_until ?? '18:00',
                'check_out_from' => $property->check_out_from ?? '08:00',
                'check_out_until' => $property->check_out_until ?? '11:00'
            ];
            
            return response()->json([
                'success' => true,
                'houseRules' => $houseRules
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting house rules: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting house rules: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailabilitySettings(Request $request, Property $property)
    {
        try {
            $availabilitySettings = $property->availabilitySettings;
            
            if (!$availabilitySettings) {
                return response()->json([
                    'success' => true,
                    'availabilitySettings' => null
                ]);
            }
            
            $settings = [
                'availability_mode' => $availabilitySettings->availability_mode,
                'availability_days' => $availabilitySettings->availability_days,
                'allow_long_stays' => $availabilitySettings->allow_long_stays ?? false,
                'max_nights' => $availabilitySettings->max_nights,
                'sync_tripadvisor' => $availabilitySettings->sync_tripadvisor ?? false
            ];
            
            return response()->json([
                'success' => true,
                'availabilitySettings' => $settings
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting availability settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting availability settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all available languages for the dropdown
     */
    public function getLanguages()
    {
        $languages = Language::orderBy('name')->get();
        return response()->json($languages);
    }

    public function getLatestProperty()
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'User not authenticated']);
            }
            
            $latestProperty = \App\Models\Property::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestProperty) {
                return response()->json([
                    'success' => true, 
                    'property_id' => $latestProperty->id
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'No property found']);
            }
        } catch (\Exception $e) {
            Log::error('Error getting latest property', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error getting latest property']);
        }
    }
} 