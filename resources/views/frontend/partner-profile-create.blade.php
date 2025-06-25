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
  @vite('resources/css/app.css')
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
      <main class="flex-1 bg-white p-6 space-y-8">
        <section x-show="tab === 'personal'" x-cloak>
          <h2 class="text-xl font-bold">Personal details</h2>
        </section>
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
</body>
</html>
