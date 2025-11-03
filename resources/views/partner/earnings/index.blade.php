@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 sm:p-8 text-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">Earnings Dashboard</h1>
                <p class="text-yellow-100 text-base sm:text-lg">Track your revenue and financial performance</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-yellow-100 text-sm">Last updated</p>
                <p class="text-white font-semibold text-sm sm:text-base">{{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Total Earnings</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">@currency($totalEarnings, 'USD')</p>
                    <p class="text-xs sm:text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+12.5% from last month
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">This Month</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">@currency($monthlyEarnings, 'USD')</p>
                    <p class="text-xs sm:text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+8.2% from last month
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-alt text-green-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Payout</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">@currency($pendingPayout, 'USD')</p>
                    <p class="text-xs sm:text-sm text-yellow-600 mt-1">
                        <i class="fas fa-clock mr-1"></i>Processing
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Average/Booking</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">@currency($averageBooking, 'USD')</p>
                    <p class="text-xs sm:text-sm text-purple-600 mt-1">
                        <i class="fas fa-chart-line mr-1"></i>+5.3% increase
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <i class="fas fa-chart-bar text-purple-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Earnings Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Monthly Earnings</h2>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Revenue trends over the past 12 months</p>
            </div>
            <div class="p-5 sm:p-6">
                <div class="relative w-full" style="height: 300px;">
                    <canvas id="earningsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Payout Schedule -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Payout Schedule</h2>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Upcoming and recent payouts</p>
            </div>
            <div class="p-5 sm:p-6">
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-green-50 rounded-xl">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">@currency(1250, 'USD')</p>
                                <p class="text-sm text-gray-600">Paid on Jan 15, 2025</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full self-start sm:self-auto">Completed</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-yellow-50 rounded-xl">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">@currency(850, 'USD')</p>
                                <p class="text-sm text-gray-600">Expected on Jan 30, 2025</p>
                            </div>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full self-start sm:self-auto">Pending</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Next Payout</p>
                                <p class="text-sm text-gray-600">Feb 15, 2025</p>
                            </div>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full self-start sm:self-auto">Scheduled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commission Invoice -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Commission Invoice</h2>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">Your commission earnings (15% rate)</p>
                </div>
                <button onclick="downloadInvoice()" class="bg-[#1F8FB2] hover:bg-[#3CC0E9] text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-download mr-2"></i>Download Invoice
                </button>
            </div>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Invoice Details</h3>
                    <p class="text-sm text-gray-600">Invoice Number: <span class="font-medium">INV-{{ str_pad(auth()->id(), 6, '0', STR_PAD_LEFT) }}</span></p>
                    <p class="text-sm text-gray-600">Date: <span class="font-medium">{{ now()->format('M d, Y') }}</span></p>
                    <p class="text-sm text-gray-600">Commission Rate: <span class="font-medium">15%</span></p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Partner Information</h3>
                    <p class="text-sm text-gray-600">Name: <span class="font-medium">{{ auth()->user()->name }}</span></p>
                    <p class="text-sm text-gray-600">Email: <span class="font-medium">{{ auth()->user()->email }}</span></p>
                </div>
            </div>

            <div class="border rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm sm:text-base">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm">Period</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-500 uppercase text-xs sm:text-sm">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 text-gray-900">Current Month Commission</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::convertAndFormat($monthlyEarnings * 0.15, 'USD') }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-gray-900">Previous Month Commission</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-900">{{ \App\Helpers\CurrencyHelper::convertAndFormat(($monthlyEarnings * 0.92) * 0.15, 'USD') }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3 font-semibold text-gray-900">Total Commission Due</td>
                            <td class="px-4 py-3 text-right font-bold text-green-600">{{ \App\Helpers\CurrencyHelper::convertAndFormat(($monthlyEarnings + ($monthlyEarnings * 0.92)) * 0.15, 'USD') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Recent Transactions</h2>
                    <p class="text-gray-600 mt-1">Latest earnings from your properties</p>
                </div>
                <button class="bg-[#1F8FB2] hover:bg-[#3CC0E9] text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm">Date</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm">Booking ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm">Property</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm hidden sm:table-cell">Guest</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 uppercase text-xs sm:text-sm hidden md:table-cell">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-500 uppercase text-xs sm:text-sm">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-900">{{ $transaction['date'] }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-900 font-medium">#{{ $transaction['booking_id'] }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-900">{{ $transaction['property'] }}</td>
                        <td class="px-4 py-3 whitespace-nowrap hidden sm:table-cell">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-2 truncate">
                                    <div class="text-gray-900 font-medium">{{ $transaction['guest'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap hidden md:table-cell">
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
                        <td class="px-4 py-3 whitespace-nowrap text-right text-green-600 font-bold">+{{ \App\Helpers\CurrencyHelper::convertAndFormat($transaction['amount'], 'USD') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
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

    function downloadInvoice() {
        // Create invoice content
        const invoiceContent = `
            <div style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #1F8FB2; margin-bottom: 10px;">Commission Invoice</h1>
                    <p style="color: #666;">Invoice #INV-{{ str_pad(auth()->id(), 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <div>
                        <h3>Partner Information</h3>
                        <p>Name: {{ auth()->user()->name }}</p>
                        <p>Email: {{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <h3>Invoice Details</h3>
                        <p>Date: {{ now()->format('M d, Y') }}</p>
                        <p>Commission Rate: 15%</p>
                    </div>
                </div>

                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Description</th>
                            <th style="border: 1px solid #ddd; padding: 12px; text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 12px;">Current Month Commission</td>
                            <td style="border: 1px solid #ddd; padding: 12px; text-align: right;">$${{{ number_format($monthlyEarnings * 0.15, 2) }}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 12px;">Previous Month Commission</td>
                            <td style="border: 1px solid #ddd; padding: 12px; text-align: right;">$${{{ number_format(($monthlyEarnings * 0.92) * 0.15, 2) }}}</td>
                        </tr>
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td style="border: 1px solid #ddd; padding: 12px;">Total Commission Due</td>
                            <td style="border: 1px solid #ddd; padding: 12px; text-align: right; color: #16a34a;">$${{{ number_format(($monthlyEarnings + ($monthlyEarnings * 0.92)) * 0.15, 2) }}}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: center; color: #666; font-size: 12px;">
                    <p>This invoice is generated automatically. Commission becomes payable 15 days after booking confirmation.</p>
                </div>
            </div>
        `;

        // Create and download PDF-like HTML file
        const blob = new Blob([invoiceContent], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'commission-invoice-{{ now()->format("Y-m-d") }}.html';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
@endsection
