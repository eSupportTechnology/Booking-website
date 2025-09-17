@extends('car_rentals.master')

@section('content')

<div class="max-w-6xl mx-auto space-y-6 mt-6">

    <!-- Section 1: Car Image + Basic Details -->
    <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row gap-6">
      
      <!-- Left Column: Car Image -->
   <div class="md:w-1/2 flex justify-center items-center border border-gray-200 p-2">
    <img src="{{ asset('images/11.jpg') }}" 
         class="w-1/2 h-auto rounded-xl">
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
        <p><strong>Brand:</strong> {{ $car->brand->brand_name ?? '' }}</p>
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

        <!-- Driver Details -->
        @if($car->with_driver === 'yes')
        <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
            <h2 class="text-xl font-bold mb-4">Driver Details</h2>
            <p><strong>Name:</strong> {{ $car->driver_name }}</p>
            <p><strong>Phone:</strong> {{ $car->driver_phone }}</p>
            <p><strong>Age:</strong> {{ $car->driver_age }}</p>
            <p><strong>Experience:</strong> {{ $car->driver_experience }} years</p>
            <p><strong>NIC:</strong> {{ $car->driver_nic }}</p>
        </div>
        @endif

        <!-- Price Details -->
        <div class="bg-white p-6 rounded-2xl shadow-lg flex-1">
            <h2 class="text-xl font-bold mb-4">Price Details</h2>
            <p><strong>Pricing Type:</strong> {{ $car->pricingType ?? 'N/A' }}</p>
            <p><strong>Price Per Day:</strong> {{ $car->pricePerDay ?? 'N/A' }}</p>
            <p><strong>Price Per Km:</strong> {{ $car->pricePerKm ?? 'N/A' }}</p>
     
        </div>

    </div>

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
