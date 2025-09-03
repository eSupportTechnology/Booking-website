@extends('admin.master')

@section('content')
<div class="p-4 sm:p-6 bg-white rounded shadow space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-3 sm:mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 sm:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 text-sm sm:text-base">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500 text-sm sm:text-base">Customers</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Title -->
    <h2 class="text-xl sm:text-2xl font-semibold text-[#1F8FB2]">Customers</h2>

    <!-- Search & Filters -->
    <div class="flex flex-col lg:flex-row justify-between items-stretch gap-3 lg:gap-6">
        <div class="flex flex-col sm:flex-row gap-3 flex-grow max-w-full lg:max-w-2xl">
            <input
                type="text"
                placeholder="Search by name or email"
                class="flex-grow border border-gray-300 rounded px-3 py-2 sm:px-4 sm:py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                id="customerSearchInput"
                value="{{ $search ?? '' }}"
            />

            <select id="statusFilter" class="border border-gray-300 rounded px-3 py-2 sm:px-4 sm:py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                <option value="">All Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button id="searchButton" class="bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">
                Search
            </button>
        </div>

        <!-- Rows per page selector -->
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Rows:</label>
            <select id="rowsPerPage" class="text-sm border border-gray-300 rounded px-2 py-1">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>
    </div>

    <!-- Desktop / Tablet Table -->
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-[#E6F7FC] text-[#1F8FB2]">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Name</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Email</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Phone</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Registration Date</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-sm sm:text-base">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 sm:px-6 py-4 font-medium">{{ $customer['displayName'] ?? $customer['name'] }}</td>
                    <td class="px-4 sm:px-6 py-4">{{ $customer['email'] }}</td>
                    <td class="px-4 sm:px-6 py-4">{{ $customer['phone'] ?? 'Not provided' }}</td>
                    <td class="px-4 sm:px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($customer['status'] === 'active') bg-green-100 text-green-800
                            @elseif($customer['status'] === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($customer['status']) }}
                        </span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">{{ $customer['registrationDate'] }}</td>
                    <td class="px-4 sm:px-6 py-4">
                        <a href="{{ route('admin.customers.view', ['id' => $customer['id']]) }}"
                           class="text-[#1F8FB2] hover:text-[#157799] flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            <span>View</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        No customers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="sm:hidden grid grid-cols-1 gap-4">
        @forelse($customers as $customer)
        <div class="bg-white border rounded-lg shadow p-4 space-y-2">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg">{{ $customer['displayName'] ?? $customer['name'] }}</h3>
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    @if($customer['status'] === 'active') bg-green-100 text-green-800
                    @elseif($customer['status'] === 'pending') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($customer['status']) }}
                </span>
            </div>
            <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $customer['email'] }}</p>
            <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ $customer['phone'] ?? 'Not provided' }}</p>
            <p class="text-sm text-gray-600"><strong>Registered:</strong> {{ $customer['registrationDate'] }}</p>
            <div class="pt-2">
                <a href="{{ route('admin.customers.view', ['id' => $customer['id']]) }}"
                   class="inline-flex items-center bg-[#1F8FB2] hover:bg-[#157799] text-white px-3 py-1.5 rounded-lg text-xs">
                    <i class="fas fa-eye mr-1"></i> View Details
                </a>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 col-span-1">No customers found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="px-2 sm:px-4 py-3 border-t border-gray-200">
        {{ $pagination->links() }}
    </div>
</div>

<!-- Keep Your Original JS As Is -->
 <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('customerSearchInput');
    const statusFilter = document.getElementById('statusFilter');
    const searchButton = document.getElementById('searchButton');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');

    // Handle search
    function performSearch() {
        const url = new URL(window.location.href);
        const search = searchInput.value.trim();
        const status = statusFilter.value;

        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }

        url.searchParams.delete('page'); // Reset pagination
        window.location.href = url.toString();
    }

    // Search button click
    searchButton.addEventListener('click', performSearch);

    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Status filter change
    statusFilter.addEventListener('change', performSearch);

    // Handle "Rows per page" change
    rowsPerPageSelect.addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('per_page', this.value);
        } else {
            url.searchParams.delete('per_page');
        }
        url.searchParams.delete('page'); // Reset pagination
        window.location.href = url.toString();
    });

    // Customer status change handler
    window.handleCustomerStatusChange = function(selectEl, userId) {
        const value = selectEl.value;
        const originalValue = selectEl.getAttribute('data-original-value');

        // Show loading state
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        // Make AJAX request to update status
        fetch(`/admin/status/customer/${userId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI styling
                updateCustomerStatusStyling(selectEl, value);

                // Show success message
                showNotification('success', data.message);

                // Update original value
                selectEl.setAttribute('data-original-value', value);
            } else {
                // Revert selection on error
                selectEl.value = originalValue;
                showNotification('error', data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error updating customer status:', error);
            // Revert selection on error
            selectEl.value = originalValue;
            showNotification('error', 'Failed to update customer status. Please try again.');
        })
        .finally(() => {
            // Remove loading state
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    };

    function updateCustomerStatusStyling(selectEl, value) {
        // Reset classes
        selectEl.className = 'appearance-none font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition';

        // Apply styling based on status
        switch (value) {
            case 'active':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                break;
            case 'pending':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                break;
            case 'inactive':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                break;
        }
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
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
});
</script>

@endsection
