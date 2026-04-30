<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Partner Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Partner Panel - All prices displayed in USD -->
    <?php
        // Force USD currency for partner panel
        session(['currency' => 'USD']);
    ?>

    <!-- Top Navbar -->
    <nav class="bg-white border-b border-gray-200 fixed w-full z-50">
        <div class="px-4">
            <div class="flex justify-between h-14 items-center">

                <!-- Left: Logo + Hamburger -->
                <div class="flex items-center gap-3">
                    <button id="menuToggle" class="text-gray-600 focus:outline-none block md:hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="{{ route('partner.dashboard') }}" class="text-lg font-semibold text-gray-800">Partner Panel</a>
                </div>

                <!-- Right: Profile -->
                <div class="flex items-center gap-3">
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-700">
                            <div class="w-8 h-8 bg-[#1F8FB2] rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                            </div>
                            <span class="text-sm hidden sm:block">{{ Str::limit(Auth::user()->name ?? 'Partner', 12) }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg hidden group-hover:block min-w-[160px] py-1">
                            <a href="{{ route('partner.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('partner.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <!-- Sidebar + Content -->
    <div class="flex pt-14 min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-56 bg-white border-r border-gray-200 fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 z-40 pt-14 md:pt-0"
            x-data="{ openProperty: true }">

            @php
                $propertyCounts = app(\App\Services\Partner\PropertyListingService::class)->getPropertyCounts();
                $appName = config('domains.app_name');
                $domain = config('domains.domain');
            @endphp

            <!-- Branding -->
            <div class="px-4 py-4 border-b border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $domain }}</p>
            </div>

            <!-- Nav Menu -->
            <nav class="p-3 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('partner.dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.dashboard') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <!-- My Properties -->
                <div>
                    <button @click="openProperty = !openProperty"
                        class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Properties
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="openProperty ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openProperty" x-collapse class="ml-7 mt-1 space-y-1">
                        <a href="{{ route('partner.list-your-property') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Add Property
                        </a>
                        <a href="{{ route('partner.properties.apartments') }}" class="flex items-center justify-between px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="flex items-center"><span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Apartments</span>
                            <span class="text-xs text-gray-400">{{ $propertyCounts->apartments }}</span>
                        </a>
                        <a href="{{ route('partner.properties.homes') }}" class="flex items-center justify-between px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="flex items-center"><span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Homes</span>
                            <span class="text-xs text-gray-400">{{ $propertyCounts->homes }}</span>
                        </a>
                        <a href="{{ route('partner.properties.hotels') }}" class="flex items-center justify-between px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="flex items-center"><span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Hotels</span>
                            <span class="text-xs text-gray-400">{{ $propertyCounts->hotels }}</span>
                        </a>
                        <a href="{{ route('partner.properties.alternative-places') }}" class="flex items-center justify-between px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="flex items-center"><span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Other</span>
                            <span class="text-xs text-gray-400">{{ $propertyCounts->alternativePlaces }}</span>
                        </a>
                        <a href="{{ route('partner.bookings.manage') }}" class="flex items-center px-3 py-1.5 text-sm text-gray-500 hover:text-[#1F8FB2]">
                            <span class="w-1 h-1 bg-gray-300 rounded-full mr-2"></span>Bookings
                        </a>
                    </div>
                </div>

                <!-- Earnings -->
                <a href="{{ route('partner.earnings') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.earnings') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 8v1"/>
                    </svg>
                    Earnings
                </a>

                <!-- Messages -->
                <a href="{{ route('partner.messages') }}"
                    class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.messages') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Messages
                    </div>
                    <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded">3</span>
                </a>

                <!-- Reviews -->
                <a href="{{ route('partner.reviews') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.reviews') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Reviews
                </a>

                <!-- Deals -->
                <a href="{{ route('partner.deals.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.deals.*') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Deals
                </a>

                <!-- Settings -->
                <a href="{{ route('partner.settings') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('partner.settings') ? 'bg-[#1F8FB2] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>

                <!-- Logout -->
                <div class="pt-3 mt-3 border-t border-gray-100">
                    <form method="POST" action="{{ route('partner.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-x-auto">
            @yield('content')
        </main>
    </div>

    <!-- Sidebar Toggle Script -->
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

        // Partner Panel Currency Utility - Force USD formatting
        window.formatPartnerPrice = function(amount) {
            return '$' + parseFloat(amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        window.partnerCurrency = 'USD';
    </script>
</body>

</html>
