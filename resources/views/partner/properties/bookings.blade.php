@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Bookings</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Bookings</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Confirmed</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['confirmed'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Pending</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
            <h2 class="text-sm text-gray-500">Cancelled</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['cancelled'] }}</p>
        </div>
    </div>

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
                        <th class="px-4 py-2">Check-out</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $booking['id'] }}</td>
                        <td class="px-4 py-2">{{ $booking['guest'] }}</td>
                        <td class="px-4 py-2">{{ $booking['property'] }}</td>
                        <td class="px-4 py-2">{{ $booking['check_in'] }}</td>
                        <td class="px-4 py-2">{{ $booking['check_out'] }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ $booking['status'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-right font-semibold">${{ $booking['amount'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection