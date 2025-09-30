@extends('frontend.master')

@section('title', 'Book ' . $property->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
@endpush

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <section class="bg-[#1F8FB2] text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:underline">Home</a>
                <span>></span>
                <a href="{{ route($property->category->name === 'Hotel, B&Bs, and more' ? 'hotel-listing' : 
                    ($property->category->name === 'Apartment' ? 'apartment-listing' : 
                    ($property->category->name === 'Homes' ? 'home-listing' : 'alternative-places-listing'))) }}" 
                   class="hover:underline">{{ $property->category->name }}</a>
                <span>></span>
                <span>{{ $property->title }}</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold">{{ $property->title }}</h1>
            <p class="text-lg mt-1">{{ $property->address }}, {{ $property->city }}</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Property Details -->
            <div class="lg:col-span-2">
                <!-- Image Gallery -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    @if($property->photos->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-4">
                            <div class="md:row-span-2">
                                <img src="{{ asset('storage/' . $property->photos->first()->file_path) }}" 
                                     alt="{{ $property->title }}" 
                                     class="w-full h-64 md:h-full object-cover rounded-lg">
                            </div>
                            @foreach($property->photos->skip(1)->take(4) as $photo)
                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                     alt="{{ $property->title }}" 
                                     class="w-full h-32 object-cover rounded-lg">
                            @endforeach
                        </div>
                    @else
                        <div class="h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No images available</span>
                        </div>
                    @endif
                </div>

                <!-- Property Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">About this property</h2>
                    <p class="text-gray-600 mb-4" style="font-family: 'Noto Sans', sans-serif;">
                        {{ $property->description }}
                    </p>
                    
                    @if($property->amenities->count() > 0)
                        <h3 class="text-lg font-semibold mb-3">Amenities</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($property->amenities->take(9) as $amenity)
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $amenity->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <div class="mb-4">
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-bold">LKR {{ number_format($property->pricing->base_price ?? 5000) }}</span>
                            <span class="text-gray-600">per night</span>
                        </div>
                    </div>

                    <form action="{{ route('customer.bookings.store', $property) }}" method="POST" 
                          x-data="{ 
                              checkIn: '', 
                              checkOut: '', 
                              guests: 2,
                              calculateTotal() {
                                  if (this.checkIn && this.checkOut) {
                                      const nights = Math.ceil((new Date(this.checkOut) - new Date(this.checkIn)) / (1000 * 60 * 60 * 24));
                                      return nights * {{ $property->pricing->base_price ?? 5000 }};
                                  }
                                  return 0;
                              }
                          }">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">

                        <!-- Check-in/Check-out -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                                <input type="date" name="check_in" x-model="checkIn" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
                                <input type="date" name="check_out" x-model="checkOut" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Guests -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                            <select name="guest_count" x-model="guests" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'guest' : 'guests' }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Room Selection (if available) -->
                        @if($property->rooms->count() > 0)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                <select name="room_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Room (Optional)</option>
                                    @foreach($property->rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Price Breakdown -->
                        <div class="border-t pt-4 mb-4" x-show="checkIn && checkOut">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Base price × <span x-text="Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24))"></span> nights</span>
                                <span>LKR <span x-text="calculateTotal().toLocaleString()"></span></span>
                            </div>
                            <div class="flex justify-between font-semibold text-lg border-t pt-2">
                                <span>Total</span>
                                <span>LKR <span x-text="calculateTotal().toLocaleString()"></span></span>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white font-semibold py-3 rounded-lg transition duration-200">
                            Reserve Now
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 text-center mt-3" style="font-family: 'Noto Sans', sans-serif;">
                        You won't be charged yet
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection