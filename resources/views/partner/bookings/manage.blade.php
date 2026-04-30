@extends('partner.master')
@section('title', 'Bookings')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Bookings</h1>
                <p class="text-gray-500 text-sm">Manage property reservations</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400">Total Revenue</p>
                <p class="text-lg font-semibold text-gray-800">{{ \App\Helpers\CurrencyHelper::convertAndFormat($bookings->sum('total_price'), 'USD', 'USD') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Total</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $bookings->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Confirmed</p>
            <p class="text-xl font-semibold text-green-600 mt-1">{{ $bookings->where('status', 'confirmed')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Pending</p>
            <p class="text-xl font-semibold text-yellow-600 mt-1">{{ $bookings->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Cancelled</p>
            <p class="text-xl font-semibold text-red-600 mt-1">{{ $bookings->where('status', 'cancelled')->count() }}</p>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">All Bookings</h2>
            <button class="text-[#1F8FB2] text-sm hover:underline">Export</button>
        </div>

        <!-- Mobile Cards -->
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse($bookings as $booking)
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="text-sm font-medium text-gray-900">#{{ $booking->id }}</span>
                        <p class="text-xs text-gray-500">{{ $booking->user->name ?? 'Guest' }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-xs font-medium
                        @if($booking->status == 'confirmed') bg-green-100 text-green-700
                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <p class="text-xs text-gray-600">{{ $booking->property->title ?? 'Property' }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d') }}</span>
                    <span class="text-sm font-medium text-green-600">{{ \App\Helpers\CurrencyHelper::convertAndFormat($booking->total_price, $booking->currency ?? 'USD', 'USD') }}</span>
                </div>
                <div class="flex gap-2 mt-3">
                    <select class="booking-status-select flex-1 text-xs border border-gray-200 rounded px-2 py-1" data-booking-id="{{ $booking->id }}">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button class="update-status-btn bg-[#1F8FB2] text-white px-3 py-1 rounded text-xs" data-booking-id="{{ $booking->id }}">Update</button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400 text-sm">No bookings yet</div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Guest</th>
                        <th class="px-4 py-2 text-left">Property</th>
                        <th class="px-4 py-2 text-left">Dates</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-right">Amount</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">#{{ $booking->id }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $booking->user->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $booking->property->title ?? 'Property' }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-xs font-medium
                                @if($booking->status == 'confirmed') bg-green-100 text-green-700
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($booking->status == 'completed') bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-green-600">
                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($booking->total_price, $booking->currency ?? 'USD', 'USD') }}
                            @if($booking->deal_id)
                            <span class="text-xs text-blue-500 block">Deal applied</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <select class="booking-status-select text-xs border border-gray-200 rounded px-2 py-1" data-booking-id="{{ $booking->id }}">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button class="update-status-btn bg-[#1F8FB2] text-white px-2 py-1 rounded text-xs hover:bg-[#1a7a99]" data-booking-id="{{ $booking->id }}">Update</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400">No bookings yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.update-status-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const bookingId = this.dataset.bookingId;
        const select = this.closest('tr, div').querySelector('.booking-status-select');

        fetch('/partner/bookings/' + bookingId + '/status', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: select.value })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + data.message);
        });
    });
});
</script>
@endsection
