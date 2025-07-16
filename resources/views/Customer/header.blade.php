<header class=" text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Container flex with items-start for vertical alignment -->
            <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">

                <!-- Left Section -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col items-start">
                        <!-- Logo -->
                        @php
                            $host = request()->getHost();
                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if (in_array($host, ['localhost', '127.0.0.1', 'bookintour.com']))
                                <h1>Bookintour.com</h1>
                            @elseif ($host === 'inselor.de')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-10 w-auto" />
                            @endif
                        </a>


                        <!-- Push nav a bit down to separate from logo -->
                        @php
                            $currentRoute = request()->route()->getName(); // Get current route name
                        @endphp

                        <nav class="flex flex-wrap gap-4 text-sm md:text-base mt-6 ">
                            <!-- Stays Link -->
                            <a href="{{ route('stays') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border
          text-white transition
          {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
                            </a>


                            <!-- Car Rentals Link -->
                            <a href="{{ route('car.rentals') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border
          text-white transition
          {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
                            </a>


                            <!-- Airport Taxis Link -->
                            <a href="{{ route('airport.taxis') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Airport taxis</span>
                            </a>

                            <a href="{{ route('airport.tours') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Tour packages</span>
                            </a>

                        </nav>


                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Currency display button -->
                    <!-- Currency display and button -->
                    <div class="flex items-center space-x-2">
                        <span id="current-currency" class="font-semibold cursor-pointer select-none"
                            title="Click to change currency">
                            LKR
                        </span>
                    </div>

                    <!-- Currency Modal -->
                    <div id="currency-modal"
                        class="fixed inset-0 hidden z-50 flex items-start justify-center px-4 py-8 bg-black bg-opacity-50 overflow-y-auto">
                        <div class="relative w-full max-w-sm p-6 bg-white rounded-lg shadow">
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Select Currency</h3>
                                <button id="currency-close-btn" type="button"
                                    class="text-gray-400 hover:text-gray-900 text-2xl font-bold leading-none"
                                    aria-label="Close modal">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="grid grid-cols-2 gap-4">
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="LKR">
                                    LKR - Sri Lankan Rupee
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="USD">
                                    USD - US Dollar
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="EUR">
                                    EUR - Euro
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="GBP">
                                    GBP - British Pound
                                </button>
                                <!-- Add more currencies as needed -->
                            </div>
                        </div>
                    </div>

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
                            <!-- Modal Header -->
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Select your language
                                </h3>
                                <button type="button"
                                    class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="mt-4">
                                <p class="mb-4 text-base text-gray-500 dark:text-gray-400">
                                    Suggested for you
                                </p>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach (config('languages') as $code => $lang)
                                        <a href="{{ route('lang.change', ['lang' => $code]) }}">
                                            <button
                                                class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}"
                                                    class="h-5 w-5" />
                                                <span>{{ $lang['name'] }}</span>
                                            </button>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="">
                        <img src="{{ asset('assets/question.svg') }}" alt="Taxi" class="w-5 h-5 cursor-pointer" />
                    </a>

                    <a href="/list-your-property" class="hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">List your property</a>

                    @auth('customer')
                        <!-- Profile dropdown -->
                        <div class="relative group">
                            <button class=" text-[#3CC0E9] font-base px-4 py-2 rounded  flex items-center space-x-2">
                                <!-- Profile Icon with Border -->
                                @php
                                    $profileImage = Auth::guard('customer')->user()?->customerPersonalDetail
                                        ?->profile_image;

                                    $divClasses =
                                        'bg-white border border-[#3CC0E9] rounded-full flex items-center justify-center ';
                                    $divClasses .= $profileImage ? 'w-10 h-10' : 'p-2 w-10 h-10';

                                    $imgClasses = $profileImage
                                        ? 'w-10 h-10 rounded-full object-cover'
                                        : 'w-7 h-7 rounded-full object-cover';
                                @endphp

                                <div class="{{ $divClasses }}">
                                    <img src="{{ $profileImage ? asset('storage/' . $profileImage) : asset('assets/user.svg') }}"
                                        class="{{ $imgClasses }}" alt="Profile" />
                                </div>




                                <!-- My Account Link -->
                                <a href="#" class="text-white hover:underline"
                                    style="font-family: 'Noto Sans', sans-serif;">
                                    Your Account
                                </a>
                            </button>

                            <!-- Dropdown -->
                            <div
                                class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible transition-all duration-200 invisible z-50">
                                <a href="{{ route('customer.details.create') }}"
                                    class="block px-4 text-base py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/mynaui_user.svg') }}" alt="My Account Icon"
                                        class="w-5 h-5" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">My Account</span>
                                </a>
                                <a href="/profile"
                                    class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/streamline_baggage.svg') }}" alt="My Account Icon"
                                        class="w-4 h-4" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Bookings & Trips</span>
                                </a>
                                <a href="/profile"
                                    class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/mynaui_letter-g-circle.svg') }}" alt="My Account Icon"
                                        class="w-5 h-5" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Genius loyalty programme</span>
                                </a>
                                <a href="/profile"
                                    class="block px-4 py-2 text-gray-700  text-base  hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/lets-icons_wallet-light.svg') }}" alt="My Account Icon"
                                        class="w-5 h-5" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Rewards & Wallet</span>
                                </a>
                                <a href="/profile"
                                    class="block px-4 py-2 text-gray-700  text-base  hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/fluent_person-feedback-20-regular.svg') }}"
                                        alt="My Account Icon" class="w-5 h-5" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Reviews</span>
                                </a>
                                <a href="/profile"
                                    class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                    <img src="{{ asset('assets/mdi-light_heart.svg') }}" alt="My Account Icon"
                                        class="w-5 h-5" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Saved</span>
                                </a>

                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                                        <img src="{{ asset('assets/simple-line-icons_logout.svg') }}" alt="Logout Icon"
                                            class="w-4 h-4" />
                                        <span style="font-family: 'Noto Sans', sans-serif;">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest buttons -->
                        <a href="{{ route('customer.login') }}"
                            class="bg-white font-base px-4 py-2 rounded hover:bg-blue-100"
                            style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">Register</a>
                        <a href="{{ route('customer.login') }}"
                            class="bg-white font-base px-4 py-2 rounded hover:bg-blue-100"
                            style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">Sign in</a>
                        @endif

                    </div>

                </div>
            </div>
        </section>
    </header>

    @push('scripts')
        <script src="{{ asset('assets/Customer/js/header.js') }}"></script>
    @endpush
    @stack('scripts')
