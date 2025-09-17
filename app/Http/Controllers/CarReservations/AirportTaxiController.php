<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Taxi;
use App\Models\TaxiType;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AirportTaxiController extends Controller
{
    public function index()
    {
        $taxi_types = TaxiType::all();
        return view('airport_taxis.airport-taxi-register', compact('taxi_types'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'taxi_type' => 'required|string'
        ]);

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
            'car_renter_id' => Auth::guard('car_renter')->id(),
            'taxi_type_id' => $map[$validated['taxi_type']],
            'number_plate' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Taxi type saved successfully',
            'taxi_id' => $taxi->id
        ]);
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'number_plate' => 'required|string|unique:taxis,number_plate,' . $request->taxi_id,
            'color' => 'required|string',
            'passenger_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'nullable|integer|min:0',
        ]);

        $taxi = Taxi::where('id', $validated['taxi_id'])
            ->where('car_renter_id', Auth::guard('car_renter')->id())
            ->firstOrFail();

        $taxi->update([
            'number_plate' => $validated['number_plate'],
            'color' => $validated['color'],
            'passenger_capacity' => $validated['passenger_capacity'],
            'luggage_capacity' => $validated['luggage_capacity'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Taxi info saved successfully',
            'taxi_id' => $taxi->id
        ]);
    }

  public function storeStep3(Request $request)
{
    $validated = $request->validate([
        'taxi_id' => 'required|exists:taxis,id',
        'name' => 'required|string',
        'contact_number' => 'required|string',
        'email' => 'nullable|email',
        'license_number' => 'required|string|unique:drivers,license_number',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'driver_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'driver_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'tourism_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'tourism_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
    ]);

    $taxi = Taxi::where('id', $validated['taxi_id'])
        ->where('car_renter_id', Auth::guard('car_renter')->id())
        ->firstOrFail();

    $driver = Driver::create([
        'taxi_id' => $taxi->id,
        'name' => $validated['name'],
        'contact_number' => $validated['contact_number'],
        'email' => $validated['email'] ?? null,
        'license_number' => $validated['license_number'],
        'photo' => null,
    ]);

    $fileService = app(FileUploadService::class);

    // Driver photo
    if ($request->hasFile('photo')) {
        $file = $fileService->uploadAndSave($request->file('photo'), 'driver_photo', 'driver', null);
        if ($file) $driver->update(['photo' => $file->id]);
    }

    // Driver license images
    foreach (['driver_license_front', 'driver_license_back', 'tourism_license_front', 'tourism_license_back'] as $field) {
        if ($request->hasFile($field)) {
            $file = $fileService->uploadAndSave($request->file($field), $field, 'driver', null);
            if ($file) $driver->update([$field => $file->id]);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Driver saved successfully',
        'driver_id' => $driver->id
    ]);
}


    public function storeStep4(Request $request)
    {
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'pricing_type' => 'required|string|in:perKm,perDay',
            'base_fare' => 'required|numeric|min:0',
            'price_per_km' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
        ]);

        $taxi = Taxi::where('id', $validated['taxi_id'])
            ->where('car_renter_id', Auth::guard('car_renter')->id())
            ->firstOrFail();

        $fareData = [
            'taxi_id' => $taxi->id,
            'pricing_type' => $validated['pricing_type'],
            'base_fare' => $validated['base_fare'],
            'price' => $validated['pricing_type'] === 'perKm' ? $validated['price_per_km'] : $validated['price_per_day']
        ];

        $fare = $taxi->fare()->updateOrCreate([], $fareData);

        return response()->json([
            'success' => true,
            'fare_id' => $fare->id,
            'message' => 'Taxi fare saved successfully.'
        ]);
    }

    public function storeStep5(Request $request)
    {
        $validated = $request->validate([
            'taxi_id' => 'required|exists:taxis,id',
            'front' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'back' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'inside' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $taxi = Taxi::where('id', $validated['taxi_id'])
            ->where('car_renter_id', Auth::guard('car_renter')->id())
            ->firstOrFail();

        $images = [];
        foreach (['front', 'back', 'inside'] as $side) {
            if ($request->hasFile($side)) {
                $images[$side] = $request->file($side)->store("taxis/{$taxi->id}", 'public');
            }
        }

        $taxi->update([
            'front_image' => $images['front'] ?? null,
            'back_image' => $images['back'] ?? null,
            'inside_image' => $images['inside'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Taxi images uploaded successfully',
            'taxi_id' => $taxi->id
        ]);
    }



  public function edit(Taxi $taxi)
{
    $taxi->load('drivers', 'fare', 'type');

    return view('airport_taxis.taxi_edit', [
        'taxi' => $taxi,
        'taxi_types' => TaxiType::all()
    ]);
}

public function update(Request $request, Taxi $taxi)
{
    // Ensure the taxi belongs to the logged-in car renter
    if ($taxi->car_renter_id !== Auth::guard('car_renter')->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Validate taxi general info
    $validatedTaxi = $request->validate([
        'taxi_type_id' => 'required|exists:taxi_types,id',
        'number_plate' => 'required|string|unique:taxis,number_plate,' . $taxi->id,
        'color' => 'required|string',
        'passenger_capacity' => 'required|integer|min:1',
        'luggage_capacity' => 'nullable|integer|min:0',
        'with_driver' => 'required|in:yes,no',
    ]);

    // Update taxi info
    $taxi->update([
        'taxi_type_id' => $validatedTaxi['taxi_type_id'],
        'number_plate' => $validatedTaxi['number_plate'],
        'color' => $validatedTaxi['color'],
        'passenger_capacity' => $validatedTaxi['passenger_capacity'],
        'luggage_capacity' => $validatedTaxi['luggage_capacity'] ?? null,
        'with_driver' => $validatedTaxi['with_driver'],
    ]);

    // Update driver if exists and taxi has driver
    if ($validatedTaxi['with_driver'] === 'yes') {
        $validatedDriver = $request->validate([
            'driver_name' => 'required|string',
            'driver_contact' => 'required|string',
            'driver_email' => 'nullable|email',
            'driver_license_number' => 'required|string|unique:drivers,license_number,' . ($taxi->driver?->id ?? '0'),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'driver_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'driver_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'tourism_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'tourism_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $driver = $taxi->driver ?? new Driver(['taxi_id' => $taxi->id]);

        $driver->fill([
            'name' => $validatedDriver['driver_name'],
            'contact_number' => $validatedDriver['driver_contact'],
            'email' => $validatedDriver['driver_email'] ?? null,
            'license_number' => $validatedDriver['driver_license_number'],
        ])->save();

        $fileService = app(FileUploadService::class);

        foreach (['photo', 'driver_license_front', 'driver_license_back', 'tourism_license_front', 'tourism_license_back'] as $field) {
            if ($request->hasFile($field)) {
                $file = $fileService->uploadAndSave($request->file($field), $field, 'driver', null);
                if ($file) $driver->update([$field => $file->id]);
            }
        }
    }

    // Update fare
    $validatedFare = $request->validate([
        'pricing_type' => 'required|string|in:perKm,perDay',
        'price_per_day' => 'nullable|numeric|min:0',
        'price_per_km' => 'nullable|numeric|min:0',
        'base_fare' => 'required|numeric|min:0',
    ]);

    $fareData = [
        'taxi_id' => $taxi->id,
        'pricing_type' => $validatedFare['pricing_type'],
        'base_fare' => $validatedFare['base_fare'],
        'price' => $validatedFare['pricing_type'] === 'perKm'
            ? $validatedFare['price_per_km'] ?? 0
            : $validatedFare['price_per_day'] ?? 0,
    ];

    $taxi->fare()->updateOrCreate([], $fareData);

    return redirect()->route('airport-taxis.edit', $taxi->id)
        ->with('success', 'Taxi updated successfully.');
}


}