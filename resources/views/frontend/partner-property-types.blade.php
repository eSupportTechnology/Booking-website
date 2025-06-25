<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>List Your Property</title>

  <!-- Google Fonts (optional) -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />

  <!-- Alpine.js (if needed later) -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <!-- Tailwind CSS via Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-blue-900 text-white px-4 py-4 flex justify-between items-center">
    <div class="text-xl font-semibold">Booking.com</div>
    <div class="flex items-center gap-4">
      <span class="text-sm">🇬🇧</span>
      <span class="text-sm bg-yellow-400 text-black px-2 py-1 rounded-full text-xs font-semibold">?</span>
      <span class="w-8 h-8 rounded-full bg-white text-blue-900 flex items-center justify-center font-bold">B</span>
    </div>
  </header>

  <!-- Main Section -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-center mb-2">
      List your property on Booking.com and start welcoming guests in no time!
    </h1>
    <p class="text-center text-gray-600 mb-8">
      To get started, choose the type of property you want to list on Booking.com
    </p>

    <!-- Property Cards -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <!-- Card 1 -->
      <div class="bg-white p-6 rounded-lg shadow border text-center flex flex-col items-center space-y-4">
        <span class="bg-green-700 text-white text-xs px-2 py-1 rounded-full font-semibold">🚀 Quick start</span>
        <img src="https://img.icons8.com/ios-filled/50/000000/apartment.png" alt="Apartment" class="w-10 h-10" />
        <h2 class="text-lg font-semibold">Apartment</h2>
        <p class="text-sm text-gray-600">Furnished and self-catering accommodation, where guests rent the entire place.</p>
        <button class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">List your property</button>
      </div>

      <!-- Card 2 -->
      <div class="bg-white p-6 rounded-lg shadow border text-center flex flex-col items-center space-y-4">
        <img src="https://img.icons8.com/ios-filled/50/000000/home.png" alt="Homes" class="w-10 h-10" />
        <h2 class="text-lg font-semibold">Homes</h2>
        <p class="text-sm text-gray-600">Properties like apartments, holiday homes, villas, etc.</p>
        <button class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">List your property</button>
      </div>

      <!-- Card 3 -->
      <div class="bg-white p-6 rounded-lg shadow border text-center flex flex-col items-center space-y-4">
        <img src="https://img.icons8.com/ios-filled/50/000000/hotel.png" alt="Hotel" class="w-10 h-10" />
        <h2 class="text-lg font-semibold">Hotel, B&Bs, and more</h2>
        <p class="text-sm text-gray-600">Properties like hotels, B&Bs, guest houses, hostels, aparthotels, etc.</p>
        <button class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">List your property</button>
      </div>

      <!-- Card 4 -->
      <div class="bg-white p-6 rounded-lg shadow border text-center flex flex-col items-center space-y-4">
        <img src="https://img.icons8.com/ios-filled/50/000000/camping-tent.png" alt="Alternative" class="w-10 h-10" />
        <h2 class="text-lg font-semibold">Alternative places</h2>
        <p class="text-sm text-gray-600">Properties like boats, campsites, luxury tents, etc.</p>
        <button class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">List your property</button>
      </div>
    </div>
  </main>

</body>
</html>
