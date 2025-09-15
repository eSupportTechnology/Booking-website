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
                        <!-- Logo -->

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

                        <!-- Green Box Message -->
                        <div id="promo-box"
                            class="bg-green-500 text-white px-4 py-2 rounded flex items-start justify-between w-full max-w-sm">
                            <span class="text-sm">We offer special discounts this season!</span>
                            <button onclick="document.getElementById('promo-box').classList.add('hidden')"
                                class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4 flex-wrap">
                    <!-- Language Button -->
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

                    <!-- Language Modal -->
                    <div id="language-modal"
                        class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Select your language
                                </h3>
                                <button type="button"
                                    class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <div class="mt-4">
                                <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach (config('languages') as $code => $lang)
                                    <a href="{{ route('lang.change', ['lang' => $code]) }}">
                                        <button
                                            class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="{{ asset($lang['flag']) }}" alt="{{ $lang['name'] }}"
                                                class="h-5 w-5" />
                                            <span>{{ $lang['name'] }}</span>
                                        </button>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('partner_name'))
                    <span class="bg-white text-[#1F8FB2] px-4 py-2 rounded font-bold"
                        style="font-family: 'Noto Sans', sans-serif;"><a href="{{ route('partner.dashboard') }}">{{ session('partner_name') }}</a></span>
                    <!-- Logout Link -->
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">
                        Logout
                    </a>

                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    @elseif(Auth::check())
                        <span class="bg-white text-[#1F8FB2] px-4 py-2 rounded font-bold"
                            style="font-family: 'Noto Sans', sans-serif;"><a href="{{ route('partner.dashboard') }}">{{ Auth::user()->name }}</a></span>
                        <!-- Logout Link -->
                       <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">
                            Logout
                        </a>

                        <!-- Hidden Logout Form -->
                        <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">
                           @csrf
                        </form>
                    @else
                    <a href="#" class="hover:underline font-sans"
                        style="font-family: 'Noto Sans', sans-serif;">Already a partner?</a>
                    <a href="{{ url('partner/login') }}"
                        class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">Sign
                        in</a>
                    @endif
                    <a href="#"
                        class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">Help</a>
                </div>

            </div>
        </div>


    </section>
</header>
