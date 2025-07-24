@extends('frontend.admin.master')

@section('content')
<div class="space-y-6">

    <!-- Title -->
    <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6">Home Listings</h1>

    <!-- Search & Add Button Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

        <!-- Search Bar -->
        <div class="w-full sm:w-1/2 lg:w-1/3">
            <input type="text" placeholder="Search homes..."
                   class="w-full px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                   id="homeSearchInput">
        </div>

        <!-- Add New Home Button -->
        <div class="w-full sm:w-auto">
            <button class="w-full sm:w-auto bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white font-medium text-xs sm:text-sm py-1.5 px-3 rounded-md shadow transition">
                + Add New Home
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 text-[10px] font-bold sm:text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Partner Name</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Home Name</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Location</th>
                        {{-- <th class="px-2 sm:px-4 py-3 sm:py-4 font-medium">Bedrooms</th> --}}
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Main Image</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Date Added</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#101</td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Michael Brown</td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                            <div class="font-medium text-[#3CC0E9]">Central Loft</div>
                        </td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">New York, USA</td>
                        {{-- <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">2</td> --}}
                        <td class="px-2 sm:px-4 py-3 sm:py-4">
                            <img src="/images/A.jpg" alt="Central Loft" class="w-10 h-10 rounded-md object-cover">
                        </td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 24, 2025</td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1 h-1 mr-1.5 rounded-full bg-green-800"></span>
                                Available
                            </span>
                        </td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4">
                            <div class="flex items-center space-x-3">
                                <button class="text-[#3CC0E9] hover:text-[#3CC0E9]/80 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
