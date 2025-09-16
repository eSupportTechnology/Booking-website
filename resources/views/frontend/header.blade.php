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

                                            <!-- Navigation -->
                    <nav class="grid grid-cols-2 gap-2 md:flex md:flex-nowrap md:gap-4 mt-2 md:mt-4">
                        <!-- Stays -->
                        <a href="{{ route('stays') }}"
                        class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition 
                                {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
                        </a>

                        <!-- Car Rentals -->
                        <a href="{{ route('car.rentals') }}"
                        class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition 
                                {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
                        </a>

                        <!-- Airport Taxis -->
                        <a href="{{ route('airport.taxis') }}"
                        class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition 
                                {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Airport taxis</span>
                        </a>

                        <!-- Tour Packages -->
                        <a href="{{ route('airport.tours') }}"
                        class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition 
                                {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                            <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
                            <span style="font-family: 'Noto Sans', sans-serif;">Tour packages</span>
                        </a>
                    </nav>

                    </div>
                </div>

        <!-- Right Section -->
    <div class="flex flex-wrap items-center justify-start md:justify-end gap-3 w-full md:w-auto mt-4 md:mt-0">
        <!-- Currency -->
        <span id="current-currency"
            class="font-semibold cursor-pointer select-none">LKR</span>

        <!-- Language -->
        @php
            $locale = app()->getLocale();
            $language = config('languages.' . $locale);
            $flag = isset($language['flag']) ? asset($language['flag']) : asset('images/flags/uk.png');
        @endphp
        <button id="language-button" type="button"
            class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 overflow-hidden">
            <img src="{{ $flag }}" alt="{{ $language['name'] ?? 'Language' }}"
                class="w-full h-full object-cover rounded-full" />
        </button>

        <!-- Help -->
        <a href="">
            <img src="{{ asset('assets/question.svg') }}" class="w-5 h-5" />
        </a>

        <!-- List property -->
        <a href="/list-your-property" class="hover:underline">List your property</a>

                    <!--Your Account -->
                    <div class="relative">
                        <button id="account-btn" class="flex items-center space-x-2">
                            <div class="bg-white p-2 border border-[#3CC0E9] rounded-full">
                                <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" />
                            </div>
                            <span>Your Account</span>
                        </button>

                        <!-- Dropdown -->
                        <div id="account-menu"
                            class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                            @auth('customer')
                                <a href="/profile"
                                class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/mynaui_user.svg') }}" class="w-5 h-5" /> My Account
                                </a>
                                <a href="/profile"
                                class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/streamline_baggage.svg') }}" class="w-4 h-4" /> Bookings & Trips
                                </a>
                                <a href="/profile"
                                class="block px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/mynaui_letter-g-circle.svg') }}" class="w-5 h-5" /> Genius loyalty programme
                                </a>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
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

                        <!-- ✅ Guest buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('customer.login') }}"
                            class="bg-white text-[#3CC0E9] rounded hover:bg-blue-100 
                                    px-2 py-1 text-sm md:px-4 md:py-2 md:text-base">
                            Register
                            </a>
                            <a href="{{ route('customer.login') }}"
                            class="bg-white text-[#3CC0E9] rounded hover:bg-blue-100 
                                    px-2 py-1 text-sm md:px-4 md:py-2 md:text-base">
                            Sign in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
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
