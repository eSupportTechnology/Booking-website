@extends('admin.master')
@section('title', 'Alternative Places Listings')
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
                        <span class="text-gray-500">Alternative Places</span>
                    </div>
                </li>
            </ol>
        </nav>
        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6">Alternative Places Listings</h1>

        <!-- Search & Add Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

            <!-- Search and Filter Section -->
            <div class="w-full sm:w-2/3 lg:w-2/3 flex gap-3">
                <input type="text" placeholder="Search alternative places..."
                    class="w-full px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                    id="alternativePlaceSearchInput">
                <select id="statusFilter" class="px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="Available">Available</option>
                    <option value="Pending">Pending</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>
        </div>

        <!-- Rows per page selector -->
        <div class="flex justify-end mb-4">
            <select id="rowsPerPage" class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] px-2 py-1.5">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 rows</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 rows</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
            </select>
        </div>

        <!-- Listings Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="alternativePlacesTable"> {{-- ADDED ID HERE --}}
                    <thead class="bg-gray-50 text-[10px] font-bold sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Partner Name</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Place Name</th> {{-- This is column 2 (index 2) --}}
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Location</th> {{-- This is column 3 (index 3) --}}
                            {{-- <th class="px-2 sm:px-4 py-3 sm:py-4 font-medium">Bedrooms</th> --}}
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Main Image</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Date Added</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th> {{-- This is column 6 (index 6) --}}
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                        @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#{{ $property->id }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $property->partnerName }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">{{ $property->title }}</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $property->location }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                @if($property->primaryImage)
                                    <img src="{{ asset('storage/' . $property->primaryImage) }}" alt="{{ $property->title }}" class="w-10 h-10 rounded-md object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-md bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $property->createdAt }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '{{ $property->id }}')"
                                            class="appearance-none {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition">
                                        <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="inactive" {{ $property->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full {{ $property->status === 'active' ? 'bg-green-800' : ($property->status === 'pending' ? 'bg-yellow-800' : 'bg-red-800') }} pointer-events-none status-dot"></span>
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
                        @empty
                        <tr>
                            <td colspan="8" class="px-2 sm:px-4 py-8 text-center text-gray-500">
                                No alternative places found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3  border-t border-gray-200">
                {{ $pagination->links() }}
            </div>
        </div>
    </div>
</section>


<!-- serach JS -->
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
        const searchInput = document.getElementById('alternativePlaceSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('alternativePlacesTable');
        const rows = table.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const id = row.children[0].textContent.toLowerCase();
                const partnerName = row.children[1].textContent.toLowerCase();
                const placeName = row.children[2].querySelector('.font-medium')?.textContent.toLowerCase() || '';
                const location = row.children[3].textContent.toLowerCase();
                const statusSelect = row.children[6].querySelector('select');
                const status = statusSelect ? statusSelect.value.toLowerCase() : '';

                const matchesSearch = id.includes(searchTerm) ||
                    partnerName.includes(searchTerm) ||
                    placeName.includes(searchTerm) ||
                    location.includes(searchTerm) ||
                    status.includes(searchTerm);

                const matchesStatus = !statusTerm || status === statusTerm;

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Handle "Rows per page" change
        const rowsPerPageSelect = document.getElementById('rowsPerPage');
        rowsPerPageSelect?.addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    });
</script>

@endsection
