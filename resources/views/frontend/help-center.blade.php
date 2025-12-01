<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - Booking UI Replica</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Top Blue Bar -->
    <header class="bg-[#003580] text-white py-4 shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">

            <div class="text-2xl font-bold tracking-wide">
                Booking.com
            </div>

            <div class="flex items-center gap-4 text-sm">
                <span>LKR</span>
                <img src="https://flagcdn.com/us.svg" class="w-5 h-5 rounded-sm">

                <a href="#" class="px-3 py-1 bg-[#0071c2] rounded text-white">List your property</a>
                <a href="#" class="px-3 py-1 bg-white text-[#003580] border rounded">Register</a>
                <a href="#" class="px-3 py-1 bg-[#0071c2] rounded text-white">Sign in</a>
            </div>
        </div>
    </header>

    <!-- Blue Section -->
    <section class="bg-[#b8d4f5] py-16 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold text-white drop-shadow">
            How can we help?
        </h1>
    </section>

    <!-- COVID notice -->
    <div class="max-w-5xl mx-auto px-4 mt-6">
        <div class="bg-orange-100 border border-orange-300 text-orange-700 px-6 py-4 rounded">
            <strong class="font-semibold">Coronavirus (COVID-19) update</strong>
            <p class="text-sm mt-1">
                We understand your travel plans may be affected. Sign in for support for changing your reservation.
            </p>
        </div>
    </div>

    <!-- Help Center -->
    <div class="max-w-5xl mx-auto mt-10 px-4">
        <div class="bg-white shadow-md border rounded-lg p-8">

            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-user-group text-gray-700"></i>
                Customer Service Help Center
            </h2>

            <p class="text-gray-600 text-sm mb-6">
                Sign in to access the Help Center, contact Customer Service, or get in touch with your accommodation provider.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


                <!-- Left Section -->

               

                <!-- Left Section -->
                <div class="border p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold mb-4">Sign in to get help with your bookings</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        View all of your bookings, make changes, and get assistance.
                    </p>

                    <!-- Sign in button -->
                    <button class="w-full bg-[#0071c2] hover:bg-[#005c9f] text-white py-2 rounded mb-4">
                        Sign in
                    </button>

                    <!-- Divider -->
                    <div class="flex items-center my-4">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <span class="px-2 text-gray-500 text-sm">or</span>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <!-- Booking number form -->
                    <input type="text" placeholder="Confirmation number"
                        class="w-full border rounded px-3 py-2 text-sm mb-3">

                    <input type="text" placeholder="PIN Code"
                        class="w-full border rounded px-3 py-2 text-sm mb-4">

                    <!-- Check booking button -->
                    <button class="w-full bg-[#0071c2] hover:bg-[#005c9f] text-white py-2 rounded">
                        Check my booking
                    </button>
                </div>




                <!-- Right Section -->
                <div class="border p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold mb-4">Lost your confirmation email?</h3>

                    <p class="text-sm text-gray-600 mb-4">
                        It happens — just enter your email below and we'll resend it.
                    </p>

                    <input type="email" placeholder="Your email address"
                           class="w-full border rounded px-3 py-2 text-sm mb-4">

                    <button class="w-full bg-[#0071c2] hover:bg-[#005c9f] text-white py-2 rounded">
                        Resend confirmation email
                    </button>
                </div>

            </div>

        </div>
    </div>

     
    <!-- FAQ SECTION -->
        <section class="max-w-5xl mx-auto mt-14 mb-20">

            <h2 class="text-xl font-bold mb-6">Frequently Asked Questions</h2>

            <div x-data="{ activeTab: 'Cancellations' }" class="bg-white shadow rounded-lg overflow-hidden grid md:grid-cols-3">

                <!-- LEFT TABS -->
                <div class="border-r">
                    @php
                    $tabs = [
                        'Cancellations',
                        'Payment',
                        'Booking Details',
                        'Communications',
                        'Room Types',
                        'Pricing',
                        'Credit cards',
                        'Property Policies',
                        'Extra Facilities',
                        'Security and awareness'
                    ];
                    @endphp

                    @foreach($tabs as $tab)
                        <button 
                            @click="activeTab = '{{ $tab }}'"
                            class="w-full text-left px-5 py-3 border-b hover:bg-gray-100 text-sm"
                            :class="activeTab === '{{ $tab }}' ? 'font-semibold text-[#0071c2] border-l-4 border-[#0071c2] bg-gray-50' : ''">
                            {{ $tab }}
                        </button>
                    @endforeach
                </div>

                <!-- RIGHT CONTENT -->
                <div class="md:col-span-2">

                    <!-- CANCELLATIONS -->
                    <div x-show="activeTab === 'Cancellations'">
                        @php
                            $cancellations = [
                                ["q" => "Can I cancel my booking?", "a" => "yes you can"],
                                ["q" => "If I need to cancel my booking, will I pay a fee?", "a" => "card payment can you"],
                                ["q" => "Can I cancel or change my dates for a non-refundable booking?", "a" => "hello booking"],
                                ["q" => "How do I know if my booking was cancelled?", "a" => "Your booking status will update automatically."],
                                ["q" => "Where can I find my cancellation policy?", "a" => "You can find it inside your confirmation email."]
                            ];
                        @endphp

                        @foreach($cancellations as $item)
                            <details class="border-b px-5 py-4">
                                <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                                    <span>{{ $item['q'] }}</span>
                                    <span>⌄</span>
                                </summary>

                                <p class="mt-3 text-gray-600 text-sm">
                                    {{ $item['a'] }}
                                </p>
                            </details>
                        @endforeach
                    </div>


                    <!-- PAYMENT -->
                    <div x-show="activeTab === 'Payment'">
                        @php
                        $payments = [
                            "Can I pay with a deposit, or prepayment?",
                            "I was charged. Do I need to do anything?",
                            "Where can I see the payment policy for my booking?",
                            "Why do I need to provide my card details?",
                            "Can I pay for my stay with a different credit card than the one used to book?",
                            "How can I get an invoice?",
                            "Why do I need to provide my credit card details?",
                            "Who's going to charge my credit card and when?"
                        ];
                        @endphp

                        @foreach($payments as $q)
                            <details class="border-b px-5 py-4">
                                <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                                    {{ $q }} <span>⌄</span>
                                </summary>
                            </details>
                        @endforeach
                    </div>

                    <!-- BOOKING DETAILS -->
                    <div x-show="activeTab === 'Booking Details'">
                        @php
                        $bookingDetails = [
                            "How do I get more info about the room or property's facilities?",
                            "Is it possible to get an extra bed or crib for a child?",
                            "I can't find my confirmation email. What should I do?",
                            "Will I pay the full price for my children?",
                            "What's the difference between a double room and a twin room?",
                            "I'll be arriving outside check-in hours. Can I still check in?",
                            "Can I make changes to my booking (i.e. change dates)?"
                        ];
                        @endphp

                        @foreach($bookingDetails as $q)
                            <details class="border-b px-5 py-4">
                                <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                                    {{ $q }} <span>⌄</span>
                                </summary>
                            </details>
                        @endforeach
                    </div>

                    <!-- OTHER TABS PLACEHOLDER -->
                    <div x-show="!['Cancellations','Payment','Booking Details'].includes(activeTab)" class="p-6 text-gray-500">
                        Content for <span class="font-semibold" x-text="activeTab"></span> will be added soon.
                    </div>

                </div>

            </div>
        </section>

        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

 




    <!-- FOOTER -->
    <footer class="bg-[#003580] text-white py-10 mt-10">

        <div class="text-center mb-6">
            <button class="px-5 py-2 border border-white rounded">List your property</button>
        </div>

        <div class="max-w-6xl mx-auto grid md:grid-cols-5 gap-6 text-sm">

            <div>
                <a class="font-semibold block mb-2" href="#">Mobile version</a>
                <a href="#" class="block">Countries</a>
                <a href="#" class="block">Regions</a>
                <a href="#" class="block">Cities</a>
                <a href="#" class="block">Districts</a>
                <a href="#" class="block">Airports</a>
                <a href="#" class="block">Hotels</a>
                <a href="#" class="block">Places of interest</a>
            </div>

            <div>
                <a class="font-semibold block mb-2" href="#">Your account</a>
                <a href="#" class="block">Homes</a>
                <a href="#" class="block">Apartments</a>
                <a href="#" class="block">Resorts</a>
                <a href="#" class="block">Villas</a>
                <a href="#" class="block">Hostels</a>
                <a href="#" class="block">B&Bs</a>
                <a href="#" class="block">Guest Houses</a>
            </div>

            <div>
                <a class="font-semibold block mb-2" href="#">Make changes online to your booking</a>
                <a href="#" class="block">Unique places to stay</a>
                <a href="#" class="block">Reviews</a>
                <a href="#" class="block">Discover stays</a>
                <a href="#" class="block">Holiday deals</a>
                <a href="#" class="block">Traveller Awards</a>
            </div>

            <div>
                <a class="font-semibold block mb-2" href="#">Become an affiliate</a>
                <a href="#" class="block">Travel Agents</a>
                <a href="#" class="block">Business</a>
            </div>

            <div>
                <a class="font-semibold block mb-2" href="#">About Booking.com</a>
                <a href="#" class="block">Customer Service Help</a>
                <a href="#" class="block">Partner help</a>
                <a href="#" class="block">Careers</a>
                <a href="#" class="block">Press Center</a>
                <a href="#" class="block">Safety Resource Center</a>
            </div>

        </div>

    </footer>




    <!-- Icons (FontAwesome) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

</body>
</html>
