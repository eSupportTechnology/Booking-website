@extends('admin.master')
@section('title', 'Home Listings')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-4">

        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Homes</span>
                    </div>
                </li>
            </ol>
        </nav>
        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6">Home Listings</h1>

        <!-- Search & Add Button Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

            <!-- Search and Filter Section -->
            <div class="w-full sm:w-2/3 lg:w-2/3 flex gap-3">
                <input type="text" placeholder="Search homes..."
                    class="w-full px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                    id="homeSearchInput">
                <select id="statusFilter" class="px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="Available">Available</option>
                    <option value="Pending">Pending</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>

            <!-- Add New Home Button -->
            <div class="w-full sm:w-auto">
                <button class="w-full sm:w-auto bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white font-medium text-xs sm:text-sm py-1.5 px-3 rounded-md shadow transition">
                    + Add New Home
                </button>
            </div>
        </div>

        <!-- Results info and Rows per page selector -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mb-4">
            <div>
                <p class="text-xs text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium" id="currentRowsDisplayed">10</span> of <span class="font-medium" id="totalRows">20</span> results
                </p>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-xs text-gray-600">Rows per page:</label>
                <select id="rowsPerPageSelect" class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] px-2 py-1.5">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="homesTable"> {{-- ADDED ID HERE --}}
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
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jane Doe</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">Forest Cabin</div> {{-- Place Name --}}
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Mountain Retreat, CO</td> {{-- Location --}}
                            {{-- <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">2</td> --}}
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <img src="/images/A.jpg" alt="Forest Cabin" class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 24, 2025</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '101')" {{-- Replace '101' with dynamic ID --}}
                                            class="appearance-none bg-green-100 text-green-800 font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition">
                                        <option value="Available" selected class="bg-green-100 text-green-800">Available</option>
                                        <option value="Pending" class="bg-yellow-100 text-yellow-800">Pending</option>
                                        <option value="Unavailable" class="bg-red-100 text-red-800">Unavailable</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-green-800 pointer-events-none status-dot"></span>
                                </div>
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
                        {{-- Add more rows for testing search --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#102</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Traveler's Nook</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">Desert Glamping</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Mojave, CA</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <img src="https://placehold.co/40x40/FF0000/FFFFFF?text=B" alt="Desert Glamping" class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">Jul 20, 2025</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '101')" {{-- Replace '101' with dynamic ID --}}
                                            class="appearance-none bg-green-100 text-green-800 font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition">
                                        <option value="Available" selected class="bg-green-100 text-green-800">Available</option>
                                        <option value="Pending" class="bg-yellow-100 text-yellow-800">Pending</option>
                                        <option value="Unavailable" class="bg-red-100 text-red-800">Unavailable</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-green-800 pointer-events-none status-dot"></span>
                                </div>
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
                    <button id="prevButtonMobile" class="relative inline-flex items-center px-4 py-2 text-xs font-medium rounded-md text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
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
    // Status change handler
    function handleStatusChange(selectEl, id) {
        const value = selectEl.value;
        const wrapper = selectEl.parentElement;
        const dot = wrapper.querySelector('.status-dot');

        // Reset classes
        selectEl.className = 'appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9]';
        dot.className = 'absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full status-dot';

        // Apply styling
        switch (value) {
            case 'Available':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                dot.classList.add('bg-green-800');
                break;
            case 'Pending':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                dot.classList.add('bg-yellow-800');
                break;
            case 'Unavailable':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                dot.classList.add('bg-red-800');
                break;
        }

        // Optional: Save via AJAX
        console.log(`Changed status of ID ${id} to ${value}`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize status selects
        document.querySelectorAll('select[onchange^="handleStatusChange"]').forEach(select => {
            handleStatusChange(select, select.getAttribute('onchange').split(',')[1]?.replace(/[^0-9]/g, ''));
        });

        const searchInput = document.getElementById('homeSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('homesTable');
        const rows = table.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const id = row.children[0]?.textContent.toLowerCase() || '';
                const partnerName = row.children[1]?.textContent.toLowerCase() || '';
                const homeNameEl = row.children[2]?.querySelector('.font-medium');
                const homeName = homeNameEl ? homeNameEl.textContent.toLowerCase() : '';
                const location = row.children[3]?.textContent.toLowerCase() || '';
                const statusSelect = row.children[6]?.querySelector('select');
                const status = statusSelect ? statusSelect.value.toLowerCase() : '';

                const matchesSearch = searchTerm === '' ||
                    id.includes(searchTerm) ||
                    partnerName.includes(searchTerm) ||
                    homeName.includes(searchTerm) ||
                    location.includes(searchTerm);

                const matchesStatus = !statusTerm || status === statusTerm;

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Pagination and Rows per page logic (optional, but good to include if present)
        const rowsPerPageSelect = document.getElementById('rowsPerPageSelect');
        const totalRowsSpan = document.getElementById('totalRows');
        const currentRowsDisplayedSpan = document.getElementById('currentRowsDisplayed');
        const allRows = Array.from(table.querySelectorAll('tbody tr')); // Get all rows for pagination

        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);

        function displayRows(page, perPage) {
            const start = (page - 1) * perPage;
            const end = start + perPage;

            allRows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update "Showing X to Y of Z results" text
            const visibleRowsCount = Math.min(end, allRows.length);
            currentRowsDisplayedSpan.textContent = `${start + 1} to ${visibleRowsCount}`;
            totalRowsSpan.textContent = allRows.length;
        }

        // Initial display
        displayRows(currentPage, rowsPerPage);

        rowsPerPageSelect.addEventListener('change', function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1; // Reset to first page when rows per page changes
            displayRows(currentPage, rowsPerPage);
        });

        // Add event listeners for pagination buttons if you implement them
        // Example for previous/next buttons (you'd need to add IDs to them)
        // document.getElementById('prevButton').addEventListener('click', function() {
        //     if (currentPage > 1) {
        //         currentPage--;
        //         displayRows(currentPage, rowsPerPage);
        //     }
        // });
        // document.getElementById('nextButton').addEventListener('click', function() {
        //     if (currentPage * rowsPerPage < allRows.length) {
        //         currentPage++;
        //         displayRows(currentPage, rowsPerPage);
        //     }
        // });
    });
</script>
@endsection
