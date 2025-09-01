@extends('admin.master')
@section('title', 'Airport Details')
@section('content')

<section class="min-h-screen p-4 sm:p-6 bg-gray-50">
    <div class="space-y-6 sm:space-y-8">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap text-sm sm:text-base mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 sm:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <a href="{{ url('/admin/airport-management') }}" class="text-gray-700 hover:text-blue-600">Airport</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-gray-500">Airport Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Airport Basic Info -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <a href="#"
               class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">Edit</a>

            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Airport Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                    <p class="text-gray-700"><span class="font-semibold">Airport ID:</span> #A101</p>
                    <p class="text-gray-700"><span class="font-semibold">Airport Name:</span> Bandaranaike International Airport</p>
                    <p class="text-gray-700"><span class="font-semibold">Location:</span> Katunayake, Sri Lanka</p>
                    <p class="text-gray-700"><span class="font-semibold">Type:</span> International</p>
                    <p class="text-gray-700"><span class="font-semibold">Status:</span>
                        <span class="px-2 sm:px-3 py-1 rounded-full text-white bg-green-500 text-xs sm:text-sm">Active</span>
                    </p>
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/airport-sample.jpg') }}"
                         alt="Airport Image"
                         class="rounded-lg shadow-md w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-40 sm:h-48 md:h-56 object-cover">
                </div>
            </div>
        </div>

         <!-- Contact Details -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <a href="#"
               class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">Edit</a>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Contact Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Contact Number:</span> +94 11 225 2861</p>
                <p class="text-gray-700"><span class="font-semibold">Email:</span> info@airport.lk</p>
                <p class="text-gray-700"><span class="font-semibold">Website:</span> www.airport.lk</p>
                <p class="text-gray-700"><span class="font-semibold">Manager:</span> Mr. Sunil Perera</p>
            </div>
        </div>

         <!-- Facilities & Services -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <a href="#"
               class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">Edit</a>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Facilities & Services</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>24/7 Taxi Service</li>
                <li>Restaurants & Cafés</li>
                <li>Duty-Free Shopping</li>
                <li>Free Wi-Fi</li>
                <li>VIP Lounge</li>
            </ul>
        </div>

          <!-- Airport Statistics -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <a href="#"
               class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">Edit</a>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Airport Statistics</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-blue-700">Total Passengers</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">12.5M</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-green-700">Monthly Flights</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">1,200</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-yellow-700">Total Airlines</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">45</p>
                </div>
            </div>
        </div>

        <!-- Customer Insights -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <a href="#"
               class="absolute top-3 sm:top-4 right-3 sm:right-4 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">Edit</a>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Customer Insights</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Unique Customers:</span> 150K</p>
                <p class="text-gray-700"><span class="font-semibold">Repeat Customers:</span> 60%</p>
                <p class="text-gray-700"><span class="font-semibold">Customer Rating:</span> ⭐ 4.8 / 5</p>
                <p class="text-gray-700"><span class="font-semibold">Customer Reviews:</span> 12,000</p>
            </div>
        </div>


        <!-- Back Button -->
        <div class="mt-4 sm:mt-6">
            <a href="{{ url('/admin/rental/airport') }}"
               class="bg-[#1F8FB2] hover:bg-[#157799] text-white px-3 py-2 sm:px-4 sm:py-2 rounded shadow text-sm sm:text-base">
                ← Back to Airport List
            </a>
        </div>
    </div>
</section>

@endsection
