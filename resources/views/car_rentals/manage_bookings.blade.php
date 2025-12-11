@extends('car_rentals.master')

@section('content')

<div class="space-y-6">

    <div class="bg-gradient-to-r from-[#3C4CE9] to-[#5865F2] rounded-2xl p-6 text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Bookings Management</h1>
            <p class="text-lg font-semibold">Total Revenue: $0.00</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-xs uppercase">Total Bookings</p>
            <p class="text-2xl font-bold">{{ $bookings->count() }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-xs uppercase">Confirmed</p>
            <p class="text-2xl font-bold">
                {{ $bookings->where('status', 'confirmed')->count() }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-xs uppercase">Pending</p>
            <p class="text-2xl font-bold">
                {{ $bookings->where('status', 'pending')->count() }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-xs uppercase">Cancelled</p>
            <p class="text-2xl font-bold">
                {{ $bookings->where('status', 'cancelled')->count() }}
            </p>
        </div>
    </div>

    <!-- ALL BOOKINGS TABLE -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">All Bookings</h2>

        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left text-xs font-semibold">Booking ID</th>
                    <th class="p-3 text-left text-xs font-semibold">Guest</th>
                    <th class="p-3 text-left text-xs font-semibold">Property</th>
                    <th class="p-3 text-left text-xs font-semibold">Dates</th>
                    <th class="p-3 text-left text-xs font-semibold">Guests</th>
                    <th class="p-3 text-left text-xs font-semibold">Status</th>
                    <th class="p-3 text-right text-xs font-semibold">Amount (USD)</th>
                    <th class="p-3 text-right text-xs font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 text-sm font-medium">#{{ $booking->id }}</td>

                    <td class="p-3 text-sm">{{ $booking->user->name }}</td>

                    <td class="p-3 text-sm">
                        {{ $booking->car->model->model_name ?? 'Car' }}
                    </td>

                    <td class="p-3 text-sm">
                        {{ $booking->start_date }} → {{ $booking->end_date }}
                    </td>

                    <td class="p-3 text-sm">{{ $booking->guests ?? 1 }}</td>

                    <td class="p-3 text-sm">
                        <form action="{{ route('booking.update_status', $booking->id) }}" method="POST">
                            @csrf
                            <select name="status"
                                class="border rounded px-2 py-1 text-sm"
                                onchange="this.form.submit()">

                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>

                    <td class="p-3 text-right font-bold">${{ number_format($booking->total_price, 2) }}</td>

                    <td class="p-3 text-right">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Message</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection
