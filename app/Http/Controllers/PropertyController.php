<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Actions\Partner\PropertyAction;
use App\DTOs\Partner\PropertyDTO;
use Illuminate\Support\Facades\Log;
use App\DTOs\Partner\PropertyStep1DTO;
use App\DTOs\Partner\PropertyStep2DTO;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyCategory;
use App\DTOs\Partner\PropertyAdditionalDetailsDTO;
use App\Actions\Partner\UpdatePropertyAdditionalDetailsAction;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = $request->input('partner_id');
        // Check if partner_id is present in the request
        \Log::info('Partner ID from request: ' . $partnerId);
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
        Log::info('Fetching subcategories for category ID: ' . $categoryId, ['subcategories' => $subcategories]);   
        // Check if subcategories are empty
        if ($subcategories->isEmpty()) {
            Log::warning('No subcategories found for category ID ' . $categoryId);
            return redirect()->back()->withErrors(['error' => 'No subcategories found for this category.']);
        }
        switch ($categoryId) {
            case 1:  // Homes
                return view('partner.partner-homes-create-form-1', compact('subcategories', 'categoryId'));
            case 2:  // Apartment
                return view('partner.partner-apartment-create-form-1', [
                    'subcategories' => $subcategories,
                    'category' => 'apartment',
                ]);
            case 3:  // Hotel
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
            $dto->user_id = auth()->id();
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
        return view('partner.partner-apartment-create-form-2', [
            'property' => $property,
            'category' => $categoryString,
        ]);
    }

    public function storeStep2(Request $request,  $propertyId, PropertyAction $action)
    {
        Log::info('storeStep2 called - DEBUG');
        // die('storeStep2 called');
        Log::info('storeStep2 called', [
            'request' => $request->all(),
            'session' => session()->all(),
            'user_id' => auth()->id(),
        ]);
        try {
            Log::info('Fetching property for update', ['property_id' => $request->input('property_id', $propertyId)]);
            $property = Property::findOrFail($request->input('property_id', $propertyId));

            Log::info('Loaded property for update', ['property' => $property->toArray()]);
            $dto = PropertyStep2DTO::fromRequest($request);
            Log::info('DTO created from request', ['dto' => $dto->toArray()]);
            $updatedProperty = $action->updatePropertyStep2($property, $dto);
            Log::info('Property after update', ['property' => $updatedProperty->toArray()]);

            return response()->json([
                'success' => true,
                'message' => 'Step 2 data saved successfully',
                'property_id' => $property->id,
            ]);
        } catch (\Exception $e) {
            Log::error('storeStep2 exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
        \Log::info('updatePartial called', ['request' => $request->all(), 'property_id' => $property->id]);
        try {
            $bedrooms = $request->has('bedrooms') && is_array($request->bedrooms) ? $request->bedrooms : null;
            $updatedProperty = $action->updatePropertyPartial($property, $request->all(), $bedrooms);
            \Log::info('Property after update', $updatedProperty->toArray());
            return response()->json(['success' => true, 'property' => $updatedProperty]);
        } catch (\Exception $e) {
            \Log::error('updatePartial exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadPhotos(Request $request)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'photos.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
    ]);

    foreach ($request->file('photos') as $photo) {
        $path = $photo->store('property_photos', 'public');

        DB::table('property_photos')->insert([
            'property_id' => $request->property_id,
            'photo_url' => $path,
            'is_cover' => false, // Or true for the first one, optionally
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json(['success' => true]);
}


    public function updateAdditionalDetails(
        Request $request,
        Property $property,
        UpdatePropertyAdditionalDetailsAction $action
    ) {
        $dto = PropertyAdditionalDetailsDTO::fromRequest($request);

        $action->execute($property, $dto);

        return response()->json(['success' => true]);
    }
}
