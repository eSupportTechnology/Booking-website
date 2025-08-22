@extends('admin.master')
@section('title', 'Apartment Listings')
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
                        <span class="text-gray-500">Apartments</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6">Apartment Listings</h1>

        <!-- Search & Add Button Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

            <!-- Search and Filter Section -->
            <div class="w-full sm:w-2/3 lg:w-2/3 flex gap-3">
                <input type="text" placeholder="Search Apartments..."
                    class="w-full px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                    id="apartmentSearchInput">
                <select id="statusFilter" class="px-3 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="Available">Available</option>
                    <option value="Pending">Pending</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>

            <!-- Add New Apartment Button -->
            <div class="w-full sm:w-auto">
                <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white font-medium text-xs sm:text-sm py-1.5 px-3 rounded-md shadow transition inline-block text-center">
                    + Add New Apartment
                </a>
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

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="apartmentsTable"> {{-- ADDED ID HERE --}}
                    <thead class="bg-gray-50 text-[10px] font-bold sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Partner Name</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Apartment Name</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Location</th>
                            {{-- <th class="px-2 sm:px-4 py-3 sm:py-4 font-medium">Bedrooms</th> --}}
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Main Image</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Date Added</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                        @forelse($apartments as $apartment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#{{ $apartment->id }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $apartment->partner->name ?? 'N/A' }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                <div class="font-medium text-[#3CC0E9]">{{ $apartment->name }}</div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $apartment->address }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                @if($apartment->photos->isNotEmpty())
                                    <img src="{{ $apartment->photos->first()->url }}" alt="{{ $apartment->name }}" class="w-10 h-10 rounded-md object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">{{ $apartment->created_at->format('M d, Y') }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '{{ $apartment->id }}')"
                                            class="appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition
                                            {{ $apartment->status === 'Available' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $apartment->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $apartment->status === 'Unavailable' ? 'bg-red-100 text-red-800' : '' }}">
                                        <option value="Available" {{ $apartment->status === 'Available' ? 'selected' : '' }} class="bg-green-100 text-green-800">Available</option>
                                        <option value="Pending" {{ $apartment->status === 'Pending' ? 'selected' : '' }} class="bg-yellow-100 text-yellow-800">Pending</option>
                                        <option value="Unavailable" {{ $apartment->status === 'Unavailable' ? 'selected' : '' }} class="bg-red-100 text-red-800">Unavailable</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full status-dot
                                        {{ $apartment->status === 'Available' ? 'bg-green-800' : '' }}
                                        {{ $apartment->status === 'Pending' ? 'bg-yellow-800' : '' }}
                                        {{ $apartment->status === 'Unavailable' ? 'bg-red-800' : '' }}">
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.properties.review', $apartment->id) }}" class="text-[#3CC0E9] hover:text-[#3CC0E9]/80 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button onclick="deleteProperty({{ $apartment->id }})" class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium inline-flex items-center">
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
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                No apartments found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($apartments->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $apartments->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium rounded-md text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if ($apartments->hasMorePages())
                        <a href="{{ $apartments->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium rounded-md text-white bg-[#3CC0E9] hover:bg-[#3CC0E9]/80">
                            Next
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Next
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs text-gray-700">
                            Showing
                            <span class="font-medium">{{ $apartments->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $apartments->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $apartments->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        {{ $apartments->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
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

        // Update status via AJAX
        fetch(`/admin/properties/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Apply styling after successful update
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
            } else {
                // Reset to previous value if update failed
                alert('Failed to update status. Please try again.');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update status. Please try again.');
            location.reload();
        });
    }

    function deleteProperty(id) {
        if (confirm('Are you sure you want to delete this property?')) {
            fetch(`/admin/properties/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to delete property. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete property. Please try again.');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        let typingTimer;
        const doneTypingInterval = 500;
        const searchInput = document.getElementById('apartmentSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const tbody = document.querySelector('#apartmentsTable tbody');

        function performSearch() {
            const searchTerm = searchInput.value.trim();
            const status = statusFilter.value;

            // Add loading state
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        <svg class="animate-spin h-5 w-5 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Searching...
                    </td>
                </tr>
            `;

            fetch(`/admin/properties/search?search=${searchTerm}&status=${status}&type=apartment`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const apartments = data.data;

                        if (apartments.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                        No apartments found matching your criteria
                                    </td>
                                </tr>
                            `;
                            return;
                        }

                        tbody.innerHTML = apartments.map(apt => `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#${apt.id}</td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">${apt.partner.name || 'N/A'}</td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">
                                    <div class="font-medium text-[#3CC0E9]">${apt.name}</div>
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">${apt.address}</td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4">
                                    ${apt.photos.length > 0 ?
                                        `<img src="${apt.photos[0].url}" alt="${apt.name}" class="w-10 h-10 rounded-md object-cover">` :
                                        `<div class="w-10 h-10 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>`
                                    }
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 text-gray-700">${new Date(apt.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4">
                                    <div class="relative">
                                        <select onchange="handleStatusChange(this, '${apt.id}')"
                                                class="appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition
                                                ${apt.status === 'Available' ? 'bg-green-100 text-green-800' : ''}
                                                ${apt.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : ''}
                                                ${apt.status === 'Unavailable' ? 'bg-red-100 text-red-800' : ''}">
                                            <option value="Available" ${apt.status === 'Available' ? 'selected' : ''} class="bg-green-100 text-green-800">Available</option>
                                            <option value="Pending" ${apt.status === 'Pending' ? 'selected' : ''} class="bg-yellow-100 text-yellow-800">Pending</option>
                                            <option value="Unavailable" ${apt.status === 'Unavailable' ? 'selected' : ''} class="bg-red-100 text-red-800">Unavailable</option>
                                        </select>
                                        <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full status-dot
                                            ${apt.status === 'Available' ? 'bg-green-800' : ''}
                                            ${apt.status === 'Pending' ? 'bg-yellow-800' : ''}
                                            ${apt.status === 'Unavailable' ? 'bg-red-800' : ''}">
                                        </span>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="/admin/properties/review/${apt.id}" class="text-[#3CC0E9] hover:text-[#3CC0E9]/80 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <button onclick="deleteProperty(${apt.id})" class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `).join('');
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    Error loading apartments
                                </td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                Error loading apartments
                            </td>
                        </tr>
                    `;
                });
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });

        statusFilter.addEventListener('change', performSearch);
    });
</script>

@endsection
