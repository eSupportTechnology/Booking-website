@extends('frontend.master')

@section('content')
<section class="py-12 bg-gray-100" x-data="{ taxiType: '', location: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2 text-center sm:text-left">
            Find Your Perfect Ride Anytime, Anywhere
        </h1>
        <p class="text-gray-600 mb-6 text-lg sm:text-xl text-center sm:text-left">
            Compare prices and book your car in minutes.
        </p>

        <!-- Search Form -->
        <form class="bg-white rounded-xl px-2 py-2 shadow-lg border-4 border-yellow-400 w-full mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">

                <!-- Taxi Type Dropdown -->
                <div x-data="{ open: false }" class="flex-1 relative">
                    <button @click="open = !open" type="button"
                            class="flex items-center gap-2 w-full border p-2 rounded text-base text-gray-800">
                        <span x-text="taxiType ? taxiType : 'Select Taxi Type'" class="truncate"></span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
                        <ul class="max-h-48 overflow-y-auto">
                            <li @click="taxiType = 'Sedan'; open = false" 
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Sedan</li>
                            <li @click="taxiType = 'SUV'; open = false" 
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">SUV</li>
                            <li @click="taxiType = 'Van'; open = false" 
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Van</li>
                            <li @click="taxiType = 'Luxury'; open = false" 
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Luxury</li>
                        </ul>
                    </div>
                    <input type="hidden" name="taxi_type" :value="taxiType" />
                </div>

                <!-- Pickup Date & Time -->
<div class="flex-1">
    <input type="text" 
           id="pickup_datetime" 
           name="pickup_datetime" 
           placeholder="Enter Pickup Date & Time"
           class="w-full border p-2 rounded text-gray-800 text-base" />
</div>

<!-- Include flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#pickup_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        altInput: true,
        altFormat: "F j, Y H:i",
        allowInput: true
    });
</script>


            <!-- Location Dropdown -->
<div class="flex-1 relative">
    <select id="location" name="location" class="w-full border p-2 rounded text-gray-800 text-base">
        <option value="">Select Location</option>
        <option value="Colombo">Colombo</option>
        <option value="Negombo">Negombo</option>
        <option value="Kandy">Kandy</option>
        <option value="Galle">Galle</option>
        <option value="Matara">Matara</option>
        <!-- Add more cities/villages here -->
    </select>
</div>

<!-- Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Choices('#location', {
            searchEnabled: true,
            removeItemButton: false,
            placeholderValue: 'Enter Drop-off Location',
            searchPlaceholderValue: 'Enter Drop-off Location'
        });
    });
</script>


                <!-- Search Button -->
                <div class="flex-shrink-0">
                    <button type="submit"
                        class="w-full sm:w-auto bg-[#3CC0E9] hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-base">
                        Search
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>

<!-- Taxi Listings Section -->
<section class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-gray-900">Available Car Rentals</h2>
        <p class="mt-2 mb-8 text-gray-600">Browse available active car rentals with or without a driver</p>

        <!-- Toggle Tabs -->
        <div x-data="{ tab: 'with' }" class="mb-6">
            <div class="flex justify-center space-x-4">
                <button 
                    @click="tab = 'with'" 
                    :class="tab === 'with' ? 'bg-[#3CC0E9] text-white' : 'bg-white text-gray-600 border'"
                    class="px-6 py-2 rounded-lg font-semibold shadow hover:bg-blue-100 transition">
                    With Driver
                </button>
                <button 
                    @click="tab = 'without'" 
                    :class="tab === 'without' ? 'bg-[#3CC0E9] text-white' : 'bg-white text-gray-600 border'"
                    class="px-6 py-2 rounded-lg font-semibold shadow hover:bg-blue-100 transition">
                    Without Driver
                </button>
            </div>

            <!-- With Driver Cars -->
            <div x-show="tab === 'with'" class="mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($activeCars->where('with_driver', 'yes') as $car)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <img src="{{ $car->front_image ? asset('storage/' . $car->front_image) : asset('images/taxi-placeholder.jpg') }}" 
                                alt="Car {{ $car->number_plate }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold">{{ $car->brand->brand_name ?? 'Brand' }} {{ $car->model->model_name ?? 'Model' }}</h3>
                                <p class="text-sm text-gray-500">
                                    Fuel: <span class="font-medium text-gray-700">{{ $car->fuel_type ?? 'Fuel' }}</span>
                                </p>
                                <p class="text-gray-600 mt-1">{{ $car->seats ?? 0 }} seats</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-blue-600 font-semibold"></span>
                                    <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 text-lg">No cars with driver available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Without Driver Cars -->
            <div x-show="tab === 'without'" class="mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($activeCars->where('with_driver', 'no') as $car)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <img src="{{ $car->front_image ? asset('storage/' . $car->front_image) : asset('images/taxi-placeholder.jpg') }}" 
                                alt="Car {{ $car->number_plate }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold">{{ $car->brand->brand_name ?? 'Brand' }} {{ $car->model->model_name ?? 'Model' }}</h3>
                                <p class="text-sm text-gray-500">
                                    Fuel: <span class="font-medium text-gray-700">{{ $car->fuel_type ?? 'Fuel' }}</span>
                                </p>
                                <p class="text-gray-600 mt-1">{{ $car->seats ?? 0 }} seats</p>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-blue-600 font-semibold"></span>
                                    <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 text-lg">No cars without driver available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection
