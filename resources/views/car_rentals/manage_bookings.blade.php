@extends('car_rentals.master')

@section('content')

<div class="space-y-6">

    <div class="bg-gradient-to-r from-[#3C4CE9] to-[#5865F2] rounded-2xl p-6 text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Bookings Management</h1>
            @php
                $pendingPayout = $bookings
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->sum('amount');
            @endphp


            <p class="text-lg font-semibold">
                Revenue: ${{ number_format($pendingPayout, 2) }}
            </p>
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
                    <th class="p-3 text-left text-xs font-semibold">Type</th>
                    <th class="p-3 text-left text-xs font-semibold">Booking ID</th>
                    <th class="p-3 text-left text-xs font-semibold">Guest</th>
                    <th class="p-3 text-left text-xs font-semibold">Vehicle</th>
                    <th class="p-3 text-left text-xs font-semibold">Dates</th>
                    <th class="p-3 text-left text-xs font-semibold">Status</th>
                    <th class="p-3 text-right text-xs font-semibold">Amount</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $b)
                    <tr class="hover:bg-gray-50">
                        
                        <!-- Type -->
                        <td class="p-3 text-sm font-bold">
                            @if($b['type'] == 'car')
                                <span class="text-blue-600">CAR</span>
                            @else
                                <span class="text-green-600">TAXI</span>
                            @endif
                        </td>

                        <!-- Booking ID -->
                        <td class="p-3 text-sm font-medium">
                            @if($b['type'] == 'car')
                                #CAR{{ $b['id'] }}
                            @else
                                #TAXI{{ $b['id'] }}
                            @endif
                        </td>

                        <td class="p-3 text-sm">{{ $b['guest'] }}</td>
                        <td class="p-3 text-sm">{{ $b['vehicle'] }}</td>

                        <!-- Dates -->
                        <td class="p-3 text-sm">
                            {{ $b['date_from'] }} → {{ $b['date_to'] }}
                        </td>

                        <!-- Status -->
                        <td class="p-3 text-sm">
                            <span class="
                                inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                @if($b['status']=='pending') bg-yellow-100 text-yellow-700
                                @elseif($b['status']=='confirmed') bg-green-100 text-green-700
                                @elseif($b['status']=='cancelled') bg-red-100 text-red-700
                                @elseif($b['status']=='completed') bg-blue-100 text-blue-700
                                @endif
                            ">
                                {{ ucfirst($b['status']) }}
                            </span>

                            <!-- Change Status Dropdown -->
                            <form action="{{ route('booking.update_status', $b['id']) }}" method="POST" class="mt-1">
                                @csrf
                                <input type="hidden" name="type" value="{{ $b['type'] }}">

                                <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $b['status']=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $b['status']=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $b['status']=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $b['status']=='completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>


                        <!-- Amount -->
                        <td class="p-3 text-right font-bold">
                            ${{ number_format($b['amount'], 2) }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-400">
                            No bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
