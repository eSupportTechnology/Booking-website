@extends('admin.master')

@section('content')
<div class="space-y-6 px-3 sm:px-6"> {{-- mobile-safe side padding --}}

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800">
            Welcome back, <b>{{ Auth::guard('admin')->user()->username ?? 'Admin' }}</b> 👋
        </h1>
        <a href="{{ route('admin.customers') }}"
           class="w-full sm:w-auto text-center text-white px-4 py-2 rounded shadow hover:opacity-90 transition"
           style="background-color:#1F8FB2;">
            Manage Customers
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow border-l-4" style="border-color:#1F8FB2;">
            <h2 class="text-xs sm:text-sm text-gray-500">Total Customers</h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ number_format($totalCustomers) }}</p>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-xs sm:text-sm text-gray-500">Total Partners</h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ number_format($totalPartners) }}</p>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h2 class="text-xs sm:text-sm text-gray-500">Total Bookings (30d)</h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ number_format($totalBookings) }}</p>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-xs sm:text-sm text-gray-500">Revenue (30d) - USD</h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">${{ number_format((float)$revenue, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Converted to USD</p>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow border-l-4 border-red-500">
            <h2 class="text-xs sm:text-sm text-gray-500">Pending Verifications</h2>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ number_format($pendingVerifications) }}</p>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Bookings</h2>

        {{-- Mobile: card list --}}
        <div class="md:hidden space-y-3">
            @forelse($recentBookings as $booking)
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'confirmed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'completed' => 'bg-blue-100 text-blue-700'
                    ];
                    $statusColor = $statusColors[strtolower($booking['status'])] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <div class="border rounded-lg p-3 flex flex-col gap-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">#{{ $booking['id'] }}</span>
                        <span class="{{ $statusColor }} text-[10px] px-2 py-0.5 rounded font-medium">
                            {{ $booking['status'] }}
                        </span>
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-gray-800">{{ $booking['customer_name'] }}</p>
                        <p class="text-gray-600">{{ $booking['property_name'] }}</p>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">{{ $booking['date'] }}</span>
                        <span class="font-semibold text-green-600">${{ number_format((float)$booking['amount'], 2) }} USD</span>
                        @if($booking['original_currency'] !== 'USD')
                            <span class="text-xs text-gray-500 block">{{ $booking['original_currency'] }} {{ number_format((float)$booking['original_amount'], 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('admin.customers') }}"
                           class="inline-block mt-1 text-sm font-medium hover:underline"
                           style="color:#1F8FB2;">View</a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-6">No recent bookings found.</p>
            @endforelse
        </div>

        {{-- Tablet/Desktop: table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Booking ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Property</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                'completed' => 'bg-blue-100 text-blue-700'
                            ];
                            $statusColor = $statusColors[strtolower($booking['status'])] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium">{{ $booking['id'] }}</td>
                            <td class="px-4 py-2">{{ $booking['customer_name'] }}</td>
                            <td class="px-4 py-2">{{ $booking['property_name'] }}</td>
                            <td class="px-4 py-2">{{ $booking['date'] }}</td>
                            <td class="px-4 py-2 font-semibold text-green-600">
                                ${{ number_format((float)$booking['amount'], 2) }} USD
                                @if($booking['original_currency'] !== 'USD')
                                    <div class="text-xs text-gray-500">{{ $booking['original_currency'] }} {{ number_format((float)$booking['original_amount'], 2) }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="{{ $statusColor }} text-xs font-medium px-2 py-1 rounded">
                                    {{ $booking['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('admin.customers') }}" class="hover:underline" style="color:#1F8FB2;">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">No recent bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Monthly Bookings Overview</h2>
            <form method="GET" class="flex gap-2">
                <select name="chart_period" class="text-sm rounded border-gray-300" onchange="this.form.submit()">
                    <option value="6" {{ request('chart_period', 6) == 6 ? 'selected' : '' }}>Last 6 Months</option>
                    <option value="12" {{ request('chart_period') == 12 ? 'selected' : '' }}>Last 12 Months</option>
                </select>
                <select name="chart_type" class="text-sm rounded border-gray-300" onchange="this.form.submit()">
                    <option value="" {{ !request('chart_type') ? 'selected' : '' }}>All Properties</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type['id'] }}" {{ request('chart_type') == $type['id'] ? 'selected' : '' }}>{{ $type['name'] }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="relative w-full h-56 sm:h-64 md:h-72 lg:h-64 xl:h-60">
            <canvas id="bookingChart" class="absolute inset-0 w-full h-full"></canvas>
        </div>
    </div>


    <!-- Quick Actions & System Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <div class="flex flex-col gap-2">
                <a href="{{ route('admin.apartments') }}"
                    class="w-full text-center text-white px-4 py-2 rounded hover:opacity-90 transition"
                    style="background-color:#1F8FB2;">Manage Properties</a>
                <a href="{{ route('admin.customers') }}"
                    class="w-full text-center text-white px-4 py-2 rounded hover:opacity-90 transition"
                    style="background-color:#3CC0E9;">Manage Users</a>
                @if(Auth::guard('admin')->user()->hasRole('superAdmin'))
                    <a href="{{ route('admin.approvals.index') }}"
                       class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                       Pending Admins
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">System Overview</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Recent Bookings:</span>
                    <span class="font-semibold">{{ count($recentBookings) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pending Verifications:</span>
                    <span class="font-semibold text-red-600">{{ $pendingVerifications }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Revenue (30d):</span>
                    <span class="font-semibold text-green-600">${{ number_format((float)$revenue, 2) }} USD</span>
                </div>
                @if($pendingVerifications > 0)
                    <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $pendingVerifications }} partner(s) awaiting verification
                        </p>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <a  href="{{ route('admin.aging-report') }}"
                    class="w-full text-center text-white px-4 py-2 rounded hover:opacity-90 transition"
                    style="background-color:#3CC0E9;">Aging Report</a>
                </div>
            </div>
            <div class="flex justify-between items-center">
                    <a  href="{{ route('admin.commission-aging') }}"
                    class="w-full text-center text-white px-4 py-2 rounded hover:opacity-90 transition"
                    style="background-color:#3CC0E9;">Commission Aging Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(31, 143, 178, 0.5)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats['labels']),
            datasets: [
                {
                    label: 'Bookings',
                    data: @json($monthlyStats['bookings']),
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#1F8FB2',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#1F8FB2',
                    pointRadius: 3
                },
                {
                    label: 'Cancellations',
                    data: @json($monthlyStats['cancellations']),
                    fill: false,
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // critical for mobile
            plugins: {
                legend: {
                    labels: {
                        color: '#374151',
                        font: { size: 12, weight: 'bold' }
                    }
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    borderColor: '#1F8FB2',
                    borderWidth: 1
                }
            },
            scales: {
                x: { ticks: { color: '#6b7280' }, grid: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#6b7280', stepSize: 50 },
                    grid: { color: '#e5e7eb', borderDash: [5,5] }
                }
            }
        }
    });
</script>
@endsection
