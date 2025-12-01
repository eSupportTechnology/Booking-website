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
            'brand_model' => 'required|string|max:255',
            'number_plate' => 'required|string|unique:taxis,number_plate,' . $request->taxi_id,
            'color' => 'required|string',
            'passenger_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'nullable|integer|min:0',
            'nearest_city' => 'required|string|max:255',
        ]);

        $taxi = Taxi::where('id', $validated['taxi_id'])
            ->where('car_renter_id', Auth::guard('car_renter')->id())
            ->firstOrFail();

        $taxi->update([
            'brand_model' => $validated['brand_model'],
            'number_plate' => $validated['number_plate'],
            'color' => $validated['color'],
            'passenger_capacity' => $validated['passenger_capacity'],
            'luggage_capacity' => $validated['luggage_capacity'] ?? null,
            'nearest_city' => $validated['nearest_city'] ?? null,
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
        'price_per_km' => 'required_if:pricing_type,perKm|nullable|numeric|min:0',
        'price_per_day' => 'required_if:pricing_type,perDay|nullable|numeric|min:0',
        'airport_fee' => 'nullable|numeric|min:0',
        'luggage_fee' => 'nullable|numeric|min:0',
    ]);

    $taxi = Taxi::where('id', $validated['taxi_id'])
        ->where('car_renter_id', Auth::guard('car_renter')->id())
        ->firstOrFail();

    $fareData = [
        'taxi_id' => $taxi->id,
        'base_fare' => $validated['base_fare'],
        'price_per_km' => $validated['pricing_type'] === 'perKm' ? $validated['price_per_km'] : null,
        'price_per_day' => $validated['pricing_type'] === 'perDay' ? $validated['price_per_day'] : null,
        'airport_fee' => $validated['airport_fee'] ?? 0,
        'luggage_fee' => $validated['luggage_fee'] ?? 0,
    ];

    $fare = $taxi->fare()->updateOrCreate(
        ['taxi_id' => $taxi->id], // Match taxi to update or create
        $fareData
    );

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
        // Load single driver, fare, and taxi type
        $taxi->load('drivers', 'fare', 'type');

        return view('airport_taxis.taxi_edit', [
            'taxi' => $taxi,
            'taxi_types' => TaxiType::all()
        ]);
    }

   public function update(Request $request, Taxi $taxi)
{
    \Log::info('Update request', $request->all());

    // authorization
    if ($taxi->car_renter_id !== Auth::guard('car_renter')->id()) {
        abort(403, 'Unauthorized action.');
    }

    // make sure drivers relation is loaded so we can find existing driver
    $taxi->load('drivers');

    $existingDriver = $taxi->drivers->first(); // pick the first driver (you keep hasMany)
    $existingDriverId = $existingDriver?->id ?? 0;

    // 1) Validate taxi basic info
    $validatedTaxi = $request->validate([
        'taxi_type_id' => 'required|exists:taxi_types,id',
        'brand_model' => 'required|string|max:255',
        'number_plate' => 'required|string|unique:taxis,number_plate,' . $taxi->id,
        'color' => 'required|string',
        'passenger_capacity' => 'required|integer|min:1',
        'luggage_capacity' => 'nullable|integer|min:0',
        'nearest_city' => 'required|string|max:255',

    ]);

    // Update taxi basic info (we'll update images later)
    $taxi->update($validatedTaxi);
    $taxi->nearest_city = $request->nearest_city;
    $taxi->save();


    // 2) Validate driver fields
    // NOTE: Blade inputs use names like: driver_name, driver_contact, driver_email,
    // driver_license_number, driver_photo, driver_license_front, driver_license_back, tourism_license_front, tourism_license_back
    $validatedDriver = $request->validate([
        'driver_name' => 'required|string',
        'driver_contact' => 'required|string',
        'driver_email' => 'nullable|email',
        // exclude current existing driver id from unique check
        'driver_license_number' => 'required|string|unique:drivers,license_number,' . $existingDriverId,
        'driver_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'driver_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'driver_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'tourism_license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'tourism_license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
    ]);

    // 3) Create or update driver (we use the first driver if exists)
    $driver = $existingDriver ?? new Driver(['taxi_id' => $taxi->id]);

    $driver->name = $validatedDriver['driver_name'];
    $driver->contact_number = $validatedDriver['driver_contact'];
    $driver->email = $validatedDriver['driver_email'] ?? null;
    $driver->license_number = $validatedDriver['driver_license_number'];
    $driver->taxi_id = $taxi->id;
    $driver->save();

    // 4) Handle driver file uploads (FileUploadService returns File model with id)
    $fileService = app(FileUploadService::class);

    // map input name => driver column
    $driverFileMap = [
        'driver_photo' => 'photo',
        'driver_license_front' => 'driver_license_front',
        'driver_license_back' => 'driver_license_back',
        'tourism_license_front' => 'tourism_license_front',
        'tourism_license_back' => 'tourism_license_back',
    ];

    foreach ($driverFileMap as $inputName => $driverColumn) {
        if ($request->hasFile($inputName)) {
            $file = $fileService->uploadAndSave($request->file($inputName), $inputName, 'driver', null);
            if ($file) {
                // save file id into driver column (your Blade expects driver->driver_license_front etc to contain file id)
                $driver->{$driverColumn} = $file->id;
            }
        }
    }

    // persist any driver file id changes
    $driver->save();

    // 5) Handle taxi images (store in storage/app/public/taxis/{id} and save path)
    foreach (['front_image', 'back_image', 'inside_image'] as $field) {
        if ($request->hasFile($field)) {
            $path = $request->file($field)->store("taxis/{$taxi->id}", 'public');
            $taxi->{$field} = $path;
        }
    }
    $taxi->save(); // persist taxi image paths if any

    // 6) Validate and update fare
$validatedFare = $request->validate([
    'pricing_type'   => 'required|string|in:perKm,perDay',
    'base_fare'      => 'required|numeric|min:0',
    'price_per_km'   => 'required_if:pricing_type,perKm|nullable|numeric|min:0',
    'price_per_day'  => 'required_if:pricing_type,perDay|nullable|numeric|min:0',
    'airport_fee'    => 'nullable|numeric|min:0',
    'luggage_fee'    => 'nullable|numeric|min:0',
]);

$fareData = [
    'taxi_id'       => $taxi->id,
    'base_fare'     => $validatedFare['base_fare'],
    'price_per_km'  => $validatedFare['pricing_type'] === 'perKm' ? $validatedFare['price_per_km'] : null,
    'price_per_day' => $validatedFare['pricing_type'] === 'perDay' ? $validatedFare['price_per_day'] : null,
    'airport_fee'   => $validatedFare['airport_fee'] ?? 0,
    'luggage_fee'   => $validatedFare['luggage_fee'] ?? 0,
];



    // match on taxi_id explicitly
    $taxi->fare()->updateOrCreate(['taxi_id' => $taxi->id], $fareData);

    return redirect()->route('taxi.listing', $taxi->id)
        ->with('success', 'Taxi updated successfully.');
}

}