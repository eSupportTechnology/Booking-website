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
                                <h1>Bookintour.com</h1>
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
                            style="font-family: 'Noto Sans', sans-serif;">{{ session('partner_name') }}</span>
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
                            style="font-family: 'Noto Sans', sans-serif;">{{ Auth::user()->name }}</span>
                        <!-- Logout Link -->
                        <form action="{{ route('partner.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">
                                Logout
                            </button>

                        </form>
                    @else
                        <a href="#" class="hover:underline font-sans"
                            style="font-family: 'Noto Sans', sans-serif;">Already a partner?</a>
                        <a href="#"
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

<!-- MAIN SECTION -->
<section class="bg-[#1F8FB2] text-white py-12 px-4 md:px-12 relative z-0">
    <div class="container px-4 md:px-8 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <!-- Left Text Column -->
        <div class="w-full md:w-1/2">
            <h1 class="text-3xl md:text-5xl font-bold -mt-12"
                style="font-family: 'Poppins', sans-serif; line-height: 1.4;">
                @lang('messages.list_your') <br>
                <span class="text-[#3CC0E9] font-semibold">@lang('messages.holiday_rental')</span><br>
                @lang('messages.on') {{ config('domains.domain') }}
            </h1>
            <p class="text-white text-xl mt-4 max-w-4xl font-light leading-snug"
                style="font-family: 'Noto Sans', sans-serif;">
                @lang('messages.description')
            </p>

            @if (Auth::check())
                <h2>Welcome, {{ Auth::user()->name }}!</h2>
            @endif

        </div>

        <!-- Right Box -->
        <div class="w-full md:w-1/2 bg-white text-black p-6 rounded-lg border-4 border-yellow-400 shadow-md max-w-md">
            <h2 class="text-xl font-bold mb-4" style="font-family: 'Poppins', sans-serif;">
                @lang('messages.register_free')
            </h2>

            <ul class="list-none space-y-2 mb-6">
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.booking_within_week')</p>
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.choose_booking_option')</p>
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.payment_facilitation')</p>
                </li>
            </ul>

            @if (Auth::check())
                <a href="{{ route('partner.property.category') }}"
                    class="w-full bg-[#3CC0E9] text-white font-semibold py-2 rounded hover:bg-[#2bb3db] transition duration-200 text-center block">
                    @lang('messages.get_started_now') →
                </a>
            @else
                <button
                    class="w-full bg-[#3CC0E9] text-white font-semibold py-2 rounded hover:bg-[#2bb3db] transition duration-200">
                    <a href="{{ url('partner/register/email') }}"
                        class="block w-full h-full text-white">@lang('messages.get_started_now') →</a>
                </button>
            @endif

            <p class="mt-4 text-sm">
                <span class="font-bold text-black">@lang('messages.already_registered')</span><br>
                <a href="#" class="text-[#3CC0E9] hover:underline">@lang('messages.continue_registration')</a>
            </p>
        </div>

    </div>
</section>


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8" style="font-family: 'Poppins', sans-serif;">
            @lang('messages.host_worry_free')
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Column 1 -->
            <div>
                <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    @lang('messages.your_rental_rules')
                </h3>
                <ul class="text-gray-700 space-y-3" style="font-family: 'Noto Sans', sans-serif;">
                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.accept_decline_bookings')
                            <a href="#" class="underline text-base text-blue-500">@lang('messages.request_to_book')</a>.
                        </span>
                    </li>

                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.set_house_rules')
                        </span>
                    </li>
                </ul>

                <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-10"
                    style="font-family: 'Noto Sans', sans-serif;">
                    @lang('messages.host_with_us')
                </button>
                <p class="text-sm text-gray-500 mt-2" style="font-family: 'Noto Sans', sans-serif;">
                    @lang('messages.ios_only_note')
                </p>
            </div>

            <!-- Column 2 -->
            <div>
                <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    @lang('messages.get_to_know_guests')
                </h3>
                <ul class="text-gray-700 space-y-2" style="font-family: 'Noto Sans', sans-serif;">
                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.chat_before_accepting')
                        </span>
                    </li>

                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.access_guest_history')
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div>
                <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    @lang('messages.stay_protected')
                </h3>
                <ul class="text-gray-700 space-y-2" style="font-family: 'Noto Sans', sans-serif;">
                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.liability_protection')
                        </span>
                    </li>

                    <li class="flex items-start gap-2">
                        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                        <span class="text-base">
                            @lang('messages.access_guest_history')
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section class="py-12 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8" style="font-family: 'Poppins', sans-serif;">
            @lang('messages.take_control_of_your_finances_with_payments_by')
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
            <!-- Left Column -->
            <ul class="pl-0 space-y-4">
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold font-base" style="font-family: 'Noto Sans', sans-serif;">Payments made
                            easy</span><br />
                        <span class="font-sm"> We facilitate the payment process for you, freeing up your time to grow
                            your business.</span>
                    </div>
                </li>
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Greater revenue
                            security</span><br />
                        Whenever guests complete prepaid reservations at your property and pay online, you are
                        guaranteed payment.
                    </div>
                </li>
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">More control over your
                            cash flow</span><br />
                        Choose your payout method and timing based on regional availability.
                    </div>
                </li>
            </ul>


            <!-- Right Column -->
            <ul class="pl-0 space-y-4">
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Daily payouts in select
                            markets</span><br />
                        Get payouts faster! We'll send your payouts 24 hours after guest checkout.
                    </div>
                </li>
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">One-stop solution for
                            multiple listings</span><br />
                        Save time managing finances with group invoicing and reconciliation.
                    </div>
                </li>
                <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
                    <div>
                        <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">More control over your
                            cash flow</span><br />
                        We help you stay compliant with regulatory changes and reduce the risk of fraud and chargebacks.
                    </div>
                </li>
            </ul>
        </div>

        <div class="text-left mt-2">
            <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-10"
                style="font-family: 'Noto Sans', sans-serif;">
                Start earning today
            </button>
        </div>
    </div>
</section>


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8" style="font-family: 'Poppins', sans-serif;">
            @lang('messages.simple_to_begin_and_stay_ahead')
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1: Import your property details -->
            <!-- Card 1 -->
            <div class="flex flex-col items-center text-center">
                <img src="{{ asset('images/post.png') }}" alt="Import Icon" class="w-[100px] h-[100px] mb-4" />

                <!-- Content container to align left -->
                <div class="text-left">
                    <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        Import your property details
                    </h3>
                    <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
                        Seamlessly import your property information from other travel websites and avoid overbooking
                        with calendar sync.
                    </p>
                </div>
            </div>

            <!-- Repeat the same structure for Card 2 and Card 3 -->


            <!-- Card 2: Start fast with review scores -->
            <div class="flex flex-col items-center text-center">
                <img src="{{ asset('images/puzzels.png') }}" alt="Review Icon" class="w-[100px] h-[100px] mb-4" />

                <div class="text-left">
                    <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        Start fast with review scores
                    </h3>
                    <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
                        Your review scores on other travel websites are converted and displayed on your property page
                        before your first eSupport.com guests leave their reviews.
                    </p>
                </div>
            </div>


            <!-- Card 3: Stand out in the market -->
            <div class="flex flex-col items-center text-center">
                <img src="{{ asset('images/search.png') }}" alt="Stand Out Icon" class="w-[90px] h-[100px] mb-4" />

                <div class="text-left">
                    <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        Stand out in the market
                    </h3>
                    <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
                        The "New to HorizonStay.com" label helps you stand out in our search results.
                    </p>
                </div>
            </div>

            <div class="text-left mt-2">
                <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-2"
                    style="font-family: 'Noto Sans', sans-serif;">
                    Get started today
                </button>
            </div>
        </div>
</section>
<!-- Section: Reach a unique global customer base -->
<section class="py-32 bg-white relative overflow-hidden">
    <!-- Background map slightly enlarged and centered -->
    <div class="absolute inset-0 flex items-center justify-center z-0">
        <img src="{{ asset('images/map.png') }}" alt="World Map"
            class="w-[900px] h-auto object-contain opacity-30" />
    </div>

    <!-- Foreground content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-black mb-16 text-left -mt-12"
                style="font-family: 'Poppins', sans-serif;">
                @lang('messages.reach_a_unique_global_customer_base')
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center mb-12">
                <div>
                    <p class="text-4xl font-bold text-black" style="font-family: 'Poppins', sans-serif;">1.8+ billion
                    </p>
                    <p class="text-gray-700 text-xl" style="font-family: 'Noto Sans', sans-serif;">holiday rental
                        guests since 2010.</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-black" style="font-family: 'Poppins', sans-serif;">1 in every 3
                    </p>
                    <p class="text-gray-700 text-xl" style="font-family: 'Noto Sans', sans-serif;">room nights booked
                        in 2024 was a holiday rental.</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-black " style="font-family: 'Poppins', sans-serif;">48% of
                        nights</p>
                    <p class="text-gray-700 text-xl" style="font-family: 'Noto Sans', sans-serif;">booked were for
                        international stays at the end of 2023.</p>
                </div>
            </div>


        </div>
        <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-2"
            style="font-family: 'Noto Sans', sans-serif;">
            Reach new guests today
        </button>
    </div>
</section>


<!-- Section: What hosts like you say -->
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title -->
        <h2 class="text-4xl font-bold text-black  mb-8" style="font-family: 'Poppins', sans-serif;">What hosts like
            you say</h2>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
            <!-- Testimonial Card -->
            <div class="border border-yellow-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    "I was able to list within 15 minutes, and no more than two hours later, I had my first booking!"
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/x.jpg') }}" alt="Parley Rose"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Parley Rose
                        </div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">UK-based host
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-blue-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    "eSupport.com is the most straightforward [OTA] to work with. Everything is clear. It's easy. And it
                    frees us up to focus on the aspects that we can really add value to, like the guest experience."
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/y.jpg') }}" alt="Martin Friedman"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Martin
                            Friedman</div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Managing
                            Director, Abodebed</div>
                    </div>
                </div>
            </div>

            <div class="border border-yellow-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    "eSupport.com accounts for our largest share of guests and has helped get us where we are today."
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/z.jpg') }}" alt="Michel and Aja"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Michel and
                            Aja</div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Owners of La
                            Maison de Souhey</div>
                    </div>
                </div>
            </div>

            <div class="border border-blue-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    "Travellers come to Charming Lofts from all over the world. eSupport.com really helps with that.
                    Unlike some other platforms, it's multinational and caters to a much larger audience. For me, that
                    was a real game-changer."
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/t.jpg') }}" alt="Parley Rose"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Parley Rose
                        </div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">UK-based host
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-yellow-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4" style="font-family: 'Noto Sans', sans-serif;">
                    "After joining eSupport.com and setting up the listing, my occupancy went up significantly and
                    bookings were coming in five to six months in advance."
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/t.jpg') }}" alt="Martin Friedman"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Martin
                            Friedman</div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Managing
                            Director, Abodebed</div>
                    </div>
                </div>
            </div>

            <div class="border border-blue-400 p-6 rounded-md bg-white shadow-sm">
                <p class="text-sm italic mb-4">
                    "Getting started with eSupport.com was super simple and took no time at all."
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="{{ asset('images/v.jpg') }}" alt="Michel and Aja"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300" />
                    <div>
                        <div class="text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">Michel and
                            Aja</div>
                        <div class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Owners of La
                            Maison de Souhey</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Join Button -->
        <div class="text-center mt-10">

        </div>
        <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-2"
            style="font-family: 'Noto Sans', sans-serif;">
            Reach new guests today
        </button>
    </div>
</section>


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Your questions answered</h2>

        </div>





        <!-- Two column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button
                        class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none"
                        style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <button
                        class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none"
                        style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button
                        class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none"
                        style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <button
                        class="w-full text-base text-bold flex justify-between items-center text-left  text-gray-800 toggle-answer focus:outline-none"
                        style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>


            </div>
        </div>
        <p class="mt-4 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
            Still have questions? Find answers to all your questions on our
            <a href="/help" class="text-sky-500  hover:text-sky-600"> FAQ</a>
        </p>
        <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-8"
            style="font-family: 'Noto Sans', sans-serif;">
            Start welcoming guests
        </button>
    </div>
</section>

<!-- Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.toggle-answer');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const answer = toggle.nextElementSibling;
                const icon = toggle.querySelector('svg');
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Language modal logic
        const languageButton = document.getElementById("language-button");
        const languageModal = document.getElementById("language-modal");
        const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

        if (languageButton && languageModal && closeBtn) {
            // Open the language modal
            languageButton.addEventListener("click", () => {
                languageModal.classList.remove("hidden");
            });

            // Close language modal on close button click
            closeBtn.addEventListener("click", () => {
                languageModal.classList.add("hidden");
            });

            // Close language modal on clicking outside the modal content
            window.addEventListener("click", (event) => {
                if (event.target === languageModal) {
                    languageModal.classList.add("hidden");
                }
            });
        }
    });
</script>
<footer class="bg-[#1A93B6] text-white py-12 px-4">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 relative">

        <!-- Left Text -->
        <div class="md:col-span-2 flex flex-col justify-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Poppins', sans-serif;">
                @lang('messages.sign_up_and_start') <br class="hidden md:block" />
                @lang('messages.welcoming_guests_today')
            </h2>
        </div>

        <!-- CTA Box -->
        <div
            class="bg-white text-black p-6 rounded-lg border-4 border-yellow-400 shadow-md w-full max-w-sm mx-auto md:mx-0">
            <h3 class="text-lg font-semibold mb-4" style="font-family: 'Poppins', sans-serif;">Register for free</h3>
            <ul class="list-none space-y-2 mb-6">
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.booking_within_week')</p>
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.choose_booking_option')</p>
                </li>
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✔</span>
                    <p>@lang('messages.payment_facilitation')</p>
                </li>
            </ul>
            <a href="{{ route('partner.property.category') }}"
                class="w-full bg-[#3CC0E9] text-white font-semibold py-2 rounded hover:bg-[#2bb3db] transition duration-200 text-center block">
                @lang('messages.get_started_now') →
            </a>
        </div>
    </div>

    <!-- Links Section -->
    <div class="max-w-7xl mx-auto px-4 mt-12 grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
        <div>
            <h4 class="font-semibold mb-2 text-2xl" style="font-family: 'Poppins', sans-serif;">Discover</h4>
            <ul>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">Trust
                        and Safety</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-2 text-2xl" style="font-family: 'Poppins', sans-serif;">Useful links</h4>
            <ul>
                <li><a href="#" class="underline text-base"
                        style="font-family: 'Poppins', sans-serif;">Extranet</a></li>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">Pulse
                        for Android</a></li>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">Pulse
                        for iOS</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-2 text-2xl" style="font-family: 'Poppins', sans-serif;">Help and communities
            </h4>
            <ul>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">Partner
                        Help</a></li>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">Partner
                        Community</a></li>
                <li><a href="#" class="underline text-base" style="font-family: 'Poppins', sans-serif;">How-to
                        videos</a></li>
            </ul>
        </div>
    </div>

    <!-- Bottom Line -->
    <div class="max-w-7xl mx-auto px-4 mt-8 border-t border-white/30 pt-4 text-sm text-center text-white">
        <div class="flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="space-x-2">
                <a href="#" class="underline" style="font-family: 'Poppins', sans-serif;">About Us</a>
                <span class="text-white">|</span>
                <a href="#" class="underline" style="font-family: 'Poppins', sans-serif;">Privacy and Cookie
                    Statement</a>
            </div>
            <p class="mt-2 md:mt-0" style="font-family: 'Poppins', sans-serif;">© Copyright <a href="#"
                    class="underline" style="font-family: 'Poppins', sans-serif;">{{ config('domains.domain') }}</a> 2025</p>
        </div>
    </div>
</footer>
