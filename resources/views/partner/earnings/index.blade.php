@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Earnings Dashboard</h1>
                <p class="text-yellow-100 text-lg">Track your revenue and financial performance</p>
            </div>
            <div class="text-right">
                <p class="text-yellow-100 text-sm">Last updated</p>
                <p class="text-white font-semibold">{{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Earnings</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($totalEarnings) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+12.5% from last month
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-dollar-sign text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">This Month</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($monthlyEarnings) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+8.2% from last month
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Payout</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($pendingPayout) }}</p>
                    <p class="text-sm text-yellow-600 mt-1">
                        <i class="fas fa-clock mr-1"></i>Processing
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Average/Booking</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($averageBooking) }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                        <i class="fas fa-chart-line mr-1"></i>+5.3% increase
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Earnings Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Monthly Earnings</h2>
                <p class="text-gray-600 mt-1">Revenue trends over the past 12 months</p>
            </div>
            <div class="p-6">
                <canvas id="earningsChart" height="80"></canvas>
            </div>
        </div>

        <!-- Payout Schedule -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Payout Schedule</h2>
                <p class="text-gray-600 mt-1">Upcoming and recent payouts</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">$1,250.00</p>
                                <p class="text-sm text-gray-600">Paid on Jan 15, 2025</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Completed</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">$850.00</p>
                                <p class="text-sm text-gray-600">Expected on Jan 30, 2025</p>
                            </div>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Next Payout</p>
                                <p class="text-sm text-gray-600">Feb 15, 2025</p>
                            </div>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Scheduled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Recent Transactions</h2>
                    <p class="text-gray-600 mt-1">Latest earnings from your properties</p>
                </div>
                <button class="bg-[#1F8FB2] hover:bg-[#3CC0E9] text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction['booking_id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['property'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction['guest'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Confirmed' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Cancelled' => 'bg-red-100 text-red-800',
                                    'Completed' => 'bg-blue-100 text-blue-800'
                                ];
                                $colorClass = $statusColors[$transaction['status']] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                <i class="fas fa-check mr-1"></i>{{ $transaction['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">+${{ number_format($transaction['amount']) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-receipt text-gray-300 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Transactions Found</h3>
                            <p class="text-gray-500">Your earnings will appear here once you receive bookings</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(234, 179, 8, 0.8)');
    gradient.addColorStop(1, 'rgba(234, 179, 8, 0.1)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Earnings ($)',
                data: @json($chartData['earnings']),
                fill: true,
                backgroundColor: gradient,
                borderColor: '#eab308',
                borderWidth: 4,
                tension: 0.4,
                pointBackgroundColor: '#eab308',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    borderColor: '#eab308',
                    borderWidth: 2,
                    cornerRadius: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            return 'Earnings: $' + context.parsed.y.toLocaleString();
                        }
                    }
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
                            return '$' + value.toLocaleString();
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