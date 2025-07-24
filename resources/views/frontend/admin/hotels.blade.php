@extends('frontend.admin.master')
@section('title', 'Hotel Listings')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">

    <div class="space-y-6 p-4">

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6">Hotel Listings</h1>

        <!-- Search & Add Button Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

            <!-- Search Bar -->
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <input type="text" placeholder="Search hotels..."
                    class="w-full px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                    id="hotelSearchInput">
            </div>

            <!-- Add New Hotel Button -->
            <div class="w-full sm:w-auto">
                <button class="w-full sm:w-auto bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white font-medium text-xs sm:text-sm py-1.5 px-3 rounded-md shadow transition">
                    + Add New Hotel
                </button>
            </div>
        </div>

        <!-- Rows per page selector -->
        <div class="flex justify-end mb-4">
            <select class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] px-2 py-1.5">
                <option value="10">10 rows</option>
                <option value="20">20 rows</option>
                <option value="30">30 rows</option>
                <option value="50">50 rows</option>
            </select>
        </div>

        <!-- Table Wrapper -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="hotelsTable"> {{-- ADDED ID HERE --}}
                    <thead class="bg-gray-50 text-[10px] font-bold sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Partner Name</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Hotel Name</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Location</th>
                            {{-- <th class="px-2 sm:px-4 py-3 sm:py-4 font-medium">Bedrooms</th> --}}
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Main Image</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Date Added</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                        {{-- Dummy Data for Hotels --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#201</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Global Stays Inc.</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">Grand Hyatt New York</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">New York, USA</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <img src="https://placehold.co/40x40/E0E0E0/333333?text=Hotel1" alt="Grand Hyatt" class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 22, 2025</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1 h-1 mr-1.5 rounded-full bg-green-800"></span>
                                    Active
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
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#202</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Travel Corp</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">The Plaza Hotel</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">London, UK</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <img src="https://placehold.co/40x40/D0D0D0/444444?text=Hotel2" alt="The Plaza" class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 19, 2025</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1 h-1 mr-1.5 rounded-full bg-red-800"></span>
                                    Inactive
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
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#203</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Luxury Resorts LLC</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">Beachfront Paradise</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Maldives</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <img src="https://placehold.co/40x40/B0B0B0/555555?text=Hotel3" alt="Beachfront Paradise" class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 15, 2025</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <span class="w-1 h-1 mr-1.5 rounded-full bg-yellow-800"></span>
                                    Pending
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

            <!-- Pagination -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button class="relative inline-flex items-center px-4 py-2 text-xs font-medium rounded-md text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                        Previous
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 text-xs font-medium rounded-md text-white bg-[#3CC0E9] hover:bg-[#3CC0E9]/80">
                        Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs text-gray-700">
                            Showing
                            <span class="font-medium">1</span>
                            to
                            <span class="font-medium">10</span>
                            of
                            <span class="font-medium">20</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-xs font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50">
                                1
                            </button>
                            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-[#3CC0E9] text-xs font-medium text-white hover:bg-[#3CC0E9]/80">
                                2
                            </button>
                            <button class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50">
                                3
                            </button>
                            <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-xs font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('hotelSearchInput');
        const table = document.getElementById('hotelsTable'); // Corrected: Added ID to the table
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function(event) {
            const searchTerm = event.target.value.toLowerCase();

            rows.forEach(row => {
                // Get text content from relevant cells for searching
                // Corrected indices based on the table structure for Hotel Listings
                const id = row.children[0].textContent.toLowerCase(); // ID (#201)
                const partnerName = row.children[1].textContent.toLowerCase(); // Partner Name (Global Stays Inc.)
                const hotelName = row.children[2].textContent.toLowerCase(); // Hotel Name (Grand Hyatt New York)
                const location = row.children[3].textContent.toLowerCase(); // Location (New York, USA)
                const dateAdded = row.children[5].textContent.toLowerCase(); // Date Added (Jul 22, 2025)
                const status = row.children[6].textContent.toLowerCase(); // Status (Active, Inactive, Pending)

                if (id.includes(searchTerm) ||
                    partnerName.includes(searchTerm) ||
                    hotelName.includes(searchTerm) ||
                    location.includes(searchTerm) ||
                    dateAdded.includes(searchTerm) ||
                    status.includes(searchTerm)) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        });
    });
</script>
@endsection
