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
    <header class="bg-[#003580] w-full py-4 shadow">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center space-x-8">
                <h1 class="text-white font-bold text-2xl">Booking.com</h1>
                <nav class="hidden md:flex space-x-6 text-white text-sm">
                    <a href="#" class="flex items-center space-x-1 hover:underline"><span>🏨</span><span>Stays</span></a>
                    <a href="#" class="flex items-center space-x-1 hover:underline"><span>🚗</span><span>Car rental</span></a>
                </nav>
            </div>

            <div class="flex items-center space-x-4 text-white">
                <span class="text-sm">LKR</span>
                <button class="border border-white/30 px-3 py-1 rounded hover:bg-white hover:text-[#003580] transition text-sm">List your property</button>
                <button class="border border-white/30 px-3 py-1 rounded hover:bg-white hover:text-[#003580] transition text-sm">Register</button>
                <button class="border border-white/30 px-3 py-1 rounded hover:bg-white hover:text-[#003580] transition text-sm">Sign in</button>
            </div>
        </div>
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

</body>
</html>
