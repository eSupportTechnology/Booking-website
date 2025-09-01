@extends('frontend.master')

@section('content')
<section class="py-12 bg-gray-100" x-data="{ driverType: '', brand: '', location: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Find Your Perfect Ride Anytime, Anywhere</h1>
        <p class="text-gray-600 mb-6 text-xl">Compare prices and book your car in minutes.</p>

        <!-- Search Form -->
        <form class="bg-white rounded-xl px-4 py-2 shadow-lg border-4 border-yellow-400 w-full mx-auto text-sm">
            <div class="flex flex-wrap md:flex-nowrap items-center w-full gap-x-4 gap-y-2">

                <!-- Driver Type Dropdown -->
                <div x-data="{ open: false }" class="relative flex-1 min-w-0">
                    <button @click="open = !open" type="button"
                            class="flex items-center gap-2 w-full text-left text-sm border p-2 rounded">
                        <span x-text="driverType ? driverType : 'Select Driver Type'" class="text-gray-800 truncate text-base"></span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
                        <ul class="max-h-48 overflow-y-auto">
                            <li @click="driverType = 'With Driver'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">With Driver</li>
                            <li @click="driverType = 'Without Driver'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Without Driver</li>
                        </ul>
                    </div>
                    <input type="hidden" name="driver_type" :value="driverType" />
                </div>

                <!-- Car Brand Selector -->
                <div x-data="{ open: false }" class="relative flex-1 min-w-0">
                    <button @click="open = !open" type="button"
                            class="flex items-center gap-2 w-full text-left text-sm border p-2 rounded">
                        <span x-text="brand ? brand : 'Select Car Brand'" class="text-gray-800 truncate text-base"></span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
                        <ul class="max-h-48 overflow-y-auto">
                            <li @click="brand = 'Toyota'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Toyota</li>
                            <li @click="brand = 'Honda'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Honda</li>
                            <li @click="brand = 'Ford'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Ford</li>
                            <li @click="brand = 'Mazda'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Mazda</li>
                            <li @click="brand = 'BMW'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">BMW</li>
                        </ul>
                    </div>
                    <input type="hidden" name="brand" :value="brand" />
                </div>

                <!-- Location Selector -->
                <div x-data="{ open: false }" class="relative flex-1 min-w-0">
                    <button @click="open = !open" type="button"
                            class="flex items-center gap-2 w-full text-left text-sm border p-2 rounded">
                        <span x-text="location ? location : 'Select Location'" class="text-gray-800 truncate text-base"></span>
                        <i class="fas fa-chevron-down ml-auto"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
                        <ul class="max-h-48 overflow-y-auto">
                            <li @click="location = 'Colombo'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Colombo</li>
                            <li @click="location = 'Negombo'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Negombo</li>
                            <li @click="location = 'Kandy'; open = false" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Kandy</li>
                        </ul>
                    </div>
                    <input type="hidden" name="location" :value="location" />
                </div>

                <!-- Search Button -->
                <div class="flex-shrink-0">
                    <button type="submit"
                        class="w-full md:w-auto bg-[#3CC0E9] hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                        Search
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Car Rental Listings Section -->
<section class="bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Topic -->
        <h2 class="text-2xl font-extrabold text-gray-900">Latest Car Rental Listings</h2>
        <!-- Sub Topic -->
        <p class="mt-2 mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
            Browse available cars with or without a driver
        </p>

        <div class="mt-10">
            <!-- Responsive Grid: 1 on mobile, 2 on tablet, 4 on desktop -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Car 1 -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
    <img src="{{ asset('images/9.jpg') }}" alt="Car 1" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-bold">Toyota Corolla</h3>
        <!-- Company Name -->
        <p class="text-sm text-gray-500">By: <span class="font-medium text-gray-700">ABC Car Rentals</span></p>
        
        <p class="text-gray-600 mt-1">Comfortable sedan with driver included.</p>
        <div class="mt-2 flex justify-between items-center">
            <span class="text-blue-600 font-semibold">$50/day</span>
            <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
        </div>
    </div>
</div>


                <!-- Car 2 -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/9.jpg') }}" alt="Car 2" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">Honda Civic</h3>
                        <p class="text-sm text-gray-500">By: <span class="font-medium text-gray-700">ABC Car Rentals</span></p>
        
                        <p class="text-gray-600 mt-1">Reliable sedan, driver included for city tours.</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-blue-600 font-semibold">$55/day</span>
                            <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Car 3 -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/10.jpg') }}" alt="Car 3" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">Nissan Altima</h3>
                        <p class="text-sm text-gray-500">By: <span class="font-medium text-gray-700">ABC Car Rentals</span></p>
        
                        <p class="text-gray-600 mt-1">Spacious sedan with professional driver service.</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-blue-600 font-semibold">$65/day</span>
                            <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
                        </div>
                    </div>
                </div>

                <!-- Car 4 -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <img src="{{ asset('images/10.jpg') }}" alt="Car 4" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">BMW 3 Series</h3>
                        <p class="text-sm text-gray-500">By: <span class="font-medium text-gray-700">ABC Car Rentals</span></p>
        
                        <p class="text-gray-600 mt-1">Luxury sedan with driver for business trips.</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-blue-600 font-semibold">$80/day</span>
                            <a href="#" class="text-white bg-[#3CC0E9] px-4 py-2 rounded hover:bg-blue-700">Book Now</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            <nav class="inline-flex space-x-2">
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Prev</a>
                <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded-lg">1</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">2</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">3</a>
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Next</a>
            </nav>
        </div>
    </div>
</section>


<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
