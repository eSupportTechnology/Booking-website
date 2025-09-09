@extends('car_rentals.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Car Rentals</h1>
                <p class="text-blue-100 text-lg">Manage your car rental listings</p>
            </div>
            <a href="{{ route('renter.types') }}"
                class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add Vehicle
            </a>
        </div>
    </div>

    <!-- Search & Filter (optional, can leave static for now) -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search cars by brand, model, or city..."
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

    <!-- Cars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($cars as $car)
            <div
                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden hover:scale-105">
                <a href="#">
                    <div class="h-48 bg-gray-200 relative">
                       @if($car->files?->first())
    <img src="{{ asset($car->image->path) }}" alt="Car Image" class="w-32 h-32 object-cover">
@else
    <img src="https://via.placeholder.com/400x300" alt="Car" class="w-full h-full object-cover">
@endif
                        <div class="absolute top-4 right-4">
                            <span
                                class="bg-{{ $car->is_active ? 'green' : 'yellow' }}-100 text-{{ $car->is_active ? 'green' : 'yellow' }}-800 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $car->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </a>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $car->brand->brand_name ?? 'Brand' }} {{ $car->model->model_name ?? 'Model' }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <i class="fas fa-car mr-2"></i>{{ $car->carType->name ?? 'Car Type' }}
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">{{ $car->seats ?? 0 }} seats</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $car->fuel_type ?? 'Fuel' }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('cars.show', $car->id) }}"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        <a href="#"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-car text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Cars Found</h3>
                <p class="text-gray-500 mb-6">Start by adding your first car rental</p>
                <a href="{{ route('carrentals.dashboard') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Car Rental
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
