<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Example</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

  <!-- Footer -->
  <footer class="bg-gray-100 text-gray-600 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Footer Links -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 text-center sm:text-left">
        
        <!-- Column 1: Support -->
        <div>
          <h3 class="text-lg font-bold mb-3">Support</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Manage your Trips</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Contact Customer Service</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Safety Resource Center</a></li>
          </ul>
        </div>

        <!-- Column 2: Discover -->
        <div>
          <h3 class="text-lg font-bold mb-3">Discover</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Genius</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Seasonal and holiday deals</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Travel Articles</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">HorizonStay for Business</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">HorizonStay for Travel Agents</a></li>
          </ul>
        </div>

        <!-- Column 3: Terms and settings -->
        <div>
          <h3 class="text-lg font-bold mb-3">Terms and settings</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Privacy &amp; cookies</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Terms &amp; conditions</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Partner dispute</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Human Rights Statement</a></li>
          </ul>
        </div>

        <!-- Column 4: About -->
        <div>
          <h3 class="text-lg font-bold mb-3">About</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-500 hover:text-gray-700">About HorizonStay</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">How we work</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Sustainabilities</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Careers</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Investor relations</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Corporate Contact</a></li>
          </ul>
        </div>
      </div>

      <!-- Footer Separator -->
      <hr class="my-8 border-gray-300">

      <!-- Copyright and Branding -->
      <div class="text-center space-y-3">
        @php
          $host = config('domains.app_name');
        @endphp

        @if ($host == 'BookinTour')
          <p class="text-sm text-gray-600">
            BookinTour.com is a part of JSG Ceylon (Pvt) Ltd, a growing leader and trusted partner in online travel and related services.
            <br>
            Copyright © 2024 – 2025. All rights reserved. BookinTour.com
          </p>
        @elseif ($host == 'Inselor')
          <p class="text-sm text-gray-600">
            Inselor.com is part of Inselor Inc., the world leader in online travel and related services.
            <br>
            Copyright © 2024 – 2025. All rights reserved. Inselor.com
          </p>
        @endif

        <a href="#" class="text-blue-600 font-semibold hover:underline">
          {{ config('domains.domain') }}
        </a>
      </div>
    </div>
  </footer>

</body>

</html>
