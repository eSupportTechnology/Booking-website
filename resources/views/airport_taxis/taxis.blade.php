@extends('car_rentals.master')

@section('content')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 sm:p-8 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2">My Taxis</h1>
                <p class="text-blue-100 text-base sm:text-lg">Manage your registered taxis</p>
            </div>
            <a href="{{ route('renter.types') }}"
            class="bg-white text-blue-600 px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-2"></i>Add Taxi
            </a>
        </div>
    </div>


    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search taxis by number plate or type..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <a href="#"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200">
                <i class="fas fa-times mr-2"></i>Clear
            </a>
        </form>
    </div>

    <!-- Taxis Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($taxi as $taxi)
            <div
                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden hover:scale-105">
                <a href="#">
                    <div class="h-48 bg-gray-200 relative">
                        <!-- Swiper -->
                        <div class="swiper taxi-swiper h-48">
                            <div class="swiper-wrapper">
                                @if($taxi->front_image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/'.$taxi->front_image) }}" alt="Front View"
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif
                                @if($taxi->back_image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/'.$taxi->back_image) }}" alt="Back View"
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif
                                @if($taxi->inside_image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/'.$taxi->inside_image) }}" alt="Inside View"
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif

                                @if(!$taxi->front_image && !$taxi->back_image && !$taxi->inside_image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/placeholder-car.jpg') }}" alt="No Image"
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif
                            </div>
                            <!-- Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>

                        <div class="absolute top-4 right-4">
                            <span
                                class="bg-{{ $taxi->is_active ? 'green' : 'yellow' }}-100 text-{{ $taxi->is_active ? 'green' : 'yellow' }}-800 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $taxi->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </a>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Taxi #{{ $taxi->number_plate ?? 'N/A' }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <i class="fas fa-car mr-2"></i>{{ $taxi->type->name ?? 'Taxi Type' }}
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">{{ $taxi->passenger_capacity ?? 0 }} seats</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $taxi->color ?? 'Color' }}
                        </span>
                    </div>
                    @if($taxi->fare)
                        <p class="text-sm text-gray-600 mb-4">
                            Fare: {{ $taxi->fare->base_fare }} + 
                            {{ $taxi->fare->pricing_type === 'perKm' ? $taxi->fare->price_per_km.' / km' : $taxi->fare->price_per_day.' / day' }}
                        </p>
                    @endif
                    <div class="flex space-x-2">
                        <a href="{{ route('renter.taxis.show', $taxi->id) }}"
                           class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                       <a href="#" 
   onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this taxi?')) { document.getElementById('delete-taxi-{{ $taxi->id }}').submit(); }"
   class="flex-1 inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
   <i class="fas fa-trash-alt mr-1"></i>Delete
</a>

<form id="delete-taxi-{{ $taxi->id }}" action="{{ route('renter.taxis.destroy', $taxi->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-car text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Taxis Found</h3>
                <p class="text-gray-500 mb-6">Start by adding your first taxi</p>
                <a href="{{ route('renter.types') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Taxi
                </a>
            </div>
        @endforelse
    </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.taxi-swiper').forEach(function (el) {
        new Swiper(el, {
            loop: true,
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
        });
    });
});
</script>
@endsection
