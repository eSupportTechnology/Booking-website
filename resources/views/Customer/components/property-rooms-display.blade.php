{{-- Enhanced Property Rooms Display Component --}}
<section id="rooms" class="py-8 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Available Rooms & Rates</h2>
            <div class="flex items-center text-blue-500 text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 010 8m-4-4h4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a4 4 0 00-4-4m0 0H8a4 4 0 000 8m0 0H6a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004 4" />
                </svg>
                We Price Match
            </div>
        </div>

        @if($property->rooms->count() > 0)
            <!-- Room Type Grouping -->
            @php
                $roomsByType = $property->rooms->groupBy('room_type_id');
            @endphp

            <div class="space-y-6">
                @foreach($roomsByType as $typeId => $rooms)
                    @php
                        $firstRoom = $rooms->first();
                        $roomType = $firstRoom->roomType;
                        $roomCount = $rooms->count();
                        $minPrice = $rooms->min('price_per_night');
                        $maxPrice = $rooms->max('price_per_night');
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <!-- Room Type Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $roomType->name ?? 'Standard Room' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $roomCount }} {{ Str::plural('room', $roomCount) }} of this type
                                    </p>
                                </div>
                                <div class="text-right">
                                    @if($minPrice == $maxPrice)
                                        <div class="text-xl font-bold text-gray-900">
                                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($minPrice, $firstRoom->currency ?? 'USD') }}
                                        </div>
                                    @else
                                        <div class="text-xl font-bold text-gray-900">
                                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($minPrice, $firstRoom->currency ?? 'USD') }} - {{ \App\Helpers\CurrencyHelper::convertAndFormat($maxPrice, $firstRoom->currency ?? 'USD') }}
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500">per night</div>
                                </div>
                            </div>
                        </div>

                        <!-- Room Details -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Room Information -->
                                <div class="lg:col-span-2 space-y-4">
                                    <!-- Room Features -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                            <span>{{ $firstRoom->max_guests }} guests</span>
                                        </div>

                                        @if($firstRoom->size_sq_m)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z"/>
                                            </svg>
                                            <span>{{ $firstRoom->size_sq_m }} m²</span>
                                        </div>
                                        @endif

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 2v1h6V2h2v1h1c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h1V2h2z"/>
                                            </svg>
                                            <span>{{ $firstRoom->bathroom_count }} {{ $firstRoom->bathroom_type }}</span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M2 16h20v2H2zm1.5-5L12 7.5 20.5 11 12 14.5z"/>
                                            </svg>
                                            <span>{{ $firstRoom->smoking_allowed ? 'Smoking allowed' : 'Non-smoking' }}</span>
                                        </div>
                                    </div>

                                    <!-- Room Description -->
                                    @if($firstRoom->description)
                                    <div>
                                        <p class="text-sm text-gray-700">{{ $firstRoom->description }}</p>
                                    </div>
                                    @endif

                                    <!-- Bed Configuration -->
                                    @if($firstRoom->beds->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Bed Configuration:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($firstRoom->beds as $bed)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                                    <img src="{{ asset('assets/mdi_bed-single.svg') }}" alt="Bed" class="w-3 h-3 mr-1">
                                                    {{ $bed->pivot->count ?? 1 }}x {{ $bed->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Room Amenities -->
                                    @if($firstRoom->amenities->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Room Amenities:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($firstRoom->amenities->take(8) as $amenity)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                                    {{ $amenity->name }}
                                                </span>
                                            @endforeach
                                            @if($firstRoom->amenities->count() > 8)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                    +{{ $firstRoom->amenities->count() - 8 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Rate Plans -->
                                    @if($firstRoom->ratePlans->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Rate Options:</h4>
                                        <div class="space-y-2">
                                            @foreach($firstRoom->ratePlans as $plan)
                                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <div class="font-medium text-sm">{{ $plan->name }}</div>
                                                        @if($plan->policy_notes)
                                                            <div class="text-xs text-gray-500 mt-1">{{ $plan->policy_notes }}</div>
                                                        @endif
                                                        <div class="flex items-center mt-1 space-x-4 text-xs text-gray-600">
                                                            @if($plan->is_refundable)
                                                                <span class="text-green-600">✓ Refundable</span>
                                                            @else
                                                                <span class="text-red-600">✗ Non-refundable</span>
                                                            @endif
                                                            @if($plan->min_nights > 1)
                                                                <span>Min {{ $plan->min_nights }} nights</span>
                                                            @endif
                                                            @if($plan->cancellation_days)
                                                                <span>Cancel {{ $plan->cancellation_days }} days before</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        @if($plan->discount > 0)
                                                            <div class="text-sm text-red-500 line-through">
                                                                {{ \App\Helpers\CurrencyHelper::convertAndFormat($firstRoom->price_per_night, $firstRoom->currency ?? 'USD') }}
                                                            </div>
                                                        @endif
                                                        <div class="text-lg font-bold text-gray-900">
                                                            {{ \App\Helpers\CurrencyHelper::convertAndFormat($plan->price, $firstRoom->currency ?? 'USD') }}
                                                        </div>
                                                        @if($plan->discount > 0)
                                                            <div class="text-xs text-green-600 font-medium">
                                                                {{ $plan->discount }}% off
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Booking Actions -->
                                <div class="space-y-4">
                                    <!-- Availability Status -->
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm font-medium text-green-800">Available</span>
                                        </div>
                                        <p class="text-xs text-green-700 mt-1">
                                            {{ $roomCount }} {{ Str::plural('room', $roomCount) }} available
                                        </p>
                                    </div>

                                    <!-- Quick Booking -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h5 class="font-medium text-blue-900 mb-2">Quick Book</h5>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-blue-700">Base rate:</span>
                                                <span class="font-medium text-blue-900">{{ \App\Helpers\CurrencyHelper::convertAndFormat($minPrice, $firstRoom->currency ?? 'USD') }}</span>
                                            </div>
                                            @if($property->services && $property->services->breakfast_included)
                                                <div class="text-green-600 text-xs">✓ Breakfast included</div>
                                            @endif
                                            @if($property->services && $property->services->parking_available)
                                                <div class="text-green-600 text-xs">✓ Free parking</div>
                                            @endif
                                        </div>
                                        <a href="{{ route('customer.bookings.show', $property) }}" 
                                           class="block w-full bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white text-center py-2 rounded font-medium mt-3 transition-colors">
                                            Select Dates & Book
                                        </a>
                                    </div>

                                    <!-- Room Details Link -->
                                    <button onclick="showRoomDetails({{ $typeId }})" 
                                            class="w-full text-[#3CC0E9] hover:text-[#2BA8D1] text-sm font-medium border border-[#3CC0E9] hover:border-[#2BA8D1] rounded py-2 transition-colors">
                                        View All {{ $roomCount }} {{ Str::plural('Room', $roomCount) }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- No Rooms Available -->
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No specific rooms configured</h3>
                <p class="mt-1 text-sm text-gray-500">This property offers accommodation without specific room types.</p>
                <div class="mt-6">
                    <a href="{{ route('customer.bookings.show', $property) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#3CC0E9] hover:bg-[#2BA8D1]">
                        Book This Property
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
function showRoomDetails(roomTypeId) {
    // This could open a modal or navigate to a detailed room view
    console.log('Show details for room type:', roomTypeId);
    // Example: Open modal with all rooms of this type
    // You could implement a modal here or navigate to a detailed page
}
</script>