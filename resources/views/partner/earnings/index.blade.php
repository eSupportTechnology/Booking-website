@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Earnings</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Earnings</h2>
            <p class="text-2xl font-bold text-gray-800">$12,450</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">This Month</h2>
            <p class="text-2xl font-bold text-gray-800">$2,450</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Pending Payout</h2>
            <p class="text-2xl font-bold text-gray-800">$850</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <h2 class="text-sm text-gray-500">Average/Booking</h2>
            <p class="text-2xl font-bold text-gray-800">$180</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Earnings Chart</h2>
        <canvas id="earningsChart" height="40"></canvas>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Booking ID</th>
                        <th class="px-4 py-2">Property</th>
                        <th class="px-4 py-2">Guest</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">2025-07-15</td>
                        <td class="px-4 py-2">BK10234</td>
                        <td class="px-4 py-2">Ocean View Apartment</td>
                        <td class="px-4 py-2">Sarah Johnson</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">Paid</span>
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-green-600">+$180</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Earnings ($)',
                data: [1200, 1800, 1500, 2200, 1900, 2400, 2450],
                backgroundColor: '#1F8FB2',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection