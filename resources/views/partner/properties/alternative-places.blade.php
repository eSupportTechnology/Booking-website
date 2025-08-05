@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Alternative Places Listings</h1>
        <a href="{{ route('partner.list-your-property') }}" class="text-white px-4 py-2 rounded shadow hover:opacity-90 transition" style="background-color: #1F8FB2;">
            Add New Alternative Place
        </a>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" class="flex space-x-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search alternative places by name or location..." class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Search</button>
            @if($search)
                <a href="{{ route('partner.properties.alternative-places') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">Clear</a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Alternative Places</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $counts->alternativePlaces }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Active</h2>
            <p class="text-2xl font-bold text-gray-800">{{ collect($properties)->where('status', 'Active')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Pending</h2>
            <p class="text-2xl font-bold text-gray-800">{{ collect($properties)->where('status', 'Pending')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <h2 class="text-sm text-gray-500">Total Bookings</h2>
            <p class="text-2xl font-bold text-gray-800">{{ collect($properties)->sum('bookings') }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Alternative Place Properties</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Property Name</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Bookings</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $property['name'] }}</td>
                        <td class="px-4 py-2">{{ $property['location'] }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ $property['status'] }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $property['bookings'] }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('partner.properties.view', $property['id']) }}" class="text-green-600 hover:underline mr-2">View</a>
                            <button class="text-blue-600 hover:underline mr-2">Edit</button>
                            <button class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection