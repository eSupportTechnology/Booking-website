@extends('admin.master')

@section('content')
<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg space-y-8">


    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-white">Customer Details</h2>

        <a href="{{ url('/admin/customers') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Customers
        </a>
    </div>

    <!-- Profile Section -->
    <div class="bg-white border rounded-lg shadow p-6 flex items-center space-x-6 relative">
        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#3CC0E9] shadow">
            @if($customer->customerPersonalDetail && $customer->customerPersonalDetail->profile_image)
                <img src="{{ asset('storage/' . $customer->customerPersonalDetail->profile_image) }}" alt="Profile Photo" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-2xl">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800">{{ $customer->customerPersonalDetail->display_name ?? $customer->name }}</h3>
            <p class="text-sm text-gray-600">Customer Profile</p>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🧾 Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Name:</h4>
                <p class="text-gray-700">{{ $customer->name }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $customer->email }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Phone:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->phone_number ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Status:</h4>
                <div class="space-x-2 mt-1">
                    @if($customer->email_verified_at)
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                    @else
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending Verification</span>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Registered On:</h4>
                <p class="text-gray-700">{{ $customer->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Display Name:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->display_name ?? 'Not set' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📞 Contact Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Phone Number:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->phone_number ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $customer->email }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Country:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->country ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">City:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->city ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Address:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->address ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Postcode:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->postal_code ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🎂 Personal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Date of Birth:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->date_of_birth ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Gender:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->gender ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Nationality:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->nationality ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Language:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->language ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Passport Details -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🛂 Passport Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Passport Name:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->passport_name ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Passport Number:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->passportNumber ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Issuing Country:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->issuingCountry ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Expiry Date:</h4>
                <p class="text-gray-700">
                    @if($customer->customerPersonalDetail && $customer->customerPersonalDetail->passport_expiry_date)
                        {{ \Carbon\Carbon::parse($customer->customerPersonalDetail->passport_expiry_date)->format('M d, Y') }}
                    @else
                        Not provided
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Booking Statistics -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📊 Booking Statistics</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="text-sm text-gray-600 mb-1">Total Bookings</h4>
                <p class="text-2xl font-bold text-[#1F8FB2]">{{ $customer->bookings->count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="text-sm text-gray-600 mb-1">Total Spent (USD)</h4>
                @php
                    $totalSpentUsd = 0;
                    foreach($customer->bookings as $booking) {
                        $totalSpentUsd += \App\Helpers\CurrencyHelper::convertPrice(
                            $booking->total_price, 
                            $booking->currency ?? 'USD', 
                            'USD'
                        );
                    }
                @endphp
                <p class="text-2xl font-bold text-[#1F8FB2]">${{ number_format($totalSpentUsd, 2) }}</p>
                <p class="text-xs text-gray-500">Converted to USD</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="text-sm text-gray-600 mb-1">Avg. Booking Value (USD)</h4>
                <p class="text-2xl font-bold text-[#1F8FB2]">
                    ${{ $customer->bookings->count() > 0 ? number_format($totalSpentUsd / $customer->bookings->count(), 2) : '0.00' }}
                </p>
                <p class="text-xs text-gray-500">Converted to USD</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="text-sm text-gray-600 mb-1">Cancelled Bookings</h4>
                <p class="text-2xl font-bold text-[#1F8FB2]">{{ $customer->bookings->where('status', 'cancelled')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Booking History -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📅 Booking History</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (USD)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booked On</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customer->bookings()->orderBy('created_at', 'desc')->get() as $booking)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($booking->property && $booking->property->primaryImage)
                                        <img src="{{ asset('storage/' . $booking->property->primaryImage) }}"
                                             alt="{{ $booking->property->title }}"
                                             class="w-10 h-10 rounded-md object-cover mr-3">
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $booking->property->title ?? 'Unknown Property' }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->property->location ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $bookingAmountUsd = \App\Helpers\CurrencyHelper::convertPrice(
                                        $booking->total_price, 
                                        $booking->currency ?? 'USD', 
                                        'USD'
                                    );
                                    $nights = max(1, $booking->check_in->diffInDays($booking->check_out));
                                @endphp
                                <div class="text-sm font-medium text-gray-900">${{ number_format($bookingAmountUsd, 2) }} USD</div>
                                @if(($booking->currency ?? 'USD') !== 'USD')
                                    <div class="text-xs text-gray-400">{{ $booking->currency }} {{ number_format($booking->total_price, 2) }}</div>
                                @endif
                                <div class="text-xs text-gray-500">
                                    ${{ number_format($bookingAmountUsd / $nights, 2) }}/night
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' :
                                       ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div>{{ $booking->created_at->format('M d, Y') }}</div>
                                <div class="text-xs">{{ $booking->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No bookings found for this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Frequently Booked Properties -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏠 Frequently Booked Properties</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $frequentProperties = $customer->bookings()
                    ->select('property_id')
                    ->selectRaw('COUNT(*) as booking_count')
                    ->groupBy('property_id')
                    ->having('booking_count', '>', 1)
                    ->orderByDesc('booking_count')
                    ->with('property')
                    ->get();
            @endphp

            @forelse($frequentProperties as $frequentBooking)
                @if($frequentBooking->property)
                    <div class="border rounded-lg overflow-hidden">
                        @if($frequentBooking->property->primaryImage)
                            <img src="{{ asset('storage/' . $frequentBooking->property->primaryImage) }}"
                                 alt="{{ $frequentBooking->property->title }}"
                                 class="w-full h-32 object-cover">
                        @endif
                        <div class="p-4">
                            <h4 class="font-medium text-gray-900">{{ $frequentBooking->property->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $frequentBooking->property->location }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-xs font-medium text-[#1F8FB2]">
                                    Booked {{ $frequentBooking->booking_count }} times
                                </span>
                                <span class="text-xs text-gray-500">
                                    Last: {{ $customer->bookings()->where('property_id', $frequentBooking->property->id)->latest()->first()->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center text-gray-500 italic">
                    No properties booked more than once.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
