@extends('car_rentals.master')

@section('content')
<div class="max-w-6xl mx-auto mt-6 space-y-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('taxis.airport-taxis.update', $taxi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Taxi Info -->
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Taxi Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Taxi Type</label>
                    <select name="taxi_type_id" class="w-full border rounded p-2">
                        @foreach($taxi_types as $type)
                            <option value="{{ $type->id }}" {{ $taxi->taxi_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Number Plate</label>
                    <input type="text" name="number_plate" value="{{ $taxi->number_plate }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Color</label>
                    <input type="text" name="color" value="{{ $taxi->color }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Passenger Capacity</label>
                    <input type="number" name="passenger_capacity" value="{{ $taxi->passenger_capacity }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Luggage Capacity</label>
                    <input type="number" name="luggage_capacity" value="{{ $taxi->luggage_capacity }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">With Driver?</label>
                    <select name="with_driver" class="w-full border rounded p-2">
                        <option value="yes" {{ $taxi->with_driver === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $taxi->with_driver === 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Driver Info -->
        @if($taxi->with_driver === 'yes')
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Driver Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Name</label>
                    <input type="text" name="driver_name" value="{{ $taxi->driver->name ?? '' }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Contact Number</label>
                    <input type="text" name="driver_contact" value="{{ $taxi->driver->contact_number ?? '' }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="driver_email" value="{{ $taxi->driver->email ?? '' }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">License Number</label>
                    <input type="text" name="driver_license_number" value="{{ $taxi->driver->license_number ?? '' }}" class="w-full border rounded p-2">
                </div>
            </div>
        </div>
        @endif

        <!-- Pricing -->
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Pricing</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Pricing Type</label>
                    <select name="pricing_type" class="w-full border rounded p-2">
                        <option value="perDay" {{ $taxi->fare?->pricing_type === 'perDay' ? 'selected' : '' }}>Per Day</option>
                        <option value="perKm" {{ $taxi->fare?->pricing_type === 'perKm' ? 'selected' : '' }}>Per Km</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Price Per Day</label>
                    <input type="number" step="0.01" name="price_per_day" value="{{ $taxi->fare?->pricing_type === 'perDay' ? $taxi->fare->price : '' }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Price Per Km</label>
                    <input type="number" step="0.01" name="price_per_km" value="{{ $taxi->fare?->pricing_type === 'perKm' ? $taxi->fare->price : '' }}" class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update Taxi</button>
        </div>
    </form>
</div>
@endsection
