<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Resource Center</title>

    {{-- Tailwind CDN (remove/change if you use your own setup) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Top Blue Navbar -->
<nav class="w-full bg-[#003580] text-white">
    <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center justify-between w-full sm:w-auto">
            <div class="text-2xl font-semibold">Booking.com</div>

            <!-- small-screen controls -->
            <div class="sm:hidden flex items-center space-x-3">
                <button aria-label="help" class="text-xl">❔</button>
            </div>
        </div>

        <div class="hidden sm:flex items-center space-x-4 text-sm">
            <span class="whitespace-nowrap">LKR</span>

            <button class="flex items-center space-x-1" aria-label="change country">
                <img src="{{ asset('assets/flags/us.svg') }}" alt="US flag" class="w-5 h-5 object-contain" />
            </button>

            <button class="rounded px-4 py-1 border border-white/30 text-sm">?</button>

            <button class="bg-white text-[#003580] font-medium px-4 py-1 rounded text-sm">List your property</button>
            <button class="bg-white text-[#003580] font-medium px-4 py-1 rounded text-sm">Register</button>
            <button class="bg-white text-[#003580] font-medium px-4 py-1 rounded text-sm">Sign in</button>
        </div>
    </div>
</nav>

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
        <nav class="flex gap-10 overflow-x-auto py-3 text-sm">
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
            <h1 class="font-extrabold text-gray-900 leading-tight text-4xl sm:text-5xl md:text-7xl lg:text-8xl -mt-4">
                Trust and safety<br class="hidden md:inline" /> resource center
            </h1>

            <p class="mt-8 text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-800">
                Safety tips, guidelines, and our values
            </p>
        </div>
    </div>
</div>

<!-- ░░░░░░ Travelers Section (from screenshot) ░░░░░░ -->
<div class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">

        <h1 class="text-3xl sm:text-4xl font-bold mb-10">Travelers</h1>

        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">

            <!-- Left Image -->
            <div class="w-full lg:w-1/2">
                <img src="{{ asset('assets/travelers.jpg') }}"
                     alt="Travelers Image"
                     class="rounded-2xl w-full object-cover">
            </div>

            <!-- Right Text -->
            <div class="w-full lg:w-1/2 space-y-4">
                <h2 class="text-xl md:text-2xl font-semibold">Stay safely</h2>

                <p class="text-gray-700 leading-relaxed">
                    At Booking.com, we strive to help everyone experience the world safely.
                    We have many processes in place to protect our guests, and to empower
                    you to take control of your safety while traveling. Visit our traveler
                    resource page to learn more about making your future stays go smoothly.
                </p>

                <a href="#"
                   class="inline-block mt-4 px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition">
                    See traveler resources
                </a>
            </div>

        </div>
    </div>
</div>
<!-- ░░░░░░ END Travelers Section ░░░░░░ -->


<!-- Footer -->
<footer class="w-full border-t mt-8">
    <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-gray-500">
        &copy; {{ date('Y') }} Booking.com — Trust & Safety Resource Center
    </div>
</footer>

</body>
</html>
