<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">

  <!-- Header -->
  <div class="bg-[#003580] py-4 px-6">
    <h1 class="text-white text-lg font-bold">Booking.com</h1>
  </div>

  <!-- Form Container -->
  <div class="max-w-md mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold mb-2">Contact details</h2>
    <p class="text-sm text-gray-600 mb-6">
      Your full name and phone number are needed to ensure the security of your Booking.com account.
    </p>

    <form>
      <!-- First Name -->
      <div class="mb-4">
        <label for="first-name" class="block text-sm font-medium text-gray-800">First name</label>
        <input type="text" id="first-name" name="first-name" class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <label for="last-name" class="block text-sm font-medium text-gray-800">Last name</label>
        <input type="text" id="last-name" name="last-name" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      </div>

      <!-- Phone Number -->
      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-800">Phone number</label>
        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2">
          <img src="https://flagcdn.com/w40/lk.png" alt="LK" class="w-5 h-5 mr-2" />
          <span class="text-gray-700 mr-2">+94</span>
          <input type="text" id="phone" name="phone" placeholder="77xxxxxxx" class="flex-1 outline-none border-none focus:ring-0" />
        </div>
        <p class="text-xs text-gray-500 mt-1">
          We'll text a two-factor authentication code to this number when you sign in.
        </p>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded mt-4">
        Next
      </button>
    </form>

    <!-- Terms and Footer -->
    <div class="text-xs text-gray-500 text-center mt-6">
      <p>
        By signing in or creating an account, you agree with our
        <a href="#" class="text-blue-600 underline">Terms & conditions</a> and
        <a href="#" class="text-blue-600 underline">Privacy statement</a>.
      </p>
      <p class="mt-4">© 2006 – 2025 Booking.com™</p>
    </div>
  </div>

</body>
</html>
