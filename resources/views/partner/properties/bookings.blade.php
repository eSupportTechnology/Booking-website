@extends('partner.master')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl p-6 sm:p-8 text-white w-full">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 w-full">
            <!-- Left Section -->
            <div class="w-full md:w-auto text-center md:text-left">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1 md:mb-2">
                    Bookings Management
                </h1>
                <p class="text-indigo-100 text-sm sm:text-base md:text-lg">
                    Track and manage all your property reservations
                </p>
            </div>

            <!-- Right Section -->
            <div class="w-full md:w-auto text-center md:text-right bg-white/10 md:bg-transparent p-3 md:p-0 rounded-xl">
                <p class="text-indigo-100 text-sm">Total Revenue</p>
                <p class="text-2xl sm:text-3xl font-bold">
                    <x-price :amount="collect($bookings)->sum('amount')" />
                </p>
            </div>
        </div>
    </div>
    


    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Total Bookings</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_bookings'] }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-xl">
                    <i class="fas fa-calendar-alt text-indigo-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Confirmed</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['confirmed'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-check-circle text-green-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-clock text-yellow-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wide">Cancelled</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['cancelled'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-xl">
                    <i class="fas fa-times-circle text-red-600 text-xl sm:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Header + Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">All Bookings</h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-1">Manage your property reservations</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 sm:px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE: Card list (visible on small screens) -->
        <div class="sm:hidden p-4 space-y-4">
            @forelse($bookings as $booking)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-sm text-gray-500">Booking ID</div>
                        <div class="font-semibold text-gray-900">#{{ $booking['id'] }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Amount</div>
                        <div class="font-bold text-green-600">${{ number_format($booking['amount']) }}</div>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <div>
                        <div class="text-xs text-gray-500">Guest</div>
                        <div class="text-sm font-medium text-gray-900">{{ $booking['guest'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Property</div>
                        <div class="text-sm text-gray-900">{{ $booking['property'] }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-500">Dates</div>
                        <div class="text-sm text-gray-900">{{ $booking['check_in'] }} <span class="text-gray-500 text-xs">to</span> {{ $booking['check_out'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Guests</div>
                        <div class="text-sm text-gray-900"><i class="fas fa-users text-gray-400 mr-1"></i>{{ $booking['guest_count'] ?? 1 }}</div>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between">
                    <div>
                        @php
                            $statusColors = [
                                'Confirmed' => 'bg-green-100 text-green-800',
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Cancelled' => 'bg-red-100 text-red-800',
                                'Completed' => 'bg-blue-100 text-blue-800'
                            ];
                            $colorClass = $statusColors[$booking['status']] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">{{ $booking['status'] }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                            <i class="fas fa-eye mr-1"></i>View
                        </button>
                        <a href="{{ route('partner.messages') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs inline-block">
                            <i class="fas fa-envelope mr-1"></i>Message
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-300 text-3xl mb-3"></i>
                <h3 class="text-base font-semibold text-gray-600 mb-1">No Bookings Found</h3>
                <p class="text-gray-500 text-sm">Your bookings will appear here once guests make reservations</p>
            </div>
            @endforelse
        </div>

        <!-- DESKTOP/TABLET: Table (hidden on small screens) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full text-sm sm:text-base">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Guests</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $booking['id'] }}</td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking['guest'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking['property'] }}</td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>
                                <div class="font-medium">{{ $booking['check_in'] }}</div>
                                <div class="text-gray-500 text-xs sm:text-sm">to {{ $booking['check_out'] }}</div>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm text-gray-900">
                            <i class="fas fa-users text-gray-400 mr-1"></i>{{ $booking['guest_count'] ?? 1 }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Confirmed' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Cancelled' => 'bg-red-100 text-red-800',
                                    'Completed' => 'bg-blue-100 text-blue-800'
                                ];
                                $colorClass = $statusColors[$booking['status']] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex px-3 py-1 text-xs sm:text-sm font-semibold rounded-full {{ $colorClass }}">
                                {{ $booking['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                            <x-price :amount="$booking['amount']" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs sm:text-sm transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>View
                                </button>
                                <a href="{{ route('partner.messages') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs sm:text-sm transition-colors duration-200 inline-block">
                                    <i class="fas fa-envelope mr-1"></i>Message
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 sm:px-6 py-12 text-center">
                            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">No Bookings Found</h3>
                            <p class="text-gray-500">Your bookings will appear here once guests make reservations</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
