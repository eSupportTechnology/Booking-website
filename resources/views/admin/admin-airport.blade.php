@extends('admin.master')
@section('title', 'Airport Transfers')
@section('content')

<section class="min-h-screen p-3 sm:p-4 bg-gray-50">
    <div class="space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap text-xs sm:text-sm mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-gray-500">Airport Transfers</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800">Airport Transfers Management</h1>

        <!-- Search & Add Button Section -->
        <div class="flex flex-col md:flex-row justify-between gap-3 md:items-center">

            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row w-full md:w-2/3 gap-3">
                <form method="GET" class="w-full md:w-2/3 flex flex-col sm:flex-row gap-3">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by flight or passenger"
                        class="w-full sm:flex-1 px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">

                    <select name="status"
                        class="w-full sm:w-auto px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] bg-white"
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

        <!-- Rows per page -->
        <div class="flex justify-end mb-3">
            <select
                class="text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] px-3 py-2">
                <option value="10">10 rows</option>
                <option value="20">20 rows</option>
                <option value="30">30 rows</option>
                <option value="50">50 rows</option>
            </select>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700" id="transfersTable">
                    <thead class="bg-gray-50 text-[10px] sm:text-xs uppercase font-semibold text-gray-500">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">ID</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Passenger</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Flight</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Status</th>
                            <th class="px-2 sm:px-4 py-3 sm:py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs sm:text-sm">
                        @forelse($transfers as $transfer)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#AT{{ $transfer->id }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">{{ $transfer->drivers->first()?->name ?? 'No Driver' }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">{{ $transfer->number_plate ?? 'N/A' }}</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleTransferStatusChange(this, 'AT{{ $transfer->id }}')"
                                        class="appearance-none @if($transfer->status === 'Scheduled') bg-green-100 text-green-800 @elseif($transfer->status === 'Completed') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-1 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2] transition">
                                        <option value="Scheduled" @selected($transfer->status === 'Scheduled')>Scheduled</option>
                                        <option value="Completed" @selected($transfer->status === 'Completed')>Completed</option>
                                        <option value="Cancelled" @selected($transfer->status === 'Cancelled')>Cancelled</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full @if($transfer->status === 'Scheduled') bg-green-800 @elseif($transfer->status === 'Completed') bg-yellow-800 @else bg-red-800 @endif status-dot"></span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    <a href="{{ route('admin.airport.details', $transfer->id) }}"
                                        class="text-[#1F8FB2] hover:text-[#157799] text-[10px] sm:text-xs font-medium inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    <button
                                        class="text-red-600 hover:text-red-800 text-[10px] sm:text-xs font-medium inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                No airport transfers found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 gap-3 sm:gap-0">
                <p class="text-xs text-gray-700">
                    Showing {{ $transfers->firstItem() ?? 0 }} to {{ $transfers->lastItem() ?? 0 }} of {{ $transfers->total() }} results
                </p>
                <div class="space-x-1">
                    {{ $transfers->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function handleTransferStatusChange(selectEl, id) {
        const value = selectEl.value;
        const dot = selectEl.parentElement.querySelector('.status-dot');


        selectEl.className =
            'appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-1 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2]';
        dot.className = 'absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full status-dot';


        switch (value) {
            case 'Scheduled':
                selectEl.classList.add('bg-green-100', 'text-green-800');
                dot.classList.add('bg-green-800');
                break;
            case 'Completed':
                selectEl.classList.add('bg-yellow-100', 'text-yellow-800');
                dot.classList.add('bg-yellow-800');
                break;
            case 'Cancelled':
                selectEl.classList.add('bg-red-100', 'text-red-800');
                dot.classList.add('bg-red-800');
                break;
        }
    }


    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('transferSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#transfersTable tbody tr');

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const id = row.children[0]?.textContent.toLowerCase() || '';
                const passenger = row.children[1]?.textContent.toLowerCase() || '';
                const flight = row.children[2]?.textContent.toLowerCase() || '';
                const currentStatus = row.children[3]?.querySelector('select')?.value.toLowerCase() || '';

                const matchesSearch = !search || id.includes(search) || passenger.includes(search) || flight.includes(search);
                const matchesStatus = !status || currentStatus === status;

                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>

@endsection
