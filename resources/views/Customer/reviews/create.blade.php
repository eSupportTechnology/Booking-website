@extends('Customer.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Booking Details Header -->
            <div class="bg-blue-50 p-6 border-b">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Write a Review</h1>
                        <h2 class="text-xl font-semibold text-blue-600">{{ $booking->property->title }}</h2>
                        <p class="text-gray-600">{{ $booking->property->address }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                        <h3 class="font-semibold text-gray-800 mb-2">Your Booking</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Check-in:</span> {{ $booking->check_in->format('M d, Y') }}</p>
                            <p><span class="font-medium">Check-out:</span> {{ $booking->check_out->format('M d, Y') }}</p>
                            <p><span class="font-medium">Guests:</span> {{ $booking->guest_count }}</p>
                            @if($booking->room)
                                <p><span class="font-medium">Room:</span> {{ $booking->room->name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('customer.reviews.store', $booking) }}" method="POST" class="p-6">
                @csrf
                
                <!-- Overall Rating -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-700 mb-4">Overall Rating *</label>
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Detailed Ratings -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    @php
                        $categories = [
                            'staff_rating' => 'Staff',
                            'facilities_rating' => 'Facilities',
                            'cleanliness_rating' => 'Cleanliness',
                            'comfort_rating' => 'Comfort',
                            'value_rating' => 'Value for Money',
                            'location_rating' => 'Location',
                            'wifi_rating' => 'WiFi'
                        ];
                    @endphp

                    @foreach($categories as $field => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="{{ $field }}" value="{{ $i }}" class="sr-only peer">
                                        <svg class="w-5 h-5 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Comment -->
                <div class="mb-8">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                    <textarea name="comment" id="comment" rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Share your experience with other travelers...">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('customer.bookings.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle star rating interactions
    const ratingGroups = document.querySelectorAll('input[type="radio"]');
    
    ratingGroups.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update visual feedback for the selected rating
            const name = this.name;
            const value = parseInt(this.value);
            const group = document.querySelectorAll(`input[name="${name}"]`);
            
            group.forEach((input, index) => {
                const star = input.nextElementSibling;
                if (index < value) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-300');
                } else {
                    star.classList.add('text-gray-300');
                    star.classList.remove('text-yellow-400');
                }
            });
        });
    });
});
</script>
@endsection