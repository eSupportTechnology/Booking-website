<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center</title>

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

   
    <header class="text-white px-2 sm:px-4 py-2 sm:py-4" style="background-color:#1F8FB2;">
        <section class="py-0">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                
                <!-- Header Container -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center flex-wrap space-y-4 md:space-y-0">

                    <!-- Left Section -->
                    <div class="w-full md:w-auto">
                        <div class="flex flex-col items-start">

                            @php
                                $host = config('domains.app_name');
                            @endphp

                            <!-- Logo -->
                            <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                                @if ($host == 'BookinTour')
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
                    <div class="flex items-center flex-wrap justify-end gap-2 sm:gap-3 md:gap-5 w-full md:w-auto order-2 px-2 sm:px-0 md:px-0">

                        <!-- Currency + Help + List Property Row -->
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
                                    class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 
                                            md:px-4 md:py-2 rounded hover:bg-blue-100 
                                            text-xs sm:text-sm md:text-base"
                                    style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                                        Register
                                    </a>

                                    <a href="/choose-option"
                                    class="bg-white font-base px-2 py-1 sm:px-3 sm:py-1 
                                            md:px-4 md:py-2 rounded hover:bg-blue-100 
                                            text-xs sm:text-sm md:text-base"
                                    style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">
                                        Sign in
                                    </a>

                                </div>

                            @else
                                <!-- Placeholder to keep layout stable -->
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


    <br>

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
                        ["q" => "Can I cancel my booking?", "a" => "Yes – any cancellation fees are determined by the property and listed in your cancellation policy. You'll pay any additional costs to the property."],
                        ["q" => "If I need to cancel my booking, will I pay a fee?", "a" => "If you have a free cancellation booking, you won't pay a cancellation fee. If your booking isn't free to cancel anymore or is non-refundable, you may incur a cancellation fee. Any cancellation fees are determined by the property, and you'll pay any additional costs to the property."],
                        ["q" => "Can I cancel or change my dates for a non-refundable booking?", "a" => "Canceling a Non-Refundable booking usually incurs a charge. However, you might have the option to request free cancellation when managing your booking. This sends a request to the property, who may decide to waive your cancellation fee. It's not possible to change dates for a Non-Refundable booking, though it's possible to re-book for your desired dates if your waive fees request is successful."],
                        ["q" => "How do I know if my booking was cancelled?", "a" => "After you cancel a booking with us, you should get an email confirming the cancellation. Make sure to check your inbox and spam/junk mail folders. If you don’t receive an email within 24 hours, contact the property to confirm they got your cancellation."],
                        ["q" => "Where can I find my cancellation policy?", "a" => "You can find this in your booking confirmation."]
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
                        [
                            "q" => "Can I pay with a deposit, or prepayment?",
                            "a" => "Some of our properties require a prepayment (i.e. a deposit) before you stay. This prepayment consist of the total cost of the booking or just part of it. The rest is paid when you stay at the property.
                                    However, for some properties, there is no deposit required. You pay the amount in full when you stay at the property. Be sure to check the payment policies in your confirmation for more details."
                        ],
                        [
                            "q" => "I was charged. Do I need to do anything?",
                            "a" => "In most cases, no action is required from you. As outlined in the payment policy for your booking, this is likely just a prepayment for all or part of the total cost.
                                    If there is no prepayment policy, then the property may have taken a test payment from your card. This is a temporary hold used to guarantee your booking and will be returned to you.
                                    If you still believe the charge is unexpected, you can contact us for assistance. We can only contact the property on your behalf after you submit proof of charge."
                        ],
                        [
                            "q" => "Where can I see the payment policy for my booking?",
                            "a" => "You'll find the payment policy in your booking confirmation, in the pricing section. This section also includes a price breakdown and the accepted payment methods."
                        ],
                        [
                            "q" => "Why do I need to provide my card details?",
                            "a" => "Properties normally request this to guarantee your booking, and the card is often used to pay when you book. If you don’t need to make a prepayment, then they may hold an amount on your card to make sure it has sufficient funds. This test payment will be returned to you."
                        ],
                        [
                            "q" => "Can I pay for my stay with a different credit card than the one used to book?",
                            "a" => "It's very likely, yes. Properties usually accept payment for a stay with a different card or cash. To confirm that paying with a different credit card is okay, contact the property."
                        ],
                        [
                            "q" => "How can I get an invoice?",
                            "a" => "Only the property can provide an invoice for your completed stay. To receive it quickly, make your request at the property before check-out, or contact them directly."
                        ],
                        [
                            "q" => "Why do I need to provide my credit card details?",
                            "a" => "Properties request this to confirm your reservation. You may be pre-authorized* to ensure that your credit card is valid and has sufficient funds. In some cases, your details are used to pay for your stay when you book.
                                    *A pre-authorization is a temporary hold on an amount to ensure your card is valid and has sufficient funds. The amount held will be returned to your account after a certain period of time, depending on the property and your card provider."
                        ],
                        [
                            "q" => "Who's going to charge my credit card and when?",
                            "a" => "Generally, the property is responsible for charging your card. If payment is instead handled by Booking.com, this will be stated clearly in your booking confirmation.
                                    You usually can expect to pay during check-in or check-out at the property. However, there are some exceptions, like properties that require a prepayment for all or some of the total amount. Again, this will be stated clearly in your confirmation and payment policies.
                                    If there's no prepayment policy, it’s also possible that the property might take a test payment from your card before you stay. This is a temporary hold, that’s used to validate your card and guarantee your booking. Unlike a real charge, this test payment will be returned to your card."
                        ],
                    ];
                @endphp

                @foreach($payments as $item)
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


            
            <!-- BOOKING DETAILS -->
            <div x-show="activeTab === 'Booking Details'">
                @php
                    $bookingDetails = [
                        [
                            "q" => "How do I get more info about the room or property's facilities?",
                            "a" => "You can find the room and property facilities in your booking confirmation."
                        ],
                        [
                            "q" => "Is it possible to get an extra bed or crib for a child?",
                            "a" => "It depends on the property's policy. Additional costs for children, including extra beds/cribs, aren't included in the reservation price. Contact the property directly for this info."
                        ],
                        [
                            "q" => "I can't find my confirmation email. What should I do?",
                            "a" => "Be sure to check your email inbox, spam, and junk folders. If you still can't find your confirmation, go to booking.com/help and we'll resend it to you."
                        ],
                        [
                            "q" => "Will I pay the full price for my children?",
                            "a" => "Additional costs for children, if any, aren't included in the reservation price. Check with the property directly to see if and when you'll pay for your child(ren)."
                        ],
                        [
                            "q" => "What's the difference between a double room and a twin room?",
                            "a" => "A double room has 1 double bed and a twin room has 2 single beds. If a room is called a double/twin, it can be set up for either type. The property will do its best to accommodate your needs."
                        ],
                        [
                            "q" => "I'll be arriving outside check-in hours. Can I still check in?",
                            "a" => "This depends on the property who will do their best to meet your needs but can't guarantee your request. You can do either of the following:
                                    Request an early or late check-in/check-out
                                    Contact the property"
                        ],
                        [
                            "q" => "Can I make changes to my booking (i.e. change dates)?",
                            "a" => "Yes! You can make changes to your booking from your confirmation email or at Booking.com. Depending on the property's policy, you can do the following:
                                    Change check-in/out times
                                    Change dates
                                    Cancel booking
                                    Edit credit card details
                                    Change guest details
                                    Select bed type
                                    Change room type
                                    Add a room
                                    Add a meal
                                    Make a request
                                    Contact the property"
                        ],
                    ];
                @endphp

                @foreach($bookingDetails as $item)
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


            <div x-show="activeTab === 'Communications'">
                @php
                    $communications = [
                        [
                            "q" => "Why does the property's email address end with @property.booking.com?",
                            "a" => "For each reservation, Booking.com provides a unique and anonymous alias email address for both you and the property. All messages sent to this alias email will be forwarded to the property, including links, images, and attachments (up to 15 MB).
                            For security purposes, Booking.com has an automated system that monitors communication for malicious content. This includes spam and the limitation of certain file types, such as .zip, .rar and .exe.
                            Please be aware that email communication generated by the property will be sent on their behalf by Booking.com. Booking.com cannot be held accountable for the content of the communication. If you suspect that the content of the communication is inappropriate, suspicious or contains spam, we ask that you report this information by clicking on the link at the bottom right corner of the email.
                            These communications will be stored by Booking.com. Booking.com can access direct communications upon request from either you or the property, and if strictly necessary, for security or law enforcement purposes, such as fraud detection and prevention.
                            Booking.com may analyze communications to improve its services. If you don't want Booking.com to monitor or store your direct communications made through Booking.com, please do not use the direct communication feature offered by Booking.com, including communication through alias email addresses."
                                                    ]
                       
                    ];
                @endphp

                @foreach($communications as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Room Types'">
                @php
                    $roomTypes = [
                        [
                            "q" => "What's the difference between a double room and a twin room?",
                            "a" => "A double room has one large double bed, while a twin room has two separate single beds. Photos in the room description usually show the exact layout."
                        ],
                        [
                            "q" => 'What do "non-refundable" and "free cancellation" mean?',
                            "a" => "Every room or property has an individual policy determined by the property.
                                    A “non-refundable” policy means a fee will apply if you decide to change or cancel your booking. This fee is mentioned during the booking process in the conditions and in the booking confirmation.
                                    A “free cancellation” policy means you can change or cancel a booking for free, as long as you do it within the time frame specified by the property (e.g. “Cancel up to x days” or “Cancel before mm/dd/yy hh:mm”). This is mentioned in the conditions during the booking process and in the booking confirmation."
                        ],
                        [
                            "q" => "Can I request an extra bed in my room and will there be an extra charge?",
                            "a" => "Information about extra beds is found under “House Rules” on the property page when you book.
                                    Additional costs, if any, are not included in the reservation price.
                                    When making a booking, you can request an extra bed in the “Special requests” box.
                                    If you already made a booking, you can always request an extra bed via the link provided in the booking confirmation email.
                                    We recommend contacting the property before arrival to make sure they have an extra bed available. You can find their contact details in the confirmation email and when you view your bookings in your account."
                        ],
                        [
                            "q" => 'Is it possible to get an extra bed or crib for a child?',
                            "a" => 'You can find info about extra beds and cribs under the "House Rules" on the property page when you book.
                                    Added costs for children, if any, are not included in the reservation price.
                                    When making a booking, you can request an extra bed or crib in the “Special requests” box.
                                    If you already made a booking, you can always request an extra bed or crib via the link provided in the booking confirmation email.
                                    We recommend contacting the property before arrival to make sure they have an extra bed or crib available. You can find their contact details in the confirmation email and your bookings in your account.
                                    If you need us to resend your booking confirmation email, go to booking.com/help.'
                        ]
                    ];
                    @endphp

                @foreach($roomTypes as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Pricing'">
                @php
                    $pricing = [
                        [
                            "q" => "Is breakfast included in the price?",
                            "a" => "Each room or accommodation you can book has its own breakfast policy. If breakfast is included, you'll see it listed on the property page when you compare different options to book. If breakfast isn’t included, you can see if the property provides it by checking its available facilities. After you book, this info can also be found in your confirmation email and in your bookings in your account."
                        ],
                        [
                            "q" => "What does the price include?",
                            "a" => "All the facilities listed under the room or accommodation type are included in the price. You can also see if other things like breakfast, taxes, or service charges are included when you compare different options to book. After you book, this info can also be found in your confirmation email and in your bookings in your account."
                        ],
                        [
                            "q" => "Are the prices shown on Booking.com per person or per room?",
                            "a" => "The price we show is for the room for the entire length of the stay, unless otherwise stated in the room type and description."
                        ],
                        [
                            "q" => "Are taxes included in the price?",
                            "a" => "This depends on the property and accommodation type, but it’s easy to see what’s included when you compare different options to book. Tax requirements change from country to country, so it’s always good to check. After you book, this info can also be found in your confirmation email and in your bookings in your account."
                        ],
                        [
                            "q" => "Do I pay a reservation fee to Booking.com?",
                            "a" => "No, we don't charge any fees at all."
                        ],
                        [
                            "q" => "What does the crossed out rate mean next to my room type?",
                            "a" => "In the event of a crossed-out rate, we look at the prices currently being charged by the hotel in the 30-day window around your proposed check-in date. From the prices within this window, we display the third-highest price on offer as the crossed-out rate. To ensure we are making a fair comparison, we always use the same booking conditions (meal plan, cancellation policy and room type). This means that you get the same room for a lower price compared to other check-in dates at the same time of year."
                        ],
                        [
                            "q" => "Can I use discount coupons (e.g. issued by magazines, stores, etc.)?",
                            "a" => "No, you cannot use discount coupons when booking on our website. In such cases you will need to follow the instructions given by the organization issuing the coupon."
                        ],
                        [
                            "q" => "Does Booking.com offer any special consideration discounts, or discounts with airline or hotel loyalty cards?",
                            "a" => "Booking.com provides the best available rates for the dates of your stay. It's not possible to have any further reductions on the price."
                        ],
                        [
                            "q" => "Do I pay the full price for my child?",
                            "a" => "Find info about a property's children policy under “House Rules” on the property page when you book.
                                    Any additional fees for children are not included in the reservation price.
                                    When making a booking, you can request an extra bed or crib in the “Special requests” box.
                                    If you already made a booking, you can always request an extra bed or crib via the link provided in the booking confirmation email.
                                    We recommend contacting the property before you arrive to make sure they have an extra bed or crib available. You can find their contact info in the confirmation email and when viewing your bookings on your account."
                        ]
                    ];
                @endphp

                @foreach($pricing as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Credit cards'">
                @php
                    $Credit_cards = [
                        [
                            "q" => "Can I use a debit card to complete my reservation?",
                            "a" => "In general, hotels can't accept a debit card to guarantee a booking. However, there are some exceptions. You'll be able see if it is possible during the booking process."
                        ],
                        [
                            "q" => "Can I make a reservation without a credit card?",
                            "a" => 'You\'ll need a valid credit card to guarantee your reservation with most properties. However, we offer a number of hotels that will guarantee your booking without a card. You can also make a booking by using someone else’s card, provided you have their permission. In this case, confirm the card holder’s name and that you have permission to use their card in the "Special requests" box when booking.'
                        ],
                        [
                            "q" => "What’s the difference between a pre-authorization and an actual charge to my credit card?",
                            "a" => "Pre-authorizations are common but are often confused with actual charges. While in-store purchases are immediately charged and deducted from your available balance, pre-authorizations are temporary holds. The length of the hold will vary, and your credit card company can advise you on how they handle this."
                        ],
                        [
                            "q" => "How will I know if my card has been pre-authorized?",
                            "a" => "Your available balance will be reduced temporarily by the full amount of your reservation. You may also see “pending transactions” on your credit card account summary. If you’re not sure if your card has been pre-authorized, both the hotel and your credit card company can verify this."
                        ],
                        [
                            "q" => "Can I make a reservation for myself using someone else’s credit card?",
                            "a" => 'Yes, but only if you have permission from the cardholder. When you make the booking, state that you’re using someone else’s card with their permission in the “Special requests” box. The property may require authorization from the cardholder. In the case of a no-show or late cancellation, any penalties will be charged to the card provided when the booking was made.'
                        ],
                        [
                            "q" => "How long will the pre-authorization hold affect my available balance?",
                            "a" => "Your card provider can better explain this, along with the general terms and conditions associated with their pre-authorization procedures. These terms vary across the board, so it’s best to contact them for specific details."
                        ],
                        [
                            "q" => "Why do I need to provide my credit card details?",
                            "a" => "In most cases, Booking.com needs credit card details to confirm your reservation with the property. Your credit card may be checked (pre-authorized) to ensure it's valid and that sufficient funds are available. After that, the full amount will be available to you again. In some cases, your credit card details will be used to process the payment for the reservation at the time of booking. Your credit card will only be charged if you have requested a pre-paid accommodation or if the cancellation policy hasn't been followed."
                        ],
                        [
                            "q" => "Will the pre-authorisation hold always equal the exact amount of my reservation?",
                            "a" => "In most cases, the hotel will pre-authorize your card for the full amount of your reservation. On occasion, you may see an amount slightly higher than the rate shown on Booking.com. If this does happen, the hotel can explain why this has occurred."
                        ],
                        [
                            "q" => "Will this happen with all bookings made through Booking.com?",
                            "a" => "Hotels reserve the right to pre-authorize your card, but this doesn't mean it will occur with every booking. Don’t worry, if your card is pre-authorized, both the hotel and your credit card company are there to help. They may also be able to assist you with removing these holds sooner."
                        ],
                        [
                            "q" => "The credit card that I used to make a reservation is no longer valid. What should I do?",
                            "a" => "Update your payment details on Booking.com. If your booking confirmation says the property will handle payment, you can contact the property directly. You'll find their contact info in your booking confirmation email or when you log in to Booking.com. For security reasons, never provide your credit card details by email."
                        ],
                        [
                            "q" => "Why was I charged?",
                            "a" => "The charge you see could be any one of the following:
                                    Pre-authorization: A pre-authorization is just a validity check that temporarily blocks an amount roughly equivalent to the cost of your reservation on your credit card. The amount will be unblocked after a certain amount of time. How long this takes will depend on the property and your credit card provider.
                                    Deposit or prepayment: Some properties require a deposit or prepayment at the time of reservation. This policy is clearly highlighted during the reservation process, and you can see it in your confirmation email as well. If your reservation allows for free cancellation, this amount is returned to you if you choose to cancel it.
                                    Our Customer Service team is always there if you need help with a payment issue. You can go to booking.com/help to get in touch with us."
                        ],
                        [
                            "q" => "What is a pre-authorization?",
                            "a" => "When you make a reservation, there may be instances where the hotel will contact your credit (or debit) card company to confirm that the card you are using is valid and hasn’t been reported lost or stolen. At this time, they may also check to see if the card has enough money to cover the transaction. This is communicated in the form of a pre-authorization for the full amount of your reservation.
                                    The hotel, however, will not proceed with the charge. The time at which your card will be charged will depend on the terms and conditions of your booking."
                        ],
                        [
                            "q" => "Which credit cards can I use to complete my booking?",
                            "a" => "To make a reservation via Booking.com all hotels accept:
                                    Mastercard
                                    Visa"
                        ],
                        [
                            "q" => "Are my credit card details safe?",
                            "a" => "Yes, always. Booking.com uses a secure connection for your booking and personal data, and credit card details are encrypted."
                        ]
                    ];
                    @endphp

                @foreach($Credit_cards as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Property Policies'">
                @php
                    $Property_Policies = [
                        [
                            "q" => "I want to check out after the stated check-out time. What should I do?",
                            "a" => "You can ask the property about arranging a late check-out when you get there. It will depend on what's available at the time of your stay."
                        ],
                        [
                            "q" => "What are the check-in and check-out times of a property?",
                            "a" => 'Check-in and check-out times differ for each property. You can find them in the "House Rules" section on the property page when you make a booking. If you already made a booking, you can see check-in and check-out times in your confirmation email and when you log in to your account.'
                        ],
                        [
                            "q" => "How do I get more info about the facilities available?",
                            "a" => 'You can check which facilities are included with a booking when comparing different options offered by a particular property. To see which facilities are available at the property itself, go to "Facilities" at the top of the property page.'
                        ],
                        [
                            "q" => "I want a smoking room however I can only choose a non-smoking room. How can I request a smoking room?",
                            "a" => 'If there are no rooms listed as "smoking rooms," it means that the hotel does not allow smoking in rooms.'
                        ],
                        [
                            "q" => "How do I find out if properties allow pets?",
                            "a" => "Pet policies are always displayed on the property’s page under House rules."
                        ],
                        [
                            "q" => "I will be arriving earlier/later than the stated check-in time. Can I still check in?",
                            "a" => "There are several ways to request early or late check-in:
                                    You can specify your estimated check-in time while making the reservation.
                                    You can manage your booking online to request check-in outside of the standard hours.
                                    You can contact the property directly using the contact details in your booking confirmation.
                                    It's important to remember that the property can't always accommodate these requests. They'll be happy to let you into your room early if possible, but there might not be anyone there in person to welcome you if you arrive late at night at a remote apartment. It's always best to check with the property directly and in advance to avoid confusion."
                        ]
                    ];
                    @endphp

                @foreach($Property_Policies as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Extra Facilities'">
               @php
                    $Extra_Facilities = [
                        [
                            "q" => "How do I know if parking is available at the property and how can I reserve it?",
                            "a" => 'You can see if the property has parking under "Facilities" before making a booking. If the property requires you to reserve a space, contact them directly with the contact details provided in your booking confirmation.'
                        ],
                        [
                            "q" => "How do I find out if a property has a certain facility (e.g. an elevator)?",
                            "a" => 'Under "Facilities" on the property page, you can see a list of all the property’s facilities, activities, and services.'
                        ],
                        [
                            "q" => "How do I know if the property offers a shuttle service and how can I book it?",
                            "a" => 'If the property offers a shuttle service it will be listed under "Facilities". After you make a booking, you can arrange the airport transfer directly with the property. You can find their contact info in your booking confirmation. Remember to have your flight details ready because they will need these to make sure the driver can find you at the airport.'
                        ],
                        [
                            "q" => "Can the property store my luggage before check-in or after check-out?",
                            "a" => 'If the property has luggage storage, you will see it displayed on the property page under "Facilities." For more info about luggage storage, contact the property directly using the details provided in your booking confirmation.'
                        ]
                    ];
                    @endphp

                @foreach($Extra_Facilities as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>


            <div x-show="activeTab === 'Security and awareness'">
              @php
                $Security_and_awareness = [
                    [
                        "q" => "What is social engineering?",
                        "a" => "Social engineering is a tactic that scammers use. They pretend to be a trusted source to trick people into giving them sensitive personal data. Online scammers usually pose as well-known companies, then use a seemingly logical reason to ask for your personal data and payments."
                    ],
                    [
                        "q" => "How can I prevent social engineering attempts?",
                        "a" => "Here are some security tips to keep you safe from online scams:
                                Phishing emails usually have spelling mistakes and convey a sense of urgency
                                Need to contact us? Open a new tab and go to our official website
                                Get an email with a link? Hover the mouse over it to see if the URL looks suspicious, or if it’s missing \"https://\" at the beginning
                                Remember: Booking.com will never ask you to enter your credit card or gift card number via email, text, or phone."
                    ],
                    [
                        "q" => "I was recently asked to pay using my gift card over the phone. Is that okay?",
                        "a" => "Booking.com will never ask you to share a credit card or a gift card number over the phone. If anyone tells you to pay by gift card or share a credit card over the phone—for any reason—it’s likely to be a scam."
                    ],
                    [
                        "q" => "I think I've been scammed. What should I do?",
                        "a" => "If you think you were exposed to an online scam involving Insiler.com, contact us as soon as possible. We’re here to help 24/7 – go to booking.com/help or access the Help Center via the app’s main menu. If you’ve made a payment, contact your payment provider to see if you can dispute it with them first. If you can’t dispute the charge with your payment provider, our Customer Service team will ask you for documentation showing the details of the charge so they can help. List your property."
                    ]
                ];
                @endphp

                @foreach($Security_and_awareness as $item)
                    <details class="border-b px-5 py-4">
                        <summary class="cursor-pointer font-medium text-sm flex justify-between items-center">
                            {{ $item['q'] }} <span>⌄</span>
                        </summary>
                        <p class="text-gray-600 text-sm mt-2 pl-1">
                            {{ $item['a'] }}
                        </p>
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





    <!-- Icons (FontAwesome) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

</body>
</html>
