<!-- resources/views/frontend/about-booking.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Booking.com™</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

    <!-- Top Navigation Bar -->
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

                           <!-- Buttons under the logo -->
                            <div class="flex flex-row flex-wrap mt-2 space-x-2">
                                <a href="{{ route('stays') }}" class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                    <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
                                </a>

                                <a href="{{ route('customer.car-rentals') }}" class="flex items-center justify-center space-x-1 px-3 py-1 rounded-full border text-white transition {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                    <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
                                    <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
                                </a>
                            </div>


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



    <!-- MSN Partnership Banner -->
    <section class="w-full bg-white py-8 text-center border-b">
        <p class="text-sm text-gray-600">In partnership with</p>
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/06/MSN_Logo_2015.svg"
             class="mx-auto w-24 mt-2" alt="MSN logo">
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-10 py-12">

        <!-- Left Sidebar Links -->
        <aside class="space-y-3 text-[#003580] text-sm">
            <a class="block hover:underline font-semibold">About Booking.com™</a>
            <a class="block hover:underline">Legal</a>
            <a class="block hover:underline">Digital Services Act</a>
            <a class="block hover:underline">Digital Markets Act</a>
            <a class="block hover:underline">Accessibility Statement</a>
            <a class="block hover:underline">Terms of Service</a>
            <a class="block hover:underline">How We Work</a>
            <a class="block hover:underline">Offices Worldwide</a>
            <a class="block hover:underline">Contact Us</a>
            <a class="block hover:underline">Press Center</a>
            <a class="block hover:underline">Career Opportunities</a>
            <a class="block hover:underline">Sustainability at Booking.com</a>
            <a class="block hover:underline">Add Your Property</a>
            <a class="block hover:underline">Booking.com for Business</a>
            <a class="block hover:underline">Extranet Log-in</a>
            <a class="block hover:underline">Become an Affiliate</a>
        </aside>

        <!-- Right Content -->
        <section class="md:col-span-3 space-y-6">
            <h2 class="text-3xl font-semibold">About Booking.com™</h2>

            <p class="leading-7 text-gray-700">
                Founded in 1996 in Amsterdam, Booking.com has grown from a small Dutch start-up to one of the world’s
                leading digital travel companies. Part of Booking Holdings Inc. (NASDAQ: BKNG), the mission of
                Booking.com is to <strong>make it easier for everyone to experience the world.</strong>
            </p>

            <p class="leading-7 text-gray-700">
                By investing in technology that takes the friction out of travel, Booking.com seamlessly connects
                millions of travelers to memorable experiences, a variety of transportation options, and incredible
                places to stay – from homes to hotels, and much more.
            </p>

            <p class="leading-7 text-gray-700">
                As one of the world’s largest travel marketplaces for both established brands and entrepreneurs of
                all sizes, Booking.com enables properties across the globe to reach a wider audience and grow their
                business.
            </p>

            <p class="leading-7 text-gray-700">
                Booking.com is available in 43 languages and offers more than 28 million reported accommodation listings,
                including over 6.6 million homes, apartments, and other unique places to stay. Whether you want to go
                wherever, whenever, Booking.com makes it simple and supports you with 24/7 customer service.
            </p>

        </section> <!-- end right content -->
    </main> <!-- ✅ closing main -->

    <!-- Top Blue Section -->
<section class="w-full bg-[#4BA3E3] text-white py-16 px-6">
    <div class="max-w-6xl mx-auto text-center leading-relaxed">

        <p class="text-sm md:text-base">
            Booking.com B.V. is based in Amsterdam in the Netherlands and supported internationally by 198 offices in over 70 countries around the world:
            Accra - Amman - Amsterdam - Antalya - Athens - Atlanta - Auckland - Bangalore - Bangkok - Barcelona - Beijing - Berlin - Bilbao - Bogotá - Bolzano - Bordeaux - Boston - Bratislava - Brisbane - Bristol - Brussels - Bucharest - Budapest - Buenos Aires - Cairo - Calgary - Cambridge - Cancún - Cape Town - Casablanca - Catania - Chengdu - Chicago - Colombo - Copenhagen - Dallas - Denver - Dubai - Dublin - Dubrovnik - Düsseldorf - Edinburgh - Faro - Florence - Frankfurt am Main - Freiburg im Breisgau - Fukuoka - Grand Rapids - Guadalajara - Guangzhou - Haikou - Hamburg - Hanoi - Helsinki - Heraklion - Ho Chi Minh City - Hong Kong - Honolulu - Houston - Innsbruck - Istanbul - Izmir - Jakarta - Jeddah - Jeju - Johannesburg - Kiev - Koh Samui - Krakow - Kuala Lumpur - Kuta (Bali) - Las Palmas de Gran Canaria - Las Vegas - Lille - Lima - Limassol - Lisbon - Ljubljana - London - Los Angeles - Lyon - Madrid - Málaga - Manchester - Manila - Marrakech - Melbourne - Mexico City - Miami - Milan - Montpellier - Montréal - Moscow - Mumbai - Munich - Naha - Nairobi - Natal - New Delhi - New Orleans - New York - Nice - Norwalk - Orlando - Osaka - Oslo - Palma de Mallorca - Panama City - Paris - Phoenix - Phuket - Porto Alegre - Prague - Qingdao - Rennes - Reykjavik - Riga - Rimini - Rio de Janeiro - Rome - Saint Petersburg - Sallanches - Salzburg - San Diego - San Francisco - San Jose - San Juan - Santiago - Santo Domingo - São Paulo - Sapporo - Seattle - Seoul - Seville - Shanghai - Siem Reap - Singapore - Sochi - Sofia - Sorrento - Split - Stockholm - Strasbourg - Sydney - Taipei - Tallinn - Tbilisi - Tel Aviv - Thessaloniki - Tokyo - Toronto - Trabzon - Vancouver - Venice - Verona - Vienna - Vilnius - Warsaw - Washington - Xi'an - Yangon - Yogyakarta - Zagreb - Zurich
        </p>

        <p class="text-sm md:text-base mt-8 opacity-90">
            Booking.com B.V. is registered with the trade register of the Chamber of Commerce in Amsterdam, the Netherlands, under registration number 31047344.
            VAT tax registration number is NL805734958B01. Registration number with Dutch Data Protection Authority is 12888246.
        </p>
    </div>
</section>

<!-- What Booking.com Offers Section -->
<section class="w-full bg-white py-16 px-6">
    <div class="max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- LEFT SIDE TITLE -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 leading-snug">
                What Booking.com<br>
                Offers
            </h2>
        </div>

        <!-- RIGHT SIDE CONTENT -->
        <div class="md:col-span-2 space-y-8 text-gray-800">

            <!-- Incredible Selection -->
            <div>
                <h3 class="font-semibold text-lg">Incredible Selection</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    Whether you want to stay in a chic city apartment, a luxury beach resort,
                    or a cozy B&amp;B in the countryside, Booking.com gives you amazing diversity
                    and variety of choice – all in one place.
                </p>
            </div>

            <!-- Low Rates -->
            <div>
                <h3 class="font-semibold text-lg">Low Rates</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    Booking.com guarantees to offer you the best available rates.
                    And with our promise to price match, you can rest assured that
                    you’re always getting a great deal.
                </p>
            </div>

            <!-- Instant Confirmation -->
            <div>
                <h3 class="font-semibold text-lg">Instant Confirmation</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    At Booking.com, every reservation is instantly confirmed.
                    When you find your perfect stay, a few clicks are all it takes.
                </p>
            </div>

            <!-- No Reservation Fees -->
            <div>
                <h3 class="font-semibold text-lg">No Reservation Fees</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    We don’t charge you any booking fees or add any administrative charges.
                    And in many cases, your booking can be canceled free of charge.
                </p>
            </div>

            <!-- Secure Booking -->
            <div>
                <h3 class="font-semibold text-lg">Secure Booking</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    We facilitate hundreds of thousands of transactions every day through our
                    secure platform and work to the highest standards to guarantee your privacy.
                    For more details, check our
                    <a href="#" class="text-blue-600 underline">Privacy Statement</a>.
                </p>
            </div>

            <!-- 24/7 Support -->
            <div>
                <h3 class="font-semibold text-lg">24/7 Support</h3>
                <p class="mt-1 text-gray-700 leading-relaxed">
                    Whether you’ve just booked or are already enjoying your trip, our Customer
                    Experience Team is available around the clock to answer your questions and
                    advocate on your behalf in more than 40 languages.
                    Make sure to check out our
                    <a href="#" class="text-blue-600 underline">FAQs</a>
                    for travelers.
                </p>
            </div>

        </div>

    </div>
    
</section>

<!-- ACCOMMODATION PARTNERS SECTION -->
<section class="w-full bg-white py-16 px-6">
    <div class="max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- LEFT SIDE: TITLE -->
        <div>
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">
                Bringing Value to Our Accommodation Partners
            </h2>
        </div>

        <!-- RIGHT SIDE: CONTENT -->
        <div class="md:col-span-2">
            <p class="text-gray-700 leading-relaxed mb-6">
                At Booking.com, we believe that all great properties deserve to be discovered. 
                That’s why we make it quick and easy for accommodation providers all around 
                the world to market their properties, reach new customers, and grow their 
                business through our platform.
            </p>

            <p class="text-gray-700 leading-relaxed">
                For more info and to list your property on Booking.com, see our 
                <a href="#" class="text-blue-600 hover:underline">Accommodation Partner Program</a> 
                and 
                <a href="#" class="text-blue-600 hover:underline">Supplier Code of Conduct</a>.
            </p>
        </div>

    </div>
</section>

 <!-- ================== TOP BLUE BAR ================== -->
    <div class="w-full bg-[#003580] py-3 flex justify-center">
        <a href="/list-your-property"
        class="text-white border border-white px-4 py-1 rounded text-sm hover:bg-white hover:text-[#003580] transition">
        List your property
        </a>
    </div>

    <!-- ================== NAVIGATION BLUE STRIP ================== -->
    <div class="w-full bg-[#003580] text-white text-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap justify-center gap-6">

            <a href="#" class="hover:underline font-semibold">Mobile version</a>
            <a href="#" class="hover:underline font-semibold">Your account</a>
            <a href="#" class="hover:underline font-semibold">Make changes online to your booking</a>
            <a href="#" class="hover:underline font-semibold">Become an affiliate</a>
            <a href="#" class="hover:underline font-semibold">Booking.com for Business</a>

        </div>
    </div>

    <!-- ================== MULTI-COLUMN FOOTER ================== -->
    <footer class="max-w-7xl mx-auto px-4 py-10 text-sm">

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">

            <!-- Column 1 -->
            <div class="space-y-2">
                <a href="#" class="text-[#0066CC] hover:underline block">Countries</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Regions</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Cities</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Districts</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Airports</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Hotels</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Places of interest</a>
            </div>

            <!-- Column 2 -->
            <div class="space-y-2">
                <a href="#" class="text-[#0066CC] hover:underline block">Homes</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Apartments</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Resorts</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Villas</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Hostels</a>
                <a href="#" class="text-[#0066CC] hover:underline block">B&Bs</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Guest Houses</a>
            </div>

            <!-- Column 3 -->
            <div class="space-y-2">
                <a href="#" class="text-[#0066CC] hover:underline block">Unique places to stay</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Reviews</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Discover monthly stays</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Seasonal and holiday deals</a>
                <a href="#" class="text-[#0066CC] hover:underline block">Traveller Review Awards</a>
            </div>

            <!-- Column 4 -->
            <div class="space-y-2">
                <a href="#" class="text-[#0066CC] hover:underline block">Booking.com for Travel Agents</a>
            </div>

            <!-- Column 5 -->
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

        <!-- Extranet Login -->
        <div class="text-center mt-10">
            <a href="#" class="text-[#0066CC] hover:underline">Extranet Log-in</a>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-12 text-gray-600 text-xs">
            Copyright © 1996–2025 Booking.com™. All rights reserved.
        </div>

        <!-- Partner Brands -->
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
