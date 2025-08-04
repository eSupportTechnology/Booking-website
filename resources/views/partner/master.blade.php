<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Partner Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-blue-50 text-gray-800">

  <!-- Top Navbar -->
  <nav class="bg-[#1F8FB2] text-white fixed w-full z-50 shadow">
    <div class="max-w-full mx-auto px-4">
      <div class="flex justify-between h-16 items-center">

        <!-- Left: Logo + Hamburger -->
        <div class="flex items-center space-x-4">
          <!-- Hamburger -->
          <button id="menuToggle" class="text-white focus:outline-none block md:hidden">
            <i class="fas fa-bars text-xl"></i>
          </button>
          <a href="#" class="text-xl font-bold">Partner Panel</a>
        </div>

        <!-- Center: Search -->
       <div class="hidden md:flex">
         <input
           type="text"
           placeholder="Search..."
           class="px-3 py-1 rounded bg-[#3CC0E9] placeholder-white text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm"
         />
       </div>

        <!-- Right: Notifications + Profile -->
        <div class="flex items-center space-x-4">
          <div class="relative">
            <button class="text-white">
              <i class="fas fa-bell"></i>
            </button>
            <span class="absolute -top-1 -right-2 bg-red-500 text-xs px-1.5 rounded-full">3</span>
          </div>
          <div class="relative group">
            <button class="text-white flex items-center space-x-1">
              <i class="fas fa-user-circle text-lg"></i>
              <span class="text-sm">{{ Auth::user()->name ?? 'Partner' }}</span>
            </button>
            <div class="absolute right-0 mt-2 bg-white text-black shadow-lg rounded hidden group-hover:block min-w-[150px] z-50">
              <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
              <div class="border-t"></div>
              <form method="POST" action="{{ route('partner.logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar + Content -->
  <div class="flex pt-16 min-h-screen">

    <!-- Sidebar -->
    <aside
      id="sidebar"
      class="w-64 bg-blue-50 text-blue-900 fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40 p-4 shadow-lg"
      x-data="{ openProperty: false }"
    >

      @php
          $appName = config('domains.app_name');
          $domain = config('domains.domain');
          $subdomain = config('domains.subdomain');
      @endphp
      <!-- Branding -->
      <div class="mb-6 flex items-center space-x-3 px-4 py-3">
          @if ($appName === 'BookinTour')
              <h1 class="text-xl font-bold text-bg-[#1F8FB2]">{{ $domain }}</h1>
          @elseif ($appName === 'Inselor')
              <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
          @else
              <h1 class="text-xl font-bold text-gray-700">{{ $subdomain }}</h1>
          @endif
      </div>

      <nav class="space-y-5 text-sm font-medium">

        <!-- MAIN SECTION -->
        <div>
          <a href="{{ route('partner.dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-200 transition font-bold text-blue-900">
            <i class="fas fa-tachometer-alt mr-3 text-bg-[#1F8FB2] text-lg"></i> Dashboard
          </a>
        </div>

        <!-- PROPERTY SECTION -->
        <div>
          <button
            @click="openProperty = !openProperty"
            class="w-full flex justify-between items-center px-4 py-2 rounded hover:bg-blue-200 transition focus:outline-none font-bold text-blue-900"
          >
            <div class="flex items-center">
              <i class="fas fa-building mr-3 text-bg-[#1F8FB2] text-lg"></i> <span>My Properties</span>
            </div>
            <i :class="openProperty ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
          </button>
          <div x-show="openProperty" x-collapse class="ml-8 mt-2 space-y-1 border-l border-blue-300 pl-4">
            <a href="{{ route('partner.list-your-property') }}" class="block py-1 hover:text-blue-700 font-semibold">Add Property</a>
            <a href="{{ route('partner.properties') }}" class="block py-1 hover:text-blue-700 font-semibold">Manage Properties</a>
            <a href="{{ route('partner.bookings') }}" class="block py-1 hover:text-blue-700 font-semibold">Bookings</a>
          </div>
        </div>

        <!-- EARNINGS -->
        <div>
          <a href="{{ route('partner.earnings') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-200 transition text-blue-800 font-bold text-base">
            <i class="fas fa-chart-line mr-3 text-bg-[#1F8FB2] text-lg"></i> Earnings
          </a>
        </div>

        <!-- MESSAGES -->
        <div>
          <a href="{{ route('partner.messages') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-200 transition text-blue-800 font-bold text-base">
            <i class="fas fa-envelope mr-3 text-bg-[#1F8FB2] text-lg"></i> Messages
          </a>
        </div>

        <!-- REVIEWS -->
        <div>
          <a href="{{ route('partner.reviews') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-200 transition text-blue-800 font-bold text-base">
            <i class="fas fa-star mr-3 text-bg-[#1F8FB2] text-lg"></i> Reviews
          </a>
        </div>

        <!-- SETTINGS -->
        <div>
          <a href="{{ route('partner.settings') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-200 transition text-blue-800 font-bold text-base">
            <i class="fas fa-cog mr-3 text-bg-[#1F8FB2] text-lg"></i> Settings
          </a>
        </div>

        <!-- LOGOUT -->
        <div>
          <form method="POST" action="{{ route('partner.logout') }}">
            @csrf
            <button type="submit"
              class="w-full flex items-center justify-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-base shadow-md transition duration-200">
              <i class="fas fa-sign-out-alt mr-2 text-lg"></i> LOGOUT
            </button>
          </form>
        </div>

      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 ml-0 md:ml-5 transition-all duration-200 ease-in-out">
      @yield('content')
    </main>
  </div>

  <!-- Toggle Sidebar Script -->
  <script>
    const toggleButton = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    // Prevent back navigation after logout
    window.addEventListener('pageshow', function(event) {
      if (event.persisted) {
        window.location.href = '{{ route('partner.login') }}';
      }
    });

    // Redirect to login on back button
    window.addEventListener('popstate', function(event) {
      window.location.href = '{{ route('partner.login') }}';
    });

    // Clear history on load
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>