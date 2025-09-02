@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-6">

    <!-- Page Title -->
    <h2 class="text-2xl sm:text-3xl font-semibold text-[#1F8FB2]">Partners</h2>

    <!-- Search Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 max-w-xl">
        <input
            type="text"
            placeholder="Search by name or email"
            class="w-full sm:flex-grow border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
            id="partnerSearchInput"
        />
        <button class="w-full sm:w-auto bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">
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

    <!-- Partners Table / Cards -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded shadow hidden sm:table">
            <thead class="bg-[#E6F7FC] text-[#1F8FB2]">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Properties</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($partners as $partner)
                <tr>
                    <td class="px-4 py-3">{{ $partner['id'] }}</td>
                    <td class="px-4 py-3">{{ $partner['name'] }}</td>
                    <td class="px-4 py-3">{{ $partner['email'] }}</td>
                    <td class="px-4 py-3">{{ $partner['propertyCount'] }}</td>
                    <td class="px-4 py-3">
                        <select onchange="handlePartnerStatusChange(this, '{{ $partner['id'] }}')"
                                class="appearance-none {{ $partner['status'] === 'Active' ? 'bg-green-100 text-green-800' : ($partner['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition"
                                data-original-value="{{ strtolower($partner['status']) }}">
                            <option value="active" {{ $partner['status'] === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ $partner['status'] === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ $partner['status'] === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </td>
                    <td class="px-4 py-3 flex flex-wrap gap-2">
                        <a href="{{ route('admin.partner.view', ['partner_id' => $partner['id']]) }}"
                           class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                        <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        No partners found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Mobile Card View -->
        <div class="sm:hidden flex flex-col gap-4">
            @forelse($partners as $partner)
            <div class="border border-gray-200 rounded shadow p-4 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-sm">#{{ $partner['id'] }}</span>
                    <select onchange="handlePartnerStatusChange(this, '{{ $partner['id'] }}')"
                            class="appearance-none {{ $partner['status'] === 'Active' ? 'bg-green-100 text-green-800' : ($partner['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} font-semibold text-xs rounded-full px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition"
                            data-original-value="{{ strtolower($partner['status']) }}">
                        <option value="active" {{ $partner['status'] === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ $partner['status'] === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ $partner['status'] === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="text-sm"><span class="font-semibold">Name:</span> {{ $partner['name'] }}</div>
                <div class="text-sm"><span class="font-semibold">Email:</span> {{ $partner['email'] }}</div>
                <div class="text-sm"><span class="font-semibold">Properties:</span> {{ $partner['propertyCount'] }}</div>
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('admin.partner.view', ['partner_id' => $partner['id']]) }}"
                       class="px-3 py-1 text-sm text-white bg-[#1F8FB2] hover:bg-[#157799] rounded">View</a>
                    <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Delete</button>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-8">No partners found.</div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $pagination->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const searchInput = document.getElementById('partnerSearchInput');
    const tableRows = document.querySelectorAll('table tbody tr');
    const mobileCards = document.querySelectorAll('.sm\\:hidden > div');

    // Rows per page
    rowsPerPageSelect?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Live search
    searchInput.addEventListener('input', function () {
        const term = this.value.toLowerCase();

        // Filter table rows (desktop)
        tableRows.forEach(row => {
            const name = row.children[1]?.textContent.toLowerCase() || '';
            const email = row.children[2]?.textContent.toLowerCase() || '';
            row.style.display = name.includes(term) || email.includes(term) ? '' : 'none';
        });

        // Filter mobile cards
        mobileCards.forEach(card => {
            const name = card.querySelector('div:nth-child(2)').textContent.toLowerCase();
            const email = card.querySelector('div:nth-child(3)').textContent.toLowerCase();
            card.style.display = name.includes(term) || email.includes(term) ? '' : 'none';
        });
    });

    // Partner status change
    window.handlePartnerStatusChange = function(selectEl, partnerId) {
        const value = selectEl.value;
        const originalValue = selectEl.getAttribute('data-original-value');
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        fetch(`/admin/status/partner/${partnerId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updatePartnerStatusStyling(selectEl, value);
                showNotification('success', data.message);
                selectEl.setAttribute('data-original-value', value);
            } else {
                selectEl.value = originalValue;
                showNotification('error', data.message || 'Failed to update status');
            }
        })
        .catch(() => {
            selectEl.value = originalValue;
            showNotification('error', 'Failed to update partner status.');
        })
        .finally(() => {
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    };

    function updatePartnerStatusStyling(selectEl, value) {
        selectEl.className = 'appearance-none font-semibold text-xs rounded-full px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition';
        if (value === 'active') selectEl.classList.add('bg-green-100', 'text-green-800');
        else if (value === 'pending') selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
        else selectEl.classList.add('bg-red-100', 'text-red-800');
    }

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg transition-all duration-300 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>

@endsection
