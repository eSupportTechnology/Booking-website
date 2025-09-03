<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- HEADER -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">

                <!-- Left Section -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col items-start space-y-2">
                        @php
                            $host = config('domains.app_name');
                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if ($host == 'BookinTour')
                                <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4 flex-wrap">
                    
                    {{-- Language Button --}}
                    @php
                        $locale = app()->getLocale();
                        $language = config('languages.' . $locale);
                        $flag = isset($language['flag']) ? asset($language['flag']) : asset('images/flags/uk.png');
                    @endphp

                    <button id="language-button" type="button"
                        class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
                        <img src="{{ $flag }}" alt="{{ $language['name'] ?? 'Language' }}"
                            class="w-full h-full object-cover rounded-full" />
                    </button>

                    {{-- Auth / Guest Section --}}
                    @if(Auth::guard('car_renter')->check())
                        {{-- Logged in Car Renter --}}
                        <span class="bg-white text-[#1F8FB2] px-4 py-2 rounded font-bold"
                              style="font-family: 'Noto Sans', sans-serif;">
                           {{ Auth::guard('car_renter')->user()->full_name ?? Auth::guard('car_renter')->user()->company_name }}

                        </span>

                        <a href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">
                           Logout
                        </a>

                        <!-- Hidden Logout Form -->
                        <form id="logout-form" action="{{ route('carrentals.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        {{-- Guest (not logged in) --}}
                        <a href="{{ route('carrentals.login.email') }}"
                           class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">
                           Car Renter Sign In
                        </a>
                    @endif

                    <a href="#"
                        class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">Help</a>
                </div>

            </div>
        </div>
    </section>
</header>
