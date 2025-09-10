@extends('admin.master')
@section('title', 'Taxi Management')
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
                        <span class="text-gray-500">Taxi</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6 leading-tight">
            Taxi Management
        </h1>

        <!-- Search & Add Button Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">

            <!-- Search & Filter Section -->
            <div class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2 sm:gap-3">
                <form method="GET" class="w-full sm:w-2/3 flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search taxis or driver name"
                        class="w-full sm:flex-1 px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                    >
                    <select name="status"
                        class="px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] bg-white w-full sm:w-auto"
                        onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-2 bg-[#1F8FB2] text-white rounded-md text-xs sm:text-sm hover:bg-[#157799]">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Rows per page selector -->
        <div class="flex justify-end mb-3 sm:mb-4">
            <select
                class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] px-2 py-2">
                <option value="10">10 rows</option>
                <option value="20">20 rows</option>
                <option value="30">30 rows</option>
                <option value="50">50 rows</option>
            </select>
        </div>

        <!-- Table Wrapper -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm text-left text-gray-700" id="taxisTable">
                    <thead class="bg-gray-50 font-bold uppercase text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">ID</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Driver</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Vehicle</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Status</th>
                            <th class="px-2 sm:px-4 py-2 sm:py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($taxis as $taxi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 font-medium text-gray-900">#T{{ $taxi->id }}</td>
                            <td class="px-2 sm:px-4 py-3">{{ $taxi->drivers->first()?->name ?? 'No Driver' }}</td>
                            <td class="px-2 sm:px-4 py-3">{{ $taxi->type?->name ?? 'Unknown' }} - {{ $taxi->number_plate }}</td>
                            <td class="px-2 sm:px-4 py-3">
                                <div class="relative">
                                    @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('change_taxi_status'))
                                    <select onchange="handleTaxiStatusChange(this, 'T{{ $taxi->id }}')"
                                        class="appearance-none @if($taxi->status === 'Active') bg-green-100 text-green-800 @elseif($taxi->status === 'Inactive') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif font-medium text-xs sm:text-sm rounded-full pl-6 pr-4 py-1 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] transition">
                                        <option value="Active" @selected($taxi->status === 'Active')>Active</option>
                                        <option value="Inactive" @selected($taxi->status === 'Inactive')>Inactive</option>
                                        <option value="On Trip" @selected($taxi->status === 'On Trip')>On Trip</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full @if($taxi->status === 'Active') bg-green-800 @elseif($taxi->status === 'Inactive') bg-yellow-800 @else bg-red-800 @endif pointer-events-none status-dot"></span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold @if($taxi->status === 'Active') bg-green-100 text-green-800 @elseif($taxi->status === 'Inactive') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $taxi->status }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-3">
                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                    @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('view_taxi'))
                                    <a href="{{ route('admin.taxi.details', $taxi->id) }}"
                                        class="text-[#1F8FB2] hover:text-[#157799] text-xs sm:text-sm font-medium inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    @endif
                                    @if(Auth::guard('admin')->user()->isSuperAdmin() || Auth::guard('admin')->user()->can('edit_taxi'))
                                    <button
                                        class="text-red-600 hover:text-red-800 text-xs sm:text-sm font-medium inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                No taxis found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-3 sm:px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-200">
                <p class="text-xs text-gray-700">
                    Showing {{ $taxis->firstItem() ?? 0 }} to {{ $taxis->lastItem() ?? 0 }} of {{ $taxis->total() }} results
                </p>
                <div class="space-x-1">
                    {{ $taxis->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    function handleTaxiStatusChange(selectEl, id) {
        const value = selectEl.value;
        const wrapper = selectEl.parentElement;
        const dot = wrapper.querySelector('.status-dot');


        selectEl.className =
            'appearance-none font-medium text-xs sm:text-sm rounded-full pl-6 pr-4 py-1 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2]';
        dot.className =
            'absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full status-dot';


        switch (value) {
            case 'Active':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                dot.classList.add('bg-green-800');
                break;
            case 'Inactive':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                dot.classList.add('bg-yellow-800');
                break;
            case 'On Trip':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                dot.classList.add('bg-red-800');
                break;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('taxiSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('taxisTable');
        const rows = table.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const id = row.children[0]?.textContent.toLowerCase() || '';
                const driverName = row.children[1]?.textContent.toLowerCase() || '';
                const vehicle = row.children[2]?.textContent.toLowerCase() || '';
                const statusSelect = row.children[3]?.querySelector('select');
                const status = statusSelect ? statusSelect.value.toLowerCase() : '';

                const matchesSearch =
                    searchTerm === '' ||
                    id.includes(searchTerm) ||
                    driverName.includes(searchTerm) ||
                    vehicle.includes(searchTerm);

                const matchesStatus = !statusTerm || status === statusTerm;

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>

@endsection
