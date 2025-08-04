@extends('partner.master')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Welcome back, <b>{{ Auth::user()->name ?? 'Partner' }} </b>👋</h1>
        <a href="{{ route('partner.list-your-property') }}" class="text-white px-4 py-2 rounded shadow hover:opacity-90 transition" style="background-color: #1F8FB2;">
            Add New Property
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Properties</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->totalProperties }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Active Bookings</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->activeBookings }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Monthly Earnings</h2>
            <p class="text-2xl font-bold text-gray-800">${{ number_format($stats->monthlyEarnings) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <h2 class="text-sm text-gray-500">Reviews</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->averageRating }} ⭐</p>
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
                        <th class="px-4 py-2">Guest</th>
                        <th class="px-4 py-2">Property</th>
                        <th class="px-4 py-2">Check-in</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Earnings</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $booking['id'] }}</td>
                        <td class="px-4 py-2">{{ $booking['guest_name'] }}</td>
                        <td class="px-4 py-2">{{ $booking['property_name'] }}</td>
                        <td class="px-4 py-2">{{ $booking['check_in'] }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ $booking['status'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-right font-semibold">${{ $booking['earnings'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Earnings Overview</h2>
        <canvas id="earningsChart" height="40"></canvas>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('partner.list-your-property') }}" class="text-center text-white px-4 py-2 rounded hover:opacity-90 transition" style="background-color: #1F8FB2;">Add New Property</a>
                <a href="#" class="text-center text-white px-4 py-2 rounded hover:opacity-90 transition" style="background-color: #3CC0E9;">Manage Bookings</a>
                <a href="#" class="text-center bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">View Earnings</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Recent Activity</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>New booking received for Ocean View Apartment</li>
                <li>Guest review: 5 stars for City Center Studio</li>
                <li>Payment received: $180 for booking BK10234</li>
                <li>Property photos updated successfully</li>
            </ul>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(31, 143, 178, 0.5)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Earnings ($)',
                    data: @json($chartData['earnings']),
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#1F8FB2',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#1F8FB2',
                    pointRadius: 4
                },
                {
                    label: 'Bookings',
                    data: @json($chartData['bookings']),
                    fill: false,
                    borderColor: '#10b981',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
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
                        stepSize: 500,
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