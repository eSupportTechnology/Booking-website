<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sustainability at Booking.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="font-sans antialiased">

<!-- HEADER -->
<header x-data="{ open: false }" class="bg-[#003580] text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 flex items-center justify-between">
        <!-- Logo -->
        <div class="text-2xl font-bold">
            Booking.com
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="#" class="px-4 py-1 rounded-full border border-white">Home</a>
            <a href="#" class="hover:underline">Operations</a>
            <a href="#" class="hover:underline">Travel Offerings</a>
            <a href="#" class="hover:underline">Industry & Insights</a>
        </nav>

        <!-- Mobile Toggle Button -->
        <button @click="open = !open" class="md:hidden text-2xl focus:outline-none">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="md:hidden bg-[#003580] border-t border-blue-700"
    >
        <nav class="flex flex-col px-4 py-4 space-y-3">
            <a href="#" class="px-4 py-2 rounded-full border border-white w-fit">Home</a>
            <a href="#" class="hover:underline">Operations</a>
            <a href="#" class="hover:underline">Travel Offerings</a>
            <a href="#" class="hover:underline">Industry & Insights</a>
        </nav>
    </div>
</header>


<!-- HERO SECTION -->
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
</section>

</body>
</html>
