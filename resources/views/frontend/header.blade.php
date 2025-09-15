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
                <!-- Right Section -->
<div class="flex items-center flex-wrap justify-end gap-2 sm:gap-3 md:gap-5 mt-2 md:mt-0 w-full md:w-auto">

    <!-- Currency -->
    <div class="flex items-center">
        <span id="current-currency"
              class="font-semibold cursor-pointer select-none text-sm md:text-base"
              title="Click to change currency">
            LKR
        </span>
    </div>

    <!-- Language -->
    @php
        $locale = app()->getLocale();
        $language = config('languages.' . $locale);
        $flag = isset($language['flag']) ? asset($language['flag']) : asset('images/flags/uk.png');
    @endphp
    <button id="language-button" type="button"
            class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
        <img src="{{ $flag }}" alt="{{ $language['name'] ?? 'Language' }}"
             class="w-full h-full object-cover rounded-full" />
    </button>

    <!-- Help -->
    <a href="#" class="flex items-center">
        <img src="{{ asset('assets/question.svg') }}" alt="Help"
             class="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
    </a>

    <!-- List property -->
    <a href="/list-your-property"
       class="hover:underline text-xs sm:text-sm md:text-base"
       style="font-family: 'Noto Sans', sans-serif;">
        List your property
    </a>

    <!-- Auth -->
    @auth('customer')
        <!-- Profile dropdown here -->
    @else
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('customer.login') }}"
               class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2 rounded hover:bg-blue-100 text-xs sm:text-sm md:text-base"
               style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                Register
            </a>
            <a href="{{ route('customer.login') }}"
               class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2 rounded hover:bg-blue-100 text-xs sm:text-sm md:text-base"
               style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                Sign in
            </a>
        </div>
    @endauth
</div>

            </div>
        </div>
    </section>
</header>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Currency modal logic
        const currentCurrency = document.getElementById("current-currency");
        const currencyModal = document.getElementById("currency-modal");
        const currencyCloseBtn = document.getElementById("currency-close-btn");

        if (currentCurrency && currencyModal && currencyCloseBtn) {
            // Open currency modal on clicking the currency span
            currentCurrency.addEventListener("click", () => {
                currencyModal.classList.remove("hidden");
            });

            // Close currency modal on close button click
            currencyCloseBtn.addEventListener("click", () => {
                currencyModal.classList.add("hidden");
            });

            // Close currency modal on clicking outside the modal content
            window.addEventListener("click", (e) => {
                if (e.target === currencyModal) {
                    currencyModal.classList.add("hidden");
                }
            });

            // Change currency when a currency button is clicked
            currencyModal.querySelectorAll("button[data-currency]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const selectedCurrency = btn.getAttribute("data-currency");
                    currentCurrency.textContent = selectedCurrency;
                    currencyModal.classList.add("hidden");
                });
            });
        }

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