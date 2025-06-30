<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Actions\Partner\PropertyAction;
use App\DTOs\Partner\PropertyDTO;
use Illuminate\Support\Facades\Log;

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
}
