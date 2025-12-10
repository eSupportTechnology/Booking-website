<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Resource Center</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Top Blue Navbar -->
 <header class="text-white px-2 sm:px-4 py-2 sm:py-4" style="background-color:#1F8FB2;">
    <section class="py-0">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <!-- Header Container -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center flex-wrap space-y-4 md:space-y-0">

            <!-- Left Section -->
            <div class="w-full md:w-auto flex flex-col md:flex-row md:items-center md:space-x-6">
                @php
                    $host = config('domains.app_name');
                    $currentRoute = request()->route()->getName();
                @endphp

                <!-- Logo + Buttons -->
                <div class="flex flex-col items-start">
                    <a href="{{ url('/') }}" class="text-2xl font-bold flex flex-col items-start">
                        @if ($host == 'BookinTour')
                            <h1>Bookintour.com</h1>

                        @elseif ($host == 'Inselor')
                            <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
                        @endif
                    </a>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center flex-wrap justify-end gap-2 sm:gap-3 md:gap-5 w-full md:w-auto order-2 px-2 sm:px-0 md:px-0">

                <!-- Currency + Help + List Property -->
                <div class="flex w-full md:w-auto justify-center md:justify-end gap-2 sm:gap-3 md:gap-5 mb-2 md:mb-0">
                    <!-- Currency -->
                    <div class="relative">
                        <span id="current-currency"
                            class="font-semibold cursor-pointer select-none text-sm md:text-base"
                            title="Click to change currency">
                            {{ app(\App\Services\CurrencyManager::class)->getUserCurrency() }}
                        </span>

                        <!-- Currency Modal -->
                        <div id="currency-modal"
                            class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">

                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">

                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900">Select Currency</h3>
                                    <button type="button" id="currency-close-btn"
                                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    @foreach(app(\App\Services\CurrencyService::class)->getSupportedCurrencies() as $currency)
                                        <button data-currency="{{ $currency }}"
                                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 text-gray-800">
                                            <span>{{ $currency }}</span>
                                        </button>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Help -->
                    <a href="#" class="flex items-center">
                        <img src="{{ asset('assets/question.svg') }}" alt="Help"
                            class="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
                    </a>

                    <!-- List Property -->
                    <a href="/list-your-property" class="hover:underline">
                        List your property
                    </a>
                </div>

                <!-- Register / Sign in -->
                <div class="flex w-full md:w-auto justify-center md:justify-end gap-2 sm:gap-3 md:gap-5">
                    @guest('customer')
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
                        <div class="flex items-center gap-1 sm:gap-2 invisible">
                            <span class="px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2">Hidden</span>
                            <span class="px-2 py-1 sm:px-3 sm:py-1 md:px-4 md:py-2">Hidden</span>
                        </div>
                    @endguest
                </div>

            </div>

        </div>

    </div>
</section>

</header>

<!-- MSN partnership section -->
<div class="w-full bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col items-center justify-center gap-1 text-center">
        <span class="text-sm text-gray-600">In partnership with</span>
        <img src="{{ asset('assets/msn-logo.png') }}" alt="MSN" class="h-8 object-contain" />
    </div>
</div>

<!-- Secondary Nav -->
<div class="w-full bg-white border-b">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex gap-6 sm:gap-10 overflow-x-auto py-3 text-sm">
            <a href="#" class="text-[#003580] font-semibold border-b-2 border-[#003580] pb-1">Overview</a>
            <a href="#" class="text-gray-500 hover:text-[#003580]">Standards</a>
            <a href="#" class="text-gray-500 hover:text-[#003580]">Guidelines</a>
            <a href="#" class="text-gray-500 hover:text-[#003580]">Travelers</a>
            <a href="#" class="text-gray-500 hover:text-[#003580]">Partners</a>
            <a href="#" class="text-gray-500 hover:text-[#003580]">COVID-19 resources</a>
        </nav>
    </div>
</div>

<!-- Hero Section -->
<div class="bg-white">
    <div class="max-w-6xl mx-auto px-4 py-16 sm:py-20 md:py-28 lg:py-36">
        <div class="max-w-5xl">
            <h1 class="font-extrabold text-gray-900 leading-tight text-3xl lg:text-7xl xl:text-8xl -mt-2">
                Trust and safety<br class="hidden md:inline" /> resource center
            </h1><br>

            <p class="mt-6 text-2xl sm:text-3xl md:text-5xl font-extrabold text-gray-800">
                Safety tips, guidelines, and our values
            </p>
        </div>
    </div>
</div>

<!-- Travelers Section -->
<div class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-8">Travelers</h1>
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 lg:gap-10">
            <!-- Left Image -->
            <div class="w-full lg:w-1/2">
                <img src="{{ asset('assets/travelers.jpg') }}" alt="Travelers Image" class="rounded-2xl w-full h-auto object-cover">
            </div>
            <!-- Right Text -->
            <div class="w-full lg:w-1/2 space-y-4">
                <h2 class="text-xl md:text-2xl font-semibold">Stay safely</h2>
                <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                    At Booking.com, we strive to help everyone experience the world safely.
                    We have many processes in place to protect our guests, and to empower
                    you to take control of your safety while traveling. Visit our traveler
                    resource page to learn more about making your future stays go smoothly.
                </p>
                <a href="#" class="inline-block mt-4 px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition">
                    See traveler resources
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Partners Section -->
<div class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-8">Partners</h1>
        <div class="flex flex-col lg:flex-row-reverse items-center lg:items-start gap-8 lg:gap-10">
            <!-- Right Image -->
            <div class="w-full lg:w-1/2">
                <img src="{{ asset('assets/travelers.jpg') }}" alt="Hosts Image" class="rounded-2xl w-full h-auto object-cover">
            </div>
            <!-- Left Text -->
            <div class="w-full lg:w-1/2 space-y-4">
                <h2 class="text-xl md:text-2xl font-semibold">Hosting safely</h2>
                <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                    Bringing peace of mind to our Booking.com Partners is a top priority. We help hosts feel confident about welcoming guests, and have processes in place to protect both you and your property. You can learn more about how to stay safe while hosting on our Partner resource page.
                </p>
                <a href="#" class="inline-block mt-4 px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition">
                    See partner resources
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Our Values Section -->
<div class="bg-white py-16">
    <div class="max-w-3xl mx-auto text-center px-4">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">Our values and guidelines</h2>
        <p class="text-gray-700 text-base sm:text-lg md:text-xl leading-relaxed mb-8">
            At Booking.com, we adhere to a set of values, standards, and guidelines intended to protect our partners, customers, and employees.
        </p>
        <a href="#" class="inline-block px-6 py-3 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition font-semibold">
            Learn more
        </a>
    </div>
</div>

<!-- If something goes wrong Section -->
<div class="bg-white">
    <div class="max-w-6xl mx-auto px-4 pt-10 pb-6">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900">If something goes wrong</h1>
    </div>
    <div class="max-w-6xl mx-auto px-4 pb-20">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16 items-start">
            <!-- Image Left -->
            <div class="w-full lg:w-1/2">
                <img src="{{ asset('assets/travelers.jpg') }}" alt="If something goes wrong" class="rounded-2xl w-full h-auto object-cover">
            </div>
            <!-- Text Right -->
            <div class="w-full lg:w-1/2">
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4">What to do if something goes wrong</h2>
                <p class="text-gray-700 leading-relaxed mb-6 text-base md:text-lg">
                    In the unlikely event that something goes wrong, we're here for you.
                    In this section, you can find guidelines to follow should an issue arise,
                    as well as the steps we'll take to look after you.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="px-5 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition text-sm md:text-base text-center">
                        As a traveler
                    </a>
                    <a href="#" class="px-5 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition text-sm md:text-base text-center">
                        As a partner
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Feedback Link -->
    <div class="max-w-6xl mx-auto px-4 pb-10 text-center sm:text-right text-sm">
        <span class="text-gray-600">Are you missing any info?</span>
        <a href="#" class="text-blue-600 font-semibold ml-2">Yes</a>
        <span class="mx-1 text-gray-400">/</span>
        <a href="#" class="text-blue-600 font-semibold">No</a>
    </div>
</div>

<!-- Disclaimer -->
<div class="bg-white mt-1 flex justify-center items-center px-4 py-4">
    <p class="text-gray-500 text-xs text-center leading-snug">
        This article is intended for information purposes only and does not constitute legal advice, rights, or a guarantee. You may need to take additional precautions depending on individual circumstances.
    </p>
</div>

<!-- Bottom Blue Bars -->
<div class="w-full bg-[#003580] py-3 flex justify-center">
    <a href="/list-your-property" class="text-white border border-white px-4 py-1 rounded text-sm hover:bg-white hover:text-[#003580] transition">
        List your property
    </a>
</div>

<div class="w-full bg-[#003580] text-white text-sm">
    <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap justify-center gap-4 sm:gap-6">
        <a href="#" class="hover:underline font-semibold">Mobile version</a>
        <a href="#" class="hover:underline font-semibold">Your account</a>
        <a href="#" class="hover:underline font-semibold">Make changes online to your booking</a>
        <a href="#" class="hover:underline font-semibold">Become an affiliate</a>
        <a href="#" class="hover:underline font-semibold">Booking.com for Business</a>
    </div>
</div>

<!-- Footer -->
<footer class="max-w-6xl mx-auto px-4 py-10 text-sm">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 sm:gap-6">
        <div class="space-y-2">
            <a href="#" class="text-[#0066CC] hover:underline block">Countries</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Regions</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Cities</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Districts</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Airports</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Hotels</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Places of interest</a>
        </div>
        <div class="space-y-2">
            <a href="#" class="text-[#0066CC] hover:underline block">Homes</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Apartments</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Resorts</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Villas</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Hostels</a>
            <a href="#" class="text-[#0066CC] hover:underline block">B&Bs</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Guest Houses</a>
        </div>
        <div class="space-y-2">
            <a href="#" class="text-[#0066CC] hover:underline block">Unique places to stay</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Reviews</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Discover monthly stays</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Seasonal and holiday deals</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Traveller Review Awards</a>
        </div>
        <div class="space-y-2">
            <a href="#" class="text-[#0066CC] hover:underline block">Booking.com for Travel Agents</a>
        </div>
        <div class="space-y-2">
            <a href="#" class="text-[#0066CC] hover:underline block">About Booking.com</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Customer Service Help</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Partner help</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Careers</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Sustainability</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Press Center</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Safety Resource Center</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Investor relations</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Terms of Service</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Partner dispute</a>
            <a href="#" class="text-[#0066CC] hover:underline block">How We Work</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Privacy Notice</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Modern Slavery Statement</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Human Rights Statement</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Corporate contact</a>
            <a href="#" class="text-[#0066CC] hover:underline block">Content guidelines and reporting</a>
        </div>
    </div>

    <div class="text-center mt-10">
        <a href="#" class="text-[#0066CC] hover:underline">Extranet Log-in</a>
    </div>

    <div class="text-center mt-12 text-gray-600 text-xs">
        Copyright © 1996–2025 Booking.com™. All rights reserved.
    </div>

    <div class="text-center mt-6 flex items-center justify-center gap-6 flex-wrap opacity-90">
        <img src="https://cf.bstatic.com/static/img/logos/BookingLogo/booking_logo.png" class="h-6" alt="">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Priceline.com_logo.svg/512px-Priceline.com_logo.svg.png" class="h-6" alt="">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/Kayak_Logo.svg/512px-Kayak_Logo.svg.png" class="h-6" alt="">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Agoda_logo.svg/512px-Agoda_logo.svg.png" class="h-6" alt="">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/OpenTable_logo.svg/512px-OpenTable_logo.svg.png" class="h-6" alt="">
    </div>
</footer>

</body>
</html>
