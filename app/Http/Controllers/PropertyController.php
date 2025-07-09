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
        // dd($properties);
        return view('frontend.partner-property-types', compact('properties'));
    }

    public function subcategories($categoryId, PropertyAction $action)
    {
        $subcategories = $action->getPropertiesByCategory($categoryId);
        Log::info('Subcategories fetched for category ID ' . $categoryId, ['subcategories' => $subcategories]);
        return view('partner.partner-homes-create-form-1', compact('subcategories'));
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

    public function apartmentSubcategories()
    {
        $apartmentCategory = \App\Models\PropertyCategory::where('name', 'Apartment')->first();
        $subcategories = $apartmentCategory ? $apartmentCategory->subcategories : collect();
        return view('partner.partner-apartment-create-form-1', compact('subcategories', 'apartmentCategory'));
    }

    public function storeApartment(Request $request, PropertyAction $action)
    {
        Log::info('Property form submission:', $request->all());
        $propertyDTO = PropertyDTO::fromRequest($request);
        $property = $action->registerProperty($propertyDTO);
        return redirect()->route('partner.property.apartment.1')->with('success', 'Apartment property created successfully.');
    }

    public function storeStep1(Request $request, PropertyAction $action)
    {
        Log::info('storeStep1 called', [
            'request' => $request->all(),
            'session' => session()->all(),
            'user_id' => auth()?->id(),
        ]);
        try {
            $dto = PropertyStep1DTO::fromRequest($request);
            $dto->user_id = auth()?->id();
            $property = $action->createPropertyStep1($dto);
            session(['property_id' => $property->id]);
            Log::info('storeStep1 success', [
                'property_id' => $property->id,
                'redirect_to' => route('partner.property.apartment.step2', $property->id),
            ]);
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

    public function showStep2($propertyId, PropertyAction $action)
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
        return redirect()->route('partner.property.apartment.3', $property->id);
    }
}