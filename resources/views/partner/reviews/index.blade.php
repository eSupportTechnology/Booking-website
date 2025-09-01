@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Reviews & Ratings</h1>
                <p class="text-orange-100 text-lg">Manage guest feedback and maintain your reputation</p>
            </div>
            <div class="text-right">
                <div class="bg-white/20 px-6 py-3 rounded-xl">
                    <p class="text-orange-100 text-sm">Average Rating</p>
                    <p class="text-3xl font-bold">4.8 ⭐</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Overall Rating</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->averageRating }} ⭐</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+0.2 from last month
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-star text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Reviews</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->totalReviews }}</p>
                    <p class="text-sm text-blue-600 mt-1">
                        <i class="fas fa-plus mr-1"></i>8 new this month
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-comments text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">This Month</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->monthlyReviews }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                        <i class="fas fa-calendar mr-1"></i>January 2025
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Response Rate</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->responseRate }}%</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-check mr-1"></i>Excellent
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-reply text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Rating Distribution -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Rating Distribution</h2>
                <p class="text-gray-600 mt-1">Breakdown of all ratings received</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 w-8">5 ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">95 (75%)</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 w-8">4 ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: 20%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">25 (20%)</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 w-8">3 ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full" style="width: 4%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">5 (4%)</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 w-8">2 ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-orange-500 h-3 rounded-full" style="width: 1%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">1 (1%)</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 w-8">1 ⭐</span>
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            <div class="bg-red-500 h-3 rounded-full" style="width: 0%"></div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">1 (0%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Review Insights</h2>
                <p class="text-gray-600 mt-1">Key metrics and trends</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-thumbs-up text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Most Praised</p>
                                <p class="text-sm text-gray-600">Cleanliness & Location</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Avg Response Time</p>
                                <p class="text-sm text-gray-600">2.5 hours</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-heart text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Guest Satisfaction</p>
                                <p class="text-sm text-gray-600">98% would recommend</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Recent Reviews</h2>
                    <p class="text-gray-600 mt-1">Latest feedback from your guests</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                @forelse($reviews as $review)
                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-start space-x-4">
                            <div class="h-12 w-12 bg-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ substr($review['guest_name'], 0, 2) }}</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $review['guest_name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $review['property_name'] }}</p>
                                <div class="flex items-center mt-1">
                                    <div class="text-yellow-500 mr-2">{{ str_repeat('⭐', $review['rating']) }}</div>
                                    <span class="text-xs text-gray-500">{{ $review['rating'] }}.0 • {{ $review['date'] }}</span>
                                </div>
                            </div>
                        </div>
                        @if($review['reply'])
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Replied</span>
                        @else
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-reply mr-1"></i>Reply
                        </button>
                        @endif
                    </div>
                    <p class="text-gray-700 mb-4">"{{ $review['comment'] }}"</p>
                    @if($review['reply'])
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600"><strong class="text-gray-800">Your reply:</strong> {{ $review['reply'] }}</p>
                        <span class="text-xs text-gray-500 mt-2 block">Replied {{ $review['date'] }}</span>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-12">
                    <i class="fas fa-star text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Reviews Yet</h3>
                    <p class="text-gray-500">Reviews from your guests will appear here</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection