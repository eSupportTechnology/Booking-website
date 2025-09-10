@extends('admin.master')
@section('title', 'Home Listings')
@section('content')

<section class="min-h-screen p-3 sm:p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-4 sm:space-y-6 p-2 sm:p-4">

        <!-- Breadcrumb -->
        <nav class="flex mb-2 sm:mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 sm:space-x-2 md:space-x-3 text-xs sm:text-sm md:text-base">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 flex items-center">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-gray-500">Homes</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">Home Listings</h1>

        <!-- Search & Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
            <div class="w-full sm:w-2/3 lg:w-1/2 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <input type="text" placeholder="Search homes..."
                    class="w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]"
                    id="homeSearchInput">
                <select id="statusFilter" class="px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Rows per page selector -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
            <p class="text-xs sm:text-sm text-gray-700">Showing home listings</p>
            <select id="rowsPerPage" class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] px-2 py-1.5">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 rows</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 rows</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
            </select>
        </div>

        <!-- Table for Desktop -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-100 hidden md:block">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="homesTable">
                    <thead class="bg-gray-50 text-[10px] font-bold sm:text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Partner</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Apartment</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Location</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Image</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Date Added</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th>
                            {{-- <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                        @forelse($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3">#{{ $property->id }}</td>
                            <td class="px-2 sm:px-4 py-3">{{ $property->partnerName }}</td>
                            <td class="px-2 sm:px-4 py-3 text-[#3CC0E9] font-medium">{{ $property->title }}</td>
                            <td class="px-2 sm:px-4 py-3">{{ $property->location }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                @if($property->primaryImage)
                                    <img src="{{ asset('storage/' . $property->primaryImage) }}" class="w-10 h-10 rounded-md object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3">{{ $property->createdAt }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                <div class="relative">
                                    <select onchange="handleStatusChange(this, '{{ $property->id }}')"
                                            class="appearance-none {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9] transition"
                                            data-original-value="{{ $property->status === 'suspended' ? 'inactive' : $property->status }}">
                                        <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="inactive" {{ $property->status === 'suspended' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full status-dot {{ $property->status === 'active' ? 'bg-green-800' : ($property->status === 'pending' ? 'bg-yellow-800' : 'bg-red-800') }}"></span>
                                </div>
                            </td>
                            {{-- <td class="px-2 sm:px-4 py-3 flex space-x-2 sm:pt-6">
                                <button class="text-[#3CC0E9] text-xs">Edit</button>
                                <button class="text-red-600 text-xs">Delete</button>
                            </td> --}}


                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">No homes found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $pagination->links() }}
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-3">
            @forelse($properties as $property)
            <div class="bg-gray-50 rounded-lg shadow p-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-900">#{{ $property->id }} - {{ $property->title }}</span>
                    <select onchange="handleStatusChange(this, '{{ $property->id }}')"
                        class="appearance-none {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} rounded-full px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-[#3CC0E9]">
                        <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ $property->status === 'suspended' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="flex gap-3 mt-2">
                    @if($property->primaryImage)
                        <img src="{{ asset('storage/' . $property->primaryImage) }}" class="w-16 h-16 rounded-md object-cover">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xs">No Image</div>
                    @endif
                    <div class="flex flex-col text-xs">
                        <span class="text-gray-700">Partner: {{ $property->partnerName }}</span>
                        <span class="text-gray-700">Location: {{ $property->location }}</span>
                        <span class="text-gray-700">Date: {{ $property->createdAt }}</span>
                    </div>
                </div>
                <div class="flex space-x-3 mt-3">
                    <button class="text-[#3CC0E9] text-xs">Edit</button>
                    <button class="text-red-600 text-xs">Delete</button>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 text-xs">No homes found.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- serach JS -->
<script>
    // Status change handler
    function handleStatusChange(selectEl, id) {
        const originalValue = selectEl.dataset.originalValue;
        const value = selectEl.value;
        const wrapper = selectEl.parentElement;
        const dot = wrapper.querySelector('.status-dot');

        // Show loading state
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        // Make AJAX request to update status
        fetch(`/admin/status/property/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                status: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update visual elements
                updateStatusStyling(selectEl, dot, value);

                // Show success notification
                showNotification('success', data.message);

                // Update dataset
                selectEl.dataset.originalValue = value;
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', error.message || 'Failed to update status. Please try again.');

            // Revert to original value
            selectEl.value = originalValue;
        })
        .finally(() => {
            // Re-enable select
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    }

    function updateStatusStyling(selectEl, dot, value) {
        // Reset classes
        selectEl.className = 'appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-0.5 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#3CC0E9]';
        dot.className = 'absolute top-1/2 left-2 -translate-y-1/2 w-1.5 h-1.5 rounded-full status-dot';

        // Apply styling based on status
        switch (value) {
            case 'active':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                dot.classList.add('bg-green-800');
                break;
            case 'pending':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                dot.classList.add('bg-yellow-800');
                break;
            case 'inactive':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                dot.classList.add('bg-red-800');
                break;
        }

        // Store current value as original for potential revert
        selectEl.setAttribute('data-original-value', value);
    }

    function showNotification(type, message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;

        // Add to page
        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('homeSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('homesTable');
        const rows = table.querySelectorAll('tbody tr');

        // Initialize original values on page load
        document.querySelectorAll('select[onchange*="handleStatusChange"]').forEach(select => {
            select.setAttribute('data-original-value', select.value);
        });

        function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();
    const statusTerm = statusFilter.value.toLowerCase();

    // Desktop table rows
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

    // Mobile card view
    const mobileCards = document.querySelectorAll('.md\\:hidden .bg-gray-50');
    mobileCards.forEach(card => {
        const title = card.querySelector('span').textContent.toLowerCase();
        const partner = card.querySelector('span.text-gray-700')?.textContent.toLowerCase() || '';
        const location = card.querySelector('span.text-gray-700:nth-child(2)')?.textContent.toLowerCase() || '';
        const date = card.querySelector('span.text-gray-700:nth-child(3)')?.textContent.toLowerCase() || '';
        const statusSelect = card.querySelector('select');
        const status = statusSelect ? statusSelect.value.toLowerCase() : '';

        const matchesSearch = title.includes(searchTerm) ||
            partner.includes(searchTerm) ||
            location.includes(searchTerm) ||
            date.includes(searchTerm) ||
            status.includes(searchTerm);

        const matchesStatus = !statusTerm || status === statusTerm;

        card.style.display = matchesSearch && matchesStatus ? '' : 'none';
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
