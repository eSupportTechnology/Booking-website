@extends('frontend.carrental-layout')

@section('title', ' Registration | ' . config('domains.app_name'))

@section('content')

<main class="container mx-auto mt-6 px-4 sm:px-6 lg:px-8 max-w-xl bg-white border border-gray-200 shadow-md rounded-md p-6">

  <!-- Registration Option Selection -->
<h2 class="text-xl font-semibold mb-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
  Register Your Account
</h2>

<div class="flex justify-center items-center space-x-6 mb-8">
  <label class="flex items-center space-x-2">
    <input type="radio" name="reg_type" value="company" checked
      class="text-blue-600 focus:ring-blue-500" />
    <span class="text-gray-800 text-sm font-medium">Company Registration</span>
  </label>
  <label class="flex items-center space-x-2">
    <input type="radio" name="reg_type" value="individual"
      class="text-blue-600 focus:ring-blue-500" />
    <span class="text-gray-800 text-sm font-medium">Individual Registration</span>
  </label>
</div>


  <!-- Company Registration Form -->
  <form id="company-form" class="space-y-4">
    <h3 class="text-base font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Company Registration</h3>
    <p class="text-sm text-gray-600 mb-4">Please provide your company details to register your {{ config('domains.domain') }} account.</p>

    <!-- Company Logo -->
    <div>
      <label for="logo" class="block text-sm font-medium text-gray-800">Company Logo</label>
      <input type="file" id="logo" name="logo" accept="image/png, image/jpeg"
        class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      <p class="text-xs text-gray-500 mt-1">Upload PNG or JPG format only.</p>
    </div>

    <!-- Company Name -->
    <div>
      <label for="company-name" class="block text-sm font-medium text-gray-800">Company Name <span class="text-red-500">*</span></label>
      <input type="text" id="company-name" name="company-name" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Business Registration Number -->
    <div>
      <label for="business-reg" class="block text-sm font-medium text-gray-800">Business Registration Number</label>
      <input type="text" id="business-reg" name="business-reg"
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Company Email -->
    <div>
      <label for="company-email" class="block text-sm font-medium text-gray-800">Company Email <span class="text-red-500">*</span></label>
      <input type="email" id="company-email" name="company-email" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Phone Number -->
    <div>
      <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
      <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
        <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag" class="w-6 h-4 rounded" />
        <select id="country-select"
          class="bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
          <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
          <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
          <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
          <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
        </select>
        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required
          class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
      </div>
    </div>

    <!-- Address -->
    <div>
      <label for="address" class="block text-sm font-medium text-gray-800">Company Address</label>
      <textarea id="address" name="address" rows="2"
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 font-semibold"
      style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">Register Company</button>
  </form>

  <!-- Individual Registration Form -->
  <form id="individual-form" class="space-y-4 hidden">
    <h3 class="text-base font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Individual Registration</h3>
    <p class="text-sm text-gray-600 mb-4">Please provide your details to register as an individual.</p>

    <!-- Full Name -->
    <div>
      <label for="full-name" class="block text-sm font-medium text-gray-800">Full Name <span class="text-red-500">*</span></label>
      <input type="text" id="full-name" name="full-name" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Email -->
    <div>
      <label for="individual-email" class="block text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
      <input type="email" id="individual-email" name="individual-email" required
        class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Phone Number -->
    <div>
      <label for="individual-phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
      <input type="tel" id="individual-phone" name="individual-phone" required
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>


    <!-- NIC Number -->
    <div>
      <label for="individual-nic" class="block text-sm font-medium text-gray-800 mb-1">NIC Number <span class="text-red-500">*</span></label>
      <input type="text" id="individual-nic" name="individual-nic" required
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
    </div>

    <!-- Address -->
    <div>
      <label for="individual-address" class="block text-sm font-medium text-gray-800">Address</label>
      <textarea id="individual-address" name="individual-address" rows="2"
        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 font-semibold"
      style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">Register Individual</button>
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

<!-- Script for switching forms and flags -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const regTypeRadios = document.querySelectorAll("input[name='reg_type']");
    const companyForm = document.getElementById("company-form");
    const individualForm = document.getElementById("individual-form");

    regTypeRadios.forEach(radio => {
      radio.addEventListener("change", () => {
        if (radio.value === "company") {
          companyForm.classList.remove("hidden");
          individualForm.classList.add("hidden");
        } else {
          individualForm.classList.remove("hidden");
          companyForm.classList.add("hidden");
        }
      });
    });

    // Flag Switching for company form
    const countrySelect = document.getElementById('country-select');
    const selectedFlag = document.getElementById('selected-flag');

    if (countrySelect && selectedFlag) {
      countrySelect.addEventListener('change', () => {
        const selectedOption = countrySelect.options[countrySelect.selectedIndex];
        const flagUrl = selectedOption.getAttribute('data-flag');
        if (flagUrl) selectedFlag.src = flagUrl;
      });
    }
  });
</script>

@endsection
