<header class="text-white px-2 sm:px-4 py-2 sm:py-4" style="background-color:#1F8FB2;">
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <!-- Container flex -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center flex-wrap space-y-4 md:space-y-0">

                <!-- Left Section -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col items-start">
                        <!-- Logo -->
                        @php
                            $host = config('domains.app_name');
                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if($host == 'BookinTour')
                                <h1>Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
                            @endif
                        </a>

                        @php
                            $currentRoute = request()->route()->getName();
                        @endphp



                    </div>
                </div>



<!-- Right Section -->
<div class="flex items-center flex-wrap justify-end gap-2 sm:gap-3 md:gap-5 w-full md:w-auto order-2 md:order-2 mt-2 md:mt-0 px-2 sm:px-0 md:px-0">
 <div class="flex w-full md:w-auto justify-center md:justify-end gap-2 sm:gap-3 md:gap-5 mb-2 md:mb-0">
    <!-- Currency -->
    <div class="relative">
        <button id="current-currency" class="flex items-center gap-1 font-semibold cursor-pointer select-none text-sm md:text-base hover:opacity-80" title="Click to change currency">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="currency-text">{{ app(\App\Services\CurrencyManager::class)->getUserCurrency() }}</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <!-- Currency Modal -->
        <div id="currency-modal" class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                <div class="flex items-start justify-between">
                    <h3 class="text-xl font-semibold text-gray-900">Select Currency</h3>
                    <button type="button" id="currency-close-btn" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    @foreach(app(\App\Services\CurrencyService::class)->getSupportedCurrencies() as $currency)
                        <button data-currency="{{ $currency }}" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 text-gray-800">
                            <span>{{ $currency }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Language -->


    <!-- Help -->
    <a href="#" class="flex items-center">
        <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
    </a>

    <!-- List property (hide for logged-in customers) -->
    @guest('customer')
        <a href="/list-your-property" class="hover:underline">List your property</a>
    @endguest

    <!-- Partner Dashboard Link -->
    @auth
        @if(Auth::user()->hasRole('partner'))
        <a href="{{ route('partner.dashboard') }}" class="flex items-center space-x-1 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="text-sm" style="font-family: 'Noto Sans', sans-serif;">Partner Dashboard</span>
        </a>
        @endif
    @endauth
   </div>

    @php
        $isPartner = Auth::check() && Auth::user()->hasRole('partner');
    @endphp

    @if(!$isPartner)
     <div class="flex w-full md:w-auto justify-center md:justify-end gap-2 sm:gap-3 md:gap-5">
    <!-- Your Account -->
    <div class="relative">
        <button id="account-btn" class="flex items-center space-x-2">
            @auth('customer')
                <div class="bg-yellow-400 w-9 h-9 rounded-full flex items-center justify-center text-gray-900 font-bold">
                    {{ strtoupper(substr(Auth::guard('customer')->user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:inline">{{ Str::limit(Auth::guard('customer')->user()->name, 15) }}</span>
            @else
                <div class="bg-white p-2 border border-[#3CC0E9] rounded-full">
                    <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" />
                </div>
                <span>Your Account</span>
            @endauth
        </button>

        <!-- Dropdown -->
        <div id="account-menu"
            class="absolute mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50
            left-0 sm:right-0">
            @auth('customer')
                <!-- User Name -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="font-semibold text-gray-900">{{ Auth::guard('customer')->user()->name }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::guard('customer')->user()->email }}</p>
                </div>

                <a href="/profile" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    My Account
                </a>
                <a href="{{ route('customer.reservations.index') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Bookings & Trips
                </a>

                <a href="{{ route('customer.messages.index') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Messages
                </a>

                <a href="{{ route('rewards.wallet') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Rewards & Wallet
                </a>

                <a href="{{ route('customer.reviews.index') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Reviews
                </a>



                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                        <img src="{{ asset('assets/simple-line-icons_logout.svg') }}" class="w-4 h-4" /> Logout
                    </button>
                </form>
            @else
                <p class="px-10 py-1 text-gray-500 text-xs md:px-4 md:py-2 md:text-sm">
                    Please sign in to view account options
                </p>
            @endauth
        </div>
    </div>


    <!-- Show Register / Sign in only when user is not logged in -->
    @guest('customer')
        <!-- Show Register / Sign in -->
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="/choose-option"
            class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2 rounded hover:bg-blue-100 text-xs sm:text-sm md:text-base"
            style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                Register
            </a>
            <a href="/choose-option"
            class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2 rounded hover:bg-blue-100 text-xs sm:text-sm md:text-base"
            style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                Sign in
            </a>
        </div>
    @else
    <!-- Empty placeholder so layout doesn't shift -->
    <div class="flex items-center gap-1 sm:gap-2 invisible">
        <span class="px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2">Hidden</span>
        <span class="px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2">Hidden</span>
    </div>
@endguest
    @endif



</div>
 </div>

                <!-- Navigation Section -->
                <div class="w-full md:w-auto order-3 md:order-3 mt-2 md:mt-0">
                    @php $currentRoute = request()->route()->getName(); @endphp
                    <nav class="grid grid-cols-2 gap-2 md:flex md:flex-nowrap md:gap-4 mt-2 md:mt-4">
                        <a href="{{ route('stays') }}" class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
                        </a>

                        <a href="{{ route('customer.car-rentals') }}" class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
                        </a>

                        <!-- Airport Taxis -->
                        <a href="{{ route('customer.airport-taxis') }}"
                        class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition
                                {{ $currentRoute == 'customer.airport-taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Airport taxis</span>
                        </a>

                        <a href="{{ route('airport.tours') }}" class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Tour packages</span>
                        </a>
                    </nav>
                </div>

            </div>
        </div>
    </section>
</header>

@push('scripts')
    <script src="{{ asset('assets/Customer/js/header.js') }}"></script>
@endpush
@stack('scripts')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const currentCurrency = document.getElementById("current-currency");
        const currencyModal = document.getElementById("currency-modal");
        const currencyCloseBtn = document.getElementById("currency-close-btn");

        if (currentCurrency && currencyModal && currencyCloseBtn) {

            currentCurrency.addEventListener("click", () => {
                currencyModal.classList.remove("hidden");
            });


            currencyCloseBtn.addEventListener("click", () => {
                currencyModal.classList.add("hidden");
            });


            window.addEventListener("click", (e) => {
                if (e.target === currencyModal) {
                    currencyModal.classList.add("hidden");
                }
            });
            currencyModal.querySelectorAll("button[data-currency]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const selectedCurrency = btn.getAttribute("data-currency");
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');

                    if (!csrfToken) {
                        console.error('CSRF token not found');
                        return;
                    }

                    fetch('/set-currency', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({currency: selectedCurrency})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const currencyText = document.getElementById("currency-text");
                            if (currencyText) {
                                currencyText.textContent = selectedCurrency;
                            }
                            currencyModal.classList.add("hidden");
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Currency change error:', error);
                        alert('Failed to change currency. Please try again.');
                    });
                });
            });
        }

        const languageButton = document.getElementById("language-button");
        const languageModal = document.getElementById("language-modal");
        const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

        if (languageButton && languageModal && closeBtn) {
            languageButton.addEventListener("click", () => {
                languageModal.classList.remove("hidden");
            });


            closeBtn.addEventListener("click", () => {
                languageModal.classList.add("hidden");
            });


            window.addEventListener("click", (event) => {
                if (event.target === languageModal) {
                    languageModal.classList.add("hidden");
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
    const accountBtn = document.getElementById("account-btn");
    const accountMenu = document.getElementById("account-menu");

    if (accountBtn && accountMenu) {
        accountBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            accountMenu.classList.remove("hidden");
        });


        window.addEventListener("click", (e) => {
            if (!accountMenu.contains(e.target) && !accountBtn.contains(e.target)) {
                accountMenu.classList.add("hidden");
            }
        });
    }


});

document.addEventListener("DOMContentLoaded", () => {
    const accountBtn = document.getElementById("account-btn");
    const accountMenu = document.getElementById("account-menu");

    if (accountBtn && accountMenu) {
        accountBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            accountMenu.classList.remove("hidden");
        });

        window.addEventListener("click", (e) => {
            if (!accountMenu.contains(e.target) && !accountBtn.contains(e.target)) {
                accountMenu.classList.add("hidden");
            }
        });
    }
});
</script>
