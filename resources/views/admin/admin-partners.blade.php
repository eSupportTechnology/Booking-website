@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-6">
    <!-- Page Title -->
    <h2 class="text-2xl font-semibold text-[#1F8FB2]">Partners</h2>

    <!-- Search Bar -->
    <div class="flex justify-between items-center gap-4 max-w-xl">
        <input
            type="text"
            placeholder="Search by name or email"
            class="flex-grow border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
            id="partnerSearchInput"
        />
        <button class="bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">
            Search
        </button>
    </div>

    <!-- Rows per page selector -->
    <div class="flex justify-end">
        <select id="rowsPerPage" class="text-sm border border-gray-300 rounded px-2 py-1">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 rows</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 rows</option>
            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 rows</option>
            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 rows</option>
        </select>
    </div>

    <!-- Partners Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-[#E6F7FC] text-[#1F8FB2]">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Properties</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($partners as $partner)
                <tr>
                    <td class="px-6 py-4">{{ $partner['id'] }}</td>
                    <td class="px-6 py-4">{{ $partner['name'] }}</td>
                    <td class="px-6 py-4">{{ $partner['email'] }}</td>
                    <td class="px-6 py-4">{{ $partner['propertyCount'] }}</td>
                    <td class="px-6 py-4">
                        <select onchange="handlePartnerStatusChange(this, '{{ $partner['id'] }}')"
                                class="appearance-none {{ $partner['status'] === 'Active' ? 'bg-green-100 text-green-800' : ($partner['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition"
                                data-original-value="{{ strtolower($partner['status']) }}">
                            <option value="active" {{ $partner['status'] === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ $partner['status'] === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ $partner['status'] === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.partner.view', ['partner_id' => $partner['id']]) }}" class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded ml-2">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No partners found.
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

<!-- Rows per page JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    rowsPerPageSelect?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Partner status change handler
    window.handlePartnerStatusChange = function(selectEl, partnerId) {
        const value = selectEl.value;
        const originalValue = selectEl.getAttribute('data-original-value');

        // Show loading state
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        // Make AJAX request to update status
        fetch(`/admin/status/partner/${partnerId}`, {
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
                updatePartnerStatusStyling(selectEl, value);

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
            console.error('Error updating partner status:', error);
            // Revert selection on error
            selectEl.value = originalValue;
            showNotification('error', 'Failed to update partner status. Please try again.');
        })
        .finally(() => {
            // Remove loading state
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    };

    function updatePartnerStatusStyling(selectEl, value) {
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
