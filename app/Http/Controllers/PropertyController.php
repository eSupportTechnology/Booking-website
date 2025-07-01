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

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:property_categories,id',
            'subcategory_id' => 'required|exists:property_subcategories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'nullable|string|max:20',
            // Add other fields as needed
        ]);

        $property = \App\Models\Property::create($validated);

        // Log the created property
        Log::info('Property created:', $property->toArray());

        // Redirect to next step or show success
        return redirect()->route('partner.property.apartment.2')->with('success', 'Property created!');
    }

   public function storeStep1(Request $request, PropertyAction $action)
{
    try {
        // Validate using DTO rules
        $validated = $request->validate(\App\DTOs\Partner\PropertyStep1DTO::validationRules());

        // Set the user_id from the logged-in user
        $validated['user_id'] = \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::id() : null;

        // Create DTO from request
        $dto = PropertyStep1DTO::fromRequest(new \Illuminate\Http\Request($validated));
        
        // Store in database (assuming you have a Property model)
        $property = $action->createPropertyStep1($dto);
        
        // Store property ID in session for next steps (optional)
        session(['property_id' => $property->id]);
        
        // Redirect to step 2 with property ID
        return redirect()->route('partner.property.apartment.step2', $property->id)->with('success', 'Step 1 data saved successfully');
        
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Error saving data: ' . $e->getMessage()]);
    }
}

    public function showStep2($propertyId)
    {
        $property = \App\Models\Property::findOrFail($propertyId);
        return view('partner.partner-apartment-create-form-2', compact('property'));
    }

    public function storeStep2(Request $request, $propertyId, PropertyAction $action)
    {
        Log::info('storeStep2 - title:', ['title' => $request->input('title')]);
        Log::info('storeStep2 - address:', ['address' => $request->input('address')]);
        Log::info('storeStep2 - city:', ['city' => $request->input('city')]);
        Log::info('storeStep2 - country:', ['country' => $request->input('country')]);
        Log::info('storeStep2 - zipcode:', ['zipcode' => $request->input('zipcode')]);
        Log::info('storeStep2 - description:', ['description' => $request->input('description')]);
        $property = \App\Models\Property::findOrFail($propertyId);

        $dto = PropertyStep2DTO::fromRequest($request);

        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'nullable|string|max:20',
            'description' => 'required|string',
        ]);

        $action->updatePropertyStep2($property, $dto);

        // Redirect to next step or show success
        return redirect()->route('partner.property.apartment.3', $property->id);
    }
}
