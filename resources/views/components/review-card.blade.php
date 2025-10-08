@props(['review'])

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-start mb-4">
        <div class="flex-1">
            <h3 class="text-xl font-semibold text-gray-900">{{ $review->property->title }}</h3>
            <p class="text-gray-600">{{ $review->property->address }}</p>
            <div class="flex items-center mt-2">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="ml-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                </div>
                <span class="ml-4 text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        
        <!-- Booking Details Corner -->
        <div class="bg-blue-50 rounded-lg p-3 ml-4 border-l-4 border-blue-500">
            <h4 class="font-semibold text-gray-800 text-sm mb-1">Your Stay</h4>
            <div class="text-xs text-gray-600 space-y-1">
                <p>{{ $review->booking->check_in->format('M d') }} - {{ $review->booking->check_out->format('M d, Y') }}</p>
                <p>{{ $review->booking->guest_count }} guest{{ $review->booking->guest_count > 1 ? 's' : '' }}</p>
                @if($review->booking->room)
                    <p>{{ $review->booking->room->name }}</p>
                @endif
            </div>
        </div>
    </div>

    @if($review->comment)
        <div class="mb-4">
            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
        </div>
    @endif

    <!-- Detailed Ratings -->
    @if($review->staff_rating || $review->facilities_rating || $review->cleanliness_rating || $review->comfort_rating || $review->value_rating || $review->location_rating || $review->wifi_rating)
        <div class="border-t pt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-3">Detailed Ratings</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                @if($review->staff_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Staff:</span>
                        <span class="font-medium">{{ $review->staff_rating }}/5</span>
                    </div>
                @endif
                @if($review->facilities_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Facilities:</span>
                        <span class="font-medium">{{ $review->facilities_rating }}/5</span>
                    </div>
                @endif
                @if($review->cleanliness_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cleanliness:</span>
                        <span class="font-medium">{{ $review->cleanliness_rating }}/5</span>
                    </div>
                @endif
                @if($review->comfort_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Comfort:</span>
                        <span class="font-medium">{{ $review->comfort_rating }}/5</span>
                    </div>
                @endif
                @if($review->value_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Value:</span>
                        <span class="font-medium">{{ $review->value_rating }}/5</span>
                    </div>
                @endif
                @if($review->location_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Location:</span>
                        <span class="font-medium">{{ $review->location_rating }}/5</span>
                    </div>
                @endif
                @if($review->wifi_rating)
                    <div class="flex justify-between">
                        <span class="text-gray-600">WiFi:</span>
                        <span class="font-medium">{{ $review->wifi_rating }}/5</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>