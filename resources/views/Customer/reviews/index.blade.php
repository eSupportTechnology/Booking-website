@extends('frontend.master')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-[#0071C2] text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center gap-2 text-sm text-blue-200 mb-4">
                <a href="{{ route('customer.profile') }}" class="hover:text-white">My Account</a>
                <span>></span>
                <span class="text-white">Reviews</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">My Reviews</h1>
            <p class="text-blue-100">Share your experiences and help other travelers</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 -mt-16 relative z-10 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <p class="text-4xl font-bold text-[#0071C2]">{{ $reviews->total() }}</p>
                <p class="text-gray-600 mt-1">Total Reviews</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                @php
                    $avgRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
                @endphp
                <p class="text-4xl font-bold text-yellow-500">{{ number_format($avgRating, 1) }}</p>
                <p class="text-gray-600 mt-1">Average Rating</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                @php
                    $pendingReviews = \App\Models\Booking::where('user_id', auth()->guard('customer')->id())
                        ->where('status', 'confirmed')
                        ->where('check_out', '<=', now())
                        ->whereDoesntHave('reviews')
                        ->count();
                @endphp
                <p class="text-4xl font-bold text-green-500">{{ $pendingReviews }}</p>
                <p class="text-gray-600 mt-1">Pending Reviews</p>
            </div>
        </div>

        @if($reviews->count() > 0)
            <!-- Reviews List -->
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Property Image -->
                                <div class="w-full md:w-48 flex-shrink-0">
                                    @php
                                        $photo = $review->property && $review->property->photos && $review->property->photos->count() > 0
                                            ? asset('storage/' . $review->property->photos->first()->path)
                                            : asset('assets/default-property.jpg');
                                    @endphp
                                    <img src="{{ $photo }}" alt="{{ $review->property->title ?? 'Property' }}"
                                         class="w-full h-32 md:h-full object-cover rounded-lg">
                                </div>

                                <!-- Review Content -->
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                {{ $review->property->title ?? 'Property' }}
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $review->property->address ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                Reviewed on {{ $review->created_at->format('M d, Y') }}
                                            </p>
                                        </div>

                                        <!-- Rating -->
                                        <div class="flex items-center gap-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-lg font-bold text-gray-900">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>

                                    <!-- Review Text -->
                                    @if($review->comment)
                                        <div class="mt-4">
                                            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                        </div>
                                    @endif

                                    <!-- Category Ratings -->
                                    @if($review->staff_rating || $review->cleanliness_rating || $review->location_rating)
                                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                                            @if($review->staff_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Staff</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->staff_rating, 1) }}</p>
                                                </div>
                                            @endif
                                            @if($review->cleanliness_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Cleanliness</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->cleanliness_rating, 1) }}</p>
                                                </div>
                                            @endif
                                            @if($review->comfort_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Comfort</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->comfort_rating, 1) }}</p>
                                                </div>
                                            @endif
                                            @if($review->location_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Location</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->location_rating, 1) }}</p>
                                                </div>
                                            @endif
                                            @if($review->value_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Value</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->value_rating, 1) }}</p>
                                                </div>
                                            @endif
                                            @if($review->facilities_rating)
                                                <div class="bg-gray-50 rounded-lg p-2 text-center">
                                                    <p class="text-xs text-gray-500">Facilities</p>
                                                    <p class="font-semibold text-[#0071C2]">{{ number_format($review->facilities_rating, 1) }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Booking Info -->
                                    @if($review->booking)
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <p class="text-sm text-gray-500">
                                                <span class="font-medium">Stay:</span>
                                                {{ \Carbon\Carbon::parse($review->booking->check_in)->format('M d') }} -
                                                {{ \Carbon\Carbon::parse($review->booking->check_out)->format('M d, Y') }}
                                                @if($review->booking->room)
                                                    <span class="mx-2">|</span>
                                                    <span class="font-medium">Room:</span> {{ $review->booking->room->name }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">No reviews yet</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    After you complete a stay, you'll be able to share your experience and help other travelers make informed decisions.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('customer.reservations.index') }}"
                       class="px-6 py-3 bg-[#0071C2] text-white rounded-lg font-medium hover:bg-[#005B9E] transition">
                        View My Bookings
                    </a>
                    <a href="{{ route('home-listing') }}"
                       class="px-6 py-3 border border-[#0071C2] text-[#0071C2] rounded-lg font-medium hover:bg-blue-50 transition">
                        Browse Properties
                    </a>
                </div>
            </div>
        @endif

        <!-- Pending Reviews Section -->
        @php
            $pendingBookings = \App\Models\Booking::with(['property', 'property.photos'])
                ->where('user_id', auth()->guard('customer')->id())
                ->where('status', 'confirmed')
                ->where('check_out', '<=', now())
                ->whereDoesntHave('reviews')
                ->latest()
                ->limit(5)
                ->get();
        @endphp

        @if($pendingBookings->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Waiting for Your Review</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($pendingBookings as $booking)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            @php
                                $photo = $booking->property && $booking->property->photos && $booking->property->photos->count() > 0
                                    ? asset('storage/' . $booking->property->photos->first()->path)
                                    : asset('assets/default-property.jpg');
                            @endphp
                            <img src="{{ $photo }}" alt="{{ $booking->property->title ?? 'Property' }}"
                                 class="w-full h-32 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $booking->property->title ?? 'Property' }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                </p>
                                <a href="{{ route('customer.reviews.create', $booking) }}"
                                   class="mt-3 block w-full text-center px-4 py-2 bg-[#0071C2] text-white rounded-lg text-sm font-medium hover:bg-[#005B9E] transition">
                                    Write Review
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
