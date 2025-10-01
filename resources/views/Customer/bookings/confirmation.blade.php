@extends('frontend.master')

@section('title', 'Booking Confirmation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
    <style>
        .noto-sans-font {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <section class="bg-[#1F8FB2] text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:underline">Home</a>
                <span>></span>
                <a href="{{ route('customer.bookings.index') }}" class="hover:underline">My Bookings</a>
                <span>></span>
                <span>Confirmation</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold">Booking Confirmation</h1>
            <p class="text-lg mt-1">Your reservation details</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-green-800">Booking Confirmed!</h2>
                    <p class="text-green-700" style="font-family: 'Noto Sans', sans-serif;">
                        Your reservation has been successfully created. Booking ID: #{{ $booking->id }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Property Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($booking->property->photos && $booking->property->photos->count() > 0)
                    <img src="{{ asset('storage/' . $booking->property->photos->first()->file_path) }}" 
                         alt="{{ $booking->property->title }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image available</span>
                    </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $booking->property->title }}</h3>
                    <p class="text-gray-600 mb-4 noto-sans-font">
                        {{ $booking->property->address }}, {{ $booking->property->city }}
                    </p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        {{ optional($booking->property->category)->name ?? 'N/A' }}
                    </span>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Reservation Details</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Booking ID</span>
                        <span class="font-medium">#{{ $booking->id }}</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Check-in</span>
                        <span class="font-medium">{{ $booking->check_in->format('l, M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Check-out</span>
                        <span class="font-medium">{{ $booking->check_out->format('l, M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-medium">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Guests</span>
                        <span class="font-medium">{{ $booking->guest_count }} {{ $booking->guest_count === 1 ? 'guest' : 'guests' }}</span>
                    </div>
                    
                    @if($booking->room_id)
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600">Room</span>
                            <span class="font-medium">{{ $booking->room->name ?? 'N/A' }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between py-3 text-lg font-semibold">
                        <span>Total Amount</span>
                        <span class="text-[#1F8FB2]">LKR {{ number_format($booking->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.bookings.index') }}" 
               class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-6 py-3 rounded-lg font-medium text-center transition duration-200">
                View All Bookings
            </a>
            <a href="{{ route('customer.dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium text-center transition duration-200">
                Back to Home
            </a>
            <button onclick="window.print()" 
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                Print Confirmation
            </button>
        </div>

        <!-- Important Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-lg font-semibold text-blue-800 mb-3">Important Information</h4>
            <ul class="text-blue-700 space-y-2 noto-sans-font">
                <li>• Please arrive at the property between 2:00 PM - 11:00 PM on your check-in date</li>
                <li>• Check-out time is 11:00 AM</li>
                <li>• Please bring a valid ID for verification</li>
                <li>• Contact the property directly for any special requests</li>
                <li>• Cancellation policy applies as per property terms</li>
            </ul>
        </div>
    </div>
</div>
@endsection