@extends('admin.master')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Welcome back, <b>{{ Auth::guard('admin')->user()->username }}</b> 👋</h1>
            <p class="text-gray-500 mt-1">Here's what's happening with your properties today.</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">Today's Date</div>
            <div class="text-lg font-semibold">{{ now()->format('F d, Y') }}</div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Properties -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-[#1F8FB2]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Properties</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalProperties }}</h3>
                </div>
                <span class="text-[#1F8FB2] bg-blue-50 rounded-full p-3">
                    <i class="fas fa-building text-xl"></i>
                </span>
            </div>
            <div class="mt-2">
                <span class="text-green-500 text-sm">
                    <i class="fas fa-arrow-up"></i> +{{ $newPropertiesThisMonth }} this month
                </span>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalPartners + $totalCustomers }}</h3>
                </div>
                <span class="text-purple-500 bg-purple-50 rounded-full p-3">
                    <i class="fas fa-users text-xl"></i>
                </span>
            </div>
            <div class="mt-2">
                <span class="text-purple-500 text-sm">
                    <i class="fas fa-arrow-up"></i> +{{ $newPartnersThisMonth + $newCustomersThisMonth }} this month
                </span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Pending Approvals</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingApprovals }}</h3>
                </div>
                <span class="text-yellow-500 bg-yellow-50 rounded-full p-3">
                    <i class="fas fa-clock text-xl"></i>
                </span>
            </div>
            <div class="mt-2">
                <a href="{{ route('admin.properties.pending') }}" class="text-yellow-500 text-sm hover:underline">
                    View all →
                </a>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Bookings</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</h3>
                </div>
                <span class="text-green-500 bg-green-50 rounded-full p-3">
                    <i class="fas fa-calendar-check text-xl"></i>
                </span>
            </div>
            <div class="mt-2">
                <span class="text-green-500 text-sm">
                    <i class="fas fa-arrow-up"></i> {{ $bookingGrowth }}% growth
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Bookings Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-[#1F8FB2] mb-4">Booking Trends</h2>
            <canvas id="bookingChart" height="300"></canvas>
        </div>

        <!-- Property Distribution Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-[#1F8FB2] mb-4">Property Distribution</h2>
            <canvas id="propertyTypeChart" height="300"></canvas>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-[#1F8FB2]">Recent Bookings</h2>
            <a href="#" class="text-[#1F8FB2] hover:underline">View all</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            #{{ $booking->id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $booking->property->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->property->location }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $booking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $booking->check_in->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-red-100 text-red-800') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No recent bookings
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Properties Pending Approval -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-[#1F8FB2]">Properties Pending Approval</h2>
            <a href="{{ route('admin.properties.pending') }}" class="text-[#1F8FB2] hover:underline">View all</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Partner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingProperties as $property)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     src="{{ optional($property->photos->first())->url ?? asset('images/default-property.jpg') }}"
                                     alt="{{ $property->title }}">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $property->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $property->city }}, {{ $property->country }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $property->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $property->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst($property->type) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $property->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button onclick="approveProperty({{ $property->id }})"
                                        class="text-green-600 hover:text-green-900">Approve</button>
                                <button onclick="rejectProperty({{ $property->id }})"
                                        class="text-red-600 hover:text-red-900">Reject</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No properties pending approval
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>

<!-- Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Booking Trends Chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingStats['labels']) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($bookingStats['data']) !!},
                backgroundColor: 'rgba(31, 143, 178, 0.1)',
                borderColor: '#1F8FB2',
                borderWidth: 2,
                tension: 0.4,
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
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Property Distribution Chart
    const propertyCtx = document.getElementById('propertyTypeChart').getContext('2d');
    const propertyChart = new Chart(propertyCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($propertyTypeStats)) !!},
            datasets: [{
                data: {!! json_encode(array_values($propertyTypeStats)) !!},
                backgroundColor: [
                    '#1F8FB2',
                    '#3CC0E9',
                    '#64D2F4',
                    '#9BE3F9'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '70%'
        }
    });
</script>

<script>
    function approveProperty(id) {
        if (confirm('Are you sure you want to approve this property?')) {
            fetch(`/admin/properties/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            }).then(data => {
                alert('Property approved successfully');
                window.location.reload();
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to approve property');
            });
        }
    }

    function rejectProperty(id) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason) {
            fetch(`/admin/properties/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ reason })
            }).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            }).then(data => {
                alert('Property rejected successfully');
                window.location.reload();
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to reject property');
            });
        }
    }
</script>
@endsection
