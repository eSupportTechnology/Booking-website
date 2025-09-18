<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Partner Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    <a href="{{ route('partner.dashboard') }}" class="text-xl font-bold">Partner Panel</a>
                </div>

                <!-- Center: Search -->
                <div class="hidden md:flex">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-1 rounded bg-[#3CC0E9] placeholder-white text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm" />
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
                        <div
                            class="absolute right-0 bg-white text-black shadow-lg rounded hidden group-hover:block min-w-[150px] z-50">
                            <a href="{{ route('partner.earnings') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Profile</a>
                            <a href="{{ route('partner.settings') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Settings</a>
                            <div class="border-t"></div>
                            <form method="POST" action="{{ route('partner.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 rounded">Logout</button>
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
        <aside id="sidebar"
            class="w-72 bg-white text-gray-800 fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40 shadow-2xl border-r border-gray-200"
            x-data="{ openProperty: false }">
            @php
                $propertyCounts = app(\App\Services\Partner\PropertyListingService::class)->getPropertyCounts();
            @endphp

            @php
                $appName = config('domains.app_name');
                $domain = config('domains.domain');
                $subdomain = config('domains.subdomain');
            @endphp

            <!-- Branding -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    @if ($appName === 'BookinTour')
                        <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] p-2 rounded-xl">
                            <i class="fas fa-home text-white text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $domain }}</h1>
                    @elseif ($appName === 'Inselor')
                        <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto" />
                    @else
                        <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] p-2 rounded-xl">
                            <i class="fas fa-home text-white text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $subdomain }}</h1>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-2">Partner Dashboard</p>
            </div>

            <nav class="p-4 space-y-2">
                <!-- DASHBOARD -->
                <a href="{{ route('partner.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-[#1F8FB2] hover:to-[#3CC0E9] hover:text-white transition-all duration-200 group {{ request()->routeIs('partner.dashboard') ? 'bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] text-white shadow-lg' : 'text-gray-700' }}">
                    <div class="bg-blue-100 group-hover:bg-white/20 p-2 rounded-lg mr-3 {{ request()->routeIs('partner.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt text-[#1F8FB2] group-hover:text-white {{ request()->routeIs('partner.dashboard') ? 'text-white' : '' }}"></i>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <!-- MY PROPERTIES -->
                <div class="space-y-1">
                    <button @click="openProperty = !openProperty"
                        class="w-full flex justify-between items-center px-4 py-3 rounded-xl hover:bg-gray-100 transition-all duration-200 focus:outline-none text-gray-700">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-building text-green-600"></i>
                            </div>
                            <span class="font-semibold">My Properties</span>
                        </div>
                        <i :class="openProperty ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-sm text-gray-400"></i>
                    </button>
                    <div x-show="!openProperty" x-collapse class="ml-12 space-y-1">
                        <a href="{{ route('partner.list-your-property') }}"
                            class="flex items-center justify-between px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Add Property</span>
                            <i class="fas fa-plus text-xs"></i>
                        </a>

                        <a href="{{ route('partner.properties.apartments') }}"
                            class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Apartments</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $propertyCounts->apartments }}</span>
                        </a>

                        <a href="{{ route('partner.properties.homes') }}"
                            class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Homes</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $propertyCounts->homes }}</span>
                        </a>

                        <a href="{{ route('partner.properties.hotels') }}"
                            class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Hotels</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $propertyCounts->hotels }}</span>
                        </a>

                        <a href="{{ route('partner.properties.alternative-places') }}"
                            class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Alternative Places</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $propertyCounts->alternativePlaces }}</span>
                        </a>

                        <a href="{{ route('partner.bookings') }}"
                            class="flex items-center justify-between px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-[#1F8FB2] transition-colors duration-200">
                            <span class="text-sm font-medium">Bookings</span>
                            <i class="fas fa-calendar-check text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- EARNINGS -->
                <a href="{{ route('partner.earnings') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-yellow-500 hover:to-yellow-600 hover:text-white transition-all duration-200 group {{ request()->routeIs('partner.earnings') ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'text-gray-700' }}">
                    <div class="bg-yellow-100 group-hover:bg-white/20 p-2 rounded-lg mr-3 {{ request()->routeIs('partner.earnings') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-chart-line text-yellow-600 group-hover:text-white {{ request()->routeIs('partner.earnings') ? 'text-white' : '' }}"></i>
                    </div>
                    <span class="font-semibold">Earnings</span>
                </a>

                <!-- MESSAGES -->
                <a href="{{ route('partner.messages') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-purple-500 hover:to-purple-600 hover:text-white transition-all duration-200 group {{ request()->routeIs('partner.messages') ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg' : 'text-gray-700' }}">
                    <div class="bg-purple-100 group-hover:bg-white/20 p-2 rounded-lg mr-3 {{ request()->routeIs('partner.messages') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-envelope text-purple-600 group-hover:text-white {{ request()->routeIs('partner.messages') ? 'text-white' : '' }}"></i>
                    </div>
                    <span class="font-semibold">Messages</span>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">3</span>
                </a>

                <!-- REVIEWS -->
                <a href="{{ route('partner.reviews') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 hover:text-white transition-all duration-200 group {{ request()->routeIs('partner.reviews') ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg' : 'text-gray-700' }}">
                    <div class="bg-orange-100 group-hover:bg-white/20 p-2 rounded-lg mr-3 {{ request()->routeIs('partner.reviews') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-star text-orange-600 group-hover:text-white {{ request()->routeIs('partner.reviews') ? 'text-white' : '' }}"></i>
                    </div>
                    <span class="font-semibold">Reviews</span>
                </a>

                <!-- SETTINGS -->
                <a href="{{ route('partner.settings') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-gray-500 hover:to-gray-600 hover:text-white transition-all duration-200 group {{ request()->routeIs('partner.settings') ? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg' : 'text-gray-700' }}">
                    <div class="bg-gray-100 group-hover:bg-white/20 p-2 rounded-lg mr-3 {{ request()->routeIs('partner.settings') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-cog text-gray-600 group-hover:text-white {{ request()->routeIs('partner.settings') ? 'text-white' : '' }}"></i>
                    </div>
                    <span class="font-semibold">Settings</span>
                </a>

                <!-- LOGOUT -->
                <div class="pt-4 mt-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('partner.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Logout</span>
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
