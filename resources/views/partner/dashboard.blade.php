@extends('partner.master')

@section('content')
<div class="space-y-6" style="font-family: 'Noto Sans', sans-serif;">
    <!-- Header -->
    <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">
                    Welcome back, {{ Auth::user()->name ?? 'Partner' }}
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    Manage your properties and track your success
                </p>
            </div>
            <a href="{{ route('partner.property.category') }}"
                class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Property
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Total Properties</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats->totalProperties }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Active Bookings</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stats->activeBookings }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Monthly Earnings</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">@currency($stats->monthlyEarnings, 'USD')</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Average Rating</p>
            <div class="flex items-center mt-1">
                <p class="text-2xl font-semibold text-gray-800">{{ $stats->averageRating }}</p>
                <svg class="w-4 h-4 text-yellow-400 ml-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Recent Bookings</h2>
            <a href="{{ route('partner.bookings') }}" class="text-[#1F8FB2] hover:underline text-sm">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Guest</th>
                        <th class="px-4 py-2 text-left">Property</th>
                        <th class="px-4 py-2 text-left">Check-in</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-right">Earnings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-900">#{{ $booking['id'] }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $booking['guest_name'] }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $booking['property_name'] }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $booking['check_in'] }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusClasses = match(strtolower($booking['status'])) {
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'completed' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 text-xs rounded {{ $statusClasses }}">{{ $booking['status'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-green-600">
                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($booking['earnings'], $booking['currency'] ?? 'USD', 'USD') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">No bookings yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="text-sm font-semibold text-gray-800">Monthly Overview</h2>
        </div>
        <div class="p-4" style="height: 300px;">
            <canvas id="earningsChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800">Quick Actions</h3>
            </div>
            <div class="p-4 space-y-2">
                <a href="{{ route('partner.list-your-property') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-8 h-8 bg-blue-50 rounded flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-[#1F8FB2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Add New Property</span>
                </a>
                <a href="{{ route('partner.bookings') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-8 h-8 bg-green-50 rounded flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Manage Bookings</span>
                </a>
                <a href="{{ route('partner.earnings') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-8 h-8 bg-yellow-50 rounded flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 8v1"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">View Earnings</span>
                </a>
                <a href="{{ route('partner.deals.index') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-8 h-8 bg-red-50 rounded flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Manage Deals</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800">Recent Activity</h3>
            </div>
            <div class="p-4">
                @if(count($recentActivity) > 0)
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-[#1F8FB2] rounded-full mt-1.5 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm text-gray-700">{{ $activity }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Just now</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-400 text-sm">No recent activity</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Earnings ($)',
                    data: @json($chartData['earnings']),
                    borderColor: '#1F8FB2',
                    backgroundColor: 'rgba(31, 143, 178, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#1F8FB2'
                },
                {
                    label: 'Bookings',
                    data: @json($chartData['bookings']),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#10B981'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleFont: { size: 11 },
                    bodyFont: { size: 11 },
                    padding: 8,
                    cornerRadius: 4
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#9CA3AF' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6' },
                    ticks: { font: { size: 10 }, color: '#9CA3AF' }
                }
            }
        }
    });
</script>
@endsection
