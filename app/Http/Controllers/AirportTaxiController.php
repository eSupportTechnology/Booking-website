<?php

namespace App\Http\Controllers;

use App\Models\Taxi;
use App\Models\TaxiType;
use Illuminate\Http\Request;

class AirportTaxiController extends Controller
{
    public function index()
    {
        $taxti_types = TaxiType::all();
        return view('airport_taxis.airport-taxi-register', compact('taxti_types'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'taxi_type' => 'required|string'
        ]);

        // Map category string to taxi_type_id (from seeded DB)
        $map = [
            'standard' => 1,
            'peopleCarrier' => 2,
            'largePeopleCarrier' => 3,
            'minibus' => 4,
            'executive' => 5,
            'luxury' => 6,
        ];

        if (!isset($map[$validated['taxi_type']])) {
            return response()->json(['success' => false, 'message' => 'Invalid taxi type selected'], 422);
        }

        $taxi = Taxi::create([
            'taxi_type_id' => $map[$validated['taxi_type']],
            'number_plate' => null, // to be filled in later steps
        ]);

        return response()->json([
            'success' => true,
            'taxi_id' => $taxi->id
        ]);
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'number_plate' => 'required|string|unique:taxis,number_plate,' . $request->taxi_id,
            'color' => 'required|string',
            'passenger_capacity' => 'required|integer|min:1|max:50',
            'luggage_capacity' => 'nullable|integer|min:0|max:20',
        ]);

        $taxi = Taxi::findOrFail($validated['taxi_id']);
        $taxi->update([
            'number_plate' => $validated['number_plate'],
            'color' => $validated['color'],
            'passenger_capacity' => $validated['passenger_capacity'],
            'luggage_capacity' => $validated['luggage_capacity'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'taxi_id' => $taxi->id,
        ]);
    }
}
