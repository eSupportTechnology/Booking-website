@extends('admin.master')

@section('content')
<div class="space-y-6 px-3 sm:px-6">

    <!-- Page Title -->
    <h1 class="text-2xl font-semibold text-gray-800">Aging Report</h1>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1F8FB2] focus:border-[#1F8FB2]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1F8FB2] focus:border-[#1F8FB2]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Property Type</label>
                <select name="property_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1F8FB2] focus:border-[#1F8FB2]">
                    <option value="">All Types</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type['id'] }}" {{ $propertyType == $type['id'] ? 'selected' : '' }}>
                            {{ $type['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1F8FB2] focus:border-[#1F8FB2]">
                    <option value="">All Status</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ $status == $statusOption ? 'selected' : '' }}>
                            {{ ucfirst($statusOption) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex justify-start">
                <button type="submit" class="bg-[#1F8FB2] text-white px-6 py-2 rounded hover:bg-[#157799] transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($agingData as $period => $bookings)
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-[#1F8FB2] text-center sm:text-left">
                <h3 class="text-sm font-medium text-gray-500">{{ $period }}</h3>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $bookings->count() }}</p>
                <p class="text-sm text-green-600">${{ number_format($bookings->sum('total_price'), 2) }}</p>
            </div>
        @endforeach
    </div>

    <!-- Bookings Table / Mobile Cards -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium">Booking Details</h3>
        </div>

        <!-- Desktop Table (Hidden on Small Screens) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Property</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Age</th>
                        <th class="px-4 py-2 text-left">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agingData as $bookings)
                        @foreach($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium">#{{ $booking->id }}</td>
                                <td class="px-4 py-2">{{ $booking->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 max-w-xs truncate" title="{{ $booking->property->title ?? '' }}">
                                    {{ $booking->property->title ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2 font-semibold text-green-600">${{ number_format($booking->total_price, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded
                                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                           ($booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700')) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $booking->created_at->diffInDays() }} days</td>
                                <td class="px-4 py-2">{{ $booking->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (Only on Small Screens) -->
        <div class="sm:hidden divide-y">
            @foreach($agingData as $bookings)
                @foreach($bookings as $booking)
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="font-medium">#{{ $booking->id }}</span>
                            <span class="text-green-600 font-semibold">${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        <div><span class="text-gray-500">Customer:</span> {{ $booking->user->name ?? 'N/A' }}</div>
                        <div><span class="text-gray-500">Property:</span> {{ Str::limit($booking->property->title ?? 'N/A', 30) }}</div>
                        <div>
                            <span class="text-gray-500">Status:</span>
                            <span class="ml-1 px-2 py-1 text-xs rounded
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                   ($booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div><span class="text-gray-500">Age:</span> {{ $booking->created_at->diffInDays() }} days</div>
                        <div><span class="text-gray-500">Created:</span> {{ $booking->created_at->format('M d, Y') }}</div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
