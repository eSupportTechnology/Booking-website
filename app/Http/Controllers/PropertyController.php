<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Actions\Partner\PropertyAction;
use App\DTOs\Partner\PropertyDTO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\DTOs\Partner\PropertyStep1DTO;
use App\DTOs\Partner\PropertyStep2DTO;


use Illuminate\Support\Facades\DB;
use App\Models\PropertyCategory;
use App\DTOs\Partner\PropertyAdditionalDetailsDTO;
use App\Actions\Partner\UpdatePropertyAdditionalDetailsAction;
use App\Models\PropertySubtype;
use App\Services\FileUploadService;
use App\DTOs\Partner\AccommodationDetailsDTO;
use App\Actions\Partner\StoreAccommodationDetailsAction;
use App\DTOs\Partner\SavePaymentMethodDTO;
use App\DTOs\Partner\SaveAmenitiesDTO;
use App\DTOs\Partner\SavePolicyDTO;
use App\DTOs\Partner\SaveRoomsDTO;
use App\DTOs\Partner\UploadPropertyPhotosDTO;
use App\DTOs\Partner\PartnerVerificationDTO;
use App\DTOs\Partner\SaveLanguagesDTO;
use App\DTOs\Partner\SaveAddressSameDTO;
use App\DTOs\Partner\PropertyServiceDTO;
use App\DTOs\Partner\SaveServicesDTO;
use App\DTOs\Partner\SaveHouseRulesDTO;
use App\DTOs\SaveAvailabilitySettingsDTO;
use App\DTOs\Partner\SaveHostProfileDTO;
use App\DTOs\Partner\SaveBedroomDTO;
use App\DTOs\Partner\SaveAdditionalDetailsDTO;
use App\DTOs\Partner\SaveAddressMultipleDTO;
use App\DTOs\Partner\SavePricingDTO;
use App\Actions\Partner\SaveHostProfileAction;
use App\Actions\Partner\SaveBedroomAction;
use App\Actions\Partner\SaveAdditionalDetailsAction;
use App\Actions\Partner\SaveAddressMultipleAction;
use App\Actions\Partner\SavePricingAction;
use App\DTOs\Partner\SaveInvoicingDTO;
use App\Models\Accommodation;
use App\Models\BedType;
use App\Models\Room;
use App\Models\PartnerVerification;
use App\Models\Language;
use App\Models\RoomType;
use App\DTOs\SaveFacilitiesDTO;
use App\Models\Amenity;
use Faker\Provider\ar_EG\Address;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = $request->input('partner_id');
        // Check if partner_id is present in the request
        Log::info('Partner ID from request: ' . $partnerId);
    }

    public function categories(PropertyAction $action)
    {
        $properties = $action->execute();
        Log::info('Property categories fetched', ['properties' => $properties]);
        // dd($properties);
        return view('partner.partner-property-types', compact('properties'));
    }

    public function subcategories($categoryId, PropertyAction $action)
    {
        $subcategories = $action->getPropertiesByCategory($categoryId);
        $amenities = $action->getAmenities();
        $roomTypes = $action->getRoomTypes();
        $bedTypes = $action->getBedTypes();
        $languages = $action->getLanguages();
        Log::info('Fetching subcategories for category ID: ' . $categoryId, ['subcategories' => $subcategories]);
        Log::info('Available amenities', ['amenities' => $amenities]);
        Log::info('Available room types', ['roomTypes' => $roomTypes]);
        Log::info('Available bed types', ['bedTypes' => $bedTypes]);
        Log::info('Available languages', ['languages' => $languages]);

        switch ($categoryId) {
            case 1:  // Homes
                if ($subcategories->isEmpty()) {
                    return redirect()->back()->withErrors(['error' => 'No subcategories found for this category.']);
                }
                return view('partner.partner-homes-create-form-1', compact('subcategories', 'categoryId', 'amenities', 'roomTypes', 'bedTypes', 'languages'));

            case 2:  // Apartment
                // Hardcode subcategories for Apartment
                $subcategories = collect([
                    (object)[
                        'id' => 1,
                        'category_id' => 2,
                        'name' => 'One',
                    ],
                    (object)[
                        'id' => 2,
                        'category_id' => 2,
                        'name' => 'Multiple',
                    ],
                ]);
                return view('partner.partner-apartment-create-form-1', [
                    'subcategories' => $subcategories,
                    'category' => 'apartment',
                ]);

            case 3:  // Hotel
                if ($subcategories->isEmpty()) {
                    return redirect()->back()->withErrors(['error' => 'No subcategories found for this category.']);
                }
                return view('partner.partner-hotels-create-1', [
                    'amenities' => $amenities,
                    'languages' => $languages,
                    'roomTypes' => $roomTypes,
                    'bedTypes' => $bedTypes,
                    'categoryId' => $categoryId,
                    'subcategories' => $subcategories,
                    'category' => 'hotel',
                ]);

            default:
                abort(404);
        }
    }

    public function rooms($categoryId, PropertyAction $action)
    {
        $subcategories = $action->getPropertiesByCategory($categoryId);
        $amenities = $action->getAmenities();
        $roomTypes = $action->getRoomTypes();
        $bedTypes = $action->getBedTypes();
        $languages = $action->getLanguages();

        switch ($categoryId) {
            case 3:  // Hotel
                if ($subcategories->isEmpty()) {
                    return redirect()->back()->withErrors(['error' => 'No subcategories found for this category.']);
                }
                return view('partner.partner-hotels-rooms', [
                    'amenities' => $amenities,
                    'languages' => $languages,
                    'roomTypes' => $roomTypes,
                    'bedTypes' => $bedTypes,
                    'categoryId' => $categoryId,
                    'subcategories' => $subcategories,
                    'category' => 'hotel',
                ]);

            default:
                abort(404);
        }
        Log::info('Subcategories fetched for category ID ' . $categoryId, ['subcategories' => $subcategories]);
        return view('partner.partner-homes-create-form-1', compact('subcategories', 'categoryId'));
    }




    public function subtypes($subcategoryId, PropertyAction $action)
    {
        $properties = $action->getPropertiesBySubcategory($subcategoryId);
        return response()->json($properties);
    }

    public function register(Request $request, PropertyAction $action)
    {
        Log::info('Registering property with request data: ', $request->all());
        $propertyDTO = PropertyDTO::fromRequest($request);
        $property = $action->registerProperty($propertyDTO);
        return response()->json($property, 201);
    }

    public function showStep1($category, PropertyAction $action)
    {
        switch ($category) {
            case 'apartment':
                // Hardcode subcategories for Apartment
                $subcategories = collect([
                    (object)[
                        'id' => 1,
                        'category_id' => 2,
                        'name' => 'One',
                    ],
                    (object)[
                        'id' => 2,
                        'category_id' => 2,
                        'name' => 'Multiple',
                    ],
                ]);
                return view('partner.partner-apartment-create-form-1', [
                    'subcategories' => $subcategories,
                    'category' => 'apartment',
                ]);
            case 'home':
                return view('partner.partner-home-create-form-1');
            default:
                abort(404);
        }
    }

    public function storeStep1(Request $request, PropertyAction $action)
    {
        Log::info('storeStep1 called', [
            'request' => $request->all(),
            'session' => session()->all(),
            'partner_id' => $request->input('partner_id'),
            'address_type_id' => $request->input('address_type_id'),
            'expects_json' => $request->expectsJson(),
            'is_ajax' => $request->ajax(),
            'method' => $request->method(),
            'url' => $request->url(),
        ]);

        $category = $request->input('category_id');

        try {
            $dto = PropertyStep1DTO::fromRequest($request);
            if (Auth::check()) {
                $dto->user_id = Auth::id();
            }
            $dto->category = $category;

            $property = $action->createPropertyStep1($dto);

            session(['property_id' => $property->id]);

            $categoryString = strtolower(PropertyCategory::find($property->category_id)?->name ?? 'apartment');

            // 🔍 Check if the request expects JSON (i.e., it's from fetch/AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'property_id' => $property->id,
                    'message' => 'Step 1 data saved successfully',
                ]);
            }

            // 🔁 Fallback for regular form submission
            return redirect()->route('partner.property.step2', [
                'category' => $categoryString,
                'property' => $property->id,
            ])->with('success', 'Step 1 data saved successfully');
        } catch (\Exception $e) {
            Log::error('storeStep1 exception', ['message' => $e->getMessage()]);

            // Return error as JSON
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }


    public function showStep2($category, $propertyId, PropertyAction $action)
    {
        $property = Property::findOrFail($propertyId);
        $categoryString = strtolower($category);
        $groupedAmenities = $action->getGroupedAmenities();

        return view('partner.partner-apartment-create-form-2', [
            'property' => $property,
            'category' => $categoryString,
            'groupedAmenities' => $groupedAmenities,
        ]);
    }

    public function storeStep2(Request $request,  $propertyId, PropertyAction $action)
    {
        Log::info('storeStep2 called', $request->all());


        try {
            $property = Property::findOrFail($request->input('property_id', $propertyId));

            if ($request->has('address_type_id') && count($request->all()) === 2) {
                $property->update([
                    'address_type_id' => $request->input('address_type_id')
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Address type saved',
                    'property_id' => $property->id,
                ]);
            }

            $dto = PropertyStep2DTO::fromRequest($request);
            $updatedProperty = $action->updatePropertyStep2($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Step 2 data saved successfully',
                'property_id' => $updatedProperty->id,
            ]);
        } catch (\Exception $e) {
            Log::error('storeStep2 exception', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }


    public function updateTitle(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $property->title = $request->input('title');
        $property->save();
        return response()->json(['success' => true]);
    }

    public function updatePartial(Request $request, Property $property, PropertyAction $action)
    {
        Log::info('updatePartial called', ['request' => $request->all(), 'property_id' => $property->id]);
        try {
            $dataToUpdate = $request->except(['bedrooms']); // Exclude bedrooms from the main property update if they are handled separately

            // Update additional details if they exist in the request
            if ($request->hasAny(['guests', 'bathrooms', 'allow_children', 'offer_cribs', 'apartment_size', 'apartment_unit'])) {
                $additionalDetailsData = [
                    'guests' => $request->input('guests'),
                    'bathrooms' => $request->input('bathrooms'),
                    'allow_children' => $request->input('allow_children'),
                    'offer_cribs' => $request->input('offer_cribs'),
                    'apartment_size' => $request->input('apartment_size'),
                    'apartment_unit' => $request->input('apartment_unit'),
                ];

                $property->additionalDetails()->updateOrCreate(
                    ['property_id' => $property->id],
                    $additionalDetailsData
                );

                // Remove these keys from dataToUpdate to avoid errors in the action
                unset(
                    $dataToUpdate['guests'],
                    $dataToUpdate['bathrooms'],
                    $dataToUpdate['allow_children'],
                    $dataToUpdate['offer_cribs'],
                    $dataToUpdate['apartment_size'],
                    $dataToUpdate['apartment_unit']
                );
            }

            $bedrooms = $request->has('bedrooms') && is_array($request->bedrooms) ? $request->bedrooms : null;
            $updatedProperty = $action->updatePropertyPartial($property, $dataToUpdate, $bedrooms);
            Log::info('Property after update', $updatedProperty->toArray());
            return response()->json(['success' => true, 'property' => $updatedProperty]);
        } catch (\Exception $e) {
            Log::error('updatePartial exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function uploadPhotos(
        UploadPropertyPhotosDTO $dto,
        FileUploadService $fileUploadService,
        PropertyAction $propertyAction
    ) {
        $propertyAction->uploadPhotos($dto, $fileUploadService);

        return response()->json(['success' => true]);
    }


    public function updateAdditionalDetails(Request $request, Property $property, UpdatePropertyAdditionalDetailsAction $action)
    {
        Log::info('updateAdditionalDetails called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);

        try {
            $dto = PropertyAdditionalDetailsDTO::fromRequest($request);
            
            Log::info('DTO created', [
                'dto_data' => $dto->toArray()
            ]);

            $result = $action->execute($property, $dto);
            
            Log::info('Additional details saved', [
                'result' => $result
            ]);

            return response()->json(['success' => true, 'message' => 'Additional details saved successfully.']);
        } catch (\Exception $e) {
            Log::error('Error saving additional details', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error saving additional details: ' . $e->getMessage()
            ], 500);
        }
    }


    public function storeAccommodationDetails(Request $request, StoreAccommodationDetailsAction $action)
    {
        Log::info('storeAccommodationDetails called', [
            'request' => $request->all(),
        ]);
        try {
            $dto = AccommodationDetailsDTO::fromRequest($request);
            Log::info('AccommodationDetailsDTO created', [
                'dto' => (array) $dto,
            ]);
            $accommodation = $action->execute($dto);
            Log::info('Accommodation created', [
                'accommodation_id' => $accommodation->id,
            ]);
            return response()->json([
                'success' => true,
                'accommodation_id' => $accommodation->id,
                'message' => 'Accommodation details saved successfully.'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('ValidationException in storeAccommodationDetails', [
                'errors' => $e->errors(),
            ]);
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Exception in storeAccommodationDetails', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function saveAmenities(Request $request, $propertyId, PropertyAction $propertyAction)
    {
        Log::info('saveAmenities called', [
            'property_id' => $propertyId,
            'request_data' => $request->all(),
            'request_method' => $request->method(),
            'url' => $request->url()
        ]);
        
        try {
            $property = Property::findOrFail($propertyId);
            Log::info('Property found', ['property_id' => $property->id]);
            
            $dto = SaveAmenitiesDTO::fromRequest($request);
            Log::info('DTO created successfully', ['dto_data' => $dto->toArray()]);
            
            $propertyAction->saveAmenities($property, $dto);
            
            return response()->json([
                'success' => true,
                'message' => 'Amenities saved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving amenities', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error saving amenities: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveFacilities(Request $request, Property $property, PropertyAction $propertyAction)
    {
        try {
            $dto = SaveFacilitiesDTO::fromRequest($request->all());
            $propertyAction->saveFacilities($property, $dto);
            
            return response()->json([
                'success' => true,
                'message' => 'Facilities saved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving facilities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving facilities: ' . $e->getMessage()
            ], 500);
        }
    }




    public function savePolicy(Request $request, Property $property, PropertyAction $propertyAction)
    {
        Log::info('savePolicy called', [
            'property_id' => $property->id,
            'request' => $request->all(),
        ]);

        try {
            $dto = SavePolicyDTO::fromRequest($request);

            Log::info('savePolicy validated', $dto->toArray());

            $propertyAction->savePolicy($property, $dto);

            return response()->json(['success' => true, 'message' => 'Policy saved']);
        } catch (\Exception $e) {
            Log::error('savePolicy error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveRooms(Request $request, PropertyAction $propertyAction)
    {
        try {
            $dto = SaveRoomsDTO::fromRequest($request);

            Log::info('Validated room data', $dto->toArray());

            $propertyAction->saveRooms($dto);

            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error saving rooms', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storePartnerVerification(Request $request, PropertyAction $propertyAction)
    {
        try {
            Log::info('storePartnerVerification called', [
                'request' => $request->all(),
            ]);
            $dto = PartnerVerificationDTO::fromRequest($request);

            $propertyAction->partnerVerification($dto);
            return response()->json(['message' => 'Partner verification saved successfully']);
        } catch (\Exception $e) {
            Log::error('Error saving partner verification', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showBedrooms($category, $property)
    {
        // $property is the ID from the route
        return view('partner.partner-apartments-bedrooms', [
            'propertyId' => $property,
        ]);
    }

    public function saveBedroom(Request $request, Property $property, SaveBedroomAction $action)
    {
        Log::info('saveBedroom called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);

        try {
            $dto = SaveBedroomDTO::fromRequest($request);
            $action->execute($dto, $property);

            // Get source and step from request
            $source = $request->input('source');
            $step = $request->input('step');

            Log::info('Bedroom saved successfully', [
                'property_id' => $property->id,
                'source' => $source,
                'step' => $step
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Bedroom saved successfully.',
                'source' => $source,
                'step' => $step
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving bedroom', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving bedroom: ' . $e->getMessage()], 500);
        }
    }

        public function showMultipleApartmentForm($property = null, PropertyAction $action)
    {
        Log::info('showMultipleApartmentForm called', [
            'property_param' => $property,
            'property_type' => gettype($property)
        ]);
        
        // If property is a numeric ID, fetch the property, otherwise set to null
        if ($property && is_numeric($property)) {
            $property = \App\Models\Property::find($property);
            
            // Load existing data for the property
            if ($property) {
                // Load amenities
                $existingAmenities = $property->amenities()->pluck('amenity_id')->toArray();
                
                // Load languages
                $existingLanguages = $property->languages()->pluck('language_id')->toArray();
                
                // Load facilities
                $existingFacilities = $property->facilities()->pluck('facility_name')->toArray();
                
                // Load partner verification data
                $existingVerification = $property->partnerVerification;
                $verificationData = null;
                
                if ($existingVerification) {
                    $verificationData = [
                        'type' => $existingVerification->type,
                        'individual' => [
                            'firstName' => $existingVerification->individual?->first_name ?? '',
                            'lastName' => $existingVerification->individual?->last_name ?? '',
                            'dob' => $existingVerification->individual?->date_of_birth ?? '',
                            'altNames' => [$existingVerification->individual?->alternative_names ?? '']
                        ],
                        'business' => [
                            'businessName' => $existingVerification->businessEntity?->business_name ?? '',
                            'tradingName' => $existingVerification->businessEntity?->trading_name ?? '',
                            'address' => $existingVerification->businessEntity?->address ?? '',
                            'zipCode' => $existingVerification->businessEntity?->zip_code ?? '',
                            'city' => $existingVerification->businessEntity?->city ?? '',
                            'country' => $existingVerification->businessEntity?->country ?? '',
                            'owners' => []
                        ]
                    ];
                    
                    // Load business owners if they exist
                    if ($existingVerification->businessEntity) {
                        $owners = \App\Models\Individual::where('business_entity_id', $existingVerification->businessEntity->id)->get();
                        foreach ($owners as $owner) {
                            $verificationData['business']['owners'][] = [
                                'firstName' => $owner->first_name ?? '',
                                'lastName' => $owner->last_name ?? '',
                                'dob' => $owner->date_of_birth ?? '',
                                'altNames' => [$owner->alternative_names ?? '']
                            ];
                        }
                    }
                }
                
                // Load other property details
                $propertyData = [
                    'title' => $property->title,
                    'description' => $property->description,
                    'address' => $property->address,
                    'city' => $property->city,
                    'country' => $property->country,
                    'zip_code' => $property->zip_code,
                    'amenities' => $existingAmenities,
                    'languages' => $existingLanguages,
                    'facilities' => $existingFacilities,
                    'verification' => $verificationData,
                    'property_count' => $property->property_count ?? 1,
                    'property_name' => $property->title ?? '',
                    'booking_type' => $property->booking_type ?? 'instant',
                    'price_per_night' => $property->price_per_night ?? '',
                    'currency' => $property->currency ?? 'USD',
                    'discount_enabled' => $property->discount_enabled ?? false,
                    'discount_percent' => $property->discount_percent ?? '',
                    'smoking_allowed' => $property->smoking_allowed ?? false,
                    'parties_allowed' => $property->parties_allowed ?? false,
                    'pets_allowed' => $property->pets_allowed ?? 'no',
                    'pets_fees' => $property->pets_fees ?? '',
                    'check_in_from' => $property->check_in_from ?? '15:00',
                    'check_in_until' => $property->check_in_until ?? '18:00',
                    'check_out_from' => $property->check_out_from ?? '08:00',
                    'check_out_until' => $property->check_out_until ?? '11:00',
                    'host_name' => $property->host_name ?? '',
                    'about_property' => $property->about_property ?? '',
                    'about_host' => $property->about_host ?? '',
                    'about_neighborhood' => $property->about_neighborhood ?? '',
                    'show_property' => $property->show_property ?? false,
                    'show_host' => $property->show_host ?? false,
                    'show_neighborhood' => $property->show_neighborhood ?? false,
                    'channel_manager' => $property->channel_manager ?? 'yes',
                    // Add other fields as needed
                ];
                
                Log::info('Loaded existing property data', [
                    'property_id' => $property->id,
                    'amenities_count' => count($existingAmenities),
                    'languages_count' => count($existingLanguages),
                    'facilities_count' => count($existingFacilities),
                    'has_verification' => $existingVerification ? true : false,
                    'property_data' => $propertyData
                ]);
            } else {
                $propertyData = null;
            }
        } else {
            $property = null;
            $propertyData = null;
        }
        
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();
        
        Log::info('showMultipleApartmentForm returning', [
            'property_id' => $property ? $property->id : null,
            'amenities_count' => $amenities->count(),
            'amenities' => $amenities->toArray(),
            'languages_count' => $languages->count(),
            'languages' => $languages->toArray(),
            'has_existing_data' => $propertyData ? true : false
        ]);
        
        return view('partner.partner-multiple-apartment', compact('property', 'amenities', 'languages', 'propertyData'));
    }

    public function showSingleApartmentForm2($propertyId = null)
    {
        Log::info('showSingleApartmentForm2 called', [
            'property_id' => $propertyId
        ]);
        
        // Get the latest property if none provided
        if (!$propertyId) {
            $property = \App\Models\Property::where('user_id', Auth::id())->latest()->first();
            if ($property) {
                $propertyId = $property->id;
            }
        }
        
        // Fetch saved room data from property_bedrooms table
        $roomDisplayData = [];
        if ($propertyId) {
            $savedRooms = \App\Models\PropertyBedroom::where('property_id', $propertyId)->get();
            
            // Process room data for display
            foreach ($savedRooms as $room) {
                $bedSummary = [];
                $totalBeds = 0;
                
                // Check each bed type and build summary
                if ($room->twin > 0) {
                    $bedSummary[] = $room->twin . ' twin bed' . ($room->twin > 1 ? 's' : '');
                    $totalBeds += $room->twin;
                }
                if ($room->full > 0) {
                    $bedSummary[] = $room->full . ' full bed' . ($room->full > 1 ? 's' : '');
                    $totalBeds += $room->full;
                }
                if ($room->queen > 0) {
                    $bedSummary[] = $room->queen . ' queen bed' . ($room->queen > 1 ? 's' : '');
                    $totalBeds += $room->queen;
                }
                if ($room->king > 0) {
                    $bedSummary[] = $room->king . ' king bed' . ($room->king > 1 ? 's' : '');
                    $totalBeds += $room->king;
                }
                if ($room->bunk > 0) {
                    $bedSummary[] = $room->bunk . ' bunk bed' . ($room->bunk > 1 ? 's' : '');
                    $totalBeds += $room->bunk;
                }
                if ($room->sofa > 0) {
                    $bedSummary[] = $room->sofa . ' sofa bed' . ($room->sofa > 1 ? 's' : '');
                    $totalBeds += $room->sofa;
                }
                if ($room->futon > 0) {
                    $bedSummary[] = $room->futon . ' futon bed' . ($room->futon > 1 ? 's' : '');
                    $totalBeds += $room->futon;
                }
                
                $roomDisplayData[$room->room_type] = [
                    'name' => $room->name,
                    'bed_summary' => implode(', ', $bedSummary),
                    'total_beds' => $totalBeds,
                    'has_beds' => $totalBeds > 0
                ];
            }
        }
        
        Log::info('showSingleApartmentForm2 returning', [
            'property_id' => $propertyId,
            'saved_rooms_count' => isset($savedRooms) ? $savedRooms->count() : 0,
            'room_display_data' => $roomDisplayData
        ]);
        
        return view('partner.partner-apartment-create-form-2', compact('propertyId', 'roomDisplayData'));
    }

    public function showMultipleApartmentForm2(PropertyAction $action, $propertyId)
    {
        Log::info('showMultipleApartmentForm2 called', [
            'property_id' => $propertyId
        ]);
        
        // Require a property ID - redirect to first form if none provided
        if (!$propertyId) {
            Log::warning('No property ID provided for Form 2, redirecting to first form');
            return redirect()->route('partner.multiple.apartment.initial')
                ->with('error', 'Please complete the first step before proceeding.');
        }
        
        // Verify the property exists
        $property = \App\Models\Property::find($propertyId);
        if (!$property) {
            Log::error('Property not found', ['property_id' => $propertyId]);
            return redirect()->route('partner.multiple.apartment.initial')
                ->with('error', 'Property not found. Please start over.');
        }
        
        // Load existing data for the property
        $existingAmenities = $property->amenities()->pluck('amenity_id')->toArray();
        $existingPhotos = $property->files()->where('file_type', 'image')->pluck('path')->map(function($path) {
            // Return in the format expected by Alpine.js with correct storage path
            return [
                'url' => '/storage/' . $path,
                'file' => null
            ];
        })->toArray();
        
        // Debug logging - check all files
        $allFiles = $property->files()->get();
        Log::info('Loading existing data for property', [
            'property_id' => $property->id,
            'amenities_count' => count($existingAmenities),
            'photos_count' => count($existingPhotos),
            'photos' => $existingPhotos,
            'all_files_count' => $allFiles->count(),
            'all_files' => $allFiles->toArray(),
            'files_query' => $property->files()->where('file_type', 'image')->toSql()
        ]);
        
        $propertyData = [
            'amenities' => $existingAmenities,
            'photos' => $existingPhotos,
            'property_count' => $property->property_count ?? 1,
            // Add other fields as needed
        ];
        
        // Fetch saved room data from property_bedrooms table
        $savedRooms = \App\Models\PropertyBedroom::where('property_id', $propertyId)->get();
        
        // Process room data for display
        $roomDisplayData = [];
        foreach ($savedRooms as $room) {
            $bedSummary = [];
            $totalBeds = 0;
            
            // Check each bed type and build summary
            if ($room->twin > 0) {
                $bedSummary[] = $room->twin . ' twin bed' . ($room->twin > 1 ? 's' : '');
                $totalBeds += $room->twin;
            }
            if ($room->full > 0) {
                $bedSummary[] = $room->full . ' full bed' . ($room->full > 1 ? 's' : '');
                $totalBeds += $room->full;
            }
            if ($room->queen > 0) {
                $bedSummary[] = $room->queen . ' queen bed' . ($room->queen > 1 ? 's' : '');
                $totalBeds += $room->queen;
            }
            if ($room->king > 0) {
                $bedSummary[] = $room->king . ' king bed' . ($room->king > 1 ? 's' : '');
                $totalBeds += $room->king;
            }
            if ($room->bunk > 0) {
                $bedSummary[] = $room->bunk . ' bunk bed' . ($room->bunk > 1 ? 's' : '');
                $totalBeds += $room->bunk;
            }
            if ($room->sofa > 0) {
                $bedSummary[] = $room->sofa . ' sofa bed' . ($room->sofa > 1 ? 's' : '');
                $totalBeds += $room->sofa;
            }
            if ($room->futon > 0) {
                $bedSummary[] = $room->futon . ' futon bed' . ($room->futon > 1 ? 's' : '');
                $totalBeds += $room->futon;
            }
            
            $roomDisplayData[$room->room_type] = [
                'name' => $room->name,
                'bed_summary' => implode(', ', $bedSummary),
                'total_beds' => $totalBeds,
                'has_beds' => $totalBeds > 0
            ];
        }
        
        $amenities = $action->getAmenitiesByContext('apartment');
        $languages = $action->getLanguages();
        
        Log::info('showMultipleApartmentForm2 returning', [
            'property_id' => $propertyId,
            'amenities_count' => $amenities->count(),
            'languages_count' => $languages->count(),
            'existing_amenities_count' => count($existingAmenities),
            'existing_photos_count' => count($existingPhotos),
            'saved_rooms_count' => $savedRooms->count(),
            'room_display_data' => $roomDisplayData
        ]);
        
        return view('partner.partner-multiple-apartment-2', compact('amenities', 'languages', 'propertyId', 'propertyData', 'roomDisplayData'));
    }

    public function saveStep1Data(Request $request, Property $property)
    {
        Log::info('saveStep1Data called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);

        try {
            // Update property with step 1 data
            $property->update([
                'guests_capacity' => $request->input('guests'),
                'bathrooms_count' => $request->input('bathrooms'),
                'property_count' => $request->input('property_count')
            ]);

            // Save bedrooms if provided
            if ($request->has('bedrooms') && is_array($request->input('bedrooms'))) {
                foreach ($request->input('bedrooms') as $bedroomData) {
                    // Create room
                    $room = $property->rooms()->create([
                        'name' => $bedroomData['name'],
                        'room_type_id' => 1 // Assuming bedroom type
                    ]);

                    // Create bed associations
                    foreach ($bedroomData['beds'] as $bedData) {
                        $room->beds()->attach($bedData['id'], ['count' => $bedData['count']]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Step 1 data saved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving step 1 data', [
                'error' => $e->getMessage(),
                'property_id' => $property->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error saving step 1 data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showMultipleApartmentForm3(PropertyAction $action)
    {
        Log::info('showMultipleApartmentForm3 called');
        
        // Redirect to dashboard or show a simple success message
        return redirect()->route('partner.multiple.apartment.initial')
            ->with('success', 'Property listing completed successfully!');
    }





    /**
     * Save selected languages for a property
     */
    public function saveLanguages(Request $request, Property $property, PropertyAction $propertyAction)
    {
        Log::info('saveLanguages called', [
            'property_id' => $property->id,
            'request' => $request->all(),
        ]);

        try {
            $dto = SaveLanguagesDTO::fromRequest($request);
            $propertyAction->saveLanguages($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Languages saved successfully.',
                'selected_languages' => $property->languages()->pluck('name')->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving languages', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save additional details including languages (for the saveAdditionalDetails method)
     */
    public function saveAdditionalDetails(Request $request, SaveAdditionalDetailsAction $action)
    {
        Log::info('saveAdditionalDetails called', [
            'request' => $request->all(),
        ]);

        try {
            $dto = SaveAdditionalDetailsDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json([
                'success' => true,
                'message' => 'Additional details saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving additional details', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveAddressSame(Request $request, PropertyAction $propertyAction)
    {
        try {
            Log::info('saveAddressSame called', ['request' => $request->all()]);

            $dto = SaveAddressSameDTO::fromRequest($request);

            $propertyAction->saveSameAddress($dto);

            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving same address', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveAddressMultiple(Request $request, SaveAddressMultipleAction $action)
    {
        try {
            $dto = SaveAddressMultipleDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json(['message' => 'Multiple addresses saved']);
        } catch (\Exception $e) {
            Log::error('Error saving multiple addresses', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving multiple addresses: ' . $e->getMessage()], 500);
        }
    }

    public function saveHostProfile(Request $request, Property $property, SaveHostProfileAction $action)
    {
        Log::info('saveHostProfile called', [
            'property_id' => $property->id,
            'request_data' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type')
        ]);

        try {
            // Merge property_id into request data since it comes from route parameter
            $requestData = $request->all();
            $requestData['property_id'] = $property->id;
            
            $dto = SaveHostProfileDTO::fromArray($requestData);
            $action->execute($dto, $property);

            return response()->json(['success' => true, 'message' => 'Host profile saved successfully']);
        } catch (\Exception $e) {
            Log::error('Error saving host profile', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving host profile: ' . $e->getMessage()], 500);
        }
    }

    public function savePricing(Request $request, Property $property, SavePricingAction $action)
    {
        Log::info('savePricing called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);
        try {
            // Merge property_id into request data since it comes from route parameter
            $requestData = $request->all();
            $requestData['property_id'] = $property->id;
            
            $dto = SavePricingDTO::fromArray($requestData);
            $action->execute($dto, $property);

            return response()->json(['success' => true, 'message' => 'Pricing saved successfully']);
        } catch (\Exception $e) {
            Log::error('Error saving pricing', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving pricing: ' . $e->getMessage()], 500);
        }
    }



    public function showHomesForm2($id, $subtype)
    {
        try {
            Log::info('showHomesForm2 called', ['id' => $id]);
            $property = Property::findOrFail($id);
            Log::info('Property found', ['property_id' => $property->id]);
            $property_subtype = PropertySubtype::findOrFail($subtype);
            Log::info('Property subtype found', ['subtype_id' => $property_subtype->id, 'name' => $property_subtype->name]);

            // Return the view with the property data
            return view('partner.partner-homes-form-2', compact('property', 'property_subtype'));
        } catch (\Exception $e) {
            Log::error('Error in showHomesForm2', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showPrivateHomesSingle(Request $request, PropertyAction $action)
    {
        $propertyId = $request->input('propertyId');
        $subtypeId = $request->input('subtypeId')||Property::where('id', $propertyId)->first()->subtype_id;
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        return view('partner.partner-homes-single', compact('propertyId', 'subtypeId', 'amenities', 'languages'));
    }

    public function showPrivateHomesMultiple(Request $request, PropertyAction $action)
    {
        $propertyId = $request->input('propertyId');
        $subtypeId = $request->input('subtypeId')||Property::where('id', $propertyId)->first()->subtype_id;
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        return view('partner.partner-homes-multiple', compact('propertyId', 'subtypeId', 'amenities', 'languages'));
    }

    public function completeHomesRegistration($propertyId, PropertyAction $action)
    {
        $property =Property::findOrFail($propertyId);
        $accommodation_type=Accommodation::where('property_id', $propertyId)->first()->ownership_type;
        Log::info('Accommodation type found', ['accommodation_type' => $accommodation_type]);
        return view('partner.partner-homes-complete-registration', compact('propertyId', 'accommodation_type'));
    }

    public function saveServices(Request $request, Property $property, PropertyAction $propertyAction)
    {
        Log::info('saveServices called', [
            'property_id' => $property->id,
            'request' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'url' => $request->url(),
        ]);

        try {
            $dto = SaveServicesDTO::fromRequest($request);
            Log::info('DTO created successfully', [
                'dto_data' => $dto->toArray()
            ]);

            $propertyAction->saveServices($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Services saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving services', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveHouseRules(Request $request, Property $property, PropertyAction $propertyAction)
    {
        Log::info('saveHouseRules called', [
            'property_id' => $property->id,
            'request' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'url' => $request->url(),
        ]);

        try {
            // Log the raw request data
            Log::info('Raw request data', [
                'all' => $request->all(),
                'json' => $request->json()->all(),
                'input' => $request->input(),
            ]);

            $dto = SaveHouseRulesDTO::fromRequest($request);
            Log::info('DTO created successfully', [
                'dto_data' => $dto->toArray()
            ]);

            $propertyAction->saveHouseRules($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'House rules saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving house rules', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveAvailabilitySettings(Request $request, Property $property, PropertyAction $propertyAction)
    {
        Log::info('saveAvailabilitySettings called', [
            'property_id' => $property->id,
            'request' => $request->all(),
        ]);

        try {
            $dto = SaveAvailabilitySettingsDTO::fromRequest($request);
            $propertyAction->saveAvailabilitySettings($property, $dto);
            return response()->json(['success' => true, 'message' => 'Availability settings saved successfully']);
        } catch (\Exception $e) {
            Log::error('Error saving availability settings', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Error saving availability settings: ' . $e->getMessage()], 500);
        }
    }

    public function showPrivateHomesRooms($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $roomTypes=RoomType::all();
        $bedTypes=BedType::all();
        $amenities=Amenity::all();
        $groupedAmenities = $amenities->groupBy('category');

        return view('partner.partner-homes-rooms', compact('property', 'roomTypes', 'bedTypes', 'groupedAmenities'));
    }

    public function showPrivateHomesImages($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('partner.partner-homes-images', compact('property'));
    }

    public function showPrivateHomesPayments($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('partner.partner-homes-payments', compact('property'));
    }

    public function showPrivateHomesEdit($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('partner.partner-homes-edit', compact('property'));
    }

    public function savePaymentMethod(Request $request, PropertyAction $action)
    {
        try {
            $dto = SavePaymentMethodDTO::fromRequest($request);
            $action->savePaymentMethod($dto);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveInvoicing(Request $request,  $propertyId, PropertyAction $action)
    {
        try {
            Log::info('saveInvoicing called', [
                'property_id' => $propertyId,
                'request' => $request->all(),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
                'url' => $request->url(),
            ]);
            $dto = SaveInvoicingDTO::fromRequest($request);
            $property = Property::findOrFail($propertyId);
            $action->saveInvoicing($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Invoicing info saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving invoicing info.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function openBooking($propertyId, PropertyAction $propertyAction)
    {
        try {
            $property = Property::findOrFail($propertyId);
            $propertyAction->openBooking($property);
            return view('frontend.open-booking');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
