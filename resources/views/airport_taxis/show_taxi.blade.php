@extends('car_rentals.master')

@section('content')

<div class="max-w-6xl mx-auto space-y-6 mt-6">

    <!-- Section 1: Car Image + Basic Details -->
    <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row gap-6">
      
        <!-- Left Column: Car Image -->
        <div class="md:w-1/2 flex justify-center items-center border border-gray-200 p-2">
            <img src="{{ asset('images/11.jpg') }}" class="w-1/2 h-auto rounded-xl">
        </div>

        <!-- Right Column: Basic Car Details -->
        <div class="md:w-1/2 flex flex-col justify-start space-y-2">
            <h2 class="text-2xl font-bold mb-4">{{ $taxi->taxiType->name ?? 'Taxi' }}</h2>

            <p>
                <span class="px-2 py-1 rounded-full text-white font-semibold
                    {{ $taxi->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $taxi->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>

            <p><strong>Number Plate:</strong> {{ $taxi->number_plate ?? 'N/A' }}</p>
            <p><strong>Taxi Color:</strong> {{ $taxi->color ?? 'N/A' }}</p>
            <p><strong>Number of Passengers:</strong> {{ $taxi->passenger_capacity ?? 0 }}</p>
            <p><strong>Luggage Capacity:</strong> {{ $taxi->luggage_capacity ?? 0 }}</p>
           
        </div>
    </div>

    <!-- Driver & Price Details -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Driver Details -->
    <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
    <h2 class="text-xl font-bold mb-4">Driver Details</h2>

    @if($taxi->drivers->count() > 0)
        @foreach($taxi->drivers as $driver)
            <div class="flex items-center mb-4 gap-4">
                <!-- Left Column: Profile Image -->
                <div class="w-24 h-24 flex-shrink-0">
                   
                       
                             <img  src="{{ asset('images/user.jpeg') }}" alt="Car" class="w-full h-full object-cover rounded-full border border-gray-300">
                       
                  
                </div>

                <!-- Right Column: Driver Details -->
                <div class="flex-1">
                    <p><strong>Driver Name:</strong> {{ $driver->name }}</p>
                    <p><strong>Contact Number:</strong> {{ $driver->contact_number }}</p>
                    <p><strong>Email:</strong> {{ $driver->email ?? 'N/A' }}</p>
                    <p><strong>License Number:</strong> {{ $driver->license_number }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>No driver assigned</p>
    @endif
</div>


        <!-- Price Details -->
  <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
    <h2 class="text-xl font-bold mb-4">Price Details</h2>

    @if($taxi->fare)
        <p><strong>Pricing Type:</strong>  {{ $taxi->fare->pricing_type === 'perKm' ? $taxi->fare->price_per_km.' / km' : $taxi->fare->price_per_day.' / day' }}</p>
        <p><strong>Base Fare:</strong> {{ $taxi->fare->base_fare }}</p>
        <p><strong>Price Per Km:</strong> {{ $taxi->fare->pricing_type === 'perKm' ? $taxi->fare->price : '-' }}</p>
        <p><strong>Price Per Day:</strong> {{ $taxi->fare->pricing_type === 'perDay' ? $taxi->fare->price : '-' }}</p>
    @else
        <p>Fare details not available</p>
    @endif
</div>


    </div>

    <!-- Back & Edit Buttons -->
    <div class="flex justify-between mt-4 max-w-6xl mx-auto">
        <a href="/my/taxi" class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-700 min-w-[100px] text-center">
            Back
        </a>

        <a href="{{ route('taxis.airport-taxis.edit', $taxi->id) }}"  class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 min-w-[100px] text-center">
            Edit
        </a>
    </div>

</div>

@endsection
