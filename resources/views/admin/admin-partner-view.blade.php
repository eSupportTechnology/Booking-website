@extends('admin.master')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Partner Profile Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-start gap-6">
            <!-- Profile Image -->
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center">
                <span class="text-4xl text-gray-400">{{ substr($partner->partner->first_name ?? 'U', 0, 1) }}</span>
            </div>

            <!-- Basic Info -->
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $partner->partner->first_name ?? 'Not Set' }} {{ $partner->partner->last_name ?? '' }}</h1>
                        <p class="text-gray-600">{{ $partner->email ?? 'No email set' }}</p>
                        <p class="text-gray-600">{{ $partner->partner->contact_number ?? 'No contact number' }}</p>
                    </div>
                    <div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            {{ $partner->partner->status === 'active' ? 'bg-green-100 text-green-800' :
                            ($partner->partner->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($partner->partner->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Earnings -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Earnings</h3>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_earnings'], 2) }}</p>
        </div>

        <!-- Monthly Earnings -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500">This Month</h3>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['monthly_earnings'], 2) }}</p>
        </div>

        <!-- Pending Payouts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500">Pending Payouts</h3>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['pending_payouts'], 2) }}</p>
        </div>

        <!-- Completed Payouts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500">Completed Payouts</h3>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['completed_payouts'], 2) }}</p>
        </div>
    </div>

    <!-- Properties Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Property Stats -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Property Overview</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-500 text-sm">Total Properties</p>
                    <p class="text-xl font-bold">{{ $propertyStats['total_properties'] }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Active Properties</p>
                    <p class="text-xl font-bold">{{ $propertyStats['active_properties'] }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Average Rating</p>
                    <p class="text-xl font-bold">{{ $propertyStats['average_rating'] }} ⭐</p>
                </div>
            </div>
        </div>

        <!-- Properties by Category -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Properties by Category</h3>
            <div class="space-y-2">
                @foreach($propertyStats['by_category'] as $category => $count)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $category }}</span>
                    <span class="font-semibold">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Monthly Earnings Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Monthly Earnings</h3>
            <canvas id="monthlyEarningsChart" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">Recent Bookings</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Booking ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Property</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Guest</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Check In</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Check Out</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($latestBookings as $booking)
                    <tr>
                        <td class="px-4 py-3">{{ $booking['id'] }}</td>
                        <td class="px-4 py-3">{{ $booking['property_name'] }}</td>
                        <td class="px-4 py-3">{{ $booking['guest_name'] }}</td>
                        <td class="px-4 py-3">{{ $booking['check_in']->format('M d, Y') }}</td>
                        <td class="px-4 py-3">{{ $booking['check_out']->format('M d, Y') }}</td>
                        <td class="px-4 py-3">${{ number_format($booking['total_amount'], 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $booking['status'] === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($booking['status'] === 'cancelled' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($booking['status']) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payout History -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">Payout History</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Method</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($payoutHistory as $payout)
                    <tr>
                        <td class="px-4 py-3">{{ $payout['date']->format('M d, Y') }}</td>
                        <td class="px-4 py-3">${{ number_format($payout['amount'], 2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payout['method']) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $payout['status'] === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($payout['status'] === 'failed' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($payout['status']) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-sm">{{ $payout['transaction_ref'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">No payout history found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Business Information -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏢 Business Details</h3>
        @php
            $businessProperties = $partner->properties->filter(function($property) {
                return $property->accommodation &&
                       $property->accommodation->ownership_type === 'business_entity' &&
                       $property->accommodation->businessEntities->isNotEmpty();
            });
        @endphp

        @if($businessProperties->isNotEmpty())
            @foreach($businessProperties as $property)
                @foreach($property->accommodation->businessEntities as $entity)
                <div class="mb-8 last:mb-0">
                    <div class="border-b pb-2 mb-4">
                        <h4 class="text-lg font-medium text-gray-800">{{ $entity->business_name }}</h4>
                        @if($entity->trading_name)
                            <p class="text-sm text-gray-600">Trading as: {{ $entity->trading_name }}</p>
                        @endif
                        <p class="text-sm text-gray-500">Associated with property: {{ $property->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-gray-800 font-medium">Business Address:</h4>
                            <p class="text-gray-700">{{ $entity->address }}</p>
                        </div>
                        <div>
                            <h4 class="text-gray-800 font-medium">Location:</h4>
                            <p class="text-gray-700">{{ $entity->city }}, {{ $entity->country }} ({{ $entity->zip_code }})</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        @endif

        @php
            $individualProperties = $partner->properties->filter(function($property) {
                return $property->accommodation &&
                       $property->accommodation->ownership_type === 'individual' &&
                       $property->accommodation->individuals->isNotEmpty();
            });
        @endphp

        @if($individualProperties->isNotEmpty())
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Individual Property Owners</h3>
                @foreach($individualProperties as $property)
                    @foreach($property->accommodation->individuals as $individual)
                    <div class="mb-4 last:mb-0">
                        <div class="border-b pb-2 mb-2">
                            <h4 class="font-medium text-gray-800">{{ $individual->first_name }} {{ $individual->last_name }}</h4>
                            <p class="text-sm text-gray-500">Associated with property: {{ $property->title }}</p>
                        </div>
                        @if($individual->date_of_birth)
                        <p class="text-sm text-gray-600">Date of Birth: {{ \Carbon\Carbon::parse($individual->date_of_birth)->format('Y-m-d') }}</p>
                        @endif
                    </div>
                    @endforeach
                @endforeach
            </div>
        @endif

        @if($businessProperties->isEmpty() && $individualProperties->isEmpty())
            <p class="text-gray-500 italic">No business entities or individual owners registered</p>
        @endif
    </div>

    <!-- Commission Settings Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">💰 Commission Settings</h3>
        
        <form action="{{ route('admin.partner.commission.update', $partner->partner->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Individual Commission Rate</label>
                    <input type="number" 
                           name="commission_rate" 
                           value="{{ $partner->partner->settings->commission_rate ?? '' }}" 
                           step="0.0001" 
                           min="0" 
                           max="1" 
                           placeholder="Leave empty to use global rate"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                    <p class="text-xs text-gray-500 mt-1">Enter as decimal (e.g., 0.12 for 12%)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Current Effective Rate</label>
                    <div class="text-2xl font-bold text-gray-700">
                        {{ number_format($partner->partner->getEffectiveCommissionRate() * 100, 1) }}%
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $partner->partner->settings->commission_rate ? 'Individual rate' : 'Using global rate' }}
                    </p>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-[#1F8FB2] text-white px-6 py-2 rounded hover:bg-[#157799] transition">
                Update Commission Rate
            </button>
        </form>
    </div>

    <!-- Properties Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏠 Listed Properties</h3>
        @if($partner->properties && $partner->properties->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Listed On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($partner->properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($property->photos->first())
                                        <img src="{{ asset('storage/' . $property->photos->first()->image_path) }}"
                                             alt="{{ $property->title }}"
                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <div>{{ $property->title }}</div>
                                        @if($property->accommodation)
                                            <div class="text-xs text-gray-500">
                                                @if($property->accommodation->businessEntities->isNotEmpty())
                                                    {{ $property->accommodation->businessEntities->first()->business_name }}
                                                @else
                                                    Individual Property
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->category->name ?? 'Not Set' }}</div>
                                @if($property->propertySubcategory)
                                    <div class="text-xs text-gray-500">{{ $property->propertySubcategory->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->city }}, {{ $property->country }}</div>
                                @if($property->zipcode)
                                    <div class="text-xs text-gray-500">{{ $property->zipcode }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $property->status === 'active' ? 'bg-green-100 text-green-800' :
                                       ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $property->reviews->count() }} Reviews
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->created_at->format('Y-m-d') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $property->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic">No properties listed yet</p>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Earnings Chart
const ctx = document.getElementById('monthlyEarningsChart');
const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const earningsByMonth = @json($stats['earnings_by_month']);
const monthlyData = Array(12).fill(0);

Object.entries(earningsByMonth).forEach(([month, amount]) => {
    monthlyData[parseInt(month) - 1] = amount;
});

new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthNames,
        datasets: [{
            label: 'Earnings',
            data: monthlyData,
            borderColor: '#3CC0E9',
            backgroundColor: 'rgba(60, 192, 233, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => '$' + value.toLocaleString()
                }
            }
        }
    }
});

// Handle Partner Status Change
function handleStatusChange(status) {
    fetch(`/admin/status/partner/{{ $partner->partner->id }}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the status button class based on new status
            const statusSelect = document.getElementById('partnerStatus');
            const statusClass = data.data.new_status === 'active' ? 'bg-green-100 text-green-800' :
                            data.data.new_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-red-100 text-red-800';

            // Remove old classes and add new ones
            statusSelect.className = `px-4 py-2 rounded-full text-sm font-semibold ${statusClass}`;

            // Show success message
            const successMessage = data.message || 'Status updated successfully';
            Swal.fire({
                title: 'Success!',
                text: successMessage,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        } else {
            throw new Error(data.message || 'Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: error.message || 'Failed to update status',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}
</script>
@endpush
@endsection
