@extends('frontend.carrental-layout')

@section('title', ' Company Registration | ' . config('domains.app_name'))

@section('content')


  <!-- Company Registration Form -->
<main
  class="container mx-auto mt-16 px-4 sm:px-6 lg:px-8 max-w-xl bg-white border border-gray-200 shadow-md rounded-md p-6">
  <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Company Registration</h2>
  <p class="text-sm text-gray-600 mb-6" style="font-family: 'Noto Sans', sans-serif;">
    Please provide your company details to register your {{ config('domains.domain') }} account.
  </p>

  <form>
    <!-- Company Logo -->
    <div class="mb-4">
      <label for="logo" class="block text-sm font-medium text-gray-800">Company Logo</label>
      <input type="file" id="logo" name="logo" accept="image/png, image/jpeg"
        class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      <p class="text-xs text-gray-500 mt-1">Upload PNG or JPG format only.</p>
    </div>

    <!-- Company Name -->
    <div class="mb-4">
      <label for="company-name" class="block text-sm font-medium text-gray-800">Company Name<span
          class="text-red-500">*</span></label>
      <input type="text" id="company-name" name="company-name" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Business Registration Number -->
    <div class="mb-4">
      <label for="business-reg" class="block text-sm font-medium text-gray-800">Business Registration Number</label>
      <input type="text" id="business-reg" name="business-reg"
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Company Email -->
    <div class="mb-4">
      <label for="company-email" class="block text-sm font-medium text-gray-800">Company Email<span
          class="text-red-500">*</span></label>
      <input type="email" id="company-email" name="company-email" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Phone Number with Country Flag -->
    <div class="mb-4">
      <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number<span
          class="text-red-500">*</span></label>
      <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
        <!-- Flag Image -->
        <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag" class="w-6 h-4 rounded" />

        <!-- Country Code Select -->
        <select id="country-select"
          class="bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
          <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
          <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
          <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
          <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
        </select>

        <!-- Phone Number Input -->
        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required
          class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
      </div>
    </div>

    <!-- Address -->
    <div class="mb-4">
      <label for="address" class="block text-sm font-medium text-gray-800">Company Address</label>
      <textarea id="address" name="address" rows="2"
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
    </div>

   

    <!-- Submit Button -->
    <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700"
      style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
      Register
    </button>
  </form>

  <!-- Terms -->
  <div class="text-xs text-gray-500 text-center mt-6">
    <p>
      By creating an account, you agree with our
      <a href="#" class="text-blue-600 underline">Terms &amp; conditions</a> and
      <a href="#" class="text-blue-600 underline">Privacy statement</a>.
    </p>
    <p class="mt-4">© 2006 – 2025 {{ config('domains.domain') }}™</p>
  </div>
</main>

<!-- Script for Flag Switching -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const countrySelect = document.getElementById('country-select');
    const selectedFlag = document.getElementById('selected-flag');

    countrySelect.addEventListener('change', () => {
      const selectedOption = countrySelect.options[countrySelect.selectedIndex];
      const flagUrl = selectedOption.getAttribute('data-flag');
      if (flagUrl) selectedFlag.src = flagUrl;
    });
  });
</script>

@endsection