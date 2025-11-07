@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl p-6 sm:p-8 text-white w-full">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 md:gap-6">
            <!-- Left Section -->
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1 md:mb-2 leading-tight text-center md:text-left">
                    Bookings Management
                </h1>
                <p class="text-indigo-100 text-sm sm:text-base md:text-lg text-center md:text-left">
                    Track and manage all your property reservations
                </p>
            </div>

            <!-- Right Section -->
            <div class="flex-1 text-center md:text-right">
                <p class="text-indigo-100 text-sm mb-1 md:mb-2">Total Revenue</p>
                <p class="text-2xl sm:text-3xl md:text-4xl font-bold break-words">
                    {{ \App\Helpers\CurrencyHelper::convertAndFormat($bookings->sum('total_price'), 'USD', 'USD') }}
                </p>
            </div>
        </div>
    </div>


    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Total Bookings</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $bookings->count() }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-alt text-indigo-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Confirmed</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-check-circle text-green-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $bookings->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-clock text-yellow-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Cancelled</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-xl">
                    <i class="fas fa-times-circle text-red-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Header + Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">All Bookings</h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-1">Manage your property reservations</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 sm:px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE: Card list (visible on small screens) -->
        <div class="sm:hidden p-4 space-y-4">
            @forelse($bookings as $booking)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-sm text-gray-500">Booking ID</div>
                        <div class="font-semibold text-gray-900">#{{ $booking->id }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Amount</div>
                        <div class="font-bold text-green-600">{{ \App\Helpers\CurrencyHelper::convertAndFormat($booking->total_price, $booking->currency ?? 'USD', 'USD') }}</div>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <div>
                        <div class="text-xs text-gray-500">Guest</div>
                        <div class="text-sm font-medium text-gray-900">{{ $booking->user->name ?? 'Guest' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Property</div>
                        <div class="text-sm text-gray-900">{{ $booking->property->title ?? 'Property' }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-500">Dates</div>
                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} <span class="text-gray-500 text-xs">to</span> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Guests</div>
                        <div class="text-sm text-gray-900"><i class="fas fa-users text-gray-400 mr-1"></i>{{ $booking->guest_count ?? 1 }}</div>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between">
                    <div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <select class="booking-status-select text-xs border border-gray-300 rounded px-2 py-1" data-booking-id="{{ $booking->id }}">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button class="update-status-btn bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600" data-booking-id="{{ $booking->id }}">
                            Update
                        </button>
                        <a href="{{ route('partner.messages') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs inline-block">
                            <i class="fas fa-envelope mr-1"></i>Message
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-300 text-3xl mb-3"></i>
                <h3 class="text-base font-semibold text-gray-600 mb-1">No Bookings Found</h3>
                <p class="text-gray-500 text-sm">Your bookings will appear here once guests make reservations</p>
            </div>
            @endforelse
        </div>

        <!-- DESKTOP/TABLET: Table (hidden on small screens) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full text-sm sm:text-base">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Guests</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Amount (USD)</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->user->name ?? 'Guest' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->property->title ?? 'Property' }}</td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }}</div>
                                <div class="text-gray-500 text-xs sm:text-sm">to {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</div>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">
                            <i class="fas fa-users text-gray-400 mr-1"></i>{{ $booking->guest_count ?? 1 }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs sm:text-sm font-semibold rounded-full
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($booking->total_price, $booking->currency ?? 'USD', 'USD') }}
                            @if($booking->currency && $booking->currency !== 'USD')
                                <br><span class="text-xs text-gray-500">{{ \App\Helpers\CurrencyHelper::formatPrice($booking->total_price, $booking->currency) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <select class="booking-status-select text-xs border border-gray-300 rounded px-2 py-1" data-booking-id="{{ $booking->id }}">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button class="update-status-btn bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs" data-booking-id="{{ $booking->id }}">
                                    Update
                                </button>
                                <a href="{{ route('partner.messages') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs inline-block">
                                    <i class="fas fa-envelope mr-1"></i>Message
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 sm:px-6 py-12 text-center">
                            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Bookings Found</h3>
                            <p class="text-gray-500">Your bookings will appear here once guests make reservations</p>
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
    document.querySelectorAll('.update-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            const parentContainer = this.closest('tr, .bg-white');
            const select = parentContainer.querySelector('.booking-status-select');
            
            if (!select) {
                alert('Status selector not found');
                return;
            }
            
            const newStatus = select.value;
            
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
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
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
});
</script>
@endsection
