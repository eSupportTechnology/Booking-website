@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Welcome back, {{ Auth::user()->name ?? 'Partner' }}! 👋</h1>
                <p class="text-blue-100 text-lg">Manage your properties and track your success</p>
            </div>
            <a href="{{ route('partner.list-your-property') }}" class="bg-white text-[#1F8FB2] px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add New Property
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->totalProperties }}</p>
                </div>
                <div class="bg-[#1F8FB2] bg-opacity-10 p-3 rounded-xl">
                    <i class="fas fa-building text-[#1F8FB2] text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Bookings</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->activeBookings }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Monthly Earnings</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($stats->monthlyEarnings) }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-dollar-sign text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Average Rating</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->averageRating }} ⭐</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <i class="fas fa-star text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">Recent Bookings</h2>
                <a href="{{ route('partner.bookings') }}" class="text-[#1F8FB2] hover:text-[#3CC0E9] font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Check-in</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Earnings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentBookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $booking['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking['guest_name'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking['property_name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking['check_in'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $booking['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">${{ $booking['earnings'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Monthly Earnings Overview</h2>
            <p class="text-gray-600 mt-1">Track your earnings and booking trends</p>
        </div>
        <div class="p-6">
            <canvas id="earningsChart" height="60"></canvas>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
                <p class="text-gray-600 mt-1">Manage your business efficiently</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('partner.list-your-property') }}" class="flex items-center p-4 bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] text-white rounded-xl hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-plus-circle text-2xl mr-4"></i>
                        <div>
                            <div class="font-semibold">Add New Property</div>
                            <div class="text-sm opacity-90">List a new property</div>
                        </div>
                    </a>
                    <a href="{{ route('partner.bookings') }}" class="flex items-center p-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-calendar-alt text-2xl mr-4"></i>
                        <div>
                            <div class="font-semibold">Manage Bookings</div>
                            <div class="text-sm opacity-90">View and manage reservations</div>
                        </div>
                    </a>
                    <a href="{{ route('partner.earnings') }}" class="flex items-center p-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-chart-line text-2xl mr-4"></i>
                        <div>
                            <div class="font-semibold">View Earnings</div>
                            <div class="text-sm opacity-90">Track your revenue</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800">Recent Activity</h3>
                <p class="text-gray-600 mt-1">Latest updates and notifications</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if(count($recentActivity) > 0)
                        @foreach($recentActivity as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-bell text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">{{ $activity }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500 mb-2">No recent activity</p>
                            <p class="text-sm text-gray-400">Start by adding your first property</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(31, 143, 178, 0.8)');
    gradient.addColorStop(1, 'rgba(31, 143, 178, 0.1)');

    const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
    gradient2.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
    gradient2.addColorStop(1, 'rgba(16, 185, 129, 0.1)');

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
                    borderWidth: 4,
                    pointBackgroundColor: '#1F8FB2',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Bookings',
                    data: @json($chartData['bookings']),
                    fill: true,
                    backgroundColor: gradient2,
                    borderColor: '#10b981',
                    borderWidth: 4,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#374151',
                        font: { size: 14, weight: '600' },
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    borderColor: '#1F8FB2',
                    borderWidth: 2,
                    cornerRadius: 12,
                    displayColors: true,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                x: {
                    ticks: { 
                        color: '#6b7280', 
                        font: { weight: '600', size: 12 } 
                    },
                    grid: { 
                        display: false 
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6b7280',
                        font: { weight: '600', size: 12 },
                        callback: function(value) {
                            return '$' + value;
                        }
                    },
                    grid: {
                        color: 'rgba(229, 231, 235, 0.8)',
                        lineWidth: 1,
                        borderDash: [5, 5]
                    },
                    border: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endsection
