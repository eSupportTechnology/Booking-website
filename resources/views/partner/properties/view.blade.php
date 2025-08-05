@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">{{ $property['name'] }}</h1>
            <p class="text-gray-600">{{ $property['type'] }} • {{ $property['location'] }}</p>
        </div>
        <div class="flex space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Property</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Property Details</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="mt-1 text-gray-600">{{ $property['description'] }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-block bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ $property['status'] }}</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Bookings</label>
                        <p class="mt-1 text-gray-600">{{ $property['bookings'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Quick Stats</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Property Type:</span>
                    <span class="font-medium">{{ $property['type'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Location:</span>
                    <span class="font-medium">{{ $property['location'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium text-green-600">{{ $property['status'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Bookings:</span>
                    <span class="font-medium">{{ $property['bookings'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Bookings</h2>
        <div class="text-center py-8 text-gray-500">
            <p>No recent bookings to display</p>
        </div>
    </div>
</div>
@endsection