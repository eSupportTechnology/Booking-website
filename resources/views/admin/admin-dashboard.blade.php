@extends('admin.master')

@section('content')
<div class="space-y-6">

    {{-- <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
            </li>
        </ol>
    </nav> --}}

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Welcome back, <b>{{ Auth::guard('admin')->user()->username ?? 'Admin' }} </b>👋</h1>
        <a href="{{ route('admin.customers') }}" class="text-white px-4 py-2 rounded shadow hover:opacity-90 transition" style="background-color: #1F8FB2;">
            Manage Customers
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Customers</h2>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalCustomers) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Total Partners</h2>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPartners) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h2 class="text-sm text-gray-500">Total Bookings (30d)</h2>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalBookings) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Revenue (30d)</h2>
            <p class="text-2xl font-bold text-gray-800">${{ $revenue }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
            <h2 class="text-sm text-gray-500">Pending Verifications</h2>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($pendingVerifications) }}</p>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Bookings</h2>
        <div class="overflow-x-auto">
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
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $booking['id'] }}</td>
                        <td class="px-4 py-2">{{ $booking['customer_name'] }}</td>
                        <td class="px-4 py-2">{{ $booking['property_name'] }}</td>
                        <td class="px-4 py-2">{{ $booking['date'] }}</td>
                        <td class="px-4 py-2 font-semibold text-green-600">${{ $booking['amount'] }}</td>
                        <td class="px-4 py-2">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'completed' => 'bg-blue-100 text-blue-700'
                                ];
                                $statusColor = $statusColors[strtolower($booking['status'])] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="{{ $statusColor }} text-xs font-medium px-2 py-1 rounded">{{ $booking['status'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('admin.customers') }}" class="hover:underline" style="color: #1F8FB2;">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No recent bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!--  Chart Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Bookings Overview</h2>
        <canvas id="bookingChart" height="40"></canvas>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('admin.apartments') }}" class="text-center text-white px-4 py-2 rounded hover:opacity-90 transition" style="background-color: #1F8FB2;">Manage Properties</a>
                <a href="{{ route('admin.customers') }}" class="text-center text-white px-4 py-2 rounded hover:opacity-90 transition" style="background-color: #3CC0E9;">Manage Users</a>
                @if(Auth::guard('admin')->user()->hasRole('superAdmin'))
                <a href="{{ route('admin.approvals.index') }}" class="text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Pending Admins</a>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
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
                    <span class="font-semibold text-green-600">${{ $revenue }}</span>
                </div>
                @if($pendingVerifications > 0)
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        {{ $pendingVerifications }} partner(s) awaiting verification
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!--  Chart Script -->
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
                    pointRadius: 4
                },
                {
                    label: 'Cancellations',
                    data: @json($monthlyStats['cancellations']),
                    fill: false,
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#374151',
                        font: { size: 14, weight: 'bold' }
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
                x: {
                    ticks: { color: '#6b7280', font: { weight: '600' } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6b7280',
                        stepSize: 50,
                        font: { weight: '600' }
                    },
                    grid: {
                        color: '#e5e7eb',
                        lineWidth: 1,
                        borderDash: [5, 5]
                    }
                }
            }
        }
    });
</script>
@endsection
