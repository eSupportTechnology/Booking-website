@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] rounded-2xl p-6 sm:p-8 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="text-center sm:text-left w-full sm:w-auto">
                <h1 class="text-2xl sm:text-4xl font-bold mb-2">
                    Welcome back, {{ Auth::user()->name ?? 'Partner' }}! 👋
                </h1>
                <p class="text-blue-100 text-base sm:text-lg">
                    Manage your properties and track your success
                </p>
            </div>
            <div class="w-full sm:w-auto flex justify-center sm:justify-end">
                <a href="{{ route('partner.property.category') }}"
                    class="bg-white text-[#1F8FB2] px-5 sm:px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg text-center w-full sm:w-auto">
                    <i class="fas fa-plus mr-2"></i>Add New Property
                </a>
            </div>
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
                    <p class="text-3xl font-bold text-gray-800 mt-2">@currency($stats->monthlyEarnings, 'USD')</p>
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
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">@currency($booking['earnings'], 'USD')</td>
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
        <div class="p-6" style="height: 400px;">
            <canvas id="earningsChart"></canvas>
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

    //console.log('Chart Data:', @json($chartData));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Earnings ($)',
                    data: @json($chartData['earnings']),
                    borderColor: '#1F8FB2',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1F8FB2',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Bookings',
                    data: @json($chartData['bookings']),
                    borderColor: '#10B981',
                    backgroundColor: gradient2,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
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
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#1F8FB2',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            if (context.datasetIndex === 0) {
                                return 'Earnings: $' + context.parsed.y.toLocaleString();
                            } else {
                                return 'Bookings: ' + context.parsed.y;
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#6B7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#6B7280',
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#ffffff'
                }
            }
        }
    });
</script>
@endsection
