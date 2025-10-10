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
    <span id="current-currency" class="font-semibold cursor-pointer select-none text-sm md:text-base" title="Click to change currency">LKR</span>

    <!-- Language -->


    <!-- Help -->
    <a href="#" class="flex items-center">
        <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
    </a>

    <!-- List property -->
    <a href="/list-your-property" class="hover:underline">List your property</a>
   </div>

     <div class="flex w-full md:w-auto justify-center md:justify-end gap-2 sm:gap-3 md:gap-5">
    <!-- Your Account -->
    <div class="relative">
        <button id="account-btn" class="flex items-center space-x-2">
            <div class="bg-white p-2 border border-[#3CC0E9] rounded-full">
                <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" />
            </div>
            <span>Your Account</span>
        </button>

        <!-- Dropdown -->
        <div id="account-menu"
     class="absolute mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50
            left-0 sm:right-0">
            @auth('customer')
                <a href="/profile" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <img src="{{ asset('assets/mynaui_user.svg') }}" class="w-5 h-5" /> My Account
                </a>
                <a href="/profile" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <img src="{{ asset('assets/streamline_baggage.svg') }}" class="w-4 h-4" /> Bookings & Trips
                </a>
                <a href="/profile" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <img src="{{ asset('assets/mynaui_letter-g-circle.svg') }}" class="w-5 h-5" /> Genius loyalty programme
                </a>

                <a href="{{ route('customer.bookings.index') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                     <img src="{{ asset('assets/balcony.svg') }}" class="w-5 h-5" /> My Bookings
                </a>

                <a href="{{ route('customer.messages.index') }}" class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                    <img src="{{ asset('assets/mynaui_letter-g-circle.svg') }}" class="w-5 h-5" /> Messages
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
                    currentCurrency.textContent = selectedCurrency;
                    currencyModal.classList.add("hidden");
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
