@extends('frontend.master')

@section('title', 'My Bookings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <section class="bg-[#1F8FB2] text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:underline">Home</a>
                <span>></span>
                <span>My Bookings</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold">My Bookings</h1>
            <p class="text-lg mt-1">Manage your reservations</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="md:flex">
                            <!-- Property Image -->
                            <div class="md:w-1/3">
                                @if($booking->property->photos->count() > 0)
                                    <img src="{{ asset('storage/' . $booking->property->photos->first()->file_path) }}" 
                                         alt="{{ $booking->property->title }}" 
                                         class="w-full h-48 md:h-full object-cover">
                                @else
                                    <div class="w-full h-48 md:h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">No image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Booking Details -->
                            <div class="md:w-2/3 p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $booking->property->title }}</h3>
                                        <p class="text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                                            {{ $booking->property->address }}, {{ $booking->property->city }}
                                        </p>
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-2">
                                            {{ $booking->property->category->name }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Check-in</p>
                                        <p class="font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Check-out</p>
                                        <p class="font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Guests</p>
                                        <p class="font-medium">{{ $booking->guest_count }} {{ $booking->guest_count === 1 ? 'guest' : 'guests' }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-xl font-bold text-gray-800">LKR {{ number_format($booking->total_price) }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('customer.bookings.confirmation', $booking) }}" 
                                           class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                            View Details
                                        </a>
                                        @if($booking->status === 'pending' || $booking->status === 'confirmed')
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="max-w-md mx-auto">
                    <img src="{{ asset('assets/booking.svg') }}" alt="No bookings" class="w-24 h-24 mx-auto mb-4 opacity-50">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No bookings yet</h3>
                    <p class="text-gray-600 mb-6" style="font-family: 'Noto Sans', sans-serif;">
                        Start exploring amazing properties and make your first booking!
                    </p>
                    <a href="{{ route('customer.dashboard') }}" 
                       class="inline-block bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        Explore Properties
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection