@extends('car_rentals.master')
@section('title', 'Reviews & Ratings')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Reviews & Ratings</h1>
                <p class="text-orange-100 text-lg">See what customers say about your vehicles</p>
            </div>
            <div class="text-right">
                <div class="bg-white/20 px-6 py-3 rounded-xl">
                    <p class="text-orange-100 text-sm">Average Rating</p>
                    <p class="text-3xl font-bold">{{ $stats->averageRating }} ⭐</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg border">
            <p class="text-sm text-gray-500 uppercase">Overall Rating</p>
            <p class="text-3xl font-bold mt-2">{{ $stats->averageRating }} ⭐</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border">
            <p class="text-sm text-gray-500 uppercase">Total Reviews</p>
            <p class="text-3xl font-bold mt-2">{{ $stats->totalReviews }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border">
            <p class="text-sm text-gray-500 uppercase">This Month</p>
            <p class="text-3xl font-bold mt-2">{{ $stats->monthlyReviews }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border">
            <p class="text-sm text-gray-500 uppercase">Response Rate</p>
            <p class="text-3xl font-bold mt-2">{{ $stats->responseRate }}%</p>
        </div>
    </div>

    <!-- Rating Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Rating Distribution -->
        <div class="bg-white rounded-2xl shadow-lg border">
            <div class="p-6 border-b">
                <h2 class="text-2xl font-bold">Rating Distribution</h2>
            </div>

            <div class="p-6 space-y-4">
                @php $total = array_sum($ratingCounts); @endphp

                @for($i = 5; $i >= 1; $i--)
                    @php
                        $count = $ratingCounts[$i] ?? 0;
                        $percent = $total > 0 ? round(($count / $total) * 100) : 0;
                    @endphp
                    <div class="flex items-center space-x-4">
                        <span class="w-8 text-sm font-semibold">{{ $i }} ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="w-16 text-sm text-gray-600">
                            {{ $count }} ({{ $percent }}%)
                        </span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Review Insights -->
        <div class="bg-white rounded-2xl shadow-lg border">
            <div class="p-6 border-b">
                <h2 class="text-2xl font-bold">Review Insights</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="p-4 bg-green-50 rounded-xl">
                    <strong>Most Praised:</strong> Vehicle Condition & Cleanliness
                </div>
                <div class="p-4 bg-blue-50 rounded-xl">
                    <strong>Avg Response Time:</strong> Fast
                </div>
                <div class="p-4 bg-purple-50 rounded-xl">
                    <strong>Customer Satisfaction:</strong> High
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white rounded-2xl shadow-lg border">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold">Recent Reviews</h2>
        </div>

        <div class="p-6 space-y-6">
            @forelse($reviews as $review)
                <div class="border rounded-xl p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex space-x-4">
                            <div class="h-12 w-12 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">
                                    {{ substr($review['guest_name'], 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold">{{ $review['guest_name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $review['property_name'] }}</p>
                                <p class="text-yellow-500">
                                    {{ str_repeat('⭐', $review['rating']) }}
                                    <span class="text-xs text-gray-500 ml-2">{{ $review['date'] }}</span>
                                </p>
                            </div>
                        </div>

                        @if($review['reply'])
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">Replied</span>
                        @else
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm">
                                Reply
                            </button>
                        @endif
                    </div>

                    <p class="mt-4 text-gray-700">"{{ $review['comment'] }}"</p>

                    @if($review['reply'])
                        <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                            <strong>Your reply:</strong> {{ $review['reply'] }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    No reviews yet
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
