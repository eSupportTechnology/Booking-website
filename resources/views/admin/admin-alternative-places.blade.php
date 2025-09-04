@extends('admin.master')
@section('title', 'Alternative Places Listings')
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
                        <span class="text-gray-500">Alternative Places</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">Alternative Places Listings</h1>

        <!-- Search & Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3 w-full">
            <div class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2">
                <input type="text" id="alternativePlaceSearchInput" placeholder="Search Alternative Places..."
                    class="w-full px-2 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]">
                <select id="statusFilter"
                    class="px-2 py-1.5 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="pending">Pending</option>
                    <option value="unavailable">Unavailable</option>
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

        <!-- Desktop / Tablet Table -->
        <div class="hidden sm:block bg-white rounded-lg shadow-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left text-gray-700" id="alternativePlacesTable">
                    <thead class="bg-gray-50 text-[10px] sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">ID</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Partner</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Place</th>
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
                                        {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}"
                                        data-original-value="{{ $property->status }}">
                                        <option value="available" {{ $property->status === 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="unavailable" {{ $property->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                    <span class="absolute top-1/2 left-1.5 -translate-y-1/2 w-1.5 h-1.5 rounded-full {{ $property->status === 'available' ? 'bg-green-800' : ($property->status === 'pending' ? 'bg-yellow-800' : 'bg-red-800') }}"></span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 flex items-center space-x-2">
                                <button class="text-[#3CC0E9] hover:text-[#3CC0E9]/80 text-[10px] sm:text-xs font-medium flex items-center">Edit</button>
                                <button class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium flex items-center">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-2 sm:px-4 py-4 text-center text-gray-500 text-xs">
                                No alternative places found.
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

        <!-- Mobile Cards -->
        <div class="sm:hidden grid grid-cols-1 gap-4">
            @forelse($properties as $property)
            <div class="bg-white border rounded-lg shadow p-4 space-y-2">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-base sm:text-lg truncate">{{ $property->title }}</h3>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $property->status === 'available' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-600"><strong>ID:</strong> #{{ $property->id }}</p>
                <p class="text-sm text-gray-600"><strong>Partner:</strong> {{ $property->partnerName }}</p>
                <p class="text-sm text-gray-600"><strong>Location:</strong> {{ $property->location }}</p>
                <div class="w-full h-32 sm:h-40 rounded-md overflow-hidden">
                    @if($property->primaryImage)
                        <img src="{{ asset('storage/' . $property->primaryImage) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-xs">No Image</div>
                    @endif
                </div>
                <p class="text-sm text-gray-600"><strong>Created:</strong> {{ $property->createdAt }}</p>
                <div class="flex space-x-2 pt-2">
                    <button class="flex-1 bg-[#3CC0E9] hover:bg-[#33aad1] text-white px-3 py-1.5 rounded text-xs sm:text-sm">Edit</button>
                    <button class="flex-1 bg-red-600 hover:bg-red-800 text-white px-3 py-1.5 rounded text-xs sm:text-sm">Delete</button>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 col-span-1">No alternative places found.</p>
            @endforelse
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const searchInput = document.getElementById('alternativePlaceSearchInput');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('alternativePlacesTable');
    const rows = table.querySelectorAll('tbody tr');

    // Initialize original values for status selects
    document.querySelectorAll('select[onchange*="handleStatusChange"]').forEach(select => {
        select.setAttribute('data-original-value', select.value);
    });

    // Handle Rows per page change
    rowsPerPageSelect.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Handle status change via AJAX
    window.handleStatusChange = function(selectEl, id) {
        const value = selectEl.value;
        const wrapper = selectEl.parentElement;
        const dot = wrapper.querySelector('span');

        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        fetch(`/admin/status/alternative-place/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatusStyling(selectEl, dot, value);
                showNotification('success', data.message);
            } else {
                selectEl.value = selectEl.getAttribute('data-original-value') || 'pending';
                showNotification('error', data.message || 'Failed to update status');
            }
        })
        .catch(() => {
            selectEl.value = selectEl.getAttribute('data-original-value') || 'pending';
            showNotification('error', 'Failed to update status. Please try again.');
        })
        .finally(() => {
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    }

    function updateStatusStyling(selectEl, dot, value) {
        selectEl.className = 'appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-5 pr-3 py-0.5 focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] transition';
        dot.className = 'absolute top-1/2 left-1.5 -translate-y-1/2 w-1.5 h-1.5 rounded-full';

        switch (value) {
            case 'available':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                dot.classList.add('bg-green-800');
                break;
            case 'pending':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                dot.classList.add('bg-yellow-800');
                break;
            case 'unavailable':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                dot.classList.add('bg-red-800');
                break;
        }

        selectEl.setAttribute('data-original-value', value);
    }

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }

    // Filter function for table and mobile cards
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value.toLowerCase();

        // Desktop table rows
        rows.forEach(row => {
            const id = row.children[0]?.textContent.toLowerCase() || '';
            const partnerName = row.children[1]?.textContent.toLowerCase() || '';
            const placeName = row.children[2]?.textContent.toLowerCase() || '';
            const location = row.children[3]?.textContent.toLowerCase() || '';
            const statusSelect = row.children[6]?.querySelector('select');
            const status = statusSelect ? statusSelect.value.toLowerCase() : '';

            const matchesSearch = id.includes(searchTerm) || partnerName.includes(searchTerm) || placeName.includes(searchTerm) || location.includes(searchTerm);
            const matchesStatus = !statusTerm || status === statusTerm;

            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });

        // Mobile card view
        const mobileCards = document.querySelectorAll('.sm\\:hidden .bg-white');
        mobileCards.forEach(card => {
            const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
            const partner = card.querySelector('p:nth-of-type(2)')?.textContent.toLowerCase() || '';
            const location = card.querySelector('p:nth-of-type(3)')?.textContent.toLowerCase() || '';
            const statusSpan = card.querySelector('span');
            const status = statusSpan ? statusSpan.textContent.toLowerCase() : '';

            const matchesSearch = title.includes(searchTerm) || partner.includes(searchTerm) || location.includes(searchTerm);
            const matchesStatus = !statusTerm || status === statusTerm;

            card.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>

@endsection