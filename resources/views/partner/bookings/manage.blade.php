@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 sm:p-8 text-white text-center sm:text-left">
        <h1 class="text-2xl sm:text-4xl font-bold mb-2">Booking Management</h1>
        <p class="text-green-100 text-base sm:text-lg">Manage your property bookings and their status</p>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">Recent Bookings</h2>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount (USD)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <!-- Mobile Card Layout -->
                    <tr class="block sm:table-row border sm:border-0 rounded-lg sm:rounded-none mb-4 sm:mb-0 shadow-sm sm:shadow-none">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Booking ID: </span>#{{ $booking->id }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Guest: </span>{{ $booking->user->name ?? 'Guest' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Property: </span>{{ $booking->property->title ?? 'Property' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Dates: </span>
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} -
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Amount: </span>
                            <span class="font-semibold text-green-600">
                                {{ \App\Helpers\CurrencyHelper::convertAndFormat($booking->total_price, $booking->currency ?? 'USD', 'USD') }}
                            </span>
                            @if($booking->currency && $booking->currency !== 'USD')
                                <br><span class="text-xs text-gray-500">Original: {{ \App\Helpers\CurrencyHelper::formatPrice($booking->total_price, $booking->currency) }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 block sm:table-cell">
                            <span class="sm:hidden font-semibold text-gray-500">Status: </span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium space-y-2 sm:space-y-0 sm:space-x-2 flex flex-col sm:flex-row sm:items-center sm:justify-start">
                            <select class="booking-status-select text-xs border border-gray-300 rounded px-2 py-1 w-full sm:w-auto" data-booking-id="{{ $booking->id }}">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <button class="update-status-btn bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600 w-full sm:w-auto" data-booking-id="{{ $booking->id }}">
                                Update
                            </button>

                            <a href="{{ route('partner.messages') }}" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600 text-center w-full sm:w-auto">
                                Message
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300"></i>
                            <p>No bookings found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.querySelectorAll('.update-status-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const bookingId = this.dataset.bookingId;
                const select = document.querySelector(`.booking-status-select[data-booking-id="${bookingId}"]`);
                const newStatus = select.value;

                console.log('Updating booking:', bookingId, 'to status:', newStatus);

                fetch('/partner/bookings/' + bookingId + '/status', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update booking status: ' + error.message);
                });
            });
        });
    }, 500);
});
</script>
@endsection
