@extends('admin.master')
@section('title', 'Apartment Listings')
@section('content')

<section class="min-h-screen p-3 sm:p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-4 sm:space-y-6 p-2 sm:p-4">

       <!-- Breadcrumb -->
<nav class="flex mb-2 sm:mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs sm:text-sm md:text-base">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 flex items-center">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                <span class="text-gray-500">Apartments</span>
            </div>
        </li>
    </ol>
</nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">Apartment Listings</h1>

        <!-- Search & Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3 w-full">
            <div class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2">
                <input type="text" id="apartmentSearchInput" placeholder="Search Apartments..."
                    class="w-full px-2 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]">
                <select id="statusFilter"
                    class="px-2 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Rows per page selector -->
        <div class="flex justify-end mb-2 sm:mb-4">
            <select id="rowsPerPage" class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] px-2 py-1">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 rows</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 rows</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
            </select>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left text-gray-700" id="apartmentsTable">
                    <thead class="bg-gray-50 text-[10px] sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">ID</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Partner</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Apartment</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Location</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Image</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Date</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Status</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-2 sm:py-3 font-medium">#{{ $property->id }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 truncate max-w-[90px]">{{ $property->partnerName }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 text-[#3CC0E9] font-medium truncate max-w-[120px]">{{ $property->title }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 truncate max-w-[90px]">{{ $property->location }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3">
                                @if($property->primaryImage)
                                    <img src="{{ asset('storage/' . $property->primaryImage) }}" alt="{{ $property->title }}"
                                         class="w-8 h-8 sm:w-10 sm:h-10 rounded-md object-cover">
                                @else
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-[10px]">N/A</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $property->createdAt }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '{{ $property->id }}')"
                                        class="appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-5 pr-3 py-0.5 focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] transition
                                        {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}"
                                        data-original-value="{{ $property->status }}">
                                        <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="inactive" {{ $property->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <span class="absolute top-1/2 left-1.5 -translate-y-1/2 w-1.5 h-1.5 rounded-full {{ $property->status === 'active' ? 'bg-green-800' : ($property->status === 'pending' ? 'bg-yellow-800' : 'bg-red-800') }}"></span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 flex items-center space-x-2">
                                <button class="text-[#3CC0E9] hover:text-[#3CC0E9]/80 text-[10px] sm:text-xs font-medium flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-2 sm:px-4 py-4 text-center text-gray-500 text-xs">
                                No apartments found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-3 py-2 border-t border-gray-200">
                {{ $pagination->links() }}
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPageSelect = document.getElementById('rowsPerPage');
        const searchInput = document.getElementById('apartmentSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('apartmentsTable');
        const rows = table.querySelectorAll('tbody tr');

        rowsPerPageSelect.addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const id = row.children[0]?.textContent.toLowerCase() || '';
                const partnerName = row.children[1]?.textContent.toLowerCase() || '';
                const apartmentName = row.children[2]?.textContent.toLowerCase() || '';
                const location = row.children[3]?.textContent.toLowerCase() || '';
                const statusSelect = row.children[6]?.querySelector('select');
                const status = statusSelect ? statusSelect.value.toLowerCase() : '';

                const matchesSearch = id.includes(searchTerm) || partnerName.includes(searchTerm) || apartmentName.includes(searchTerm) || location.includes(searchTerm);
                const matchesStatus = !statusTerm || status === statusTerm;

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>

@endsection
