<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
 {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
</head>

<body class="bg-white text-gray-800">
  <!-- HEADER -->
  <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
          <div class="w-full md:w-auto">
            <div class="flex flex-col items-start space-y-2">
              <h1 class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
              <div id="promo-box" class="bg-green-500 text-white px-4 py-2 rounded flex items-start justify-between w-full max-w-sm">
                <span class="text-sm">We offer special discounts this season!</span>
                <button onclick="document.getElementById('promo-box').classList.add('hidden')" class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
              </div>
            </div>
          </div>
          <div class="flex items-center space-x-4 flex-wrap">
            <button id="language-button" type="button" class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
            </button>
            <div id="language-modal" class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
              <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-start justify-between">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Select your language</h3>
                  <button type="button" class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <div class="mt-4">
                  <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                  <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                      <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" alt="English (UK)" class="h-5 w-5" />
                      <span>English (UK)</span>
                    </button>
                    <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg" alt="Deutsch" class="h-5 w-5" />
                      <span>Deutsch</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#" class="hover:underline font-sans">Already a partner?</a>
            <a href="#" class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">Sign in</a>
            <a href="#" class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">Help</a>
          </div>
        </div>
      </div>
    </section>
  </header>

  <!-- BODY -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ tab: 'personal' }">
    <div class="flex flex-row">
      <!-- Sidebar -->
      <aside class="w-full max-w-sm bg-white rounded-lg border border-gray-200 p-3 space-y-1">
        <button @click="tab = 'personal'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white border-b border-gray-200 rounded-t-lg hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'personal' }">
          <img :src="tab === 'personal' ? '{{ asset('assets/blue-B.svg') }}' : '{{ asset('assets/circum_user (2).svg') }}'" alt="Personal" class="w-6 h-6 mr-3" />
          Personal details
        </button>
        <button @click="tab = 'security'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white border-b border-gray-200 hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'security' }">
          <img :src="tab === 'security' ? '{{ asset('assets/lock-blue-B.svg') }}' : '{{ asset('assets/lock-B.svg') }}'" alt="Security" class="w-6 h-6 mr-3" />
          Security settings
        </button>
        <button @click="tab = 'travellers'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white border-b border-gray-200 hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'travellers' }">
          <img :src="tab === 'travellers' ? '{{ asset('assets/blue-E.svg') }}' : '{{ asset('assets/ph_users-three-light (3).svg') }}'" alt="Travellers" class="w-6 h-6 mr-3" />
          Other travellers
        </button>
        <button @click="tab = 'customisation'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white border-b border-gray-200 hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'customisation' }">
          <img :src="tab === 'customisation' ? '{{ asset('assets/blue-D.svg') }}' : '{{ asset('assets/codicon_settings (1).svg') }}'" alt="Customisation" class="w-6 h-6 mr-3" />
          Customisation preferences
        </button>
        <button @click="tab = 'payment'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white border-b border-gray-200 hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'payment' }">
          <img :src="tab === 'payment' ? '{{ asset('assets/blue-C.svg') }}' : '{{ asset('assets/stash_credit-card-light (1).svg') }}'" alt="Payment" class="w-6 h-6 mr-3" />
          Payment methods
        </button>
        <button @click="tab = 'privacy'" class="flex items-center w-full px-4 py-3 text-sm font-medium bg-white rounded-b-lg hover:bg-gray-100" :class="{ 'text-blue-600 font-semibold': tab === 'privacy' }">
          <img :src="tab === 'privacy' ? '{{ asset('assets/blue-A.svg') }}' : '{{ asset('assets/material-symbols-light_privacy-tip-outline (1).svg') }}'" alt="Privacy" class="w-6 h-6 mr-3" />
          Privacy and data management
        </button>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 bg-white py-2 px-6 space-y-8 mb-6">
 <section 
  x-data="{
    editing: null,
    phoneFlag: 'https://flagcdn.com/w40/lk.png',
    completed: {
      name: '',
      displayName: '',
      emailAddress: '',
      phone: '',
      dob: '',
      nationality: '',
      gender: '',
      address: '',
      passport: ''
    }
  }"
  x-show="tab === 'personal'"
  x-cloak
>
  <div class="flex items-center justify-between mb-6">
  <!-- Left: Title and description -->
  <div>
    <h2 class="text-2xl font-bold">Personal details</h2>
    <p class="text-gray-600 mt-1" style="font-family: 'Noto Sans', sans-serif;">
      Update your information and find out how it's used
    </p>
  </div>

   <!-- Right: Profile Picture + Camera Upload Button -->
  <div class="relative w-16 h-16">
    <!-- Profile Image -->
    <img src="https://via.placeholder.com/100" alt="Profile" class="w-full h-full rounded-full object-cover border" />

    <!-- Camera Button -->
    <label for="profile-upload" class="absolute bottom-0 right-0 bg-white border rounded-full p-1 shadow cursor-pointer hover:bg-gray-100">
       <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Stay" class="w-3 h-3" />
      <input type="file" id="profile-upload" class="hidden" />
    </label>
  </div>
</div>


  <template x-for="(section, index) in Object.keys(completed)" :key="section">
    <div class="border-t pt-4 min-h-[100px] flex flex-col justify-center">
      <div class="flex justify-between items-start md:items-center">
        <div>
          <h3 class="text-sm font-bold text-gray-700" x-text="{
            name: 'Name',
            displayName: 'Display Name',
            emailAddress: 'Email Address',
            phone: 'Phone Number',
            dob: 'Date of Birth',
            nationality: 'Nationality',
            gender: 'Gender',
            address: 'Address',
            passport: 'Passport Details'
          }[section]"></h3>

          <!-- EMAIL -->
          <template x-if="section === 'emailAddress' && editing !== 'emailAddress'">
            <div class="mt-1 space-y-1">
              <div class="flex items-center space-x-2">
                <span class="text-sm text-blue-600" x-text="completed.emailAddress || 'someone@example.com'"></span>
                <span class="bg-green-500 text-white text-xs px-2 py-0.5 rounded">Verified</span>
              </div>
              <p class="text-sm text-gray-500">This is the email address you use to sign in. It’s also where we send your booking confirmations.</p>
            </div>
          </template>

          <!-- PHONE -->
          <template x-if="section === 'phone' && editing !== 'phone'">
            <div class="mt-1 space-y-1">
              <div class="flex items-center space-x-2">
                <span class="text-sm text-blue-600" x-text="completed.phone || '+94XXXXXXX'"></span>
                <span class="bg-green-500 text-white text-xs px-2 py-0.5 rounded">Verified</span>
              </div>
            </div>
          </template>

          <!-- GENERAL DISPLAY OR HINT TEXT -->
          <template x-if="section !== 'emailAddress' && section !== 'phone' && editing !== section">
            <p class="text-sm mt-1" :class="completed[section] ? 'text-gray-900 font-medium' : 'text-gray-500'" x-text="
              completed[section] 
                ? completed[section] 
                : {
                    name: 'Enter your full legal name.',
                    displayName: 'This name is shown when you leave reviews or messages.',
                    dob: 'Enter your date of birth.',
                    nationality: 'Select the country/region you\'re from.',
                    gender: 'Select your gender.',
                    address: 'Add your address.',
                    passport: 'Add your passport details.'
                  }[section]
            "></p>
          </template>
        </div>

        <button class="text-blue-600 hover:underline text-sm" @click="editing = section">Edit</button>
      </div>

      <!-- Input Form Fields -->
      <div x-show="editing === section" class="mt-1 mb-4 space-y-2">
   <template x-if="section === 'name'">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input 
      type="text" 
      placeholder="First name(s)" 
      class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm" 
      x-ref="firstNameInput" 
    />
    <input 
      type="text" 
      placeholder="Last name(s)" 
      class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm" 
      x-ref="lastNameInput" 
    />
  </div>
</template>



       <template x-if="section === 'displayName'">
  <input
    type="text"
    x-model="completed.displayName"
    placeholder="Choose a display name"
    class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm"
    x-ref="input1"
  />
</template>

       <template x-if="section === 'emailAddress'">
  <input 
    type="email" 
    placeholder="Email address" 
    class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm" 
    x-ref="emailInput" 
  />
</template>


    <template x-if="section === 'phone'">
  <div class="space-y-2">
    <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
      <!-- Flag Image -->
      <img :src="phoneFlag" alt="Flag" class="w-6 h-4 rounded" />

      <!-- Country Code Dropdown -->
      <select
        x-ref="countryCode"
        @change="phoneFlag = $event.target.options[$event.target.selectedIndex].dataset.flag"
        class="bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
      >
        <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
        <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
        <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
        <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
      </select>

      <!-- Phone Input -->
      <input
        type="tel"
        placeholder="Enter phone number"
        class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm"
        x-ref="phoneInput"
      />
    </div>
  </div>
</template>

<!-- Script to Update Flag Image Dynamically -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("country-select");
    const flagImg = document.getElementById("selected-flag");

    if (select && flagImg) {
      select.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const flagUrl = selectedOption.getAttribute("data-flag");
        flagImg.src = flagUrl;
      });
    }
  });
</script>
        <!-- DOB -->
<template x-if="section === 'dob'">
  <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm" x-ref="dobInput" />
</template>

<!-- Nationality -->
<template x-if="section === 'nationality'">
  <select class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm" x-ref="nationalityInput">
    <option value="">Select your nationality</option>
    <option value="Sri Lankan">Sri Lankan</option>
    <option value="American">American</option>
    <option value="British">British</option>
  </select>
</template>

      <template x-if="section === 'gender'">
  <select
    class="w-full border border-gray-300 rounded-md px-3 py-3 text-sm"
    x-ref="genderInput"
  >
    <option value="">Select your gender</option>
    <option value="Female">Female</option>
    <option value="Male">Male</option>
    <option value="Other">Other</option>
  </select>
</template>

        <template x-if="section === 'address'">
          <div class="space-y-3">
            <!-- Country / Region -->
            <div>
              <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country/region</label>
              <select id="country" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="country">
                <option value="">Select the country/region you live in</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="United States">United States</option>
                <option value="United Kingdom">United Kingdom</option>
              </select>
            </div>

            <!-- Street -->
            <div>
              <label for="street" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
              <input id="street" type="text" placeholder="Street name" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="street" />
            </div>

            <!-- City & Postcode -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Town/City</label>
                <input id="city" type="text" placeholder="City" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="city" />
              </div>
              <div>
                <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">Postcode</label>
                <input id="postcode" type="text" placeholder="Postcode" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="postcode" />
              </div>
            </div>
          </div>
        </template>

        <template x-if="section === 'passport'">
          <div class="space-y-4">
            <!-- Names -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First name(s) <span class="text-red-500">*</span></label>
                <input type="text" placeholder="First name(s)" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportFirstName" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last name(s) <span class="text-red-500">*</span></label>
                <input type="text" placeholder="Last name(s)" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportLastName" />
              </div>
            </div>
            <p class="text-xs text-gray-500">Please enter the name exactly as written on the passport or other official travel document.</p>

            <!-- Issuing Country and Passport Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Issuing country <span class="text-red-500">*</span></label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportIssuingCountry">
                  <option value="">Select issuing country</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="United States">United States</option>
                  <option value="United Kingdom">United Kingdom</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Passport number <span class="text-red-500">*</span></label>
                <input type="text" placeholder="Enter document number" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportNumber" />
              </div>
            </div>

            <!-- Expiry Date -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Expiry date <span class="text-red-500">*</span></label>
              <div class="grid grid-cols-3 gap-2">
                <input type="text" placeholder="DD" maxlength="2" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportExpiryDay" />
                <input type="text" placeholder="MM" maxlength="2" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportExpiryMonth" />
                <input type="text" placeholder="YYYY" maxlength="4" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" x-ref="passportExpiryYear" />
              </div>
              <p class="text-xs text-gray-500 mt-1">
                We'll safely store this data and remove it after two years of inactivity.
              </p>
            </div>

            <!-- Consent Checkbox -->
            <div class="flex items-start space-x-2">
              <input type="checkbox" id="consent" class="mt-1 border-gray-300 rounded" x-ref="passportConsent" />
              <label for="consent" class="text-sm text-gray-700">
                I consent to Booking.com storing my passport information in accordance with the
                <a href="#" class="text-blue-600 hover:underline">privacy statement</a>
              </label>
            </div>
          </div>
        </template>

          <!-- Save & Cancel -->
        <div class="flex justify-end space-x-4 mt-2">
          <button @click="editing = null" class="text-blue-600 hover:underline text-sm">Cancel</button>
          <button
 @click="
if (section === 'name') {
  const first = $refs.firstNameInput?.value || '';
  const last = $refs.lastNameInput?.value || '';
  completed.name = [first, last].filter(Boolean).join(' ');
} else if (section === 'address') {
    completed.address = 
      [$refs.country?.value, $refs.street?.value, $refs.city?.value, $refs.postcode?.value]
      .filter(Boolean).join(', ');
  } else if (section === 'passport') {
    completed.passport = 
      [
        $refs.passportFirstName?.value,
        $refs.passportLastName?.value,
        $refs.passportIssuingCountry?.value,
        $refs.passportNumber?.value,
        ($refs.passportExpiryDay?.value && $refs.passportExpiryMonth?.value && $refs.passportExpiryYear?.value) 
          ? `Expires: ${$refs.passportExpiryDay.value}/${$refs.passportExpiryMonth.value}/${$refs.passportExpiryYear.value}` 
          : ''
      ].filter(Boolean).join(' | ');
  } else if (section === 'phone') {
    completed.phone = ($refs.countryCode?.value || '') + ' ' + ($refs.phoneInput?.value || '');
  } else if (section === 'dob') {
    completed.dob = $refs.dobInput?.value || '';
  } else if (section === 'nationality') {
    completed.nationality = $refs.nationalityInput?.value || '';
  } else if (section === 'gender') {
    completed.gender = $refs.genderInput?.value || '';
  }
    else if (section === 'emailAddress') {
  completed.emailAddress = $refs.emailInput?.value || '';
}

  editing = null;
"


            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </template>
</section>




<!-- Script to Update Flag Image Dynamically -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("country-select");
    const flagImg = document.getElementById("selected-flag");

    if (select && flagImg) {
      select.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const flagUrl = selectedOption.getAttribute("data-flag");
        flagImg.src = flagUrl;
      });
    }
  });
</script>



        <section x-show="tab === 'security'" x-cloak>
          <h2 class="text-xl font-bold">Security settings</h2>
        </section>
        <section x-show="tab === 'travellers'" x-cloak>
          <h2 class="text-xl font-bold">Other travellers</h2>
        </section>
        <section x-show="tab === 'customisation'" x-cloak>
          <h2 class="text-xl font-bold">Customisation preferences</h2>
        </section>
        <section x-show="tab === 'payment'" x-cloak>
          <h2 class="text-xl font-bold">Payment methods</h2>
        </section>
        <section x-show="tab === 'privacy'" x-cloak>
          <h2 class="text-xl font-bold">Privacy and data management</h2>
        </section>
      </main>
    </div>
  </div>
  <!-- FOOTER -->
<footer class="bg-gray-100 mt-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-600">
    <div class="space-x-3 mb-2">
      <a href="#" class="hover:underline">About Booking.com</a>
      <span class="text-gray-400">·</span>
      <a href="#" class="hover:underline">Terms & Conditions</a>
      <span class="text-gray-400">·</span>
      <a href="#" class="hover:underline">How we work</a>
      <span class="text-gray-400">·</span>
      <a href="#" class="hover:underline">Privacy & Cookie Statement</a>
      <span class="text-gray-400">·</span>
      <a href="#" class="hover:underline">Help Centre</a>
    </div>
    <p class="text-xs text-gray-500">&copy; 1996–2025 Bookintour.com™. All rights reserved.</p>
  </div>
</footer>

</body>
</html>