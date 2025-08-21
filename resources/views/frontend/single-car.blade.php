<!-- resources/views/deal.blade.php -->

@extends('frontend.master')

@section('content')
<div class="bg-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border rounded-lg p-4 bg-blue-50 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Bandaranaike International Airport</h2>
                <p class="text-sm text-gray-600">Fri 22 Aug 2025, 16:00 → Sat 23 Aug 2025, 10:00</p>
            </div>
            <a href="#" class="mt-2 sm:mt-0 px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-100">Edit</a>
        </div>

        <!-- Deal Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Section -->
            <div class="lg:col-span-2 border rounded-lg shadow p-4 bg-white">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Your deal</h3>

                <!-- Car Card -->
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                    <!-- Car Image -->
                    <img src="{{ asset('images/car-sample.jpg') }}" alt="Car" class="w-40 h-28 object-cover rounded">

                    <!-- Car Info -->
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">Top Pick</span>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">Genius</span>
                        </div>
                        <h4 class="font-bold text-gray-800">Perodua Axia <span class="font-normal text-sm text-gray-500">or similar small car</span></h4>
                        <div class="flex flex-wrap text-sm text-gray-600 mt-2 space-x-4">
                            <span>🚗 4 seats</span>
                            <span>🛄 1 Large bag</span>
                            <span>⚙️ Automatic</span>
                            <span>♾️ Unlimited mileage</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Bandaranaike International Airport<br><span class="italic">Outside of Terminal</span></p>
                    </div>
                </div>

                <!-- Rating -->
                <div class="mt-4 flex items-center space-x-3">
                    <span class="bg-green-600 text-white px-2 py-1 text-xs rounded">Europcar</span>
                    <span class="bg-gray-100 px-2 py-1 text-xs rounded text-gray-800">6.1 OK (60 reviews)</span>
                </div>

                <!-- Highlights -->
                <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-3">
                    <h5 class="font-semibold text-green-700 mb-2">Great choice!</h5>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Customer rating: 6.1 / 10</li>
                        <li>Most popular fuel policy</li>
                        <li>Most popular company here</li>
                    </ul>
                </div>

                <!-- Included -->
                <div class="mt-4">
                    <h5 class="font-semibold text-gray-800">Included in the price</h5>
                    <p class="text-sm text-gray-600">✔ Insurance ✔ Taxes ✔ Unlimited mileage</p>
                </div>
            </div>

            <!-- Right Section (Price + Pick-up Info) -->
            <div class="border rounded-lg shadow p-4 bg-white">
                
                <!-- Pick-up Drop-off -->
                <div class="mb-6">
                    <h5 class="font-semibold text-gray-800">Pick-up and drop-off</h5>
                    <div class="mt-2 space-y-3 text-sm text-gray-700">
                        <label class="flex items-start space-x-2">
                            <input type="radio" checked class="mt-1">
                            <div>
                                <p>Fri 22 Aug - 16:00</p>
                                <p class="text-gray-500">Bandaranaike International Airport</p>
                                <a href="#" class="text-blue-600 text-xs hover:underline">View pick-up instructions</a>
                            </div>
                        </label>
                        <label class="flex items-start space-x-2">
                            <input type="radio" class="mt-1">
                            <div>
                                <p>Sat 23 Aug - 10:00</p>
                                <p class="text-gray-500">Bandaranaike International Airport</p>
                                <a href="#" class="text-blue-600 text-xs hover:underline">View drop-off instructions</a>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <h5 class="font-semibold text-gray-800">Car price breakdown</h5>
                    <div class="mt-2 text-sm text-gray-700 space-y-2">
                        <p class="flex justify-between"><span>Car hire charge</span> <span>LKR 16,953.78 (US$56.21)</span></p>
                        <p class="flex justify-between"><span>Genius discount</span> <span class="text-green-600">-US$5.62</span></p>
                        <hr>
                        <p class="flex justify-between font-bold"><span>Price for 1 day</span> <span>≈ LKR 15,258.70</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
