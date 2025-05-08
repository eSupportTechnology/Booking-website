<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
    </style>
</head>
<body>
<div class="w-full bg-white py-6">
    <!-- Search Bar -->
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-md px-4 py-4 grid grid-cols-1 md:grid-cols-5 gap-2">
        <div class="flex items-center bg-gray-100 rounded px-3 py-2 col-span-2">
            <img src="images/car.png" class="w-5 h-5 mr-2" alt="Location">
            <input type="text" placeholder="Nuwara Eliya" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <div class="flex items-center bg-gray-100 rounded px-3 py-2">
            <img src="images/calender.png" class="w-5 h-5 mr-2" alt="Calendar">
            <input type="text" placeholder="Tue, May 13 – Tue, May 15" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <div class="flex items-center bg-gray-100 rounded px-3 py-2">
            <img src="images/user.png" class="w-5 h-5 mr-2" alt="Guests">
            <input type="text" placeholder="2 Adults · 0 Children · 1 Room" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <button class="bg-cyan-600 text-white px-4 py-2 rounded-md hover:bg-cyan-700 text-sm">Search</button>
    </div>

    <!-- Search Summary -->
    <div class="max-w-6xl mx-auto mt-6 px-4">
        <h2 class="text-xl font-semibold">Nuwara Eliya: <span class="font-normal">430 properties found</span></h2>
        <div class="mt-2 flex items-center justify-between text-sm">
            <span class="text-gray-500">Sort by: <strong class="text-black">Our top picks</strong></span>
            <div class="flex gap-2">
                <button class="border px-2 py-1 rounded text-sm">List</button>
                <button class="border px-2 py-1 rounded text-sm">Grid</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto mt-6 px-4 grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Filter Section -->
        <aside class="hidden md:block col-span-1">
            <div class="sticky top-6">
                <h3 class="font-semibold mb-2">Filter by:</h3>
                <div class="text-sm mb-4">
                    <p class="font-medium">Your budget (per night)</p>
                    <div class="w-full bg-gray-200 h-2 rounded mt-2 mb-4"></div>
                </div>

                <div class="mb-4">
                    <h4 class="font-medium mb-1">Popular filters</h4>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li><input type="checkbox"> Breakfast included</li>
                        <li><input type="checkbox"> Private bathroom</li>
                        <li><input type="checkbox"> Parking</li>
                        <li><input type="checkbox"> Balcony</li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Results Section -->
        <section class="md:col-span-3 space-y-4">
            <!-- Result Card -->
            <div class="border rounded-md p-4 shadow-sm flex flex-col md:flex-row gap-4">
                <img src="images/hotel.jpg" alt="Hotel Image" class="w-full md:w-48 h-32 object-cover rounded">
                <div class="flex-1">
                    <h3 class="font-semibold text-lg">Sandathenna by Secret Leisure</h3>
                    <p class="text-gray-500 text-sm">Nuwara Eliya • 2.5 km from downtown</p>
                    <ul class="text-sm text-gray-600 mt-1 list-disc pl-5">
                        <li>Breakfast included</li>
                        <li>Free cancellation</li>
                        <li>No prepayment needed</li>
                    </ul>
                    <p class="text-xs text-red-600 mt-1">Only 5 rooms left at this price</p>
                </div>
                <div class="flex flex-col justify-between text-right">
                <span class="text-sm text-gray-500 line-through">LKR 72,000</span>

                    <span class="text-xl font-bold text-red-600">LKR 46,500</span>
                    <span class="text-xs text-gray-500">+LKR 9,057 taxes and fees</span>
                    <button class="mt-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded text-sm">See availability</button>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
