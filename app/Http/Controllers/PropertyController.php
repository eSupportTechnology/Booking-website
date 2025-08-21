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
use App\DTOs\Partner\ApartmentStep1DTO;


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
use App\Models\CancellationPolicy;
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

    public function subcategories(PropertyAction $action, $categoryId, $propertyId = null)
    {
        $subcategories = $action->getPropertiesByCategory($categoryId);
        $amenities = $action->getAmenities();
        $roomTypes = $action->getRoomTypes();
        $bedTypes = $action->getBedTypes();
        $languages = $action->getLanguages();


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
                    'propertyId' => $propertyId,
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
            // Check if this is an apartment form (category_id = 2 for apartments)
            if ($category == 2) {
                // Use ApartmentStep1DTO for apartments (no subcategory_id required)
                $dto = ApartmentStep1DTO::fromRequest($request);
                if (Auth::check()) {
                    $dto->user_id = Auth::id();
                }
                $dto->category = $category;

                $property = $action->createApartmentStep1($dto);
            } else {
                // Use PropertyStep1DTO for other categories (homes, hotels, etc.)
                $dto = PropertyStep1DTO::fromRequest($request);
                if (Auth::check()) {
                    $dto->user_id = Auth::id();
                }
                $dto->category = $category;

                $property = $action->createPropertyStep1($dto);
            }

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

            // Log::info('DTO created', [
            //     'dto_data' => $dto->toArray()
            // ]);

            $result = $action->execute($property, $dto);

            // Log::info('Additional details saved', [
            //     'result' => $result
            // ]);

            return response()->json(['success' => true, 'message' => 'Additional details saved successfully.']);
        } catch (\Exception $e) {
            // Log::error('Error saving additional details', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);

            return response()->json([
                'success' => false,
                'message' => 'Error saving additional details: ' . $e->getMessage()
            ], 500);
        }
    }


    public function storeAccommodationDetails(Request $request, StoreAccommodationDetailsAction $action)
    {
        // Log::info('storeAccommodationDetails called', [
        //     'request' => $request->all(),
        // ]);
        try {
            $dto = AccommodationDetailsDTO::fromRequest($request);
            // Log::info('AccommodationDetailsDTO created', [
            //     'dto' => (array) $dto,
            // ]);
            $accommodation = $action->execute($dto);
            // Log::info('Accommodation created', [
            //     'accommodation_id' => $accommodation->id,
            // ]);
            return response()->json([
                'success' => true,
                'accommodation_id' => $accommodation->id,
                'message' => 'Accommodation details saved successfully.'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log::error('ValidationException in storeAccommodationDetails', [
            //     'errors' => $e->errors(),
            // ]);
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log::error('Exception in storeAccommodationDetails', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function saveAmenities(Request $request, $propertyId, PropertyAction $propertyAction)
    {
        // Log::info('saveAmenities called', [
        //     'property_id' => $propertyId,
        //     'request_data' => $request->all(),
        //     'request_method' => $request->method(),
        //     'url' => $request->url()
        // ]);

        try {
            $property = Property::findOrFail($propertyId);
            // Log::info('Property found', ['property_id' => $property->id]);

            $dto = SaveAmenitiesDTO::fromRequest($request);
            // Log::info('DTO created successfully', ['dto_data' => $dto->toArray()]);

            $propertyAction->saveAmenities($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Amenities saved successfully'
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saving amenities', [
            //     'message' => $e->getMessage(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     'trace' => $e->getTraceAsString()
            // ]);
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
            // Log::error('Error saving facilities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving facilities: ' . $e->getMessage()
            ], 500);
        }
    }




    public function savePolicy(Request $request, Property $property, PropertyAction $propertyAction)
    {
        // Log::info('savePolicy called', [
        //     'property_id' => $property->id,
        //     'request' => $request->all(),
        // ]);

        try {
            $dto = SavePolicyDTO::fromRequest($request);

            // Log::info('savePolicy validated', $dto->toArray());

            $propertyAction->savePolicy($property, $dto);

            return response()->json(['success' => true, 'message' => 'Policy saved']);
        } catch (\Exception $e) {
            // Log::error('savePolicy error', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
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
        $propertyModel = \App\Models\Property::findOrFail($property);

        // Fetch existing bedrooms for this property
        $existingBedrooms = \App\Models\PropertyBedroom::where('property_id', $property)->get();

        // Convert to rooms structure for frontend
        $rooms = [
            'bedroom1' => ['name' => 'Bedroom 1', 'twin' => 0, 'full' => 1, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'livingRoom' => ['name' => 'Living room', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'otherSpaces' => ['name' => 'Other spaces', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0]
        ];

        foreach ($existingBedrooms as $room) {
            // Create a consistent key format for bedrooms
            if (str_contains(strtolower($room->name), 'bedroom')) {
                // Extract bedroom number
                if (preg_match('/bedroom\s*(\d+)/i', $room->name, $matches)) {
                    $bedroomNumber = $matches[1];
                    $roomKey = 'bedroom' . $bedroomNumber;
                } else {
                    // If no number found, use 'bedroom1'
                    $roomKey = 'bedroom1';
                }
            } else {
                // For non-bedroom rooms, use the original logic
                $roomKey = strtolower(str_replace(' ', '', $room->name));
            }

            Log::info('Processing existing room', [
                'room_name' => $room->name,
                'room_key' => $roomKey,
                'room_type' => $room->room_type
            ]);

            $rooms[$roomKey] = [
                'name' => $room->name,
                'twin' => $room->twin ?? 0,
                'full' => $room->full ?? 0,
                'queen' => $room->queen ?? 0,
                'king' => $room->king ?? 0,
                'bunk' => $room->bunk ?? 0,
                'sofa' => $room->sofa ?? 0,
                'futon' => $room->futon ?? 0
            ];
        }

        Log::info('Final rooms data for frontend', [
            'property_id' => $property,
            'rooms_keys' => array_keys($rooms),
            'rooms_data' => $rooms
        ]);

        return view('partner.partner-apartments-bedrooms', [
            'property' => $propertyModel,
            'propertyId' => $property,
            'rooms' => $rooms
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
            'property_id' => $propertyId,
            'request_url' => request()->url(),
            'user_id' => Auth::id()
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
        $rooms = [
            'bedroom1' => ['name' => 'Bedroom 1', 'twin' => 0, 'full' => 1, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'livingRoom' => ['name' => 'Living room', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'otherSpaces' => ['name' => 'Other spaces', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0]
        ];

        if ($propertyId) {
            $savedRooms = \App\Models\PropertyBedroom::where('property_id', $propertyId)->get();

            Log::info('Loading saved rooms from database', [
                'property_id' => $propertyId,
                'saved_rooms_count' => $savedRooms->count(),
                'saved_rooms' => $savedRooms->toArray()
            ]);

            // Process room data for display and convert to rooms object
            foreach ($savedRooms as $room) {
                Log::info('Processing room', [
                    'room_id' => $room->id,
                    'room_name' => $room->name,
                    'room_type' => $room->room_type,
                    'twin' => $room->twin,
                    'full' => $room->full,
                    'queen' => $room->queen,
                    'king' => $room->king,
                    'bunk' => $room->bunk,
                    'sofa' => $room->sofa,
                    'futon' => $room->futon
                ]);

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

                // Convert to rooms object structure for frontend
                $roomKey = strtolower(str_replace(' ', '', $room->name));
                $rooms[$roomKey] = [
                    'name' => $room->name,
                    'twin' => $room->twin ?? 0,
                    'full' => $room->full ?? 0,
                    'queen' => $room->queen ?? 0,
                    'king' => $room->king ?? 0,
                    'bunk' => $room->bunk ?? 0,
                    'sofa' => $room->sofa ?? 0,
                    'futon' => $room->futon ?? 0
                ];

                Log::info('Added room to rooms object', [
                    'room_key' => $roomKey,
                    'room_data' => $rooms[$roomKey]
                ]);
            }
        }

        // Fetch property data if propertyId exists
        $propertyData = null;
        if ($propertyId) {
            Log::info('Looking for property with ID:', ['property_id' => $propertyId]);
            $property = \App\Models\Property::find($propertyId);
            if ($property) {
                Log::info('Property found:', [
                    'id' => $property->id,
                    'title' => $property->title,
                    'user_id' => $property->user_id
                ]);
                $propertyData = [
                    'id' => $property->id,
                    'title' => $property->title,
                    'address' => $property->address,
                    'city' => $property->city,
                    'country' => $property->country,
                    'apartment' => $property->apartment,
                    'zipcode' => $property->zipcode,
                    'description' => $property->description,
                    'channel_manager' => $property->channel_manager,
                    'wizard_step' => $property->wizard_step,
                    'property_wizard_step' => $property->property_wizard_step,
                    'pricing_wizard_step' => $property->pricing_wizard_step,
                    'rooms' => $rooms
                ];
            } else {
                Log::warning('Property not found with ID:', ['property_id' => $propertyId]);
            }
        } else {
            Log::info('No property ID provided, will use latest property');
        }

        Log::info('showSingleApartmentForm2 returning', [
            'property_id' => $propertyId,
            'saved_rooms_count' => isset($savedRooms) ? $savedRooms->count() : 0,
            'room_display_data' => $roomDisplayData,
            'final_rooms_object' => $rooms,
            'property_data' => $propertyData
        ]);

        // Get grouped amenities for the view
        $groupedAmenities = \App\Models\Amenity::all()->groupBy('category');

        return view('partner.partner-apartment-create-form-2', compact('propertyId', 'propertyData', 'roomDisplayData', 'groupedAmenities', 'rooms'));
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
        $existingPhotos = $property->files()->where('file_type', 'image')->pluck('path')->map(function ($path) {
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

        // Fetch saved room data from property_bedrooms table
        $savedRooms = \App\Models\PropertyBedroom::where('property_id', $propertyId)->get();

        // Initialize rooms object with default structure
        $rooms = [
            'bedroom1' => ['name' => 'Bedroom 1', 'twin' => 0, 'full' => 1, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'livingRoom' => ['name' => 'Living room', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
            'otherSpaces' => ['name' => 'Other spaces', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0]
        ];

        $propertyData = [
            'amenities' => $existingAmenities,
            'photos' => $existingPhotos,
            'property_count' => $property->property_count ?? 1,
            'rooms' => $rooms,
            // Add other fields as needed
        ];

        // Process room data for display and convert to rooms object
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

            // Create a unique key for each room
            $displayKey = $room->room_type;
            if ($room->room_type === 'bedroom') {
                // For bedrooms, use the room name as the key to distinguish between Bedroom 1, Bedroom 2, etc.
                $displayKey = strtolower(str_replace(' ', '', $room->name));
            } elseif ($room->room_type === 'living_room') {
                // For living room, use consistent key
                $displayKey = 'livingroom';
            } elseif ($room->room_type === 'other') {
                // For other spaces, use consistent key
                $displayKey = 'otherspaces';
            }

            // Log::info('Processing room for display', [
            //     'room_id' => $room->id,
            //     'room_name' => $room->name,
            //     'room_type' => $room->room_type,
            //     'display_key' => $displayKey,
            //     'bed_summary' => implode(', ', $bedSummary),
            //     'total_beds' => $totalBeds,
            //     'has_beds' => $totalBeds > 0
            // ]);

            $roomDisplayData[$displayKey] = [
                'name' => $room->name,
                'bed_summary' => implode(', ', $bedSummary),
                'total_beds' => $totalBeds,
                'has_beds' => $totalBeds > 0
            ];

            // Convert to rooms object structure for frontend
            // Map room names to frontend keys
            $roomKey = null;
            $normalizedName = strtolower(trim($room->name));

            if (strpos($normalizedName, 'living') !== false) {
                $roomKey = 'livingRoom';
            } elseif (strpos($normalizedName, 'other') !== false) {
                $roomKey = 'otherSpaces';
            } else {
                // For bedrooms, create consistent keys
                if (strpos($normalizedName, 'bedroom') !== false) {
                    // Extract bedroom number and create key like 'bedroom1', 'bedroom2', etc.
                    if (preg_match('/bedroom\s*(\d+)/i', $room->name, $matches)) {
                        $bedroomNumber = $matches[1];
                        $roomKey = 'bedroom' . $bedroomNumber;
                    } else {
                        // If no number found, use 'bedroom1'
                        $roomKey = 'bedroom1';
                    }
                } else {
                    // For other rooms, use the original logic
                    $roomKey = strtolower(str_replace(' ', '', $room->name));
                }
            }

            // Log the room key mapping for debugging
            // Log::info('Added room to rooms object', [
            //     'room_key' => $roomKey,
            //     'room_data' => [
            //         'name' => $room->name,
            //         'twin' => $room->twin ?? 0,
            //         'full' => $room->full ?? 0,
            //         'queen' => $room->queen ?? 0,
            //         'king' => $room->king ?? 0,
            //         'bunk' => $room->bunk ?? 0,
            //         'sofa' => $room->sofa ?? 0,
            //         'futon' => $room->futon ?? 0
            //     ]
            // ]);

            $rooms[$roomKey] = [
                'name' => $room->name,
                'twin' => $room->twin ?? 0,
                'full' => $room->full ?? 0,
                'queen' => $room->queen ?? 0,
                'king' => $room->king ?? 0,
                'bunk' => $room->bunk ?? 0,
                'sofa' => $room->sofa ?? 0,
                'futon' => $room->futon ?? 0
            ];
        }

        $amenities = $action->getAmenitiesByContext('apartment');
        $languages = $action->getLanguages();

        // Log::info('showMultipleApartmentForm2 returning', [
        //     'property_id' => $propertyId,
        //     'amenities_count' => $amenities->count(),
        //     'languages_count' => $languages->count(),
        //     'existing_amenities_count' => count($existingAmenities),
        //     'existing_photos_count' => count($existingPhotos),
        //     'saved_rooms_count' => $savedRooms->count(),
        //     'room_display_data' => $roomDisplayData,
        //     'room_display_keys' => array_keys($roomDisplayData)
        // ]);

        return view('partner.partner-multiple-apartment-2', compact('amenities', 'languages', 'propertyId', 'propertyData', 'roomDisplayData', 'rooms'));
    }

    public function saveStep1Data(Request $request, Property $property)
    {
        // Log::info('saveStep1Data called', [
        //     'property_id' => $property->id,
        //     'request_data' => $request->all()
        // ]);

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
            // Log::error('Error saving step 1 data', [
            //     'error' => $e->getMessage(),
            //     'property_id' => $property->id
            // ]);

            return response()->json([
                'success' => false,
                'message' => 'Error saving step 1 data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showMultipleApartmentForm3(PropertyAction $action)
    {
        // Log::info('showMultipleApartmentForm3 called');

        // Redirect to dashboard or show a simple success message
        return redirect()->route('partner.multiple.apartment.initial')
            ->with('success', 'Property listing completed successfully!');
    }





    /**
     * Save selected languages for a property
     */
    public function saveLanguages(Request $request, Property $property, PropertyAction $propertyAction)
    {
        // Log::info('saveLanguages called', [
        //     'property_id' => $property->id,
        //     'request' => $request->all(),
        // ]);

        try {
            $dto = SaveLanguagesDTO::fromRequest($request);
            $propertyAction->saveLanguages($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Languages saved successfully.',
                'selected_languages' => $property->languages()->pluck('name')->toArray()
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saving languages', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);

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
        // Log::info('saveAdditionalDetails called', [
        //     'request' => $request->all(),
        // ]);

        try {
            $dto = SaveAdditionalDetailsDTO::fromRequest($request);
            $action->execute($dto);

            return response()->json([
                'success' => true,
                'message' => 'Additional details saved successfully.',
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saving additional details', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveAddressSame(Request $request, PropertyAction $propertyAction)
    {
        try {
            // Log::info('saveAddressSame called', ['request' => $request->all()]);

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
        // Log::info('saveHostProfile called', [
        //     'property_id' => $property->id,
        //     'request_data' => $request->all(),
        //     'request_method' => $request->method(),
        //     'content_type' => $request->header('Content-Type')
        // ]);

        try {
            // Merge property_id into request data since it comes from route parameter
            $requestData = $request->all();
            $requestData['property_id'] = $property->id;

            $dto = SaveHostProfileDTO::fromArray($requestData);
            $action->execute($dto, $property);

            return response()->json(['success' => true, 'message' => 'Host profile saved successfully']);
        } catch (\Exception $e) {
            // Log::error('Error saving host profile', [
            //     'error' => $e->getMessage(),
            //     'property_id' => $property->id,
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     'trace' => $e->getTraceAsString()
            // ]);
            return response()->json(['success' => false, 'message' => 'Error saving host profile: ' . $e->getMessage()], 500);
        }
    }

    public function checkBasicInfoCompletion(Property $property)
    {
        // Log::info('Checking basic info completion for property', ['property_id' => $property->id]);

        try {
            // Check if all required basic information fields are filled
            $hasTitle = !empty($property->title);
            $hasAddress = !empty($property->address) && !empty($property->city);
            $hasChannelManager = !empty($property->channel_manager);

            // Check if property details are saved
            $hasPropertyDetails = !empty($property->description) ||
                !empty($property->guests) ||
                !empty($property->bathrooms) ||
                !empty($property->apartment_size);

            $completed = $hasTitle && $hasAddress && $hasChannelManager && $hasPropertyDetails;

            // Log::info('Basic info completion check result', [
            //     'property_id' => $property->id,
            //     'hasTitle' => $hasTitle,
            //     'hasAddress' => $hasAddress,
            //     'hasChannelManager' => $hasChannelManager,
            //     'hasPropertyDetails' => $hasPropertyDetails,
            //     'completed' => $completed
            // ]);

            return response()->json([
                'completed' => $completed,
                'details' => [
                    'hasTitle' => $hasTitle,
                    'hasAddress' => $hasAddress,
                    'hasChannelManager' => $hasChannelManager,
                    'hasPropertyDetails' => $hasPropertyDetails
                ]
            ]);
        } catch (\Exception $e) {
            //Log::error('Error checking basic info completion', ['error' => $e->getMessage()]);

            return response()->json([
                'completed' => false,
                'error' => 'Failed to check completion status'
            ], 500);
        }
    }

    public function savePricing(Request $request, Property $property, SavePricingAction $action)
    {
        // Log::info('savePricing called', [
        //     'property_id' => $property->id,
        //     'request_data' => $request->all()
        // ]);
        try {
            // Merge property_id into request data since it comes from route parameter
            $requestData = $request->all();
            $requestData['property_id'] = $property->id;

            // Convert string values to proper types before creating DTO
            if (isset($requestData['price_per_night']) && $requestData['price_per_night'] !== null) {
                $requestData['price_per_night'] = (float) $requestData['price_per_night'];
            }
            if (isset($requestData['discount_percent'])) {
                $requestData['discount_percent'] = (int) $requestData['discount_percent'];
            }
            if (isset($requestData['discount_enabled'])) {
                $requestData['discount_enabled'] = (bool) $requestData['discount_enabled'];
            }
            if (isset($requestData['property_id'])) {
                $requestData['property_id'] = (int) $requestData['property_id'];
            }

            $dto = SavePricingDTO::fromArray($requestData);
            $action->execute($dto, $property);

            return response()->json(['success' => true, 'message' => 'Pricing saved successfully']);
        } catch (\Exception $e) {
            // Log::error('Error saving pricing', [
            //     'error' => $e->getMessage(),
            //     'property_id' => $property->id,
            //     'trace' => $e->getTraceAsString()
            // ]);
            return response()->json(['success' => false, 'message' => 'Error saving pricing: ' . $e->getMessage()], 500);
        }
    }

    public function saveRatePlans(Request $request, Property $property)
    {
        Log::info('saveRatePlans called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);

        try {
            // Save rate plans data to property_policies table
            // Only save the cancellation policy since that's the main field available
            $property->policies()->updateOrCreate([], [
                'property_id' => $property->id,
                'cancellation_policy' => $request->input('standard_rate.cancellation_policy', 'flexible'),
                // Store rate plans data as JSON in a custom field or use existing fields
                'check_in_from' => json_encode([
                    'standard_rate' => $request->input('standard_rate'),
                    'non_refundable_rate' => $request->input('non_refundable_rate'),
                    'weekly_rate' => $request->input('weekly_rate')
                ])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rate plans saved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving rate plans: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving rate plans: ' . $e->getMessage()
            ], 500);
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
        $subtypeId = $request->input('subtypeId') || Property::where('id', $propertyId)->first()->subtype_id;
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        return view('partner.partner-homes-single', compact('propertyId', 'subtypeId', 'amenities', 'languages'));
    }

    public function showPrivateHomesMultiple(Request $request, PropertyAction $action)
    {
        $propertyId = $request->input('propertyId');
        $subtypeId = Property::where('id', $propertyId)->first()->subtype_id;
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        return view('partner.partner-homes-multiple', compact('propertyId', 'subtypeId', 'amenities', 'languages'));
    }

    public function completeHomesRegistration($propertyId, PropertyAction $action)
    {
        $property = Property::findOrFail($propertyId);
        $accommodation_type = Accommodation::where('property_id', $propertyId)->first()->ownership_type;

        if (!$accommodation_type) {
            return redirect()->back()->with('error', 'Accommodation type not found for this property.');
        }
        return view('partner.partner-homes-complete-registration', compact('propertyId', 'accommodation_type'));
    }

    public function saveServices(Request $request, Property $property, PropertyAction $propertyAction)
    {
        // Log::info('saveServices called', [
        //     'property_id' => $property->id,
        //     'request' => $request->all(),
        //     'request_method' => $request->method(),
        //     'content_type' => $request->header('Content-Type'),
        //     'url' => $request->url(),
        // ]);

        try {
            $dto = SaveServicesDTO::fromRequest($request);
            // Log::info('DTO created successfully', [
            //     'dto_data' => $dto->toArray()
            // ]);

            $propertyAction->saveServices($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Services saved successfully.',
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saving services', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveHouseRules(Request $request, Property $property, PropertyAction $propertyAction)
    {
        // Log::info('saveHouseRules called', [
        //     'property_id' => $property->id,
        //     'request' => $request->all(),
        //     'request_method' => $request->method(),
        //     'content_type' => $request->header('Content-Type'),
        //     'url' => $request->url(),
        // ]);

        try {
            // Log the raw request data
            // Log::info('Raw request data', [
            //     'all' => $request->all(),
            //     'json' => $request->json()->all(),
            //     'input' => $request->input(),
            // ]);

            $dto = SaveHouseRulesDTO::fromRequest($request);
            // Log::info('DTO created successfully', [
            //     'dto_data' => $dto->toArray()
            // ]);

            $propertyAction->saveHouseRules($property, $dto);

            return response()->json([
                'success' => true,
                'message' => 'House rules saved successfully.',
            ]);
        } catch (\Exception $e) {
            // Log::error('Error saving house rules', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            // ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveAvailabilitySettings(Request $request, Property $property, PropertyAction $propertyAction)
    {
        // Log::info('saveAvailabilitySettings called', [
        //     'property_id' => $property->id,
        //     'request' => $request->all(),
        // ]);

        try {
            $dto = SaveAvailabilitySettingsDTO::fromRequest($request);
            $propertyAction->saveAvailabilitySettings($property, $dto);
            return response()->json(['success' => true, 'message' => 'Availability settings saved successfully']);
        } catch (\Exception $e) {
            // Log::error('Error saving availability settings', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
            return response()->json(['success' => false, 'message' => 'Error saving availability settings: ' . $e->getMessage()], 500);
        }
    }

    public function showPrivateHomesRooms($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $roomTypes = RoomType::all();
        $bedTypes = BedType::all();
        $amenities = Amenity::all();
        $groupedAmenities = $amenities->groupBy('category');

        if ($property->category_id == 1) {
            return view('partner.partner-homes-rooms', compact('property', 'roomTypes', 'bedTypes', 'groupedAmenities'));
        }
        return view('partner.partner-hotels-rooms', compact('property', 'roomTypes', 'bedTypes', 'groupedAmenities'));
    }

    public function showPrivateHomesImages($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        if ($property->category_id == 1) {
            return view('partner.partner-homes-images', compact('property'));
        }
        return view('partner.partner-hotels-photos', compact('property'));
    }

    public function showPrivateHomesPayments($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        if ($property->category_id == 1) {
            // Homes - use the homes payments view
            return view('partner.partner-homes-payments', compact('property'));
        } else {
            // Hotels - use the hotels payment view
            return view('partner.partner-hotels-payment', compact('property'));
        }
    }

    public function showPaymentPage($property = null)
    {
        Log::info('showPaymentPage called', [
            'property_parameter' => $property,
            'request_url' => request()->url(),
            'request_path' => request()->path()
        ]);

        $propertyModel = null;
        if ($property) {
            $propertyModel = Property::findOrFail($property);
            \Log::info('Property found', ['property_id' => $propertyModel->id]);
        } else {
            \Log::info('No property parameter provided');
        }

        return view('partner.partner-hotels-payment', compact('propertyModel'));
    }

    public function showPrivateHomesEdit($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $rooms = Room::where('property_id', $propertyId)->get()->groupBy('room_type_id');
        if ($property->category_id == 1) {
            return view('partner.partner-homes-edit', compact('property', 'rooms'));
        }
        return view('partner.partner-hotels-edit', compact('property', 'rooms'));
    }

    public function getPropertyCategory($propertyId)
    {
        try {
            $property = Property::findOrFail($propertyId);
            return response()->json([
                'category_id' => $property->category_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Property not found'
            ], 404);
        }
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

    public function savePaymentStep(Request $request, $propertyId)
    {
        try {
            $property = Property::findOrFail($propertyId);

            $data = $request->validate([
                'payment_method' => 'required|in:online,credit',
            ]);

            $property->payment_method = $data['payment_method'];
            $property->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment method saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving payment method.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function saveVerification(Request $request, $propertyId)
    // {
    //     try {
    //         $data = $request->validate([
    //             'ownership_type' => 'required|in:individual,business',
    //             'owners' => 'required|array',
    //             'owners.*.firstName' => 'required|string|max:255',
    //             'owners.*.lastName' => 'required|string|max:255',
    //             'owners.*.dob' => 'required|date',
    //             'legal_company_name' => 'nullable|string|max:255',
    //         ]);

    //         // Save main accommodation record
    //         $accommodation = Accommodation::updateOrCreate(
    //             ['property_id' => $propertyId],
    //             ['ownership_type' => $data['ownership_type']]
    //         );

    //         // Clear existing related records
    //         $accommodation->individuals()->delete();
    //         $accommodation->businessEntities()->delete();

    //         if ($data['ownership_type'] === 'individual') {
    //             foreach ($data['owners'] as $owner) {
    //                 $accommodation->individuals()->create([
    //                     'first_name' => $owner['firstName'],
    //                     'last_name' => $owner['lastName'],
    //                     'date_of_birth' => $owner['dob'],
    //                 ]);
    //             }
    //         } elseif ($data['ownership_type'] === 'business') {
    //             $accommodation->businessEntities()->create([
    //                 'business_name' => $data['legal_company_name'],
    //                 'trading_name' => $data['legal_company_name'], // adjust if needed
    //                 'address' => $request->input('address', ''),
    //                 'zip_code' => $request->input('zip_code', ''),
    //                 'city' => $request->input('city', ''),
    //                 'country' => $request->input('country', ''),
    //             ]);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Accommodation verification data saved successfully.',
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Error saving accommodation verification data.', [
    //             'error' => $e->getMessage(),
    //             'property_id' => $propertyId,
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error saving accommodation verification data.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function saveVerification(Request $request, StoreAccommodationDetailsAction $action)
    {
        // Validate and map request to DTO
        $dto = AccommodationDetailsDTO::fromRequest($request);

        // Save using the action
        $accommodation = $action->execute($dto);

        return response()->json([
            'success' => true,
            'accommodation_id' => $accommodation->id,
        ]);
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

    public function showFinalStep($propertyId = null)
    {
        Log::info('showFinalStep called', ['property_id' => $propertyId]);

        $property = null;
        $propertyData = [];
        $roomDisplayData = [];

        if ($propertyId) {
            try {
                $property = Property::findOrFail($propertyId);

                // Get additional details for guests and bathrooms
                $additionalDetails = $property->additionalDetails;

                // Get property data
                $propertyData = [
                    'name' => $property->title ?? 'Property Name',
                    'address' => $property->address ?? 'Address not set',
                    'guests_capacity' => $additionalDetails->guests_capacity ?? 0,
                    'bathrooms_count' => $additionalDetails->bathrooms_count ?? 0,
                    'photos' => $property->files()->where('file_type', 'image')->pluck('path')->toArray(),
                ];

                // Get room data (bedrooms, living room, other spaces)
                $bedrooms = $property->bedrooms()->get();
                $roomDisplayData = [];

                foreach ($bedrooms as $bedroom) {
                    $roomType = $bedroom->room_type;
                    $bedSummary = [];
                    $totalBeds = 0;

                    // Use correct field names from PropertyBedroom model
                    if ($bedroom->twin > 0) {
                        $bedSummary[] = $bedroom->twin . ' Twin';
                        $totalBeds += $bedroom->twin;
                    }
                    if ($bedroom->full > 0) {
                        $bedSummary[] = $bedroom->full . ' Full';
                        $totalBeds += $bedroom->full;
                    }
                    if ($bedroom->queen > 0) {
                        $bedSummary[] = $bedroom->queen . ' Queen';
                        $totalBeds += $bedroom->queen;
                    }
                    if ($bedroom->king > 0) {
                        $bedSummary[] = $bedroom->king . ' King';
                        $totalBeds += $bedroom->king;
                    }
                    if ($bedroom->sofa > 0) {
                        $bedSummary[] = $bedroom->sofa . ' Sofa';
                        $totalBeds += $bedroom->sofa;
                    }
                    if ($bedroom->bunk > 0) {
                        $bedSummary[] = $bedroom->bunk . ' Bunk';
                        $totalBeds += $bedroom->bunk;
                    }
                    if ($bedroom->futon > 0) {
                        $bedSummary[] = $bedroom->futon . ' Futon';
                        $totalBeds += $bedroom->futon;
                    }

                    $roomDisplayData[$roomType] = [
                        'has_beds' => !empty($bedSummary),
                        'bed_summary' => implode(', ', $bedSummary),
                        'total_beds' => $totalBeds
                    ];
                }

                // Log::info('Property data for final step', [
                //     'property_id' => $propertyId,
                //     'property_data' => $propertyData,
                //     'room_display_data' => $roomDisplayData,
                //     'bedrooms_count' => $bedrooms->count()
                // ]);

            } catch (\Exception $e) {
                // Log::error('Error loading property for final step', [
                //     'property_id' => $propertyId,
                //     'error' => $e->getMessage(),
                //     'trace' => $e->getTraceAsString()
                // ]);
            }
        }

        return view('partner.partner-apartment-final-step', compact('property', 'propertyData', 'roomDisplayData'));
    }

    public function completePaymentProcess(Request $request, $propertyId)
    {
        try {
            $property = Property::findOrFail($propertyId);

            // Update property status to completed
            $property->update([
                'status' => 'completed'
            ]);

            // You can add additional logic here like:
            // - Sending confirmation emails
            // - Creating notifications
            // - Logging the completion

            return response()->json([
                'success' => true,
                'message' => 'Payment process completed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error completing payment process: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveAccommodationVerification(Request $request, $propertyId)
    {
        try {
            $data = $request->validate([
                'ownership_type' => 'required|in:individual,business',
                'owners' => 'required|array',
                'owners.*.firstName' => 'required|string|max:255',
                'owners.*.lastName' => 'required|string|max:255',
                'owners.*.dob' => 'required|date',
                'legal_company_name' => 'nullable|string|max:255',
            ]);

            // Save main accommodation record
            $accommodation = Accommodation::updateOrCreate(
                ['property_id' => $propertyId],
                ['ownership_type' => $data['ownership_type']]
            );

            // Clear existing related records
            $accommodation->individuals()->delete();
            $accommodation->businessEntities()->delete();

            if ($data['ownership_type'] === 'individual') {
                foreach ($data['owners'] as $owner) {
                    $accommodation->individuals()->create([
                        'first_name' => $owner['firstName'],
                        'last_name' => $owner['lastName'],
                        'date_of_birth' => $owner['dob'],
                    ]);
                }
            } elseif ($data['ownership_type'] === 'business') {
                $accommodation->businessEntities()->create([
                    'business_name' => $data['legal_company_name'],
                    'trading_name' => $data['legal_company_name'], // adjust if needed
                    'address' => $request->input('address', ''),
                    'zip_code' => $request->input('zip_code', ''),
                    'city' => $request->input('city', ''),
                    'country' => $request->input('country', ''),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Accommodation verification data saved successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving accommodation verification data.', [
                'error' => $e->getMessage(),
                'property_id' => $propertyId,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error saving accommodation verification data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveCancelPolicy(Request $request, $propertyId)
    {
        $data = $request->validate([
            'free_cancellation_days' => 'required|integer|in:1,5,14,30',
            'protection_enabled' => 'required|boolean',
        ]);
        \App\Models\CancellationPolicy::updateOrCreate(
            ['property_id' => $propertyId],
            $data
        );
        return redirect()->back()->with('success', 'Cancellation policy saved!');
    }
}
