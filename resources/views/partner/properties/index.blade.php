@extends('partner.master')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">My Properties</h1>
                <p class="text-green-100 text-lg">Manage and monitor all your listed properties</p>
            </div>
            <a href="{{ route('partner.list-your-property') }}" class="bg-white text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-green-50 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add New Property
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->totalProperties }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-building text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Properties</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->activeProperties }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Approval</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->pendingApproval }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Inactive</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->inactiveProperties }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-xl">
                    <i class="fas fa-pause-circle text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Property List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Property List</h2>
                    <p class="text-gray-600 mt-1">Manage all your properties in one place</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bookings</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($properties as $property)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-home text-gray-500"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $property['name'] }}</div>
                                    <div class="text-sm text-gray-500">ID: #{{ $property['id'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $property['type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                            {{ $property['location'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $property['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-check text-gray-400 mr-2"></i>
                                {{ $property['bookings'] }} bookings
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('partner.properties.views', $property['id']) }}" class="bg-[#1F8FB2] hover:bg-[#3CC0E9] text-white px-3 py-2 rounded-lg text-xs transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs transition-colors duration-200">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs transition-colors duration-200">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection