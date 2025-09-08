@extends('frontend.carrental-layout')

@section('title', ' Registration | ' . config('domains.app_name'))

@section('content')

<main class="container mx-auto mt-6 px-4 sm:px-6 lg:px-8 max-w-xl bg-white border border-gray-200 shadow-md rounded-md p-6">

  <h2 class="text-xl font-semibold mb-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
    Register Your Account
  </h2>

  <!-- Alerts -->
  @if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm" role="alert">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
      {{ session('error') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
      <ul class="mb-0 pl-4 list-disc">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Toggle -->
  <div class="flex justify-center items-center space-x-6 mb-8">
    <label class="flex items-center space-x-2">
      <input type="radio" name="reg_type" value="company" checked class="text-blue-600 focus:ring-blue-500" />
      <span class="text-gray-800 text-sm font-medium">Company Registration</span>
    </label>
    <label class="flex items-center space-x-2">
      <input type="radio" name="reg_type" value="individual" class="text-blue-600 focus:ring-blue-500" />
      <span class="text-gray-800 text-sm font-medium">Individual Registration</span>
    </label>
  </div>

  <!-- Company Registration Form -->
  <form id="company-form" action="{{ route('car_renter.register.company.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <h3 class="text-base font-semibold mb-2">Company Registration</h3>
    <p class="text-sm text-gray-600 mb-4">Please provide your company details to register your {{ config('domains.domain') }} account.</p>

    <div>
      <label for="logo" class="block text-sm font-medium text-gray-800">Company Logo <span class="text-red-500">*</span></label>
      <input type="file" id="logo" name="logo" accept="image/png, image/jpeg" class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md px-3 py-2" />
      <p class="text-xs text-gray-500 mt-1">Upload PNG or JPG format only.</p>
    </div>

    <div>
      <label for="company_name" class="block text-sm font-medium text-gray-800">Company Name <span class="text-red-500">*</span></label>
      <input type="text" id="company_name" name="company_name" required class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="business_reg" class="block text-sm font-medium text-gray-800">Business Registration Number <span class="text-red-500">*</span></label>
      <input type="text" id="business_reg" name="business_reg" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="tin_no" class="block text-sm font-medium text-gray-800">Tin Number</label>
      <input type="text" id="business_reg" name="business_reg" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="company_email" class="block text-sm font-medium text-gray-800">Company Email <span class="text-red-500">*</span></label>
      <input type="email" id="company_email" name="company_email" required class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
      <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
        <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag" class="w-6 h-4 rounded" />
        <select id="country-select" class="bg-white border border-gray-300 rounded-md px-2 py-1">
          <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
          <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
          <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
          <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
        </select>
        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required class="flex-1 outline-none border-none" />
      </div>
    </div>

    <div>
      <label for="address" class="block text-sm font-medium text-gray-800">Company Address <span class="text-red-500">*</span></label>
      <textarea id="address" name="address" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
    </div>

    <button type="submit" class="w-full text-white py-2 rounded font-semibold" style="background-color:#3CC0E9;">Register Company</button>
  </form>

  <!-- Individual Registration Form -->
  <form id="individual-form" action="{{ route('car_renter.register.individual.store') }}" method="POST" class="space-y-4 hidden">
    @csrf
    <h3 class="text-base font-semibold mb-2">Individual Registration</h3>
    <p class="text-sm text-gray-600 mb-4">Please provide your details to register as an individual.</p>

    <div>
      <label for="full_name" class="block text-sm font-medium text-gray-800">Full Name <span class="text-red-500">*</span></label>
      <input type="text" id="full_name" name="full_name" required class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="individual_email" class="block text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
      <input type="email" id="individual_email" name="individual_email" required class="mt-1 block w-full border border-blue-500 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="individual_phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number 1 <span class="text-red-500">*</span></label>
      <input type="tel" id="individual_phone" name="individual_phone" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

      <div>
      <label for="individual_phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number 2<span class="text-red-500">*</span></label>
      <input type="tel" id="individual_phone" name="individual_phone" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

      <div>
      <label for="individual_phone2" class="block text-sm font-medium text-gray-800 mb-1">Phone number 2 <span class="text-red-500">*</span></label>
      <input type="tel" id="individual_phone2" name="individual_phone2" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="individual_nic" class="block text-sm font-medium text-gray-800 mb-1">NIC Number <span class="text-red-500">*</span></label>
      <input type="text" id="individual_nic" name="individual_nic" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
    </div>

    <div>
      <label for="individual_address" class="block text-sm font-medium text-gray-800">Address <span class="text-red-500">*</span></label>
      <textarea id="individual_address" name="individual_address" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
    </div>

    <button type="submit" class="w-full text-white py-2 rounded font-semibold" style="background-color:#3CC0E9;">Register Individual</button>
  </form>

  <div class="text-xs text-gray-500 text-center mt-6">
    <p>By creating an account, you agree with our <a href="#" class="text-blue-600 underline">Terms &amp; conditions</a> and <a href="#" class="text-blue-600 underline">Privacy statement</a>.</p>
    <p class="mt-4">© 2006 – 2025 {{ config('domains.domain') }}™</p>
  </div>
</main>

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

  const countrySelect = document.getElementById('country-select');
  const selectedFlag = document.getElementById('selected-flag');
  if (countrySelect && selectedFlag) {
    countrySelect.addEventListener('change', () => {
      const flagUrl = countrySelect.options[countrySelect.selectedIndex].getAttribute('data-flag');
      if (flagUrl) selectedFlag.src = flagUrl;
    });
  }
});
</script>

@endsection
