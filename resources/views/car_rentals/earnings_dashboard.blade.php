@extends('car_rentals.master')
@section('title','Earnings Dashboard')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] rounded-2xl p-6 text-white">
        <h1 class="text-3xl font-bold">Earnings Dashboard</h1>
        <p class="text-blue-100">Track your car rental income</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        @php
            $cards = [
                ['Car Earnings', $carEarnings, 'car', 'blue'],
                ['Taxi Earnings', $taxiEarnings, 'taxi', 'green'],
                ['Gross Earnings', $grossEarnings, 'wallet', 'indigo'],
                ['Total Commission', $totalCommission, 'percent', 'red'],
                ['Net Earnings', $netEarnings, 'chart-line', 'emerald'],
            ];
            @endphp


        @foreach($cards as [$title, $value, $icon, $color])
        <div class="bg-white p-6 rounded-xl shadow border">
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800 mt-2">
                $ {{ number_format($value,2) }}
            </p>
            <i class="fas fa-{{ $icon }} text-{{ $color }}-600 text-xl mt-2"></i>
        </div>
        @endforeach
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">Monthly Earnings</h2>
        <canvas id="earningsChart" height="120"></canvas>
    </div>

    <!-- Transactions -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold">Recent Bookings</h2>
        </div>

        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Booking</th>
                    <th class="px-4 py-2 text-left">Car</th>
                    <th class="px-4 py-2 text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $t['date'] }}</td>
                    <td class="px-4 py-2">#{{ $t['booking_id'] }}</td>
                    <td class="px-4 py-2">{{ $t['car'] }}</td>
                    <td class="px-4 py-2 text-right text-green-600 font-bold">
                        + $ {{ number_format($t['amount'],2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        No earnings yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6">

        @php
            $stats = [
                ['Car Earnings', $carEarnings, 'blue'],
                ['Taxi Earnings', $taxiEarnings, 'green'],
                ['Gross Earnings', $grossEarnings, 'indigo'],
                ['Commission', $totalCommission, 'red'],
                ['Net Earnings', $netEarnings, 'emerald'],
            ];
        @endphp

        @foreach($stats as [$title, $value, $color])
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">{{ $title }}</p>
                <p class="text-2xl font-bold text-{{ $color }}-600 mt-2">
                    $ {{ number_format($value, 2) }}
                </p>
            </div>
        @endforeach

    </div>

        <a href="{{ route('car_rentals.invoice') }}"
        class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg mt-6 inline-block">
        <i class="fas fa-file-pdf mr-2"></i> Download Invoice
        </a>

            </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('earningsChart'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            data: @json($earnings),
            borderColor: '#1F8FB2',
            backgroundColor: 'rgba(31,143,178,0.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { plugins:{ legend:{display:false} } }
});
</script>
@endsection
