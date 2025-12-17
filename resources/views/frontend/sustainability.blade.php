<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sustainability at Booking.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased" x-data="{ page: 'home', open: false }">

<!-- HEADER -->
<header class="bg-[#003580] text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 flex items-center justify-between">
        <div class="text-2xl font-bold pl-10 sm:pl-20 md:pl-28 lg:pl-36">Booking.com</div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="#" @click.prevent="page='home'" class="px-4 py-1 rounded-full border border-white">Home</a>
            <a href="#" @click.prevent="page='operations'" class="hover:underline">Operations</a>
            <a href="#" @click.prevent="page='travel-offerings'" class="hover:underline">Travel Offerings</a>
            <a href="#" @click.prevent="page='industry-insights'" class="hover:underline">Industry & Insights</a>
        </nav>

        <!-- Mobile Toggle -->
        <button @click="open = !open" class="md:hidden text-2xl focus:outline-none">☰</button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition @click.outside="open = false" class="md:hidden bg-[#003580] border-t border-blue-700">
        <nav class="flex flex-col px-4 py-4 space-y-3">
            <a href="#" @click.prevent="page='home'; open=false" class="px-4 py-2 rounded-full border border-white w-fit">Home</a>
            <a href="#" @click.prevent="page='operations'; open=false" class="hover:underline">Operations</a>
            <a href="#" @click.prevent="page='travel-offerings'; open=false" class="hover:underline">Travel Offerings</a>
            <a href="#" @click.prevent="page='industry-insights'; open=false" class="hover:underline">Industry & Insights</a>
        </nav>
    </div>
</header>

<main>

    <!-- HOME PAGE -->
    <section x-show="page==='home'" class="transition-all duration-500">
        <section class="relative w-full h-[87vh]">
            <!-- Background Image -->
            <img
                src="{{ asset('assets/travelers.jpg') }}"
                alt="Nature"
                class="absolute inset-0 w-full h-full object-cover"
            >

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/20"></div>

            <!-- Content Box -->
            <div class="relative z-10 flex items-center h-full">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="bg-[#003580]/80 text-white p-6 sm:p-8 md:p-10 max-w-2xl">
                        <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                            Sustainability at Booking.com
                        </h1>

                        <p class="text-sm sm:text-base leading-relaxed">
                            We believe travel is a force for good – promoting economic growth,
                            fostering cultural exchange, and deepening shared understanding.
                            Through our three-pillar sustainability strategy, we aim to empower
                            travel choices by providing transparency, offering more sustainable
                            travel options, and fostering trust by supporting a more sustainable
                            travel industry.
                        </p>

                        <p class="mt-4 underline font-semibold cursor-pointer">
                            Our sustainability strategy focuses on three pillars:
                        </p>
                    </div>
                </div>
            </div>
        </section><br>

        <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
            
            <!-- LEFT IMAGE -->
            <div class="w-full h-[60vh] md:h-auto">
                <img
                    src="{{ asset('assets/travelers.jpg') }}"
                    alt="Sustainable Operations"
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- RIGHT CONTENT -->
            <div class="flex items-center justify-center bg-[#041C44] px-6 py-16">
                <div class="text-center text-white max-w-md">
                    
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Sustainable Operations
                    </h2>

                    <p class="text-base sm:text-lg leading-relaxed mb-8">
                        Operating our business sustainably and building a<br>
                        culture of sustainability
                    </p>

                    <a
                        href="#"
                        class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-10 py-3 rounded-sm hover:bg-yellow-400 transition"
                    >
                        Operations
                    </a>

                </div>
            </div>

        </section>

        <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
            
            <!-- LEFT CONTENT -->
            <div class="flex items-center justify-center bg-[#002F6C] px-6 py-16 order-2 md:order-1">
                <div class="text-center text-white max-w-md">
                    
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    More Sustainable Travel
                    </h2>

                    <p class="text-base sm:text-lg leading-relaxed mb-8">
                        Making it easier for travelers to make more sustainable travel choices
                    </p>

                    <a
                        href="#"
                        class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-10 py-3 rounded-sm hover:bg-yellow-400 transition"
                    >
                        Travel Offerings
                    </a>

                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="w-full h-[60vh] md:h-auto order-1 md:order-2">
                <img
                    src="{{ asset('assets/travelers.jpg') }}"
                    alt="Sustainable Operations"
                    class="w-full h-full object-cover"
                >
            </div>

        </section>

        <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
            
            <!-- LEFT IMAGE -->
            <div class="w-full h-[60vh] md:h-auto">
                <img
                    src="{{ asset('assets/travelers.jpg') }}"
                    alt="Sustainable Operations"
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- RIGHT CONTENT -->
            <div class="flex items-center justify-center bg-[#0057B8] px-6 py-16">
                <div class="text-center text-white max-w-md">
                    
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Sustainable Operations
                    </h2>

                    <p class="text-base sm:text-lg leading-relaxed mb-8">
                        Operating our business sustainably and building a
                        culture of sustainability
                    </p>

                    <a
                        href="#"
                        class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-10 py-3 rounded-sm hover:bg-yellow-400 transition"
                    >
                        Operations
                    </a>

                </div>
            </div>

        </section>

        <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-[3fr_2fr]">
            
            <!-- IMAGE (BIGGER) -->
            <div class="w-full h-[65vh] md:h-auto">
                <img
                    src="{{ asset('assets/travelers.jpg') }}"
                    alt="Sustainable Operations"
                    class="w-full h-full object-cover"
                >
            </div>

            <!-- CONTENT (SMALLER) -->
            <div class="flex items-center justify-center bg-[#041C44] px-6 py-12">
                <div class="text-center text-white max-w-sm">
                    
                    <h2 class="text-2xl sm:text-3xl font-bold mb-3">
                    Annual
                    Sustainability 
                    Report
                    </h2>

                    <p class="text-base sm:text-lg leading-relaxed mb-8">
                        Learn more about all our efforts
                    </p>

                    <a
                        href="#"
                        class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-8 py-2.5 text-sm rounded-sm hover:bg-yellow-400 transition"
                    >
                        Explore
                    </a>

                </div>
            </div>

        </section>
    </section>

        <!-- OPERATIONS PAGE -->
        <section x-show="page==='operations'" class="transition-all duration-500">
            <section class="w-full">
                <div class="relative w-full h-[40vh] sm:h-[50vh] lg:h-[65vh] overflow-hidden">
                    <img 
                        src="{{ asset('assets/planet-hero.jpg') }}" 
                        alt="Planet view"
                        class="w-full h-full object-cover"
                    >
                </div>
            </section>

            <!-- Content Section -->
            <section class="bg-white py-16 sm:py-20">
                <div class="max-w-4xl mx-auto px-4 text-center">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-black mb-6">
                        Planet
                    </h1>

                    <p class="text-base sm:text-lg lg:text-xl text-gray-700 leading-relaxed">
                        Our planet is our home and also our destination. We aim to do our part to 
                        protect and preserve it to best serve our travelers and partners.
                    </p>
                </div>
            </section>
        </section>

        <!-- TRAVEL OFFERINGS PAGE -->
        <section x-show="page==='travel-offerings'" class="transition-all duration-500">
            <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
                <div class="flex items-center justify-center bg-[#002F6C] px-6 py-16">
                    <div class="text-center text-white max-w-md">
                        <h2 class="text-3xl sm:text-4xl font-bold mb-4">More Sustainable Travel</h2>
                        <p class="text-base sm:text-lg leading-relaxed mb-8">
                            Making it easier for travelers to make more sustainable travel choices
                        </p>
                        <a href="#" class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-10 py-3 rounded-sm hover:bg-yellow-400 transition">Travel Offerings</a>
                    </div>
                </div>
                <div class="w-full h-[60vh] md:h-auto">
                    <img src="{{ asset('assets/travelers.jpg') }}" alt="Travel Offerings" class="w-full h-full object-cover">
                </div>
            </section>
        </section>

        <!-- INDUSTRY & INSIGHTS PAGE -->
        <section x-show="page==='industry-insights'" class="transition-all duration-500">
            <section class="w-full min-h-[50vh] md:min-h-[80vh] grid grid-cols-1 md:grid-cols-2">
                <div class="w-full h-[60vh] md:h-auto">
                    <img src="{{ asset('assets/travelers.jpg') }}" alt="Industry Insights" class="w-full h-full object-cover">
                </div>
                <div class="flex items-center justify-center bg-[#0057B8] px-6 py-16">
                    <div class="text-center text-white max-w-md">
                        <h2 class="text-3xl sm:text-4xl font-bold mb-4">Industry & Insights</h2>
                        <p class="text-base sm:text-lg leading-relaxed mb-8">
                            Learn about the industry trends and insights
                        </p>
                        <a href="#" class="inline-block bg-[#FDBA12] text-[#041C44] font-semibold px-10 py-3 rounded-sm hover:bg-yellow-400 transition">Insights</a>
                    </div>
                </div>
            </section>
    </section>

</main>

<!-- FOOTER -->
<footer class="bg-[#003580] text-white">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col sm:flex-row items-center sm:items-start sm:justify-start sm:space-x-20 space-y-6 sm:space-y-0 text-sm pl-0 sm:pl-16 md:pl-24">
            <div class="text-center sm:text-left">
                <p class="font-semibold uppercase mb-1">Terms of Use</p>
                <a href="#" class="underline">Privacy</a>
            </div>
            <div class="text-center sm:text-left">
                <p class="font-semibold uppercase mb-1">More from Booking</p>
                <ul class="space-y-1">
                    <li><a href="#" class="underline">Booking.com</a></li>
                    <li><a href="#" class="underline">Careers</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-10 text-center text-xs leading-relaxed max-w-4xl mx-auto">
            <p>
                Copyright © 1996–2021 Booking.com. All rights reserved.
                <a href="#" class="underline">About Booking.com</a> |
                <a href="#" class="underline">Privacy and Cookies Statement</a>
            </p>
            <p class="mt-2">
                All references to "Booking.com", including any mention of "us", "we" and "our"
                refer to Booking.com BV, the company behind Booking.com™
            </p>
        </div>
    </div>
</footer>

</body>
</html>
