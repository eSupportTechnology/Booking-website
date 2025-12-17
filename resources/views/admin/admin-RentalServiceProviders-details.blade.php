@extends('admin.master')
@section('title', 'Rental Service Provider Details')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyEarningsChart');

const earningsByMonth = @json($stats['earnings_by_month']);
const monthLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const data = Array(12).fill(0);

Object.entries(earningsByMonth).forEach(([month, amount]) => {
    data[parseInt(month) - 1] = amount;
});

new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthLabels,
        datasets: [{
            data,
            borderColor: '#1F8FB2',
            backgroundColor: 'rgba(31,143,178,0.15)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rs ' + v.toLocaleString()
                }
            }
        }
    }
});
</script>

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-2 sm:p-4">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap mb-3 sm:mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center flex-wrap space-x-1 md:space-x-3 text-xs sm:text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <a href="{{ route('admin.rental-providers') }}" class="text-gray-700 hover:text-blue-600">Rental Service Providers</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <span class="text-gray-500">Provider Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6 leading-tight">
            Rental Service Provider Details - #{{ $provider->id }}
        </h1>
        <!-- Financial Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">

            <!-- Total Earnings -->
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Earnings</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rs {{ number_format($stats['total_earnings'], 2) }}
                </p>
            </div>

            <!-- This Month -->
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-sm text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rs {{ number_format($stats['monthly_earnings'], 2) }}
                </p>
            </div>

            <!-- Pending Payouts -->
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-sm text-gray-500">Pending Payouts</p>
                <p class="text-2xl font-bold text-yellow-600">
                    Rs {{ number_format($stats['pending_payouts'], 2) }}
                </p>
            </div>

            <!-- Completed Payouts -->
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <p class="text-sm text-gray-500">Completed Payouts</p>
                <p class="text-2xl font-bold text-green-600">
                    Rs {{ number_format($stats['completed_payouts'], 2) }}
                </p>
            </div>

            <!-- Admin Total Earnings -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 border-l-4 border-green-500">
                <p class="text-sm text-gray-500">Admin Total Earnings</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rs {{ number_format($stats['admin_total_earnings'], 2) }}
                </p>
            </div>

            <!-- Admin Earnings This Month -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 border-l-4 border-blue-500">
                <p class="text-sm text-gray-500">Admin Earnings (This Month)</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rs {{ number_format($stats['admin_monthly_earnings'], 2) }}
                </p>
            </div>

        </div>


        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                Completed Reservations
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Vehicle</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Period</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Commission</th>
                            <th class="px-4 py-2">Admin Earn</th>
                            <th class="px-4 py-2">Provider Earn</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($completedReservations as $r)
                        <tr>
                            <td class="px-4 py-2">#{{ $r['id'] }}</td>
                            <td class="px-4 py-2">{{ $r['vehicle'] }}</td>
                            <td class="px-4 py-2">{{ $r['vehicle_type'] }}</td>
                            <td class="px-4 py-2">
                                {{ $r['start_date'] }} → {{ $r['end_date'] }}
                            </td>
                            <td class="px-4 py-2 font-semibold">
                                ${{ number_format($r['total_price'], 2) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $r['commission_rate'] }}%
                            </td>
                            <td class="px-4 py-2 text-green-600 font-semibold">
                                ${{ number_format($r['commission_amount'], 2) }}
                            </td>
                            <td class="px-4 py-2 text-blue-600 font-semibold">
                                ${{ number_format($r['provider_earning'], 2) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($r['created_at'])->format('Y-m-d') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                No completed reservations found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

       <!-- Completed Taxi Bookings -->
<div class="bg-white border border-gray-200 rounded-lg p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Completed Taxi Bookings
    </h2>

    @if($completedTaxiBookings->count())
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Booking ID</th>
                        <th class="px-4 py-2 text-left">Taxi</th>
                        <th class="px-4 py-2 text-left">Taxi Type</th>
                        <th class="px-4 py-2 text-left">Trip Date</th>
                        <th class="px-4 py-2 text-left">Total Fare</th>
                        <th class="px-4 py-2 text-left">Commission</th>
                        <th class="px-4 py-2 text-left">Admin Earns</th>
                        <th class="px-4 py-2 text-left">Provider Earns</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($completedTaxiBookings as $booking)
                        @php
                            $typeId = optional($booking->taxi->type)->id;

                            $rate = optional($taxiCommissions->get($typeId))->commission_rate;
                            $rate = $rate !== null ? $rate : 15;

                            $adminEarning    = ($booking->total_amount * $rate) / 100;
                            $providerEarning = $booking->total_amount - $adminEarning;
                        @endphp



                        <tr>
                            <td class="px-4 py-2 font-medium">
                                {{ $booking->booking_id }}
                            </td>

                            <td class="px-4 py-2">
                                Taxi #{{ $booking->taxi_id }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $booking->taxi->type->name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('Y-m-d') }}
                            </td>

                            <td class="px-4 py-2 font-semibold">
                                Rs {{ number_format($booking->total_amount, 2) }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $rate }}%
                            </td>

                            <td class="px-4 py-2 text-green-700 font-semibold">
                                Rs {{ number_format($adminEarning, 2) }}
                            </td>

                            <td class="px-4 py-2 text-blue-700 font-semibold">
                                Rs {{ number_format($providerEarning, 2) }}
                            </td>

                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 text-center py-4">
            No completed taxi bookings found
        </p>
    @endif
</div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Provider Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                @if($provider->isCompany()) bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($provider->account_type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-sm text-gray-900">{{ $provider->email }}</p>
                        </div>
                        @if($provider->isCompany())
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <p class="text-sm text-gray-900">{{ $provider->company_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Registration No</label>
                            <p class="text-sm text-gray-900">{{ $provider->business_reg_no ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">TIN Number</label>
                            <p class="text-sm text-gray-900">{{ $provider->tin_number ?? 'N/A' }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <p class="text-sm text-gray-900">{{ $provider->full_name }}</p>
                        </div>
                        @if($provider->nic_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIC Number</label>
                            <p class="text-sm text-gray-900">{{ $provider->nic_number }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <p class="text-sm text-gray-900">{{ $provider->phone }}</p>
                        </div>
                        @if($provider->phone2)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone 2</label>
                            <p class="text-sm text-gray-900">{{ $provider->phone2 }}</p>
                        </div>
                        @endif
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <p class="text-sm text-gray-900">{{ $provider->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cars Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Cars ({{ $provider->cars->count() }})</h2>
                    @if($provider->cars->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Brand</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Price/Day</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($provider->cars as $car)
                                <tr>
                                    <td class="px-4 py-2">#{{ $car->id }}</td>
                                    <td class="px-4 py-2">{{ $car->carType->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $car->brand->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            @if($car->status === 'Active') bg-green-100 text-green-800 
                                            @elseif($car->status === 'Inactive') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">${{ number_format($car->price_per_day, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No cars registered</p>
                    @endif
                </div>

                <!-- Taxis Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Taxis ({{ $provider->taxis->count() }})</h2>
                    @if($provider->taxis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Number Plate</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Capacity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($provider->taxis as $taxi)
                                <tr>
                                    <td class="px-4 py-2">#{{ $taxi->id }}</td>
                                    <td class="px-4 py-2">{{ $taxi->type->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $taxi->number_plate ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            @if($taxi->status === 'Active') bg-green-100 text-green-800 
                                            @elseif($taxi->status === 'Inactive') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $taxi->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $taxi->passenger_capacity ?? 'N/A' }} passengers</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No taxis registered</p>
                    @endif
                </div>
            </div>

            <!-- Commission Settings -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                     Commission Rates by Vehicle Category
                </h2>

                <form method="POST"
                    action="{{ route('admin.car-renters.vehicle-type-commission.update', $provider->id) }}">
                    @csrf

                    <div class="space-y-4">
                        @foreach($vehicleTypes as $type)
                            @php
                                $rate = $provider->getCommissionRateForVehicleType($type->id);
                            @endphp

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between
                                        border rounded-lg p-4 gap-3">

                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $type->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $rate == 15 ? 'Using default rate (15%)' : 'Custom rate applied' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        max="100"
                                        name="commissions[{{ $type->id }}]"
                                        value="{{ $rate }}"
                                        class="w-24 border rounded px-3 py-2
                                            focus:outline-none focus:ring-2
                                            focus:ring-[#1F8FB2] text-sm">
                                    <span class="text-sm text-gray-500">%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit"
                            class="mt-6 bg-[#1F8FB2] text-white px-6 py-2 rounded
                                hover:bg-[#157799] transition">
                        Update Commission Rates
                    </button>
                </form>

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Taxi Commission Rates by Type
            </h2>

            <!-- Taxi Commission Settings -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                         Taxi Commission Rates by Type
                    </h2>

                    <form method="POST"
                        action="{{ route('admin.car-renters.taxi-commission.update', $provider->id) }}">
                        @csrf

                        <div class="space-y-4">
                            @foreach($taxiTypes as $type)
                                @php
                                    $rate = $taxiCommissions[$type->id]->commission_rate ?? 15;
                                @endphp

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between
                                            border rounded-lg p-4 gap-3">

                                    <div>
                                        <p class="font-medium text-gray-800">{{ $type->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $rate == 15 ? 'Using default rate (15%)' : 'Custom rate applied' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <input
                                            type="number"
                                            step="0.1"
                                            min="0"
                                            max="100"
                                            name="commissions[{{ $type->id }}]"
                                            value="{{ $rate }}"
                                            class="w-24 border rounded px-3 py-2
                                                focus:outline-none focus:ring-2
                                                focus:ring-[#1F8FB2] text-sm">
                                        <span class="text-sm text-gray-500">%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit"
                            class="mt-6 bg-[#1F8FB2] text-white px-6 py-2 rounded
                                hover:bg-[#157799] transition">
                            Update Taxi Commission Rates
                        </button>
                    </form>
                </div>

            </div>

            <!-- Summary Card -->
            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Cars</span>
                            <span class="font-semibold">{{ $provider->cars->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Taxis</span>
                            <span class="font-semibold">{{ $provider->taxis->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Cars</span>
                            <span class="font-semibold">{{ $provider->cars->where('status', 'Active')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Taxis</span>
                            <span class="font-semibold">{{ $provider->taxis->where('status', 'Active')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Member Since</span>
                            <span class="font-semibold">{{ $provider->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($provider->isCompany() && $provider->company_logo)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Company Logo</h2>
                    <img src="{{ asset('storage/' . $provider->company_logo) }}" alt="Company Logo" class="w-full h-32 object-contain">
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection