<!DOCTYPE html>
<html lang="en" x-data="{ step: 1, selectedBox: null }" xmlns:x-bind="http://www.w3.org/1999/xlink">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create homes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">

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

  <!-- Start Form -->
  <div class="max-w-6xl p-4 ml-14 bg-gray-100">

    <!-- Step 1: Main Form Step -->
    <form class="p-6 rounded-lg space-y-6" @submit.prevent>
    <div class="flex justify-between mb-6 text-sm font-medium hidden">
  <template x-for="n in 10" :key="n">
    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
      Step <span x-text="n"></span>
    </div>
  </template>
</div>


      <!-- Main Step 1 Content -->
<div x-show="step === 1" x-cloak>
  <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow mx-auto" x-data="{ selected: '' }">
    <h2 class="text-2xl font-bold text-center mb-6">What can guests book?</h2>

    <!-- Option 1 -->
    <label
      :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
      class="relative block rounded p-4 cursor-pointer transition bg-white mb-4"
      @click="selected = 'one'"
    >
      <!-- ✔ Tick -->
      <template x-if="selected === 'one'">
        <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
      </template>

      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="One Apartment" class="w-8 h-8" />
        <div>
          <span class="text-base font-bold text-gray-800">Entire place</span>
          <p class="text-xs text-gray-800">
            Guests are able to use the entire place and do not have to share this with the host or other guests.
          </p>
        </div>
      </div>
      <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
    </label>

    <!-- Option 2 -->
    <label
      :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
      class="relative block rounded p-4 cursor-pointer transition bg-white"
      @click="selected = 'multiple'"
    >
      <!-- ✔ Tick -->
      <template x-if="selected === 'multiple'">
        <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
      </template>

      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/accomm_private_room@2x.png') }}" alt="Multiple Apartments" class="w-8 h-8" />
        <div>
          <span class="text-base font-bold text-gray-800">A private room</span>
          <p class="text-xs text-gray-800">
            Guests rent a room within the property. There are common areas that are either shared with the host or other guests.
          </p>
        </div>
      </div>
      <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
    </label>

    <!-- Navigation Buttons -->
    <div class="flex items-center justify-between pt-4">
      <button
        type="button"
        @click="if(step > 1) step--"
        class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded"
        :disabled="step === 1"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : ''"
      >
        ←
      </button>
      <button
        type="button"
        @click="if(selected !== '') step = 2"
        class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"
        :disabled="selected === ''"
        :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''"
      >
        Continue
      </button>
    </div>
  </div>
</div>


      <!-- Step 2: Selection Container -->
      <div id="selection-container" x-show="step === 2" x-cloak class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-2xl font-bold mb-8 text-left">
          From the list below, which property category is most similar to your place?
        </h2>

        <div class="bg-white p-6 rounded-lg shadow">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Cards -->
            <template x-for="(property, index) in [
              { id: 'section-apartment', title: 'Apartment', desc: 'Furnished and self-catering accommodation available for short- and long-term rental' },
              { id: 'section-holiday-home', title: 'Holiday home', desc: 'Free-standing home with private, external entrance and rented specifically for holidays' },
              { id: 'section-villa', title: 'Villa', desc: 'Private self-standing and self-catering home with luxury feel' },
              { id: 'section-chalet', title: 'Chalet', desc: 'Free-standing home characterised by sloped roof and rented specifically for holidays' },
              { id: 'section-holiday-park', title: 'Holiday park', desc: 'Private self-catering residences located on shared grounds with shared facilities or recreational activities' },
              { id: 'section-aparthotel', title: 'Aparthotel', desc: 'A self-catering apartment with some hotel facilities like a reception desk' }
            ]" :key="index">
              <div
                @click="selectedBox = property.id"
                :class="selectedBox === property.id ? 'border-blue-500 bg-gray-100' : 'border border-gray-300'"
                class="relative rounded p-4 cursor-pointer transition-all duration-200"
              >
                <h3 class="text-base font-bold text-gray-800 mb-4" x-text="property.title"></h3>
                <p class="text-sm text-gray-800" x-text="property.desc"></p>

                <div
  class="tick-box absolute top-2 right-2"
  x-show="selectedBox === property.id"
>
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
  </svg>
</div>

              </div>
            </template>
          </div>
        </div>

        <!-- Help Link -->
        <div class="mt-8 text-left">
       <a href="#" class="flex items-center space-x-2 text-sm text-blue-500 hover:underline">
  <img src="{{ asset('assets/iconoir_question-mark-circle.svg') }}" class="w-5 h-5" />
  <span class="text-base">I don't see my property type on the list</span>
</a>

        </div>

             <template x-if="step === 2">
  <div class="flex items-center justify-between pt-4">
    <button type="button"
            @click="step = 1"
            class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
      ← 
    </button>
    <button id="continueBtn"
            @click="if(selectedBox) { step = 3; }"
            :disabled="!selectedBox"
            :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-blue-600 cursor-pointer'"
            class="px-4 py-2 text-white rounded transition-all duration-200"
            type="button">
      Continue 
    </button>
  </div>
</template>

     
      </div>

      <!-- Step 3+: Property Details Sections -->
      <template x-if="step === 3">
        <div>
          <!-- Apartment -->
          <section x-show="selectedBox === 'section-apartment'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Apartment Details</h3>
            <p>Details related to apartment...</p>
            <button
              type="button"
              @click="step = 2"
              class="mt-4 bg-gray-300 px-4 py-2 rounded"
            >
              Back
            </button>
          </section>

          <!-- Holiday Home -->
          <section x-show="selectedBox === 'section-holiday-home'"  x-data="{ subStep: 1 }">
            <form class="p-6 rounded-lg " enctype="multipart/form-data" @submit.prevent>
              <!-- Step 1 -->
             <div x-show="subStep === 1" x-cloak class="p-6 rounded">
  <!-- Main Content -->
  <div class="max-w-xl ml-4 mr-auto">
    <!-- White Box -->
    <div class="bg-white shadow-md  p-6 text-left">
      <p class=" text-base text-gray-700">
        Great, since your holiday homes are located at the same address there should be some things that apply to all of them. Let's start filling in those general settings.
      </p>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
      <button onclick="history.back()" class= "border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
        ← 
      </button>
      <button type="button" @click="subStep = 2"    class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
        Continue 
      </button>
    </div>
  </div>
</div>



             



              <!-- Step 2 -->
              <div x-show="subStep === 2" x-cloak >
 <div class="relative w-[1400px] h-auto overflow-hidden rounded-lg shadow mx-auto  -mt-14 -ml-16">


    <!-- Google Maps iframe full background -->
    <iframe 
        class="absolute inset-0 w-full h-full"
        loading="lazy"
        src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
        allowfullscreen>
    </iframe>

        <!-- Optional overlay for readability -->
        <div class="absolute inset-0 "></div>

        <!-- Form content centered on map -->
        <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
  <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Find your address</label>
                        <input type="text" id="address" name="address" value="Sri Lanka" class="mt-1 p-2 w-full border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment or floor number (optional)</label>
                        <input type="text" id="apartment" name="apartment" value="aaa" class="mt-1 p-2 w-full border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option selected>Sri Lanka</option>
                        </select>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                        <div class="flex-1">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                            <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <input id="update_address" type="checkbox" name="update_address" checked class="mr-2">
                        <label for="update_address" class="text-sm text-gray-700">Update the address when moving the pin on the map.</label>
                    </div>
                    <!-- Dismissible message box -->
<div x-data="{ showMessage: true }" x-show="showMessage" class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative" role="alert">
  <strong class="font-bold">Note:</strong>
  <span class="block sm:inline">Make sure the pin location is accurate before continuing.</span>
  <span @click="showMessage = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
    <svg class="fill-current h-6 w-6 text-yellow-800" role="button" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 20 20"><title>Close</title><path
        d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
  </span>
</div>

                    <p class="text-sm text-gray-600 mt-2">
                        Is the red pin location incorrect? Uncheck the option above and click or press on the map to move the pin.
                    </p>
                   <div class="flex justify-between mt-6">
  <!-- Back Button (Left) -->
   <button type="button"
        @click="subStep = 1"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
  

  <!-- Continue Button (Right) -->
  <button   type="submit"
   @click="subStep = 3"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>

                </form>
            </div>
        </div>
    </div>
</div>
              </div>
              <!-- Step 3 -->
              <div x-show="subStep === 3" x-cloak class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Step 3: Photos</h2>
                <input type="file" name="photos[]" multiple class="w-full border p-2 rounded" />
                <div class="flex justify-between mt-4">
                  <button type="button" @click="subStep = 2" class="bg-gray-300 px-4 py-2 rounded">Back</button>
                  <button type="button" @click="subStep = 4" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
                </div>
              </div>
              <!-- Step 4 -->
              <div x-show="subStep === 4" x-cloak class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Step 4: Pricing</h2>
                <input type="number" name="price" placeholder="Price per night" class="w-full border p-2 rounded" />
                <div class="flex justify-between mt-4">
                  <button type="button" @click="subStep = 3" class="bg-gray-300 px-4 py-2 rounded">Back</button>
                  <button type="button" @click="subStep = 5" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
                </div>
              </div>
              <!-- Step 5 -->
              <div x-show="subStep === 5" x-cloak class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Step 5: Availability</h2>
                <input type="date" name="available_from" class="w-full border p-2 rounded" />
                <div class="flex justify-between mt-4">
                  <button type="button" @click="subStep = 4" class="bg-gray-300 px-4 py-2 rounded">Back</button>
                  <button type="button" @click="subStep = 6" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
                </div>
              </div>
              <!-- Step 6 -->
              <div x-show="subStep === 6" x-cloak class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Step 6: Review & Submit</h2>
                <p class="text-gray-700 mb-4">Please review all details and click submit to finish.</p>
                <div class="flex justify-between mt-4">
                  <button type="button" @click="subStep = 5" class="bg-gray-300 px-4 py-2 rounded">Back</button>
                  <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit</button>
                </div>
              </div>
              <div class="mt-4">
                <button
                  type="button"
                  @click="step = 2"
                  class="bg-gray-300 px-4 py-2 rounded"
                >
                  Back to Selection
                </button>
              </div>
            </form>
          </section>

          <!-- Villa -->
          <section x-show="selectedBox === 'section-villa'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Villa Details</h3>
            <p>Details related to villa...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Chalet -->
          <section x-show="selectedBox === 'section-chalet'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Chalet Details</h3>
            <p>Details related to chalet...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Holiday Park -->
          <section x-show="selectedBox === 'section-holiday-park'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Holiday Park Details</h3>
            <p>Details related to holiday park...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Aparthotel -->
          <section x-show="selectedBox === 'section-aparthotel'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Aparthotel Details</h3>
            <p>Details related to aparthotel...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>
        </div>
      </template>
    </form>
  </div>

</body>
</html>
