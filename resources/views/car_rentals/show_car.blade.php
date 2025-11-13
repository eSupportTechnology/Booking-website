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
      <div class="md:w-1/4 flex justify-center items-center border border-gray-200 p-2">
          <div class="relative h-56 w-56 w-full">
              <div class="swiper car-swiper h-full">
                  <div class="swiper-wrapper">
                      @if($car->car_front)
                          <div class="swiper-slide">
                              <img src="{{ asset('storage/' . $car->car_front) }}" 
                                   alt="Car Front" 
                                   class="w-full h-56  object-cover rounded-xl">
                          </div>
                      @endif
                      @if($car->car_back)
                          <div class="swiper-slide">
                              <img src="{{ asset('storage/' . $car->car_back) }}" 
                                   alt="Car Back" 
                                   class="w-full h-56  object-cover rounded-xl">
                          </div>
                      @endif
                      @if($car->car_inside)
                          <div class="swiper-slide">
                              <img src="{{ asset('storage/' . $car->car_inside) }}" 
                                   alt="Car Inside" 
                                   class="w-full h-56  object-cover rounded-xl">
                          </div>
                      @endif
                  </div>

                  <!-- Pagination & Nav -->
                  <div class="swiper-pagination"></div>
                  <div class="swiper-button-prev !w-6 !h-6 after:!text-[20px]"></div>
                  <div class="swiper-button-next !w-6 !h-6 after:!text-[20px]"></div>
              </div>
          </div>
      </div>


      <!-- Right Column: Basic Car Details -->
      <div class="md:w-1/2 flex flex-col justify-start space-y-2">
        <h2 class="text-2xl font-bold mb-4">{{ $car->brand->brand_name ?? '' }} {{ $car->model->model_name ?? '' }}</h2>
        <p>
    
    <span class="px-2 py-1 rounded-full text-white font-semibold
        {{ $car->is_active ? 'bg-green-500' : 'bg-red-500' }}">
        {{ $car->is_active ? 'Active' : 'Inactive' }}
    </span>
</p>
        <p><strong>Car Type:</strong> {{ $car->carType->name ?? '' }}</p>
        <p><strong>Company:</strong> {{ $car->company->name ?? '' }}</p>
      <!--  <p><strong>Brand:</strong> {{ $car->brand->brand_name ?? '' }}</p>-->
        <p><strong>Model:</strong> {{ $car->model->model_name ?? '' }}</p>
     
        <p><strong>Seats:</strong> {{ $car->seats }}</p>
      </div>

    </div>

    <!-- Section 2-4: Vehicle Specs, Driver Details, Price Details -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Vehicle Specifications -->
        <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
            <h2 class="text-xl font-bold mb-4">Vehicle Specifications</h2>
            <p><strong>Transmission:</strong> {{ $car->transmission ?? 'N/A' }}</p>
            <p><strong>Fuel Type:</strong> {{ $car->fuel_type ?? 'N/A' }}</p>
            <p><strong>Mileage Type:</strong> {{ $car->mileage_type ?? 'N/A' }}</p>
        </div>
<div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
    <h2 class="text-xl font-bold mb-4">Price Details</h2>

    @php
        $pricingType = $car->price_per_day !== null ? 'perDay' : ($car->price_per_km !== null ? 'perKm' : 'N/A');
    @endphp

    <p><strong>Pricing Type:</strong> {{ $pricingType }}</p>
    <p><strong>Price Per Day:</strong> {{ $car->price_per_day ?? 'N/A' }}</p>
    <p><strong>Price Per Km:</strong> {{ $car->price_per_km ?? 'N/A' }}</p>
   
</div>


    </div>
<!-- Driver Details -->
@if($car->with_driver === 'yes')
<div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
    <h2 class="text-xl font-bold mb-4">Driver Details</h2>

    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Column: Driver Info -->
        <div class="flex-1 space-y-2">
            <p><strong>Name:</strong> {{ $car->driver_name }}</p>
            <p><strong>Phone:</strong> {{ $car->driver_phone }}</p>
            <p><strong>Age:</strong> {{ $car->driver_age }}</p>
            <p><strong>Experience:</strong> {{ $car->driver_experience }} years</p>
            <p><strong>NIC:</strong> {{ $car->driver_nic }}</p>
        </div>

        <!-- Right Column: Driver License Images in a row -->
        <div class="flex-1 flex gap-2 items-center">
            @if($car->driver_license_front)
            <div class="flex flex-col items-center">
                <p class="text-sm font-medium mb-1">Driver License (Front)</p>
                <img src="{{ asset('storage/' . $car->driver_license_front) }}" 
                     alt="Driver License Front" 
                     class="w-60 h-40 object-cover rounded-lg border">
            </div>
            @endif
            @if($car->driver_license_back)
            <div class="flex flex-col items-center">
                <p class="text-sm font-medium mb-1">Driver License (Back)</p>
                <img src="{{ asset('storage/' . $car->driver_license_back) }}" 
                     alt="Driver License Back" 
                     class="w-60 h-40 object-cover rounded-lg border">
            </div>
            @endif
        </div>
    </div>
</div>
@endif


    <!-- Back Button -->
<div class="flex justify-between mt-4 max-w-6xl mx-auto">
    <!-- Back Button -->
    <a href="/my/car-rentals" class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-700 min-w-[100px] text-center">
        Back
    </a>

    <!-- Edit Button -->
    <a href="{{ route('cars.edit', $car->id) }}" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 min-w-[100px] text-center">
        Edit
    </a>
</div>


</div>

@endsection


<script>
document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".car-swiper", {
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
});
</script>
