@extends('partner.master')
@section('title', 'Reviews')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Reviews</h1>
                <p class="text-gray-500 text-sm">Manage guest feedback</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-semibold text-gray-800">{{ $stats->averageRating }}</span>
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm text-gray-500">avg rating</span>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Total Reviews</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $stats->totalReviews }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">This Month</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $stats->monthlyReviews }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">Response Rate</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $stats->responseRate }}%</p>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 uppercase">5-Star Reviews</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">75%</p>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">Rating Distribution</h2>
            </div>
            <div class="p-4 space-y-2">
                @foreach([5 => 75, 4 => 20, 3 => 4, 2 => 1, 1 => 0] as $stars => $percent)
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-4 text-gray-600">{{ $stars }}</span>
                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#1F8FB2] rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                    <span class="w-8 text-gray-500 text-right">{{ $percent }}%</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">Insights</h2>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 bg-green-50 rounded-lg">
                    <p class="text-xs text-gray-600">Most Praised</p>
                    <p class="text-sm font-medium text-gray-800">Cleanliness</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-gray-600">Avg Response</p>
                    <p class="text-sm font-medium text-gray-800">2.5 hours</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg">
                    <p class="text-xs text-gray-600">Would Recommend</p>
                    <p class="text-sm font-medium text-gray-800">98%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Recent Reviews</h2>
            <button class="text-[#1F8FB2] text-sm hover:underline">Export</button>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($reviews as $review)
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1F8FB2] rounded-full flex items-center justify-center text-white text-xs font-medium flex-shrink-0">
                            {{ substr($review['guest_name'], 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $review['guest_name'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $review['property_name'] }}</p>
                            <div class="flex items-center gap-1 mt-1">
                                @for($i = 0; $i < $review['rating']; $i++)
                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                                <span class="text-xs text-gray-400 ml-1">{{ $review['date'] }}</span>
                            </div>
                        </div>
                    </div>
                    @if(!$review['reply'])
                    <button class="text-sm text-[#1F8FB2] hover:underline">Reply</button>
                    @else
                    <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded">Replied</span>
                    @endif
                </div>
                <p class="text-sm text-gray-700 ml-11">"{{ $review['comment'] }}"</p>
                @if($review['reply'])
                <div class="ml-11 mt-2 p-2 bg-gray-50 rounded text-sm">
                    <span class="font-medium text-gray-700">Your reply:</span>
                    <span class="text-gray-600">{{ $review['reply'] }}</span>
                </div>
                @endif
            </div>
            @empty
            <div class="p-8 text-center text-gray-400 text-sm">No reviews yet</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
