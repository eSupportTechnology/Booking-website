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
use App\Models\Room;
use App\Models\PartnerVerification;
use App\Models\Language;
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
        $dto = PropertyAdditionalDetailsDTO::fromRequest($request);

        $action->execute($property, $dto);

        return response()->json(['success' => true, 'message' => 'Amenities saved successfully.']);
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


    public function saveAmenities(Request $request, Property $property, PropertyAction $propertyAction)
    {
        try {
            Log::info('saveAmenities called', [
                'property_id' => $property->id,
                'request' => $request->all(),
            ]);


            try {
                $dto = SaveAmenitiesDTO::fromRequest($request);
                Log::info('SaveAmenitiesDTO created:', ['amenities' => $dto->amenities]);
                Log::info('saveAmenities validated', $dto->toArray());
                Log::info('SaveAmenitiesDTO created:', ['amenities' => $dto->amenities]);

                $propertyAction->saveAmenities($property, $dto);

                return response()->json(['success' => true, 'message' => 'Amenities saved successfully']);
            } catch (\Exception $e) {
                Log::error('Error saving amenities:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error('saveAmenities error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
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
        try {
            $dto = SaveBedroomDTO::fromRequest($request);
            $action->execute($dto, $property);

            return response()->json(['success' => true, 'message' => 'Bedroom saved successfully.']);
        } catch (\Exception $e) {
            Log::error('Error saving bedroom', [
                'error' => $e->getMessage(),
                'property_id' => $property->id,
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
        } else {
            $property = null;
        }

        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        Log::info('showMultipleApartmentForm returning', [
            'property_id' => $property ? $property->id : null,
            'amenities_count' => $amenities->count(),
            'amenities' => $amenities->toArray(),
            'languages_count' => $languages->count(),
            'languages' => $languages->toArray()
        ]);

        return view('partner.partner-multiple-apartment', compact('property', 'amenities', 'languages'));
    }

    /**
     * Get all available languages for the dropdown
     */
    public function getLanguages()
    {
        $languages = Language::orderBy('name')->get();
        return response()->json($languages);
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
        $subtypeId = $request->input('subtypeId');
        $amenities = $action->getAmenities();
        $languages = $action->getLanguages();

        return view('partner.partner-homes-single', compact('propertyId', 'subtypeId', 'amenities', 'languages'));
    }

    public function showPrivateHomesMultiple(Request $request)
    {
        $propertyId = $request->input('propertyId');
        $subtypeId = $request->input('subtypeId');

        return view('partner.partner-homes-multiple', compact('propertyId', 'subtypeId'));
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
        return view('partner.partner-homes-rooms', compact('property'));
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
}
