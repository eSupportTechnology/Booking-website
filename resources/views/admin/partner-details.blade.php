@extends('admin.master')

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
                    <select id="partnerStatus"
                            onchange="handleStatusChange(this.value)"
                            class="px-4 py-2 rounded-full text-sm font-semibold {{ $partner->partner->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <option value="active" {{ $partner->partner->is_verified ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ !$partner->partner->is_verified ? 'selected' : '' }}>Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
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
    <div class="bg-white rounded-lg shadow-sm p-6">
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
    fetch(`/admin/partners/{{ $partner->id }}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI or show success message
            alert('Status updated successfully');
        } else {
            throw new Error('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}
</script>
@endpush
@endsection
