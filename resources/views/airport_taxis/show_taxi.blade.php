@extends('car_rentals.master')

@section('content')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<div class="max-w-6xl mx-auto space-y-6 mt-6">

    <!-- Section 1: Car Image + Basic Details -->
    <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row gap-6">
      
        <!-- Left Column: Car Images with Swiper -->
        <div class="md:w-1/2 flex justify-center items-center border border-gray-200 p-2">
            <div class="swiper taxi-swiper w-full h-60">
                <div class="swiper-wrapper">
                    @if($taxi->front_image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$taxi->front_image) }}" alt="Front View"
                                 class="w-full h-auto rounded-xl object-cover">
                        </div>
                    @endif

                    @if($taxi->back_image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$taxi->back_image) }}" alt="Back View"
                                 class="w-full h-auto rounded-xl object-cover">
                        </div>
                    @endif

                    @if($taxi->inside_image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/'.$taxi->inside_image) }}" alt="Inside View"
                                 class="w-full h-auto rounded-xl object-cover">
                        </div>
                    @endif

                    @if(!$taxi->front_image && !$taxi->back_image && !$taxi->inside_image)
                        <div class="swiper-slide">
                            <img src="{{ asset('images/placeholder-car.jpg') }}" alt="No Image"
                                 class="w-full h-auto rounded-xl object-cover">
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
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
    @php
        $photoFile = $driver->photo ? \App\Models\File::find($driver->photo) : null;
    @endphp

    @if($photoFile?->path)
        <img src="{{ asset('storage/' . $photoFile->path) }}"
             alt="{{ $driver->name }}"
             class="w-full h-full object-cover rounded-full border border-gray-300">
    @else
        <!-- fallback placeholder -->
        <img src="{{ asset('images/user.jpeg') }}"
             alt="Default Profile"
             class="w-full h-full object-cover rounded-full border border-gray-300">
    @endif
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
                <p><strong>Pricing Type:</strong>
                    {{ $taxi->fare->pricing_type === 'perKm' ? $taxi->fare->price_per_km.' / km' : $taxi->fare->price_per_day.' / day' }}
                </p>
                <p><strong>Base Fare:</strong> {{ $taxi->fare->base_fare }}</p>
                <p><strong>Price Per Km:</strong> {{ $taxi->fare->pricing_type === 'perKm' ? $taxi->fare->price : '-' }}</p>
                <p><strong>Price Per Day:</strong> {{ $taxi->fare->pricing_type === 'perDay' ? $taxi->fare->price : '-' }}</p>
            @else
                <p>Fare details not available</p>
            @endif
        </div>
    </div>
<!-- Driver License & Tourism License Section -->
@php
    $driverLicenseFront = $driver->driver_license_front 
        ? \App\Models\File::find($driver->driver_license_front) 
        : null;
    $driverLicenseBack = $driver->driver_license_back
        ? \App\Models\File::find($driver->driver_license_back)
        : null;
    $tourismLicenseFront = $driver->tourism_license_front
        ? \App\Models\File::find($driver->tourism_license_front)
        : null;
    $tourismLicenseBack = $driver->tourism_license_back
        ? \App\Models\File::find($driver->tourism_license_back)
        : null;
@endphp
   <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b pb-6">
    <!-- Driver License -->
    <div>
        <h3 class="text-xl font-bold mb-4">Driver License</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($driverLicenseFront?->path)
                <div>
                    <p class="text-sm font-medium mb-1">Front</p>
                    <img src="{{ asset('storage/'.$driverLicenseFront->path) }}"
                         alt="Driver License Front"
                         class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif

            @if($driverLicenseBack?->path)
                <div>
                    <p class="text-sm font-medium mb-1">Back</p>
                    <img src="{{ asset('storage/'.$driverLicenseBack->path) }}"
                         alt="Driver License Back"
                         class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif
        </div>
    </div>

    <!-- Tourism License -->
    <div>
        <h3 class="text-xl font-bold mb-4">Tourism License</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if($tourismLicenseFront?->path)
                <div>
                    <p class="text-sm font-medium mb-1">Front</p>
                    <img src="{{ asset('storage/'.$tourismLicenseFront->path) }}"
                         alt="Tourism License Front"
                         class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif

            @if($tourismLicenseBack?->path)
                <div>
                    <p class="text-sm font-medium mb-1">Back</p>
                    <img src="{{ asset('storage/'.$tourismLicenseBack->path) }}"
                         alt="Tourism License Back"
                         class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif
        </div>
    </div>
</div>
</div>

    <!-- Back & Edit Buttons -->
    <div class="flex justify-between mt-4 max-w-6xl mx-auto">
        <a href="/my/taxi"
           class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-700 min-w-[100px] text-center">
            Back
        </a>

        <a href="{{ route('taxis.airport-taxis.edit', $taxi->id) }}"
           class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 min-w-[100px] text-center">
            Edit
        </a>
    </div>

</div>

<!-- Swiper Init -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".taxi-swiper", {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
           
        });
    });
</script>

@endsection
