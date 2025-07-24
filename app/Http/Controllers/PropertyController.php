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
use App\DTOs\Partner\SaveAmenitiesDTO;
use App\DTOs\Partner\SavePolicyDTO;
use App\DTOs\Partner\UploadPropertyPhotosDTO;
use App\Models\Room;
use App\Models\PartnerVerification;
use App\Models\Language;

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
        Log::info('Fetching subcategories for category ID: ' . $categoryId, ['subcategories' => $subcategories]);
        Log::info('Available amenities', ['amenities' => $amenities]);
        Log::info('Available room types', ['roomTypes' => $roomTypes]);
        Log::info('Available bed types', ['bedTypes' => $bedTypes]);

        switch ($categoryId) {
            case 1:  // Homes
                if ($subcategories->isEmpty()) {
                    return redirect()->back()->withErrors(['error' => 'No subcategories found for this category.']);
                }
                return view('partner.partner-homes-create-form-1', compact('subcategories', 'categoryId', 'amenities', 'roomTypes', 'bedTypes'));

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
                return view('partner.partner-apartment-create-form-1');
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
        Log::info('saveAmenities called', [
            'property_id' => $property->id,
            'request' => $request->all(),
        ]);
        $dto = SaveAmenitiesDTO::fromRequest($request);

        $propertyAction->saveAmenities($property, $dto);

        return response()->json(['success' => true]);
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

    public function saveRooms(Request $request)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'rooms' => 'required|array|min:1',
                'rooms.*.room_type_id' => 'required|exists:room_types,id',
                'rooms.*.name' => 'nullable|string',
                'rooms.*.price_per_night' => 'nullable|numeric',
                'rooms.*.max_guests' => 'nullable|integer',
                'rooms.*.bathroom_count' => 'nullable|integer',
                'rooms.*.size_sq_m' => 'nullable|numeric',
                'rooms.*.beds' => 'nullable|array',
            ]);

            Log::info('Validated room data', $validated);
            foreach ($validated['rooms'] as $roomData) {
                $room = Room::create([
                    'property_id' => $validated['property_id'],
                    'room_type_id' => $roomData['room_type_id'],
                    'name' => $roomData['name'],
                    'price_per_night' => $roomData['price_per_night'],
                    'max_guests' => $roomData['max_guests'],
                    'bathroom_count' => $roomData['bathroom_count'],
                    'size_sq_m' => $roomData['size_sq_m'],
                ]);

                if (!empty($roomData['beds'])) {
                    foreach ($roomData['beds'] as $bedTypeId => $count) {
                        if ((int)$count > 0) {
                            $room->beds()->attach($bedTypeId, ['count' => $count]);
                        }
                    }
                }
            }

            return response()->json(['success' => 'success']);
        } catch (\Exception  $e) {
            Log::error('Error saving rooms', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function storePartnerVerification(Request $request)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'type' => 'required|in:individual,business',
                'full_name' => 'nullable|string',
                'national_id' => 'nullable|string',
                'company_name' => 'nullable|string',
                'registration_number' => 'nullable|string',
            ]);

            PartnerVerification::updateOrCreate(
                ['property_id' => $validated['property_id']],
                $validated
            );

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

    public function saveBedroom(Request $request, Property $property)
    {
        $validated = $request->validate([
            'room_name' => 'required|string',
            'beds' => 'required|array',
            'beds.*.id' => 'required|exists:bed_types,id',
            'beds.*.count' => 'required|integer|min:0',
        ]);

        $room = $property->rooms()->updateOrCreate(
            ['name' => $validated['room_name']],
            ['room_type_id' => 1] // Assuming 'bedroom' type
        );

        $bedData = [];
        foreach ($validated['beds'] as $bed) {
            if ($bed['count'] > 0) {
                $bedData[$bed['id']] = ['count' => $bed['count']];
            }
        }

        $room->beds()->sync($bedData);

        return response()->json(['success' => true, 'message' => 'Bedroom saved successfully.']);
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
    public function saveLanguages(Request $request, Property $property)
    {
        Log::info('saveLanguages called', [
            'property_id' => $property->id,
            'request' => $request->all(),
        ]);

        try {
            $validated = $request->validate([
                'languages' => 'required|array',
                'languages.*' => 'exists:languages,id',
            ]);

            // Sync the languages with the property
            $property->languages()->sync($validated['languages']);

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
    public function saveAdditionalDetails(Request $request)
    {
        Log::info('saveAdditionalDetails called', [
            'request' => $request->all(),
        ]);

        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'languages' => 'nullable|array',
                'languages.*' => 'exists:languages,id',
            ]);

            $property = Property::findOrFail($validated['property_id']);

            // Save languages if provided
            if (!empty($validated['languages'])) {
                $property->languages()->sync($validated['languages']);
            }

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

    public function saveAddressSame(Request $request)
    {
        try {
            Log::info('saveAddressSame called', [
                'request' => $request->all(),
            ]);
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'count' => 'required|integer|min:1',
                'address' => 'required|string|max:255',
            ]);

            $existingProperty = Property::findOrFail($validated['property_id']);
            Property::findOrFail($validated['property_id'])->update([
                'address' => $validated['address'],
            ]);

            for ($i = 1; $i < $validated['count']; $i++) {
                Property::create([
                    'user_id' => Auth::id(),
                    'category_id' => $existingProperty->category_id,
                    'subcategory_id' => $existingProperty->subcategory_id,
                    'subtype_id' => $existingProperty->subtype_id,
                    'address' => $validated['address'],
                ]);
            }

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

    public function saveAddressMultiple(Request $request)
    {
        $validated = $request->validate([
            'first_property_id' => 'required|exists:properties,id',
            'addresses' => 'required|array',
        ]);

        $addresses = $validated['addresses'];

        Property::findOrFail($validated['first_property_id'])->update([
            'address' => $addresses[0]
        ]);

        for ($i = 1; $i < count($addresses); $i++) {
            Property::create([
                'address' => $addresses[$i],
                'category_id' => session('category_id'),
                'subcategory_id' => session('subcategory_id'),
                'apartment_type' => session('apartment_type'),
                // other required fields...
            ]);
        }

        return response()->json(['message' => 'Multiple addresses saved']);
    }

    public function saveHostProfile(Request $request, Property $property)
    {
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'about_property' => 'nullable|string|max:1000',
                'about_host' => 'nullable|string|max:1000',
                'about_neighborhood' => 'nullable|string|max:1000',
                'show_property' => 'boolean',
                'show_host' => 'boolean',
                'show_neighborhood' => 'boolean',
                'none_selected' => 'boolean',
                'host_name' => 'nullable|string|max:255'
            ]);

            $property->hostProfile()->updateOrCreate(
                ['property_id' => $property->id],
                $validated
            );

            Log::info('Host profile saved successfully', ['property_id' => $property->id, 'data' => $validated]);

            return response()->json(['success' => true, 'message' => 'Host profile saved successfully']);
        } catch (\Exception $e) {
            Log::error('Error saving host profile', ['error' => $e->getMessage(), 'property_id' => $property->id]);
            return response()->json(['success' => false, 'message' => 'Error saving host profile: ' . $e->getMessage()], 500);
        }
    }

    public function savePricing(Request $request, Property $property)
    {
        Log::info('savePricing called', [
            'property_id' => $property->id,
            'request_data' => $request->all()
        ]);
        try {
            $validated = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'booking_type' => 'required|in:instant,request',
                'price_per_night' => 'nullable|numeric|min:0',
                'currency' => 'required|in:usd,eur,gbp',
                'discount_enabled' => 'boolean',
                'discount_percent' => 'nullable|integer|min:0|max:100'
            ]);
            Log::info('savePricing validated data', [
                'property_id' => $property->id,
                'validated' => $validated
            ]);
            Log::info('Before updateOrCreate', [
                'property_id' => $property->id
            ]);
            $property->pricing()->updateOrCreate(
                ['property_id' => $property->id],
                $validated
            );
            Log::info('After updateOrCreate', [
                'property_id' => $property->id
            ]);
            Log::info('Pricing saved successfully', ['property_id' => $property->id, 'data' => $validated]);
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
}
