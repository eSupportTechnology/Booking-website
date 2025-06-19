<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking.com - Having Trouble Signing In</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

  <!-- Header -->
  <header class="bg-blue-800 text-white px-4 py-3 flex justify-between items-center">
    <div class="text-xl font-bold">Booking.com</div>
    <div class="flex items-center space-x-4">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Flag_of_the_United_Kingdom_%283-5%29.svg/200px-Flag_of_the_United_Kingdom_%283-5%29.svg.png" 
           alt="UK Flag" class="h-6 w-6 object-contain">
      <img src="https://www.booking.com/images/icons/help-black.svg" 
           alt="Help Icon" class="h-6 w-6 object-contain">
    </div>
  </header>

  <!-- Main Content -->
  <main class="w-full px-4 sm:px-6 lg:px-8 py-8">
    <section class="w-full bg-white p-6 rounded-lg shadow-md mx-auto sm:w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2">
      <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Having trouble signing in?</h1>
      <p class="mb-6 text-gray-700 text-center">
        We're here to help. Below are some options to help get you back on track.
      </p>

      <!-- Options -->
      <ul class="space-y-4">
        <li class="flex items-center justify-between border-b pb-2">
          <div class="flex items-center space-x-2">
            <img src="https://www.booking.com/images/icons/forgot-password.svg" 
                 alt="Forgot Password Icon" class="h-6 w-6 object-contain">
            <a href="#" class="text-blue-500 hover:underline">Forgot your password?</a>
          </div>
          <img src="https://www.booking.com/images/icons/arrow-right.svg" 
               alt="Arrow Right" class="h-6 w-6 object-contain">
        </li>
        <li class="flex items-center justify-between border-b pb-2">
          <div class="flex items-center space-x-2">
            <img src="https://www.booking.com/images/icons/forgot-username.svg" 
                 alt="Forgot Username Icon" class="h-6 w-6 object-contain">
            <a href="#" class="text-blue-500 hover:underline">Forgot your username?</a>
          </div>
          <img src="https://www.booking.com/images/icons/arrow-right.svg" 
               alt="Arrow Right" class="h-6 w-6 object-contain">
        </li>
        <li class="flex items-center justify-between">
          <div class="flex items-center space-x-2">
            <img src="https://www.booking.com/images/icons/go-to-sign-in.svg" 
                 alt="Go to Sign In Icon" class="h-6 w-6 object-contain">
            <a href="#" class="text-blue-500 hover:underline">Go to sign-in</a>
          </div>
          <img src="https://www.booking.com/images/icons/arrow-right.svg" 
               alt="Arrow Right" class="h-6 w-6 object-contain">
        </li>
      </ul>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 text-gray-600 px-4 py-6 text-center text-sm">
    <p class="mb-2">
      By signing in or creating an account, you agree with our
      <a href="#" class="text-blue-500 hover:underline">Terms & Conditions</a>
      and
      <a href="#" class="text-blue-500 hover:underline">Privacy statement</a>.
    </p>
    <p class="mb-1">All rights reserved.</p>
    <p>Copyright (2006 – 2025) – Booking.com™</p>
  </footer>

</body>
</html>
