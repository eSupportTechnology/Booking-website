@extends('frontend.admin.master')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Welcome back, Admin 👋</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            Add New Booking
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h2 class="text-sm text-gray-500">Total Bookings</h2>
            <p class="text-2xl font-bold text-gray-800">1,250</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">New Users</h2>
            <p class="text-2xl font-bold text-gray-800">320</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Revenue</h2>
            <p class="text-2xl font-bold text-gray-800">$18,450</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
            <h2 class="text-sm text-gray-500">Cancellations</h2>
            <p class="text-2xl font-bold text-gray-800">12</p>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Bookings</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Booking ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Property</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">BK10234</td>
                        <td class="px-4 py-2">John Doe</td>
                        <td class="px-4 py-2">Ocean View Hotel</td>
                        <td class="px-4 py-2">2025-07-20</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">Confirmed</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <button class="text-blue-600 hover:underline">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--  Chart Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Bookings Overview</h2>
        <canvas id="bookingChart" height="40"></canvas>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <div class="flex flex-col space-y-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Add Property</button>
                <button class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">Manage Users</button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Review Reports</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Notifications</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>3 new bookings today.</li>
                <li>Partner contract expiring soon.</li>
                <li>System update scheduled for next week.</li>
            </ul>
        </div>
    </div>
</div>

<!--  Enhanced Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                {
                    label: 'Bookings',
                    data: [120, 150, 180, 140, 200, 170, 250],
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#2563eb',
                    pointRadius: 4
                },
                {
                    label: 'Cancellations',
                    data: [20, 30, 15, 25, 18, 22, 10],
                    fill: false,
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#374151',
                        font: { size: 14, weight: 'bold' }
                    }
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    borderColor: '#2563eb',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6b7280', font: { weight: '600' } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6b7280',
                        stepSize: 50,
                        font: { weight: '600' }
                    },
                    grid: {
                        color: '#e5e7eb',
                        lineWidth: 1,
                        borderDash: [5, 5]
                    }
                }
            }
        }
    });
</script>
@endsection
