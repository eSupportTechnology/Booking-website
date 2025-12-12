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
                
                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Some of our recommendation systems go beyond your search parameters and filters and make personalized recommendations based on how you have interacted with Booking.com systems such as destination postcards, nearby destinations, and our search results. If you’re based in the EEA, you can change your settings so our recommendation systems do not provide personalized recommendations. To do so:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>On our desktop or mobile site: Select “Manage personalized recommendations” in the footer.</li>
                    <li>On our app: Select “Manage personalized recommendations” in the banner.</li>
                    
               
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                   Even if you do that, we may still retain some information about you so that we can provide you with our services and give you a more convenient experience, such as setting your language preference on our Platform based on where you are. This could be information that you provided (e.g. your phone number, email address) or that we gathered based on how you interact with our Platform. 
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Your preference on personalized recommendations will apply to any device you have signed in to your Booking.com account. If you’re not signed in to your account, your preference will not apply to other devices, and it’ll be saved as part of your “cookies.” When that cookie expires, so will your preference.
                </p>

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
                    In addition, guests can also give separate “subscores” for specific Travel Experience aspects such as: location, cleanliness, staff, comfort, facilities, value, and free Wifi. Guests submit their subscores and overall scores independently, so there’s no direct link between them.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    You can review an Accommodation that you booked through our Platform if you stayed there or arrived at the Accommodation but didn’t actually stay there. To edit a review you already submitted, contact our Customer Service team.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    We have people and automated systems that specialize in detecting fake reviews submitted to our Platform. If we find any, we delete them and, if necessary, take action against whoever’s responsible.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Anyone who spots something problematic can always report it to our Customer Service team, and our Fraud team will investigate.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Ideally, we would publish every consumer review we receive, whether positive or negative, unless it breaches our 
                    <span class="text-blue-600 underline">Content Standards and Guidelines</span>.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    To make sure reviews are relevant, we may only accept reviews that are submitted within three months of checking out, and we may stop showing reviews once they’re 36 months old or if the Accommodation has a change of ownership.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    An Accommodation may choose to reply to a review.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    When you find multiple reviews, the most recent ones will be at the top, subject to a few other factors such as what language a review is in, whether it’s just a score or contains comments as well, etc. To make sure the most helpful reviews appear first, each factor can become more (or less) important, depending on how our Platform changes over time, for example.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If you would prefer us not to order reviews in our default way, you can sort them based on other factors, such as:
                </p>

                <ul class="list-disc ml-6 space-y-1 text-gray-700 text-sm sm:text-base leading-5 sm:leading-6 mt-2">
                    <li>Newest first</li>
                    <li>Oldest first</li>
                    <li>Highest scores</li>
                    <li>Lowest scores</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    We sometimes show external review scores from other well-known travel websites, and we make it clear when we’ve done this.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Reviews may contain translations powered by Google, not Booking.com. Google disclaims all warranties related to the translations, express or implied, including any warranties of accuracy, reliability, and any implied warranties of merchantability, fitness for a particular purpose, and non-infringement.
                </p>
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
                    When you make a booking, you agree to pay the cost of the Travel Experience itself and any other taxes and fees that may apply (e.g. for any extras). Taxes and fees may vary for different reasons, such as the Service Provider’s location, the kind of room selected, and the number of guests. The price description indicates whether any taxes and fees are included or excluded.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    You’ll be able to find more information about the price while you’re booking.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Our Platform provides descriptions of any equipment and facilities that Service Providers offer based on what they tell us. It also tells you how much extra they’ll cost, if anything.
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
                    <li>The Service Provider charges you in advance. We (or our affiliate) will take your Payment Method details and forward them to the Service Provider.</li>
                    <li>We organize your payment to the Service Provider in advance. We (or our affiliate) will take your Payment Method details and make sure the Service Provider is paid.</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If you cancel a booking or don’t show up, any cancellation/no-show fee and any refund will depend on the Service Provider’s cancellation/no-show policy.
                </p>
            </div>


            <!-- ============================= -->
            <!--        1I SECTION             -->
            <!-- ============================= -->
            <div id="1I" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1I. Host type</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    We ask Service Providers, wherever they are in the world, to tell us if they’re acting as a “private host” or as a “professional host,” as defined by EU law.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    EU consumer law says we have to tell you this. So if you’re in the European Economic Area (EEA), Switzerland, or the United Kingdom, you might find that some Accommodations in our search results have a “managed by a private host” label and a description of what that means. All other Accommodations, to the best of our knowledge, are managed by “professional hosts.”
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    This label has no relevance in terms of tax, including VAT and other “indirect taxes” that relate to added value, sales, or consumption.
                </p>
            </div>


            <!-- ============================= -->
            <!--        1J SECTION             -->
            <!-- ============================= -->
            <div id="1J" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1J. Star ratings, review scores, and quality ratings</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Star ratings look like 1–5 yellow stars next to the property’s name.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    We don’t assign star ratings. Depending on local regulations, they’re assigned either by the Service Providers themselves or by independent third parties (e.g. organizations that rate hotels). Either way, star ratings show you how Accommodations measure up in terms of—among other things—value, facilities, and available services. We don’t impose our own standards for star ratings, and we don’t review these star ratings, but if we become aware that a star rating is inaccurate, we’ll ask the Service Provider to either prove they deserve it or adjust it.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Review scores look like a blue square with a white number from 1 to 10. We don’t assign review scores. Our customers do. Be sure to refer to “Reviews” (section 1F).
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Quality ratings look like 1–5 yellow squares next to the property’s name. We assign quality ratings to certain Accommodations on our Platform. Each rating is based on 400+ features falling into five major categories:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>Facilities / amenities / services</li>
                    <li>Property configuration (e.g. unit size, number of rooms, occupancy)</li>
                    <li>Number and quality of photos uploaded by the Service Provider</li>
                    <li>Average review score (and subscores that customers find particularly helpful, such as cleanliness)</li>
                    <li>Overall historical booking data (e.g. to assess the Accommodation’s star ratings)</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    We use these features to identify statistical patterns and carry out machine learning analyses. This automatically calculates a quality rating between 1 and 5.
                </p>
            </div>


            <!-- ============================= -->
            <!--        1K SECTION             -->
            <!-- ============================= -->
            <div id="1K" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1K. Help and advice – if the unexpected happens</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    If you have any questions or something doesn’t go according to plan, be sure to contact us. You can do this by accessing your booking, our app, or our 
                    <span class="text-blue-600 underline">Help Center</span>, where you’ll also find some useful FAQs. We handle complaints as soon as possible, treating the most urgent ones with the highest priority.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    You can help us help you as quickly as possible by providing, if available:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>Your booking confirmation number and PIN, your contact details, and the email address you used when you booked your stay</li>
                    <li>A summary of the situation you need assistance with, including how you’d like us to help you</li>
                    <li>Any supporting documents, such as bank statements, photos, receipts, etc.</li>
                </ul>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    Whatever the issue, we’ll do what we can to help you.
                </p>

                <!-- Mispriced bookings -->
                <h4 class="text-base sm:text-lg font-semibold mt-4 mb-1">What happens if a booking is mispriced?</h4>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Sometimes (very rarely), you might spot an obviously incorrect price on our Platform. If that happens, and if you make your booking before we correct the mistake, your booking may be canceled, and we’ll refund anything you’ve paid. We’ll remove any obvious pricing errors we find as soon as we become aware of them.
                </p>

                <!-- Removing service providers -->
                <h4 class="text-base sm:text-lg font-semibold mt-4 mb-1">Do we ever remove Service Providers from our Platform altogether?</h4>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Absolutely. We can do so if, for example, we find out they breached their contractual obligations or provided an inaccurate description of their Accommodation and failed to correct it when we asked them.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    For more information, check out “What if something goes wrong?” (A16) and “Applicable law and forum” (A20) in our 
                    <span class="text-blue-600 underline">Terms of Service</span>.
                </p>
            </div>


            <!-- ============================= -->
            <!--        1L SECTION             -->
            <!-- ============================= -->
            <div id="1L" class="mt-8">
                <h3 class="text-lg sm:text-xl font-semibold mb-2">1L. Overbooking</h3>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                    Once your booking is confirmed, your Service Provider is required to honor it.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If the Service Provider is “overbooked,” they’re responsible for finding a solution as soon as possible. We provide them with guidelines as well as practical support.
                </p>

                <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                    If they can’t give you the option you booked, and can’t offer you a suitable alternative:
                </p>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                    <li>You’ll be able to cancel your booking at no cost (with a full refund of anything you’ve paid)</li>
                    <li>We can help you find an alternative Accommodation in a similar category and price on our Platform. If the alternative is more expensive, we’ll refund you the difference after your stay, once you send us the invoice from the alternative Service Provider.</li>
                </ul>

                <!-- Refund section -->
                <h4 class="text-base sm:text-lg font-semibold mt-4 mb-1">When it comes to refunds:</h4>

                <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>If your Service Provider organized your payment, we’ll try to make sure they refund you as soon as possible.
                        <li>If we organized your payment, we’ll refund you ourselves. In 90% of cases, the money will be in your account within five business days, counting either from:    
                            <ul class="list-disc ml-6 mt-1 space-y-1">
                                <li>The cancellation of your original booking, or</li>
                                <li>The verification of the invoice you sent us to show that you stayed somewhere else.</li>  
                            </ul>
                        </li>    
                        </li>
                    
                </ul>
            </div>


            <!-- Back to top link -->
            <div class="mt-6 flex justify-end">
                <a href="#accommodations" class="text-blue-600 text-sm sm:text-base flex items-center space-x-1 hover:text-blue-800">
                    <span>Back to top</span>
                    <span>↑</span>
                </a>
            </div>


            <!-- 2. Attractions -->
            <div id="attractions" class="mt-8">
                <h2 class="text-2xl font-semibold mt-6 mb-4">2. Attractions</h2>

                <ul class="list-disc ml-6 space-y-1 text-blue-600">
                    <li><a href="#1A">2A. Definitions and who we are</a></li>
                    <li><a href="#1B">2B. How does our service work?</a></li>
                    <li><a href="#1C">2C. Who do we work with?</a></li>
                    <li><a href="#1D">2D. How do we make money?</a></li>
                    <li><a href="#1E">2E. Our recommendation systems</a></li>
                    <li><a href="#1F">2F. Reviews</a></li>
                    <li><a href="#1G">2G. Prices</a></li>
                    <li><a href="#1H">2H. Payments</a></li>
                    <li><a href="#1I">2I. Help and advice – if the unexpected happens</a></li>
                </ul>

                <!-- 2A. Definitions and who we are -->
                <div id="2A" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2A. Definitions and who we are</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        Some of the words here have specific meanings, so check out the “Booking.com dictionary” in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        When you book an Attraction, <strong>Booking.com B.V.</strong> provides and is responsible for the Platform but not the Travel Experience itself (section 2B). Booking.com B.V. is a company incorporated under the laws of the Netherlands (registered address: Oosterdokskade 163, 1011 DL, Amsterdam, The Netherlands; Chamber of Commerce number: 31047344; VAT number: NL805734958B01).
                    </p>
                </div>

                <!-- 2B. How does our service work? -->
                <div id="2B" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2B. How does our service work?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We provide a place for you to find and book Attraction services. When you make a booking on our Platform, you enter into a contract with the Service Provider or a Third-Party Aggregator.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        The information on our Platform is based on what Service Providers and/or Third-Party Aggregators tell us. We do our best to keep things up to date at all times.
                    </p>
                </div>

                <!-- 2C. Who do we work with? -->
                <div id="2C" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2C. Who do we work with?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We have contractual relationships with various Service Providers and Third-Party Aggregators. Only Service Providers with a direct relationship with us or Third-Party Aggregators will be displayed on our Platform.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        In some cases, Third-Party Aggregators act as intermediaries for Service Providers, and in some cases, they buy Attraction services and resell them. Service Providers and Third-Party Aggregators may also offer Travel Experiences outside our Platform, so what’s offered on our Platform may not be exhaustive.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        Our Platform shows you the Attractions you can book through us worldwide, and our search results page tells you how many of them might be right for you, based on what you’ve told us.
                    </p>
                </div>

                <!-- 2D. How do we make money? -->
                <div id="2D" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2D. How do we make money?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We don’t buy or (re)sell any products or services. When you make a booking, the Service Provider or Third-Party Aggregator just pays us a commission. We don’t charge any booking fees.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        If an Attraction in your search results has a badge that says “Ad,” it means that the Service Provider has paid for it to appear there.
                    </p>
                </div>

                <!-- 2E. Our recommendation systems -->
                <div id="2E" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2E. Our recommendation systems</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We use recommendation systems to select, display, and/or rank the information on our Platform to help you discover Travel Experiences we think you’ll like. This includes Nearby destinations, search results, and personalized recommendations.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        All recommendations are based on factors such as what you tell us in the search form, your previous interactions with our Platform, your current activity, and other relevant data.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        You can sort results by:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Most popular</li>
                        <li>Lowest price</li>
                        <li>Distance from stay</li>
                        <li>Best reviewed</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        You can also filter by category, price, city, features, and other options. Personalized recommendations may be adjusted or turned off in your account settings.
                    </p>
                </div>

                <!-- 2F. Reviews -->
                <div id="2F" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2F. Reviews</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        When you get multiple reviews, they’ll be ranked by “Most relevant” – ordered by date, with reviews that include comments prioritized, and taking the language of the review into account.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        You can also sort them by:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Newest first</li>
                        <li>Oldest first</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        All reviews must comply with our <span class="text-blue-600 underline">Content Standards and Guidelines</span>.
                    </p>
                </div>

                <!-- 2G. Prices -->
                <div id="2G" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2G. Prices</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        The rates displayed on our Platform are set by the Service Providers and/or Third-Party Aggregators. We may finance rewards or other benefits out of our own pocket.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        When you make a booking, you agree to pay the cost of the Travel Experience and any other charges that may apply (e.g. for extras, insurance, or taxes). The price description indicates whether any taxes and fees are included or excluded.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        Our Platform describes any equipment that Service Providers offer based on what they tell us, and how much it will cost. Any currency conversion is for information purposes only – actual rates may vary.
                    </p>
                </div>

                <!-- 2H. Payments -->
                <div id="2H" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2H. Payments</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        When you make a booking on our Platform, Booking.com will organize your payment. For details, check out “Payment” (A8) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- 2I. Help and advice – if the unexpected happens -->
                <div id="2I" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">2I. Help and advice – if the unexpected happens</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        If you have any questions or something doesn’t go according to plan, be sure to contact us. You can do this by accessing your booking, our app, or our <span class="text-blue-600">Help Center</span>, where you’ll also find some useful FAQs.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        You can help us help you as quickly as possible by providing, if available:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Your booking confirmation number and PIN, your contact details, and the email address you used when you made your booking.</li>
                        <li>A summary of the issue, including how you’d like us to help you.</li>
                        <li>Any supporting documents, such as bank statements, photos, receipts, etc.</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        Whatever the issue, we’ll do what we can to help you.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        For more information, check out “What if something goes wrong?” (A16) and “Applicable law and forum” (A20) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- Back to top button (right aligned with arrow) -->
                <div class="mt-6 flex justify-end">
                    <a href="#attractions" class="text-blue-600 text-sm sm:text-base flex items-center space-x-1 hover:text-blue-800">
                        <span>Back to top</span>
                        <span>↑</span>
                    </a>
                </div>
            </div>


            <!-- 3. Car Rentals -->
            <div id="car-rentals" class="mt-8">
                    <h2 class="text-2xl font-semibold mt-6 mb-4">3. Car Rentals</h2>
                    <ul class="list-disc ml-6 space-y-1 text-blue-600">
                    <li><a href="#1A">3A. Definitions and who we are</a></li>
                    <li><a href="#1B">3B. How does our service work?</a></li>
                    <li><a href="#1C">3C. Who do we work with?</a></li>
                    <li><a href="#1D">3D. How do we make money?</a></li>
                    <li><a href="#1E">3E. Our recommendation systems</a></li>
                    <li><a href="#1F">3F. Reviews</a></li>
                    <li><a href="#1G">3G. Prices</a></li>
                    <li><a href="#1H">3H. Payments</a></li>
                    <li><a href="#1I">3I. Help and advice – if the unexpected happens</a></li>
                </ul>

                    <!-- 3A. Definitions and who we are -->
                    <div id="3A" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3A. Definitions and who we are</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            Some of the words here have specific meanings, so check out the “Booking.com dictionary” in our <span class="text-blue-600 underline">Terms of Service</span>.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                            When you book a Rental on Booking.com or Rentalcars.com, <strong>Booking.com Transport Limited</strong> provides and is responsible for the Platform – but not the Travel Experience itself (section 3B). Booking.com Transport Limited is a company registered in England and Wales (company number: 05179829; registered office: 6 Goods Yard Street, Manchester, M3 3BG, United Kingdom).
                        </p>
                    </div>

                    <!-- 3B. How does our service work? -->
                    <div id="3B" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3B. How does our service work?</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            We make it easy for you to compare bookings from many different car rental companies. The information on our Platform is based on what Service Providers tell us, and we do our best to keep things up to date at all times.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                            Our Platform shows you the Rentals you can book through us worldwide, and our search results page tells you how many of them might be right for you, based on what you’ve told us.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                            When you book your car, you enter into a contract with us, and we agree to arrange and manage* your Booking.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                            When you sign your Rental Agreement at the counter, you enter into a contract with the rental company, and they agree to provide the car. You’ll already have reviewed and accepted all the key terms while booking the car.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 italic mt-2">
                            *We’re here to try to help you if you need to change or cancel your booking or if you have any questions before, during, or after your Rental.
                        </p>
                    </div>

                    <!-- 3C. Who do we work with? -->
                    <div id="3C" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3C. Who do we work with?</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            Every rental company on our Platform is a trusted partner who passed all our tests before we started working with them. Only Service Providers with a contractual relationship with us will be displayed on our Platform. They may also offer Travel Experiences outside our Platform, so what they offer on our Platform may not be exhaustive.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                            Our specialist team visits rental companies before they appear on our Platform, and all Service Providers on our Platform are professional traders.
                        </p>
                    </div>

                    <!-- 3D. How do we make money? -->
                    <div id="3D" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3D. How do we make money?</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            We make money when we find you a Rental. There are two ways we do this:
                        </p>
                        <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                            <li>We agree on a commission with the rental company for our services</li>
                            <li>The rental company provides us with a net rate, and we apply our own markup</li>
                        </ul>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            Either way, we aim to offer our customers multiple choices at competitive prices, all on a Platform that is free for you to use.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            If a car in your search results has a badge that says “Ad,” it means that the Service Provider has paid for it to appear there.
                        </p>
                    </div>

                    <!-- 3E. Our recommendation systems -->
                    <div id="3E" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3E. Our recommendation systems</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            We use recommendation systems to select, display, and/or rank the information on our Platform to help you discover Travel Experiences we think you’ll like. This includes popular car rental brands and search results.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            Recommendations are based on factors such as your search details, previous interactions with our Platform, your current browsing activity, and the performance of Service Providers.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            You can sort results by:
                        </p>
                        <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                            <li>Recommended (default)</li>
                            <li>Price</li>
                            <li>Top Reviewed</li>
                            <li>Genius</li>
                            <li>Distance</li>
                        </ul>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            Listings may also include labels like “Ad,” “Featured,” “Top pick,” “Ideal for families,” “Genius,” percentage tags, Hybrid/Electric labels, or Previously viewed.
                        </p>
                    </div>

                    <!-- 3F. Reviews -->
                    <div id="3F" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3F. Reviews</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            After your Rental, you’ll be invited to leave a review, which may be:
                        </p>
                        <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                            <li>Uploaded to our Platform to help other customers make an informed decision*</li>
                            <li>Used for marketing purposes on our Platform, on social media, in newsletters, etc.*</li>
                            <li>Shared with your rental company to help them (and us) provide an even better service**</li>
                        </ul>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 italic mt-2">
                            *We would not use your full name or address.  
                            **We may tell the rental company which Rental the review is about.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            We publish every consumer review we receive, unless it breaches our <span class="text-blue-600 underline">Content Standards and Guidelines</span>.
                        </p>
                    </div>

                    <!-- 3G. Prices -->
                    <div id="3G" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3G. Prices</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            The rates displayed on our Platform are set by the Service Providers or by us. We may finance rewards or other benefits out of our own pocket.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            When you make a booking, you agree to pay the cost of the Travel Experience itself and any applicable extras, insurance, or taxes. The price description tells you what taxes (if any) are included.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            Any equipment offered by Service Providers will be described on our Platform with pricing information. Currency conversions are for information only; actual rates may vary.
                        </p>
                    </div>

                    <!-- 3H. Payments -->
                    <div id="3H" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3H. Payments</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            When you book a Rental on our Platform, Booking.com will organize your payment. For details, check out “Payment” (A8) in our <span class="text-blue-600 underline">Terms of Service</span>.
                        </p>
                    </div>

                    <!-- 3I. Help and advice – if the unexpected happens -->
                    <div id="3I" class="mt-8">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2">3I. Help and advice – if the unexpected happens</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                            If you have any questions or something doesn’t go according to plan, be sure to <span class="text-blue-600 underline">contact us</span>. To help us assist you quickly, provide:
                        </p>
                        <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                            <li>Your booking reference number and the email address you used when you booked your car</li>
                            <li>A summary of the issue, including how you’d like us to help</li>
                            <li>Details of any charges incurred</li>
                            <li>Supporting documents such as rental agreements, invoices, photos, receipts, etc.</li>
                        </ul>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            One of our agents will be in touch as soon as possible. They might ask for more details. Whatever the issue is, we will do what we can to help you.
                        </p>
                        <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                            For more information, check out “What if something goes wrong?” (A16) and “Applicable law and forum” (A20) in our <span class="text-blue-600 underline">Terms of Service</span>.
                        </p>
                    </div>

                    <!-- Back to top button -->
                    <div class="mt-6 flex justify-end">
                        <a href="#car-rentals" class="text-blue-600 text-sm sm:text-base flex items-center space-x-1 hover:text-blue-800">
                            <span>Back to top</span>
                            <span>↑</span>
                        </a>
                    </div>
            </div>


            <!-- 4. Flights -->
            <div id="flights" class="mt-8">
                <h2 class="text-2xl font-semibold mt-6 mb-4">4. Flights</h2>
                <ul class="list-disc ml-6 space-y-1 text-blue-600">
                    <li><a href="#1A">4A. Definitions and who we are</a></li>
                    <li><a href="#1B">4B. How does our service work?</a></li>
                    <li><a href="#1C">4C. Who do we work with?</a></li>
                    <li><a href="#1D">4D. How do we make money?</a></li>
                    <li><a href="#1E">4E. Our recommendation systems</a></li>
                    <li><a href="#1F">4F. Prices</a></li>
                    <li><a href="#1G">4G. Payments</a></li>
                    <li><a href="#1H">4H. Help and advice – if the unexpected happens</a></li>
                </ul>

                <!-- 4A. Definitions and who we are -->
                <div id="4A" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4A. Definitions and who we are</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        Some of the words here have specific meanings, so check out the “Booking.com dictionary” in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        When you book a Flight, <strong>Booking.com B.V.</strong> provides and is responsible for the Platform but not the Travel Experience itself (section 4B). Booking.com B.V. is a company incorporated under the laws of the Netherlands (registered address: Oosterdokskade 163, 1011 DL, Amsterdam, The Netherlands; Chamber of Commerce number: 31047344; VAT number: NL805734958B01).
                    </p>
                </div>

                <!-- 4B. How does our service work? -->
                <div id="4B" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4B. How does our service work?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We provide a place for you to find and book Flights. When you make a booking on our Platform, you enter into a contract with the Service Provider and the Third-Party Aggregator.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        The information on our Platform is based on what Service Providers and/or Third-Party Aggregators tell us. We do our best to keep things up to date at all times.
                    </p>
                </div>

                <!-- 4C. Who do we work with? -->
                <div id="4C" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4C. Who do we work with?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We have contractual relationships with various Third-Party Aggregators, who act as intermediaries for Service Providers. Only Service Providers with a direct relationship with them will be displayed on our Platform.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Service Providers and Third-Party Aggregators may also offer Travel Experiences outside our Platform, so what they offer on our Platform may not be exhaustive.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Our Platform shows you the Flights you can book through us worldwide, and our search results page tells you how many of them might be right for you, based on what you’ve told us.
                    </p>
                </div>

                <!-- 4D. How do we make money? -->
                <div id="4D" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4D. How do we make money?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We don’t buy or (re)sell any products or services. When people book Flights and extras on our Platform (e.g., baggage and seat selection), the Third-Party Aggregator pays us a commission.
                    </p>
                </div>

                <!-- 4E. Our recommendation systems -->
                <div id="4E" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4E. Our recommendation systems</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We use recommendation systems to select, display, and/or rank the information available on our Platform to help you discover destinations we think you’ll like. For example, trending cities may be suggested based on your location while browsing.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Factors for recommendations include:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Your search form inputs (destination, dates, etc.)</li>
                        <li>Previous interactions with our Platform (past searches, existing reservations), unless you opted out</li>
                        <li>Your current interaction with our Platform, including your country while browsing</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Our search results themselves are also a recommendation system. Services and products often used for similar trips may be labeled “Popular for trips like yours.”
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Default ranking and sorting options:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Best (default): Factors include price, travel time, number of stops, baggage allowance, and Genius exclusives.</li>
                        <li>Cheapest: Lower prices appear higher.</li>
                        <li>Fastest: Shorter travel times appear higher.</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Filters can narrow results by stops, duration, and preferred airlines.
                    </p>
                </div>

                <!-- 4F. Prices -->
                <div id="4F" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4F. Prices</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        The rates displayed are set by the Service Providers and/or Third-Party Aggregators. We may finance rewards or other benefits out of our own pocket.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        When you make a booking, you agree to pay the cost of the Travel Experience and any applicable extras, insurance, or taxes. The price description indicates whether fees are included or excluded.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Equipment descriptions and costs are provided by the Service Providers. Currency conversion is for information only; actual rates may vary.
                    </p>
                </div>

                <!-- 4G. Payments -->
                <div id="4G" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4G. Payments</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        When you make a booking on our Platform, your payment could be organized by us, or by a Third-Party Aggregator. For details, check out “Payment” (A8) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- 4H. Help and advice – if the unexpected happens -->
                <div id="4H" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">4H. Help and advice – if the unexpected happens</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        Once you’ve made a booking, contact us if you have any questions or something doesn’t go according to plan. You can do this by accessing your booking, our app, or our <span class="text-blue-600 underline">Help Center</span>, where you’ll find FAQs.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        To help us assist you quickly, provide (if available):
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Your Customer Reference number and PIN, contact details, and the email you used when booking</li>
                        <li>A summary of the issue, including how you’d like us to help</li>
                        <li>Supporting documents such as bank statements, photos, receipts, etc.</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Whatever the issue, we’ll do what we can to help you. For more information, check out “What if something goes wrong?” (A16) and “Applicable law and forum” (A20) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- Back to top button -->
                <div class="mt-6 flex justify-end">
                    <a href="#flights" class="text-blue-600 text-sm sm:text-base flex items-center space-x-1 hover:text-blue-800">
                        <span>Back to top</span>
                        <span>↑</span>
                    </a>
                </div>
            </div>

            <!-- 5. Private and public transportation -->
            <div id="transportation" class="mt-8">
                <h2 class="text-2xl font-semibold mt-6 mb-4">5. Private and public transportation</h2>
                <ul class="list-disc ml-6 space-y-1 text-blue-600">
                    <li><a href="#1A">5A. Definitions and who we are</a></li>
                    <li><a href="#1B">5B. How does our service work?</a></li>
                    <li><a href="#1C">5C. Who do we work with?</a></li>
                    <li><a href="#1D">5D. How do we make money?</a></li>
                    <li><a href="#1E">5E. Our recommendation systems</a></li>
                    <li><a href="#1F">5F. Reviews</a></li>
                    <li><a href="#1G">5G. Prices</a></li>
                    <li><a href="#1H">5H. Payments</a></li>
                    <li><a href="#1I">5I. Help and advice – if the unexpected happens</a></li>
                </ul>

                <!-- 5A. Definitions and who we are -->
                <div id="5A" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5A. Definitions and who we are</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        Some of the words here have specific meanings, so check out the “Booking.com dictionary” in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-3">
                        When you book a transportation service, <strong>Booking.com Transport Limited</strong> provides and is responsible for the Platform but not the Travel Experience itself (section 5B). Booking.com Transport Limited is a company registered in England and Wales (company number: 05179829; registered office: 6 Goods Yard Street, Manchester, M3 3BG, United Kingdom).
                    </p>
                </div>

                <!-- 5B. How does our service work? -->
                <div id="5B" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5B. How does our service work?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We make it easy for you to compare bookings from public and private ground transportation providers. When you do a search, we filter results to show the most suitable vehicle in each category based on what you’ve told us.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Service Providers are independent companies. We don’t own or control the services you book. Information on our Platform is based on what Service Providers tell us, and we do our best to keep things up to date.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        We provide help and support before, during, or after your trip. See “Help and advice – if the unexpected happens” (section 5I) for details.
                    </p>
                </div>

                <!-- 5C. Who do we work with? -->
                <div id="5C" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5C. Who do we work with?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        Only Service Providers with a contractual relationship with us will be displayed on our Platform. They may also offer Travel Experiences outside our Platform, so what they offer may not be exhaustive.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        All Service Providers on our Platform are professional traders. We regularly check them to ensure they continue to meet necessary standards.
                    </p>
                </div>

                <!-- 5D. How do we make money? -->
                <div id="5D" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5D. How do we make money?</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We don’t buy or (re)sell any products or services. When you make a booking, we agree on a commission with the transportation providers for our services. We don’t charge any booking fees.
                    </p>
                </div>

                <!-- 5E. Our recommendation systems -->
                <div id="5E" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5E. Our recommendation systems</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        We use recommendation systems to select, display, and/or rank the information on our Platform to help you discover transportation services we think you’ll like.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Recommendation factors include:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Search form inputs (destination, dates, number of passengers, etc.)</li>
                        <li>Performance of different transportation providers</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        For searches:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li><strong>Private Transportation:</strong> Vehicles are selected based on price, provider performance, and party size. Larger vehicles appear higher for bigger parties.</li>
                        <li><strong>Trains and Buses:</strong> We show the best result for the journey you want, ranked by price and convenience.</li>
                    </ul>
                </div>

                <!-- 5F. Reviews -->
                <div id="5F" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5F. Reviews</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        After your Journey, you’ll be invited to leave a review, which may be:
                    </p>
                    <ul class="list-disc ml-6 text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2 space-y-1">
                        <li>Uploaded to our Platform to help other customers make informed decisions*</li>
                        <li>Used for marketing purposes on our Platform, social media, newsletters, etc.*</li>
                        <li>Shared with your Service Provider to help them improve service**</li>
                    </ul>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        *We do not use your full name or address.<br>
                        **We may indicate which Journey the review is about.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Reviews that breach our <span class="text-blue-600 underline">Content Standards and Guidelines</span> are not published.
                    </p>
                </div>

                <!-- 5G. Prices -->
                <div id="5G" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5G. Prices</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        The price of each booking comprises the base rate set by the Service Provider and our commission. We may also finance rewards or other benefits out of our own pocket.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        When you book, you agree to pay the cost of the Travel Experience and any applicable extras (e.g., tolls, waiting fees). Taxes and fees may vary. Prices include any applicable taxes.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Currency conversion is for information only; actual rates may vary.
                    </p>
                </div>

                <!-- 5H. Payments -->
                <div id="5H" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5H. Payments</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        When you book a bus, train, or private transportation on our Platform, Booking.com organizes your payment. For details, see “Payment” (A8) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- 5I. Help and advice – if the unexpected happens -->
                <div id="5I" class="mt-8">
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">5I. Help and advice – if the unexpected happens</h3>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6">
                        If you have questions or something doesn’t go according to plan, contact us. If it’s about something during your Journey, provide your booking reference (if available) and contact details.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        You can help us resolve issues quickly by providing any relevant documents or information when you first contact us. We resolve the vast majority of issues within 14 days.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-5 sm:leading-6 mt-2">
                        Whatever the issue, we’ll do what we can to help you. For more information, see “What if something goes wrong?” (A16) and “Applicable law and forum” (A20) in our <span class="text-blue-600 underline">Terms of Service</span>.
                    </p>
                </div>

                <!-- Back to top button -->
                <div class="mt-6 flex justify-end">
                    <a href="#transportation" class="text-blue-600 text-sm sm:text-base flex items-center space-x-1 hover:text-blue-800">
                        <span>Back to top</span>
                        <span>↑</span>
                    </a>
                </div>
            </div>

                            

        </main>
    </div>

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
