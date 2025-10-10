@extends('frontend.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Reviews</h1>

        @if($reviews->count() > 0)
            <div class="grid gap-6">
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
@endsection
