@extends('Customer.master')

@push('styles')
<style>
    .bg-primary {
        background-color: #3CC0E9;
    }
    .bg-primary-dark {
        background-color: #2BA8D1;
    }
</style>
@endpush

@section('content')
<!-- Search Results Section -->
<div class="container mx-auto px-4 py-8">
    <!-- Search Results Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Search Results</h1>
        <p class="text-gray-600">{{ $properties->total() }} properties found</p>
    </div>

    <!-- Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($properties as $property)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Property Image -->
                <div class="relative h-48">
                    @if($property->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $property->images->first()->path) }}"
                             alt="{{ $property->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No image available</span>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $property->name }}</h3>

                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-gray-600 text-sm">
                            {{ optional($property->address)->city ?? 'N/A' }}, {{ optional($property->address)->country ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center mb-3">
                        @if($property->reviews_count > 0)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 ml-1">
                                    {{ number_format($property->reviews_avg_rating ?? 0, 1) }}
                                    ({{ $property->reviews_count }})
                                </span>
                            </div>
                        @else
                            <span class="text-sm text-gray-500">No reviews yet</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-end">
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold text-lg text-gray-800">${{ number_format($property->price_per_night, 2) }}</span> / night
                        </div>
                        <a href="{{ url('/property/'.$property->id) }}"
                           class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-primary-dark transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No properties found</h3>
                <p class="text-gray-500">Try adjusting your search criteria</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $properties->links() }}
    </div>
</div>
@endsection
