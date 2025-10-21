@extends('admin.master')
@section('title', 'Rental Service Providers Management')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-2 sm:p-4">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap mb-3 sm:mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center flex-wrap space-x-1 md:space-x-3 text-xs sm:text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <span class="text-gray-500">Rental Service Providers</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6 leading-tight">
            Rental Service Providers Management
        </h1>

        <!-- Search & Filter Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <form method="GET" class="w-full flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, email, or phone"
                        class="w-full sm:flex-1 px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                    >
                    <select name="account_type"
                        class="px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] bg-white w-full sm:w-auto"
                        onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="company" @selected(request('account_type') === 'company')>Company</option>
                        <option value="individual" @selected(request('account_type') === 'individual')>Individual</option>
                    </select>
                    <button type="submit" class="px-3 py-2 bg-[#1F8FB2] text-white rounded-md text-xs sm:text-sm hover:bg-[#157799]">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Table Wrapper -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left text-gray-700">
                    <thead class="bg-gray-50 font-bold uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">ID</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Name/Company</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Email</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Status</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Type</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Cars</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Taxis</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($providers as $provider)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 font-medium text-gray-900">#{{ $provider->id }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('edit_rental_providers'))
                                <select onchange="handleRentalProviderStatusChange(this, '{{ $provider->id }}')"
                                    class="appearance-none font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition {{ $provider->status === 'active' ? 'bg-green-100 text-green-800' : ($provider->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}"
                                    data-original-value="{{ strtolower($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) }}">
                                    <option value="active" {{ ($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ ($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="inactive" {{ ($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) === 'active' ? 'bg-green-100 text-green-800' : (($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($provider->status ?? ($provider->user && $provider->user->email_verified_at ? 'active' : 'pending')) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                @if($provider->isCompany())
                                    <div class="font-medium">{{ $provider->company_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $provider->full_name }}</div>
                                @else
                                    {{ $provider->full_name }}
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-3">{{ $provider->email }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($provider->isCompany()) bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($provider->account_type) }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ $provider->cars_count }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    {{ $provider->taxis_count }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                    <a href="{{ route('admin.rental-providers.view', $provider->id) }}"
                                        class="text-[#1F8FB2] hover:text-[#157799] text-xs sm:text-sm font-medium inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No rental service providers found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-3 sm:px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-200">
                <p class="text-xs text-gray-700">
                    Showing {{ $providers->firstItem() ?? 0 }} to {{ $providers->lastItem() ?? 0 }} of {{ $providers->total() }} results
                </p>
                <div class="space-x-1">
                    {{ $providers->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.handleRentalProviderStatusChange = function(selectEl, providerId) {
        const value = selectEl.value;
        const originalValue = selectEl.getAttribute('data-original-value');
        selectEl.disabled = true;
        selectEl.style.opacity = '0.6';

        fetch(`/admin/status/rental-provider/${providerId}`, {
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
                updateRentalProviderStatusStyling(selectEl, value);
                showNotification('success', data.message);
                selectEl.setAttribute('data-original-value', value);
            } else {
                selectEl.value = originalValue;
                showNotification('error', data.message || 'Failed to update status');
            }
        })
        .catch(() => {
            selectEl.value = originalValue;
            showNotification('error', 'Failed to update rental provider status.');
        })
        .finally(() => {
            selectEl.disabled = false;
            selectEl.style.opacity = '1';
        });
    };

    function updateRentalProviderStatusStyling(selectEl, value) {
        selectEl.className = 'appearance-none font-semibold text-xs rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition';
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
@endpush
