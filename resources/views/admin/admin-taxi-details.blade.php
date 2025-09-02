@extends('admin.master')
@section('title', 'Taxi Details')
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
                        <a href="{{ url('/admin/taxi-management') }}" class="text-gray-700 hover:text-blue-600">Taxi</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-gray-500">Taxi Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Taxi Basic Info -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">


            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Taxi Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                    <p class="text-gray-700"><span class="font-semibold">Taxi ID:</span> #T101</p>
                    <p class="text-gray-700"><span class="font-semibold">Vehicle Model:</span> Toyota Prius</p>
                    <p class="text-gray-700"><span class="font-semibold">Vehicle Number:</span> ABC-1234</p>
                    <p class="text-gray-700"><span class="font-semibold">Taxi Type:</span> Sedan</p>
                    <p class="text-gray-700"><span class="font-semibold">Status:</span>
                        <span class="px-2 sm:px-3 py-1 rounded-full text-white bg-green-500 text-xs sm:text-sm">Active</span>
                    </p>
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('public\images\4.jpg') }}"
                         alt="Taxi Image"
                         class="rounded-lg shadow-md w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-40 sm:h-48 md:h-56 object-cover">
                </div>
            </div>
        </div>

        <!-- Driver Details -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Driver Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Driver Name:</span> John Doe</p>
                <p class="text-gray-700"><span class="font-semibold">Contact Number:</span> +94 77 123 4567</p>
                <p class="text-gray-700"><span class="font-semibold">Email:</span> johndoe@gmail.com</p>
                <p class="text-gray-700"><span class="font-semibold">License Number:</span> D1234567</p>
                <p class="text-gray-700"><span class="font-semibold">Experience:</span> 5 years</p>
                <p class="text-gray-700"><span class="font-semibold">Driver Rating:</span> ⭐ 4.8 / 5</p>
            </div>
        </div>

        <!-- Taxi Performance & Revenue -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Performance & Revenue</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-blue-700">Total Revenue</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">LKR 120,000</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-green-700">Monthly Revenue</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">LKR 30,000</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-yellow-700">Total Trips</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">145</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mt-4 sm:mt-6">
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-purple-700">Customers Served</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">95</p>
                </div>
                <div class="bg-pink-50 border border-pink-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-pink-700">Average Fare</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">LKR 1,200</p>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 sm:p-5 shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-orange-700">Total Distance</h3>
                    <p class="text-lg sm:text-2xl font-bold text-gray-800 mt-1 sm:mt-2">4,500 km</p>
                </div>
            </div>
        </div>

        <!-- Taxi Usage Statistics -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Usage Statistics</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Total Bookings:</span> 180</p>
                <p class="text-gray-700"><span class="font-semibold">Completed Trips:</span> 170</p>
                <p class="text-gray-700"><span class="font-semibold">Canceled Trips:</span> 5</p>
                <p class="text-gray-700"><span class="font-semibold">Ongoing Trips:</span> 5</p>
                <p class="text-gray-700"><span class="font-semibold">Peak Booking Time:</span> Evening</p>
                <p class="text-gray-700"><span class="font-semibold">Top 3 Pickup Locations:</span> Colombo, Kandy, Negombo</p>
            </div>
        </div>

        <!-- Customer Insights -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Customer Insights</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Unique Customers:</span> 95</p>
                <p class="text-gray-700"><span class="font-semibold">Repeat Customers:</span> 40%</p>
                <p class="text-gray-700"><span class="font-semibold">Customer Rating:</span> ⭐ 4.7 / 5</p>
                <p class="text-gray-700"><span class="font-semibold">Customer Reviews:</span> 120</p>
            </div>
        </div>

        <!-- Maintenance & Vehicle Health -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Maintenance & Health</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p class="text-gray-700"><span class="font-semibold">Last Maintenance:</span> 20 Jul 2025</p>
                <p class="text-gray-700"><span class="font-semibold">Next Maintenance:</span> 10 Oct 2025</p>
                <p class="text-gray-700"><span class="font-semibold">Total Maintenance Cost:</span> LKR 15,000</p>
                <p class="text-gray-700"><span class="font-semibold">Vehicle Condition:</span> Excellent</p>
                <p class="text-gray-700"><span class="font-semibold">Insurance Expiry:</span> 15 Jan 2026</p>
                <p class="text-gray-700"><span class="font-semibold">Fitness Certificate Validity:</span> 31 Dec 2025</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4 sm:mt-6">
            <a href="{{ url('/admin/rental/taxi') }}"
               class="bg-[#1F8FB2] hover:bg-[#157799] text-white px-3 py-2 sm:px-4 sm:py-2 rounded shadow text-sm sm:text-base">
                ← Back to Taxi List
            </a>
        </div>
    </div>
</section>

@endsection
