<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How We Work - Booking.com</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">

    <!-- TOP BLUE HEADER -->
    <header class="text-white px-2 sm:px-4 py-2 sm:py-4" style="background-color:#1F8FB2;">
        <section class="py-0">
            <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
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

    <!-- PARTNERSHIP STRIP -->
    <div class="w-full bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col items-center justify-center gap-1 text-center">
            <span class="text-sm text-gray-600">In partnership with</span>
            <img src="{{ asset('assets/msn-logo.png') }}" alt="MSN" class="h-8 object-contain" />
        </div>
    </div>

    <!-- MAIN GRID LAYOUT -->
    <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-10">

        <!-- LEFT SIDEBAR -->
        <aside class="space-y-6 text-gray-700">
            <div>About Booking.com™</div>
            <div>Legal</div>
            <div>Digital Services Act</div>
            <div>Digital Markets Act</div>
            <div>Accessibility Statement</div>
            <div>Terms of Service</div>

            <!-- Active Tab -->
            <div class="bg-blue-50 text-blue-600 p-3 rounded">
                How We Work
            </div>

            <div>Offices Worldwide</div>
            <div>Contact Us</div>
            <div>Press Center</div>
            <div>Career Opportunities</div>
            <div>Sustainability at Booking.com</div>
            <div>Add Your Property</div>
            <div>Booking.com for Business</div>
            <div>Extranet Log-in</div>
            <div>Become an Affiliate</div>
            <div>Supplier Code of Conduct</div>
            
        </aside>

        <!-- MAIN CONTENT -->
        <main class="md:col-span-3">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold">How we work</h1>
                <button onclick="window.print()" class="flex items-center space-x-1 text-blue-700">
                    <span>🖨️</span> <span>Print</span>
                </button>
            </div>

            <p class="text-gray-600 mb-4">Updated May 31, 2025</p>

            <!-- TABLE OF CONTENTS -->
            <h2 class="text-xl font-semibold mb-3">Table of contents</h2>
            <ul class="list-disc ml-6 space-y-1 text-blue-600">
                <li><a href="#accommodations">1. Accommodations</a></li>
                <li><a href="#attractions">2. Attractions</a></li>
                <li><a href="#car-rentals">3. Car rentals</a></li>
                <li><a href="#flights">4. Flights</a></li>
                <li><a href="#transport">5. Private and public transportation</a></li>
            </ul>

            <!-- SECTION 2 -->
            <h2 id="accommodations" class="text-2xl font-semibold mt-6 mb-4">1. Accommodations</h2>

            <ul class="list-disc ml-6 space-y-1 text-blue-600">
                <li><a href="#1A">1A. Definitions and who we are</a></li>
                <li><a href="#1B">1B. How does our service work?</a></li>
                <li><a href="#1C">1C. Who do we work with?</a></li>
                <li><a href="#1D">1D. How do we make money?</a></li>
                <li><a href="#1E">1E. Our recommendation systems</a></li>
                <li><a href="#1F">1F. Reviews</a></li>
                <li><a href="#1G">1G. Prices</a></li>
                <li><a href="#1H">1H. Payments</a></li>
                <li><a href="#1I">1I. Host type</a></li>
                <li><a href="#1J">1J. Star ratings, review scores, and quality ratings</a></li>
                <li><a href="#1K">1K. Help and advice – if the unexpected happens</a></li>
                <li><a href="#1L">1L. Overbooking</a></li>
            </ul>


            <!-- ============================= -->
            <!--        1A SECTION             -->
            <!-- ============================= -->
            <div id="1A" class="mt-8">
                <h3 class="text-xl font-semibold mb-2">1A. Definitions and who we are</h3>

                <p class="text-gray-700 leading-7">
                    Some of the words here have specific meanings, so check out the “Booking.com dictionary” in our 
                    <a href="#" class="text-blue-600 underline">Terms of Service</a>.
                </p>

                <p class="text-gray-700 leading-7 mt-3">
                    When you book an Accommodation, <strong>Booking.com B.V.</strong> provides and is responsible for the Platform but not the Travel Experience itself (section 1B).  
                    Booking.com B.V. is a company incorporated under the laws of the Netherlands 
                    (registered address: Oosterdokskade 163, 1011 DL, Amsterdam, The Netherlands;  
                    Chamber of Commerce number: 31047344; VAT number: NL805734958B01).
                </p>
            </div>


            <!-- ============================= -->
            <!--        1B SECTION             -->
            <!-- ============================= -->
            <div id="1B" class="mt-8">
                <h3 class="text-xl font-semibold mb-2">1B. How does our service work?</h3>

                <p class="text-gray-700 leading-7">
                    We make it easy for you to compare bookings from many hotels, hosts, and other Service Providers.
                </p>

                <p class="text-gray-700 leading-7 mt-3">
                   When you make a booking on our Platform, you enter into a contract with the Service Provider (unless otherwise stated).
                </p>

                <p class="text-gray-700 leading-7 mt-3">
                    The information on our Platform is based on what Service Providers tell us. We do our best to keep things up to date at all times, but realistically, it can take a few hours to update, for example, text descriptions and lists of the facilities that Accommodations provide.
                </p>
            </div>


            <!-- ============================= -->
            <!--        1C SECTION             -->
            <!-- ============================= -->
            <div id="1C" class="mt-8">
                <h3 class="text-xl font-semibold mb-2">1C. Who do we work with?</h3>

                <p class="text-gray-700 leading-7">
                    Only Service Providers with a contractual relationship with us will be displayed on our Platform. They may also offer Travel Experiences outside our Platform.
                </p>

                <p class="text-gray-700 leading-7 mt-3">
                   We don’t own any Accommodations ourselves – each Service Provider is a separate company that has agreed to work with us in a certain way.
                </p>

                <p class="text-gray-700 leading-7 mt-3">
                    Our Platform shows you the Accommodations you can book through us worldwide, and our search results page tells you how many of them might be right for you based on what you’ve told us.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1D SECTION             -->
            <!-- ============================= -->
            <div id="1D" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1D. How do we make money?</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                   We don’t buy or (re)sell any products or services. Once your stay is finished, the Service Provider just pays us a commission. A badge with a thumbs-up icon indicates that the property is part of our Preferred Partner Program – they pay us a higher commission if you make a booking.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                   If an Accommodation in your search results has a badge that says “Ad,” it means that the Service Provider has paid for it to appear there.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1E SECTION             -->
            <!-- ============================= -->
            <div id="1E" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1E. Our recommendation systems</h3>
                 <h3 class="text-lg sm:text-sm font-semibold mb-2">How Booking.com uses recommendation systems</h3>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    All great properties deserve to be discovered. That’s why we use “recommendation” systems to select, display, and/or rank information on our Platform in a way that’ll help you discover properties we think you’ll like.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    For example, on the “Stays” landing page, you’ll find several recommendation systems, including:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>Trending destinations: Destinations you may want to travel to based on bookings made by other travelers whose searches were similar to yours.</li>
                    <li>Homes guests love: Home properties with high review scores.</li>
                    <li>Looking for the perfect stay? Properties (as opposed to destinations) that you may want to stay at based on bookings made by other guests whose searches were similar to yours.</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Our search results are also a recommendation system. In fact, they’re the recommendation system that our customers use the most, so be sure to check out “Our default ranking and sorting options” section.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    All the recommendation systems we use provide recommendations based on one or more of the following factors:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>What you tell us when you are looking to book a Travel Experience, such as destination, dates, number of guests, etc.</li>
                    <li>The information we’ve gathered based on your previous interactions with our Platform, such as your past searches, existing reservations, etc., unless you opted out of the personalized recommendations.</li>
                    <li>Any other information on how you currently interact with our Platform, including the country where you are while browsing.</li>
                    
                </ul>
                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>An Accommodation’s performance on our Platform:
                            <ul class="list-disc ml-6 mt-1 space-y-1">
                                <li>Click-through rate: How many people click on it.</li>
                                <li>Gross bookings: How many bookings are made with that Accommodation.</li>
                                <li>Net bookings: How many bookings are made with that Accommodation minus how many are canceled.</li>
                            </ul>
                        </li>
                    <li>Information about the Accommodation’s availability, pricing scores, review scores, etc.</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    To make it as easy as possible for you to find and book an Accommodation you like, each factor can be more or less important in different cases, depending on what we think is most likely to produce a list of properties you may want to book.
                </p><br>

                <h3 class="text-lg sm:text-sm font-semibold mb-2">Our default ranking and sorting options</h3>
                
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Our search results are also a recommendation system. They show all the Accommodations (hotels, apartments, etc.) that match your search. If you like, you can use filters to narrow down your results.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    To check all the booking options an Accommodation offers, just select it.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                   When you first get your search results, they’ll be sorted (“ordered”) by “Our top picks” (called “Popularity” on our app): 
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>To appear high up on the page, an Accommodation needs to do well in each of these three areas:
                            <ul class="list-disc ml-6 mt-1 space-y-1">
                                <li>Click-through rate: How many people click on it;</li>
                                <li>Gross bookings: How many bookings are made with that Accommodation;</li>
                                <li>Net bookings. How many bookings are made with that Accommodation minus how many are canceled.</li>
                            </ul>
                        </li>

                <li>Those numbers depend on many factors, including review scores, availability, policies, pricing, quality of content (e.g. photos), and other features.</li>
                <li>Other things can also influence an Accommodation’s ranking – for example, how much commission they pay us on bookings, how quickly they usually pay it, whether they’re part of our Genius program or Preferred Partner (+) Program, and, in certain places*, whether we organize their payments.</li>
                <li>Any information we've gathered based on how you interact with our Platform (including what you tell us) will also be a factor unless you opted out of the personalized recommendations.</li>
                </ul>

                 <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    * Currently, this ranking factor only applies to US Accommodations booked by US-based customers.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Many of these factors help our recommendation systems decide which Accommodations might be the most appealing and relevant to you. Some play a small role in that decision, while others play a significant role – the importance of each factor can change depending on the Accommodation's features and how you and other people use our Platform.
                </p>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    For example, an Accommodation's click-through rate and number of bookings often play a significant role in these decisions as they directly reflect the Accommodation's overall appeal and how satisfied its guests tend to be with what it offers. A high click-through rate usually means that an Accommodation makes a good first impression on our Platform (e.g. through images, amenities, or descriptions), and getting a lot of bookings indicates that many people find it meets their requirements.
                </p>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    However, other factors play a role as well. For example, we might give preference to Accommodations that are part of our Genius program or offer versatile, user-friendly payment policies. After all, these factors suggest that these Accommodations understand how important service and convenience are to our customers.
                </p>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Our recommendations are also influenced by how other customers with similar preferences use our Platform. For example, if “Person A” often books Accommodations in Paris, Barcelona, and Rome, and “Person B” often books Accommodations in Paris, Barcelona, Rome, Berlin, and Madrid, then our recommendation system might predict that Person A would also be interested in properties in Berlin and Madrid.
                </p>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If an Accommodation in your search results has a badge that says “Ad,” it means that the Service Provider has paid for it to appear there.
                </p>
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If you would prefer us not to order your search results in our default way, you can sort them in other ways, such as:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>Homes & apartments first: Homes and apartments appear higher than hotels and other types of Accommodation.</li>
                    <li>Price (lowest first): Accommodations with lower prices appear higher up.</li>
                    <li>Genius discount first: Genius Accommodations appear higher than other Accommodations.</li>
                    <li>Property rating (high to low): Accommodations with more stars* and/or higher quality ratings* appear higher.</li>
                    <li>Property rating (low to high): Accommodations with fewer stars and/or lower quality ratings appear higher.</li>
                    <li>Top reviewed (called “Best reviewed” in our app): Accommodations with higher review scores* appear higher. If you find any instances where this isn’t the case, it’s because we also factor in reliability (i.e. number of reviews). For example, an Accommodation with 1,000 reviews and an average score of 8.2 could appear higher than an Accommodation with 5 reviews and an average score of 8.3.</li>
                    <li>Distance from (X): Accommodations that are closer to X (e.g. the city center) appear higher on the page. (When we say “close,” we mean “close in a straight line.”)</li>
                    <li>Property rating: Accommodations with more stars appear higher up. The ones with lower prices appear higher within each segment (5 stars, 4 stars, etc.).</li>
                    <li>Best reviewed and lowest price: Accommodations with higher review scores appear higher. Within each 0.5 segment (between 10 and 9.5, between 9.5 and 9, etc.), the ones with lower prices appear higher.</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    * Check out “Star ratings, review scores, and quality ratings” (section 1J).
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Keep in mind that whatever sorting option you choose, the factors described in “Our top picks” may still influence things. For example, those factors might act as “tiebreakers” between two or more Accommodations that would otherwise appear in the same spot. However, the “Our top picks” factors are purely secondary because they’re only used where we need to decide which of two properties to put first.
                </p><br>

                <h3 class="text-lg sm:text-sm font-semibold mb-2">Personalized recommendations</h3>
                
                

                <!-- Add additional paragraphs and bullet points as needed, all using text-sm sm:text-base, leading-5 sm:leading-6 -->
            </div>

            <!-- ============================= -->
            <!--        1F SECTION             -->
            <!-- ============================= -->
            <div id="1F" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1F. Reviews</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Each review score is from 1 to 10. We use a weighted review system, which means that the more recent the review, the bigger the impact on the total review score calculation.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    In addition, guests can give separate “subscores” for specific Travel Experience aspects such as location, cleanliness, staff, comfort, facilities, value, and free Wifi. Guests submit their subscores and overall scores independently.
                </p>

                <!-- Continue adding all content under 1F using the same classes -->
            </div>

            <!-- ============================= -->
            <!--        1G SECTION             -->
            <!-- ============================= -->
            <div id="1G" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1G. Prices</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    The rates displayed on our Platform are set by the Service Providers. We may finance rewards or other benefits out of our own pocket.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    When you make a booking, you agree to pay the cost of the Travel Experience itself and any other taxes and fees that may apply.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1H SECTION             -->
            <!-- ============================= -->
            <div id="1H" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1H. Payments</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    There are three ways you might pay for your Booking:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>The Service Provider charges you at the Accommodation.</li>
                    <li>The Service Provider charges you in advance. We (or our affiliate) forward your Payment Method details to them.</li>
                    <li>We organize your payment to the Service Provider in advance. We (or our affiliate) make sure the Service Provider is paid.</li>
                </ul>
            </div>

            <!-- ============================= -->
            <!--        1I SECTION             -->
            <!-- ============================= -->
            <div id="1I" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1I. Host type</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    We ask Service Providers to tell us if they’re acting as a “private host” or “professional host,” as defined by EU law. This label has no tax relevance but is required under EU consumer law.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1J SECTION             -->
            <!-- ============================= -->
            <div id="1J" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1J. Star ratings, review scores, and quality ratings</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Star ratings look like 1–5 yellow stars, review scores are blue squares from 1–10, and quality ratings are yellow squares from 1–5. We don’t assign review scores ourselves; customers do.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1K SECTION             -->
            <!-- ============================= -->
            <div id="1K" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1K. Help and advice – if the unexpected happens</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Contact us via your booking, app, or Help Center. Provide your booking confirmation, a summary of the issue, and any supporting documents. We handle urgent complaints first.
                </p>
            </div>

            <!-- ============================= -->
            <!--        1L SECTION             -->
            <!-- ============================= -->
            <div id="1L" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1L. Overbooking</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    If the Service Provider is overbooked, they must provide a solution. You may cancel at no cost or be offered a suitable alternative. Refunds are handled by us or the Service Provider depending on who organized the payment.
                </p>
            </div>

            <!-- Back to top link -->
            <div class="mt-6">
                <a href="#accommodations" class="text-blue-600 underline text-sm sm:text-base">Back to top</a>
            </div>



        </main>
    </div>

</body>
</html>
