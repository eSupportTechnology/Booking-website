@extends('frontend.admin.master')
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
                <input type="text"
                    placeholder="Search by flight or passenger"
                    class="w-full sm:flex-1 px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]"
                    id="transferSearchInput">

                <select id="statusFilter"
                    class="w-full sm:w-auto px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F8FB2] bg-white">
                    <option value="">All Status</option>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Add Button -->
            <div class="w-full sm:w-auto">
                <button class="w-full sm:w-auto bg-[#1F8FB2] hover:bg-[#157799] text-white font-medium text-xs sm:text-sm py-2 px-4 rounded-md shadow transition">
                    + Add New Transfer
                </button>
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
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#AT101</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">Alice Johnson</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">AI203</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleTransferStatusChange(this, 'AT101')"
                                        class="appearance-none bg-green-100 text-green-800 font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-1 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2] transition">
                                        <option value="Scheduled" selected>Scheduled</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full bg-green-800 status-dot"></span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    <a href="{{ route('admin.airport.details') }}"
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

                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 sm:px-4 py-3 sm:py-4 font-medium text-gray-900">#AT102</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">Bob Smith</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">AI205</td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="relative">
                                    <select onchange="handleTransferStatusChange(this, 'AT102')"
                                        class="appearance-none bg-yellow-100 text-yellow-800 font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-1 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2] transition">
                                        <option value="Scheduled">Scheduled</option>
                                        <option value="Completed" selected>Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                    <span class="absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full bg-yellow-800 status-dot"></span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-3 sm:py-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    <a href="{{ route('admin.airport.details') }}"
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
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 gap-3 sm:gap-0">
                <p class="text-xs text-gray-700">Showing 1 to 2 of 2 results</p>
                <div class="space-x-1">
                    <button class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500 hover:bg-gray-50">&lt;</button>
                    <button class="px-2 py-1 text-xs bg-[#1F8FB2] text-white rounded">1</button>
                    <button class="px-2 py-1 text-xs bg-white border border-gray-300 rounded text-gray-500 hover:bg-gray-50">&gt;</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function handleTransferStatusChange(selectEl, id) {
        const value = selectEl.value;
        const dot = selectEl.parentElement.querySelector('.status-dot');

        // Reset classes
        selectEl.className =
            'appearance-none font-medium text-[10px] sm:text-xs rounded-full pl-6 pr-4 py-1 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1F8FB2]';
        dot.className = 'absolute top-1/2 left-2 -translate-y-1/2 w-2 h-2 rounded-full status-dot';

        // Change color based on status
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

    // Search & Filter
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
