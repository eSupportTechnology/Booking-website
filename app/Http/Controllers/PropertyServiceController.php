<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyService;

class PropertyServiceController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $data = $request->validate([
            'serve_breakfast' => 'nullable|boolean',
            'breakfast_included' => 'nullable|string',
            'breakfast_type' => 'nullable|array',
            'parking_available' => 'nullable|string',
            'parking_cost' => 'nullable|numeric',
            'parking_cost_unit' => 'nullable|string',
            'parking_reservation' => 'nullable|string',
            'parking_location' => 'nullable|string',
            'parking_type' => 'nullable|string',
        ]);

        $property->services()->updateOrCreate(
            ['property_id' => $property->id],
            $data
        );

        return response()->json(['success' => true, 'message' => 'Services saved successfully.']);
    }
}
