@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">My Properties</h1>
        <a href="{{ route('partner.list-your-property') }}" class="text-white px-4 py-2 rounded shadow hover:opacity-90 transition" style="background-color: #1F8FB2;">
            Add New Property
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Total Properties</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->totalProperties }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Active Properties</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->activeProperties }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Pending Approval</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->pendingApproval }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
            <h2 class="text-sm text-gray-500">Inactive</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $stats->inactiveProperties }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Property List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Property Name</th>
                        <th class="px-4 py-2">Type</th>
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
                        <td class="px-4 py-2">{{ $property['type'] }}</td>
                        <td class="px-4 py-2">{{ $property['location'] }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ $property['status'] }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $property['bookings'] }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('partner.properties.views', $property['id']) }}" class="bg-[#1F8FB2] text-white px-3 py-1 rounded text-xs hover:opacity-90 transition mr-2">View Details</a>
                            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition mr-2">Edit</button>
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection