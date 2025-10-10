@extends('frontend.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full lg:w-1/3 space-y-4 border rounded-md overflow-hidden divide-y divide-gray-200 bg-white">
                <div class="flex items-center gap-4 p-4">
                    <div class="bg-yellow-400 text-black rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg">
                        {{ substr(Auth::guard('customer')->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-lg">{{ Auth::guard('customer')->user()->name ?? 'User' }}</p>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Edit your profile</a>
                    </div>
                </div>
                <div class="flex justify-between p-4">
                    <span>All reviews</span>
                    <span>{{ $reviews->total() ?? 0 }}</span>
                </div>
                <div class="flex justify-between p-4">
                    <span>Property reviews</span>
                    <span>{{ $reviews->total() ?? 0 }}</span>
                </div>
            </div>

            <!-- Reviews Content -->
            <div class="flex-1">
                @if($reviews && $reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <x-review-card :review="$review" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">⭐</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No reviews yet</h3>
                        <p class="text-gray-600 mb-6">Complete a stay to leave your first review!</p>
                        <a href="{{ route('customer.bookings.index') }}" class="bg-[#3CC0E9] text-white px-6 py-3 rounded-lg hover:bg-[#2BA8D1] transition">
                            View My Bookings
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
