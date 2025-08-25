<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Taxi;
use App\Models\TaxiType;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'license_number' => 'required|string|unique:drivers,license_number',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Log::info('Validated Data: ', $validated);
        $driver = Driver::create([
            'name' => $validated['name'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'] ?? null,
            'license_number' => $validated['license_number'],
            'photo' => null,
        ]);

        if ($request->hasFile('photo')) {
            $fileService = app()->make(FileUploadService::class);

            $file = $fileService->uploadAndSave(
                $request->file('photo'),
                'driver_photo',
                'driver',
                null
            );

            if ($file) {
                $driver->update([
                    'photo' => $file->id,
                ]);
            }
        }

        DB::table('taxi_driver')->insert([
            'taxi_id' => $validated['taxi_id'],
            'driver_id' => $driver->id,
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'driver_id' => $driver->id,
        ]);
    }

     public function storeStep4(Request $request){
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'pricing_type' => 'required|string|in:perKm,perDay',
            'base_fare' => 'required|numeric|min:0',
            'price_per_km' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
        ]);

        $taxi = Taxi::findOrFail($validated['taxi_id']);
        $fareData = [
            'taxi_id' => $taxi->id,
            'pricing_type' => $validated['pricing_type'],
            'base_fare' => $validated['base_fare'],
        ];

        if ($validated['pricing_type'] === 'perKm') {
            $fareData['price'] = $validated['price_per_km'];
        } elseif ($validated['pricing_type'] === 'perDay') {
            $fareData['price'] = $validated['price_per_day'];
        }

        $taxi->fare()->updateOrCreate([], $fareData);

        return response()->json([
            'success' => true,
            'fare_id' => $taxi->fare->id,
            'message' => 'Taxi fare settings saved successfully.'
        ]);
     }
}
