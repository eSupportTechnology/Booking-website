<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Actions\Partner\PropertyAction;
use App\DTOs\Partner\PropertyDTO;
use Illuminate\Support\Facades\Log;
use App\DTOs\Partner\PropertyStep1DTO;
use App\DTOs\Partner\PropertyStep2DTO;

class PropertyController extends Controller
{
    public function categories(PropertyAction $action)
    {
        $properties = $action->execute();
        dd($properties);
        return response()->json($properties);
    }

    public function subcategories(  $categoryId , PropertyAction $action)
    {
        // $categoryId = $request->input('category_id');
        $subcategories = $action->getPropertiesByCategory($categoryId);
        Log::info('Subcategories fetched for category ID ' . $categoryId, ['subcategories' => $subcategories]);
        return view('partner.partner-homes-create-form-1', compact('subcategories'));
    }

    public function subtypes($subcategoryId, PropertyAction $action)
    {
        // $subcategoryId = $request->input('subcategory_id');
        $properties = $action->getPropertiesBySubcategory($subcategoryId);
        // dd($properties);
        return response()->json($properties);
    }

    public function register(Request $request, PropertyAction $action)
    {   
        Log::info('Registering property with request data: ', $request->all());
        $propertyDTO = PropertyDTO::fromRequest($request);
        $property = $action->registerProperty($propertyDTO);
        return response()->json($property, 201);
    }

    public function apartmentSubcategories()
    {
        $apartmentCategory = \App\Models\PropertyCategory::where('name', 'Apartment')->first();
        $subcategories = $apartmentCategory ? $apartmentCategory->subcategories : collect();
        return view('partner.partner-apartment-create-form-1', compact('subcategories', 'apartmentCategory'));
    }

    public function storeApartment(Request $request)
    {
        // Log all incoming request data
        Log::info('Property form submission:', $request->all());
    }

   public function storeStep1(Request $request, PropertyAction $action)
{
    Log::info('storeStep1 called', [
        'request' => $request->all(),
        'session' => session()->all(),
        'user_id' => auth()?->id(),
    ]);
    try {
        // Instantiate DTO 
        $dto = PropertyStep1DTO::fromRequest($request);
        // Set the user_id from the logged-in user
        $dto->user_id = auth()?->id();
        // Store in database
        $property = $action->createPropertyStep1($dto);
        // Store property ID in session for next steps 
        session(['property_id' => $property->id]);
        Log::info('storeStep1 success', [
            'property_id' => $property->id,
            'redirect_to' => route('partner.property.apartment.step2', $property->id),
        ]);
        // Redirect to step 2 with property ID
        return redirect()->route('partner.property.apartment.step2', $property->id)
            ->with('success', 'Step 1 data saved successfully');
    } catch (\Exception $e) {
        Log::error('storeStep1 exception', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return redirect()->back()->withErrors(['error' => 'Error saving data: ' . $e->getMessage()]);
    }
}

    public function showStep2($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('partner.partner-apartment-create-form-2', compact('property'));
    }

    public function storeStep2(Request $request, $propertyId, PropertyAction $action)
    {
        Log::info('storeStep2 called', [
            'request' => $request->all(),
            'session' => session()->all(),
            'user_id' => auth()?->id(),
        ]);
        $property = Property::findOrFail($propertyId);
        $dto = PropertyStep2DTO::fromRequest($request);
        $action->updatePropertyStep2($property, $dto);
        // Redirect to next step or show success
        return redirect()->route('partner.property.apartment.3', $property->id);
    }
}
