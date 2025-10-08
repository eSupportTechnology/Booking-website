@extends('Customer.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Bookings</h1>

        @if($bookings->count() > 0)
            <div class="grid gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold">{{ $booking->property->title ?? 'Property' }}</h3>
                                <p class="text-gray-600">{{ $booking->property->address ?? 'Address not available' }}</p>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                @if($booking->payment_status)
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($booking->payment_status === 'completed') bg-green-50 text-green-700
                                        @elseif($booking->payment_status === 'pending') bg-orange-50 text-orange-700
                                        @elseif($booking->payment_status === 'expired') bg-red-50 text-red-700
                                        @else bg-gray-50 text-gray-700 @endif">
                                        Payment: {{ ucfirst($booking->payment_status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="font-medium">Check-in:</span>
                                <p>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="font-medium">Check-out:</span>
                                <p>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="font-medium">Total Price:</span>
                                <p class="text-lg font-bold">LKR {{ number_format($booking->total_price) }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex gap-2 flex-wrap">
                                <span class="text-sm text-gray-600">Guests: {{ $booking->guest_count }}</span>
                                @if($booking->room)
                                    <span class="text-sm text-gray-600">•</span>
                                    <span class="text-sm text-gray-600">Room: {{ $booking->room->name }}</span>
                                @endif
                                <span class="text-sm text-gray-600">•</span>
                                <span class="text-sm text-gray-600">Booked: {{ $booking->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex space-x-2">
                                @if($booking->payment_status === 'pending' && $booking->status !== 'cancelled')
                                    <a href="{{ route('customer.payment.show', $booking) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                                        Complete Payment
                                    </a>
                                @endif
                                
                                @if($booking->canBeReviewed())
                                    <a href="{{ route('customer.reviews.create', $booking) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm transition">
                                        Write Review
                                    </a>
                                @elseif($booking->hasReview())
                                    <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded text-sm">
                                        ✓ Reviewed
                                    </span>
                                @endif
                                
                                @if($booking->status !== 'cancelled')
                                    <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm transition">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📅</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No bookings yet</h3>
                <p class="text-gray-600 mb-6">Start exploring and book your perfect stay!</p>
                <a href="{{ route('home-listing') }}" class="bg-[#3CC0E9] text-white px-6 py-3 rounded-lg hover:bg-[#2BA8D1] transition">
                    Browse Properties
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
