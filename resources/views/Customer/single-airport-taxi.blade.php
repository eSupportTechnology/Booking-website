<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Details - Mercedes Benz E 220</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Container -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Back link -->
    <a href="#" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Back to marketplace</a>

    <div class="flex flex-col lg:flex-row gap-8">

      <!-- Left Column: Images -->
      <div class="flex-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
          <img src="https://via.placeholder.com/800x500.png?text=Car+Main+Image" alt="Mercedes Benz E 220" class="w-full h-auto object-cover rounded-t-lg">
        </div>
        <!-- Thumbnails -->
        <div class="flex gap-2 overflow-x-auto">
          <img src="https://via.placeholder.com/150x100.png?text=Car+1" class="w-24 h-16 object-cover rounded cursor-pointer">
          <img src="https://via.placeholder.com/150x100.png?text=Car+2" class="w-24 h-16 object-cover rounded cursor-pointer">
          <img src="https://via.placeholder.com/150x100.png?text=Car+3" class="w-24 h-16 object-cover rounded cursor-pointer">
          <img src="https://via.placeholder.com/150x100.png?text=Car+4" class="w-24 h-16 object-cover rounded cursor-pointer">
        </div>
      </div>

      <!-- Right Column: Details & Booking -->
      <div class="flex-1 space-y-6">

        <!-- Title & Price -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h1 class="text-2xl font-bold mb-2">Mercedes Benz E 220</h1>
          <p class="text-green-600 font-semibold text-xl mb-4">€14,000.00 <span class="text-gray-500 text-sm">(Minimum price €14,000.00)</span></p>

          <!-- Car Info -->
          <ul class="text-gray-700 space-y-1 text-sm">
            <li><strong>Advertisement number:</strong> 171959</li>
            <li><strong>Location:</strong> 6060</li>
            <li><strong>Desired price:</strong> €14,000.00</li>
            <li><strong>Minimum price:</strong> €14,000.00</li>
            <li><strong>Advertised on:</strong> 12/15/22 | 10:12 am</li>
            <li><strong>Planned sale:</strong> As soon as possible</li>
          </ul>
        </div>

        <!-- Booking Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Book This Car</h2>
          <form class="space-y-4">
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-1">Your Name</label>
              <input type="text" placeholder="Enter your name" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
              <input type="email" placeholder="Enter your email" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-1">Phone</label>
              <input type="tel" placeholder="Enter your phone number" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-1">Select Date</label>
              <input type="date" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
              <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">Book Now</button>
            </div>
          </form>
        </div>

        <!-- Vehicle Details -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Vehicle Details</h2>
          <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
            <div><strong>Brand:</strong> Mercedes Benz</div>
            <div><strong>Model:</strong> E220</div>
            <div><strong>First Registration:</strong> 04/2017</div>
            <div><strong>KM:</strong> 160,000</div>
            <div><strong>Transmission:</strong> Automatic</div>
            <div><strong>Fuel:</strong> Diesel</div>
            <div><strong>Engine Damage:</strong> Yes</div>
            <div><strong>Accident Free:</strong> Yes</div>
            <div><strong>Roadworthy:</strong> No</div>
            <div><strong>MOT until:</strong> April 2023</div>
          </div>
        </div>

        <!-- Extras -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold mb-4">Extras</h2>
          <div class="flex flex-wrap gap-2">
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">8 times wheels</span>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">All wheel drive</span>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">Parking assistance</span>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">Electric windows</span>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">Air conditioning</span>
          </div>
        </div>

      </div>
    </div>
  </div>

</body>
</html>
