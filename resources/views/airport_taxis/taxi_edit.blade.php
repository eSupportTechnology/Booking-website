@extends('car_rentals.master')

@section('content')
<div class="max-w-6xl mx-auto mt-6 space-y-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('taxis.airport-taxis.update', $taxi->id) }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Taxi Info --}}
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-bold border-b pb-2">Taxi Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Taxi Type</label>
                    <select name="taxi_type_id" class="w-full border rounded p-2">
                        @foreach($taxi_types as $type)
                            <option value="{{ $type->id }}" 
                                {{ $taxi->taxi_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Number Plate</label>
                    <input type="text" name="number_plate" 
                           value="{{ old('number_plate', $taxi->number_plate) }}" 
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Color</label>
                    <input type="text" name="color" 
                           value="{{ old('color', $taxi->color) }}" 
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Passenger Capacity</label>
                    <input type="number" name="passenger_capacity" 
                           value="{{ old('passenger_capacity', $taxi->passenger_capacity) }}" 
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Luggage Capacity</label>
                    <input type="number" name="luggage_capacity" 
                           value="{{ old('luggage_capacity', $taxi->luggage_capacity) }}" 
                           class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        {{-- Driver Info --}}
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-bold border-b pb-2">Driver Details</h2>
            @php $driver = $taxi->drivers->first(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Name</label>
                    <input type="text" name="driver_name" 
                           value="{{ old('driver_name', $driver?->name) }}"
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Contact Number</label>
                    <input type="text" name="driver_contact" 
                           value="{{ old('driver_contact', $driver?->contact_number) }}"
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="driver_email" 
                           value="{{ old('driver_email', $driver?->email) }}"
                           class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">License Number</label>
                    <input type="text" name="driver_license_number" 
                           value="{{ old('driver_license_number', $driver?->license_number) }}"
                           class="w-full border rounded p-2">
                </div>
            </div>
@php
    $driverLicenseFront = $driver?->driver_license_front 
        ? \App\Models\File::find($driver->driver_license_front) 
        : null;

    $driverLicenseBack = $driver?->driver_license_back
        ? \App\Models\File::find($driver->driver_license_back)
        : null;

    $tourismLicenseFront = $driver?->tourism_license_front
        ? \App\Models\File::find($driver->tourism_license_front)
        : null;

    $tourismLicenseBack = $driver?->tourism_license_back
        ? \App\Models\File::find($driver->tourism_license_back)
        : null;
@endphp

{{-- Driver Photo + Licenses --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
  <div>
    <label class="block font-semibold mb-1">Driver Photo</label>
    <input type="file" name="driver_photo" class="w-full border rounded p-2">

    @php
        $photoFile = $driver->photo ? \App\Models\File::find($driver->photo) : null;
    @endphp

    @if($photoFile?->path)
        <img src="{{ asset('storage/' . $photoFile->path) }}"
             alt="{{ $driver->name }}"
             class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300">
    @else
        <!-- fallback placeholder -->
        <img src="{{ asset('images/user.jpeg') }}"
             alt="Default Profile"
             class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300">
    @endif
</div>

    <div>
        <label class="block font-semibold mb-1">Driver License Front</label>
        <input type="file" name="driver_license_front" class="w-full border rounded p-2">
        @if($driverLicenseFront?->path)
            <img src="{{ asset('storage/'.$driverLicenseFront->path) }}" 
                 class="mt-2 w-32 h-32 object-cover rounded-lg">
        @endif
    </div>

    <div>
        <label class="block font-semibold mb-1">Driver License Back</label>
        <input type="file" name="driver_license_back" class="w-full border rounded p-2">
        @if($driverLicenseBack?->path)
            <img src="{{ asset('storage/'.$driverLicenseBack->path) }}" 
                 class="mt-2 w-32 h-32 object-cover rounded-lg">
        @endif
    </div>

    <div>
        <label class="block font-semibold mb-1">Tourism License Front</label>
        <input type="file" name="tourism_license_front" class="w-full border rounded p-2">
        @if($tourismLicenseFront?->path)
            <img src="{{ asset('storage/'.$tourismLicenseFront->path) }}" 
                 class="mt-2 w-32 h-32 object-cover rounded-lg">
        @endif
    </div>

    <div>
        <label class="block font-semibold mb-1">Tourism License Back</label>
        <input type="file" name="tourism_license_back" class="w-full border rounded p-2">
        @if($tourismLicenseBack?->path)
            <img src="{{ asset('storage/'.$tourismLicenseBack->path) }}" 
                 class="mt-2 w-32 h-32 object-cover rounded-lg">
        @endif
    </div>
</div>

      {{-- Pricing --}}
<div class="bg-white p-6 rounded-xl shadow space-y-4">
    <h2 class="text-xl font-bold border-b pb-2">Pricing</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Pricing Type --}}
        <div>
            <label class="block font-semibold mb-1">Pricing Type</label>
            <select name="pricing_type" class="w-full border rounded p-2">
                <option value="perDay" {{ $taxi->fare?->price_per_day ? 'selected' : '' }}>Per Day</option>
                <option value="perKm" {{ $taxi->fare?->price_per_km ? 'selected' : '' }}>Per Km</option>
            </select>
        </div>

        {{-- Base Fare --}}
        <div>
            <label class="block font-semibold mb-1">Base Fare</label>
            <input type="number" step="0.01" name="base_fare"
                   value="{{ old('base_fare', $taxi->fare?->base_fare) }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Price per Km --}}
        <div>
            <label class="block font-semibold mb-1">Price per Km</label>
            <input type="number" step="0.01" name="price_per_km"
                   value="{{ old('price_per_km', $taxi->fare?->price_per_km) }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- Price per Day --}}
        <div>
            <label class="block font-semibold mb-1">Price per Day</label>
            <input type="number" step="0.01" name="price_per_day"
                   value="{{ old('price_per_day', $taxi->fare?->price_per_day) }}"
                   class="w-full border rounded p-2">
        </div>


    </div>
</div>


        {{-- Taxi Images --}}
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-bold border-b pb-2">Taxi Images</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(['front','back','inside'] as $side)
                    <div>
                        <label class="block font-semibold mb-1">{{ ucfirst($side) }} Image</label>
                        <input type="file" name="{{ $side }}_image" class="w-full border rounded p-2">
                        @if($taxi->{$side.'_image'})
                            <img src="{{ asset('storage/'.$taxi->{$side.'_image'}) }}" 
                                 class="mt-2 w-32 h-32 object-cover rounded">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                Update Taxi
            </button>
        </div>
    </form>
</div>
@endsection
