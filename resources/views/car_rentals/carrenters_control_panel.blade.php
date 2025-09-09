@extends('car_rentals.master')


@section('content')
  <div class="space-y-8 p-8">
    <!-- Header -->
  <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] rounded-2xl p-8 text-white">
    <div class="flex justify-between items-center">
        <div>
            @if(Auth::guard('car_renter')->check())
                <h1 class="text-4xl font-bold mb-2">
                    Welcome back, {{ Auth::guard('car_renter')->user()->full_name ?? Auth::guard('car_renter')->user()->company_name }}! 👋
                </h1>
                <p class="text-blue-100 text-lg">Manage your properties and track your success</p>
            @endif
        </div>
        <a href="{{ route('renter.types') }}"
           class="bg-white text-[#1F8FB2] px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg">
            <i class="fa-solid fa-plus mr-2"></i> Add Vehicle
        </a>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Properties</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">30</p>
          </div>
          <div class="bg-[#1F8FB2] bg-opacity-10 p-3 rounded-xl">
            <i class="fas fa-building text-[#1F8FB2] text-2xl"></i>
          </div>
        </div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Bookings</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">12</p>
          </div>
          <div class="bg-green-100 p-3 rounded-xl">
            <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
          </div>
        </div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Monthly Earnings</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">$50,000</p>
          </div>
          <div class="bg-yellow-100 p-3 rounded-xl">
            <i class="fas fa-dollar-sign text-yellow-600 text-2xl"></i>
          </div>
        </div>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Average Rating</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">5⭐</p>
          </div>
          <div class="bg-purple-100 p-3 rounded-xl">
            <i class="fas fa-star text-purple-600 text-2xl"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
      <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold text-gray-800">Recent Bookings</h2>
          <a href="#" class="text-[#1F8FB2] hover:text-[#3CC0E9] font-medium">
            View All <i class="fas fa-arrow-right ml-1"></i>
          </a>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Booking ID</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Guest</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Property</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Check-in</th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Earnings</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium text-gray-900">#B001</td>
              <td class="px-6 py-4 text-sm text-gray-900">John Doe</td>
              <td class="px-6 py-4 text-sm text-gray-900">Luxury Apartment</td>
              <td class="px-6 py-4 text-sm text-gray-900">2025-06-06</td>
              <td class="px-6 py-4">
                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
              </td>
              <td class="px-6 py-4 text-right text-sm font-bold text-green-600">$1200</td>
            </tr>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium text-gray-900">#B002</td>
              <td class="px-6 py-4 text-sm text-gray-900">Jane Smith</td>
              <td class="px-6 py-4 text-sm text-gray-900">Cozy Studio</td>
              <td class="px-6 py-4 text-sm text-gray-900">2025-06-10</td>
              <td class="px-6 py-4">
                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
              </td>
              <td class="px-6 py-4 text-right text-sm font-bold text-green-600">$800</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
      <div class="p-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">Monthly Earnings Overview</h2>
        <p class="text-gray-600 mt-1">Track your earnings and booking trends</p>
      </div>
      <div class="p-6" style="height: 400px;">
        <canvas id="earningsChart"></canvas>
      </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Quick Actions -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
          <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
          <p class="text-gray-600 mt-1">Manage your business efficiently</p>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 gap-4">
            <a href="#" class="flex items-center p-4 bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] text-white rounded-xl hover:shadow-lg">
              <i class="fas fa-plus-circle text-2xl mr-4"></i>
              <div>
                <div class="font-semibold">Add New Property</div>
                <div class="text-sm opacity-90">List a new property</div>
              </div>
            </a>
            <a href="#" class="flex items-center p-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg">
              <i class="fas fa-calendar-alt text-2xl mr-4"></i>
              <div>
                <div class="font-semibold">Manage Bookings</div>
                <div class="text-sm opacity-90">View and manage reservations</div>
              </div>
            </a>
            <a href="#" class="flex items-center p-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:shadow-lg">
              <i class="fas fa-chart-line text-2xl mr-4"></i>
              <div>
                <div class="font-semibold">View Earnings</div>
                <div class="text-sm opacity-90">Track your revenue</div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-100">
          <h3 class="text-xl font-bold text-gray-800">Recent Activity</h3>
          <p class="text-gray-600 mt-1">Latest updates and notifications</p>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="bg-blue-100 p-2 rounded-full">
                <i class="fas fa-bell text-blue-600 text-sm"></i>
              </div>
              <div class="flex-1">
                <p class="text-gray-800">New booking received from John Doe</p>
                <p class="text-xs text-gray-500 mt-1">Just now</p>
              </div>
            </div>
            <div class="flex items-start space-x-3">
              <div class="bg-blue-100 p-2 rounded-full">
                <i class="fas fa-bell text-blue-600 text-sm"></i>
              </div>
              <div class="flex-1">
                <p class="text-gray-800">Property "Cozy Studio" got a 5⭐ review</p>
                <p class="text-xs text-gray-500 mt-1">5 minutes ago</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('earningsChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(31, 143, 178, 0.8)');
    gradient.addColorStop(1, 'rgba(31, 143, 178, 0.1)');

    const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
    gradient2.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
    gradient2.addColorStop(1, 'rgba(16, 185, 129, 0.1)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [
          {
            label: 'Earnings ($)',
            data: [5000, 8000, 12000, 15000, 20000, 25000],
            borderColor: '#1F8FB2',
            backgroundColor: gradient,
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#1F8FB2',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
          },
          {
            label: 'Bookings',
            data: [20, 35, 40, 50, 65, 80],
            borderColor: '#10B981',
            backgroundColor: gradient2,
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#10B981',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: { size: 12, weight: '500' }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#ffffff',
            bodyColor: '#ffffff',
            borderColor: '#1F8FB2',
            borderWidth: 1,
            cornerRadius: 8,
            displayColors: true,
            callbacks: {
              label: function(context) {
                if (context.datasetIndex === 0) {
                  return 'Earnings: $' + context.parsed.y.toLocaleString();
                } else {
                  return 'Bookings: ' + context.parsed.y;
                }
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { size: 11 }, color: '#6B7280' }
          },
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' },
            ticks: {
              font: { size: 11 },
              color: '#6B7280',
              callback: function(value) { return value.toLocaleString(); }
            }
          }
        },
        interaction: { intersect: false, mode: 'index' },
        elements: { point: { hoverBackgroundColor: '#ffffff' } }
      }
    });
  </script>
@endsection