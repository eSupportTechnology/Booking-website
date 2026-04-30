@extends('partner.master')
@section('title', 'Earnings')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Earnings</h1>
                <p class="text-gray-500 text-sm">Track your revenue and payments</p>
            </div>
            <p class="text-xs text-gray-400">Last updated: {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Total Earnings</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">@currency($totalEarnings, 'USD')</p>
            <p class="text-xs text-green-600 mt-1">+12.5% from last month</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">This Month</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">@currency($monthlyEarnings, 'USD')</p>
            <p class="text-xs text-green-600 mt-1">+8.2% from last month</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Pending Payout</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">@currency($pendingPayout, 'USD')</p>
            <p class="text-xs text-yellow-600 mt-1">Processing</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Avg/Booking</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">@currency($averageBooking, 'USD')</p>
            <p class="text-xs text-green-600 mt-1">+5.3% increase</p>
        </div>
    </div>

    <!-- Charts & Payouts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Chart -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">Monthly Earnings</h2>
            </div>
            <div class="p-4" style="height: 250px;">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        <!-- Payout Schedule -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">Payout Schedule</h2>
            </div>
            <div class="p-4 space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">@currency(1250, 'USD')</p>
                            <p class="text-xs text-gray-500">Paid on Jan 15, 2025</p>
                        </div>
                    </div>
                    <span class="text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">Completed</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">@currency(850, 'USD')</p>
                            <p class="text-xs text-gray-500">Expected on Jan 30, 2025</p>
                        </div>
                    </div>
                    <span class="text-xs text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded">Pending</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Next Payout</p>
                            <p class="text-xs text-gray-500">Feb 15, 2025</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded">Scheduled</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Recent Transactions</h2>
            <button class="text-[#1F8FB2] text-sm hover:underline">Export</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Booking</th>
                        <th class="px-4 py-2 text-left">Property</th>
                        <th class="px-4 py-2 text-left hidden sm:table-cell">Guest</th>
                        <th class="px-4 py-2 text-left hidden md:table-cell">Status</th>
                        <th class="px-4 py-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-700">{{ $transaction['date'] }}</td>
                        <td class="px-4 py-3 text-gray-900">#{{ $transaction['booking_id'] }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $transaction['property'] }}</td>
                        <td class="px-4 py-3 text-gray-700 hidden sm:table-cell">{{ $transaction['guest'] }}</td>
                        <td class="px-4 py-3 hidden md:table-cell">
                            @php
                                $statusClasses = match($transaction['status']) {
                                    'Confirmed' => 'bg-green-100 text-green-700',
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 text-xs rounded {{ $statusClasses }}">{{ $transaction['status'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-green-600">+{{ \App\Helpers\CurrencyHelper::convertAndFormat($transaction['amount'], 'USD') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">No transactions yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Earnings ($)',
                data: @json($chartData['earnings']),
                borderColor: '#1F8FB2',
                backgroundColor: 'rgba(31, 143, 178, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#9CA3AF' } },
                y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { font: { size: 10 }, color: '#9CA3AF' } }
            }
        }
    });
</script>
@endsection
