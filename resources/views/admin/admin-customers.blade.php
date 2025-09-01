@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-6">
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
                    <span class="text-gray-500">Customers</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Title -->
    <h2 class="text-2xl font-semibold text-[#1F8FB2]">Customers</h2>

    <!-- Search Bar -->
    <div class="flex justify-between items-center gap-4">
        <div class="flex gap-4 flex-grow max-w-2xl">
            <input
                type="text"
                placeholder="Search by name or email"
                class="flex-grow border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                id="customerSearchInput"
                value="{{ $search ?? '' }}"
            />
            <select id="statusFilter" class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
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
            <label class="text-sm text-gray-600">Rows per page:</label>
            <select id="rowsPerPage" class="text-sm border border-gray-300 rounded px-2 py-1">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 rows</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 rows</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 rows</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 rows</option>
            </select>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-[#E6F7FC] text-[#1F8FB2]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Phone</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Bookings</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Registration Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($customers as $customer)
                <tr>
                    <td class="px-6 py-4">{{ $customer['id'] }}</td>
                    <td class="px-6 py-4">{{ $customer['name'] }}</td>
                    <td class="px-6 py-4">{{ $customer['email'] }}</td>
                    <td class="px-6 py-4">{{ $customer['phone'] ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $customer['bookingsCount'] }}</td>
                    <td class="px-6 py-4">{{ $customer['registrationDate'] }}</td>
                    <td class="px-6 py-4">
                        <select onchange="handleCustomerStatusChange(this, '{{ $customer['id'] }}')"
                                class="appearance-none {{ $customer['status'] === 'active' ? 'bg-green-100 text-green-800' : ($customer['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition"
                                data-original-value="{{ $customer['status'] }}">
                            <option value="active" {{ $customer['status'] === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ $customer['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ $customer['status'] === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.customer.view', ['customer_id' => $customer['id']]) }}" class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded ml-2">Delete</button>
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

    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $pagination->links() }}
    </div>
</div>

<!-- JavaScript for search and pagination -->
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
