<!-- resources/views/wizard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alternative Places</title>
     <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('wizardForm', () => ({
                category: '',
                step: 0,

                selectCategory(cat) {
                    this.category = cat;
                },

                continueWizard() {
                    if (this.category !== '') this.step = 1;
                },

                nextStep() {
                    if (this.step < 2) this.step++;
                },

                previousStep() {
                    if (this.step > 1) this.step--;
                }
            }));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Vite assets (optional for Laravel Mix setup) -->
  @vite(['resources/js/app.js'])
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
</head>
<body class="bg-white">
     <!-- Header -->
  <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
          <!-- Logo -->
          <div class="w-full md:w-auto md:ml-6">
            <a href="/" class="text-2xl font-bold font-poppins">Bookintour.com</a>
          </div>

          <!-- Right Section -->
          <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
            <!-- Help Icon -->
            <a href="/help" title="Help">
              <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            </a>

            <!-- Language Button -->
            <button
              id="language-button"
              type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language"
            >
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
            </button>

            <!-- Language Modal -->
            <div
              id="language-modal"
              class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50"
            >
              <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                <!-- Modal Header -->
                <div class="flex items-start justify-between">
                  <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                  <button
                    type="button"
                    class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                  >
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>

                <!-- Modal Body -->
                <div class="mt-4">
                  <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                  <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)" class="h-5 w-5" />
                      <span>English (UK)</span>
                    </button>
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="h-5 w-5" />
                      <span>Deutsch</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>


<div x-data="wizardForm()" class=" mt-16 px-4 ">

    <!-- Step 0: Category Selection -->
    <template x-if="step === 0">
        <div>
            <h2 class="text-2xl font-bold mb-4">From the list below, which property category is most similar to your place?</h2>
 <div class="max-w-4x   sm:px-6 lg:ml-32">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-4xl">
                <template x-for="option in ['campsite', 'hotel', 'homestay']" :key="option">
                    <div
                        @click="selectCategory(option)"
                        :class="category === option ? 'border-blue-600 border-2 bg-blue-50' : 'border border-gray-300'"
                        class="relative cursor-pointer p-4 rounded-lg text-center transition duration-200 hover:border-blue-400"
                    >
                        <span class="capitalize text-lg font-semibold" x-text="option"></span>
                        <template x-if="category === option">
                            <span class="absolute top-2 right-2 text-green-600">
                                <i data-feather="check-circle"></i>
                            </span>
                        </template>
                    </div>
                </template>
            </div>

            <div class="mt-6">
                <button
                    @click="continueWizard"
                    :disabled="!category"
                    class="w-full py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 disabled:bg-gray-400"
                >
                    Continue
                </button>
            </div>
        </div>
    </template>

    <!-- Steps 1 & 2 -->
    <template x-if="step > 0">
        <div>
            <p class="capitalize text-gray-600 font-medium mb-2" x-text="category.charAt(0).toUpperCase() + category.slice(1) + ' - Step ' + step + '/2'"></p>

            <!-- Step 1 content -->
            <template x-if="step === 1">
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-gray-700">Name</span>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter name">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Email</span>
                        <input type="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter email">
                    </label>
                </div>
            </template>

            <!-- Step 2 content -->
            <template x-if="step === 2">
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-gray-700">Location</span>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter location">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Description</span>
                        <textarea class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4" placeholder="Describe..."></textarea>
                    </label>
                </div>
            </template>

            <!-- Navigation buttons -->
            <div class="mt-6 flex justify-between">
                <button
                    @click="previousStep"
                    :disabled="step === 1"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 disabled:opacity-50"
                >
                    Back
                </button>

                <template x-if="step < 2">
                    <button
                        @click="nextStep"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    >
                        Next
                    </button>
                </template>

                <template x-if="step === 2">
                    <button
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                    >
                        Submit
                    </button>
                </template>
            </div>
        </div>
    </template>
</div>
</body>
</html>
