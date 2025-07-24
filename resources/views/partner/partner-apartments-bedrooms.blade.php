<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create apartment</title></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <!-- Vite assets (optional for Laravel Mix setup) -->
  @vite(['resources/js/app.js'])
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 text-gray-800">
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
 <!-- Horizontal Layout Container -->
<div x-data="{
    beds: {{ json_encode($bedTypes->map(fn($bed) => ['id' => $bed->id, 'name' => $bed->name, 'count' => 0])) }},
    showMoreBeds: false,
    isLoading: false,
    increment(bedId) {
        const bed = this.beds.find(b => b.id === bedId);
        if (bed) {
            bed.count++;
        }
    },
    decrement(bedId) {
        const bed = this.beds.find(b => b.id === bedId);
        if (bed && bed.count > 0) {
            bed.count--;
        }
    },
    async save() {
        this.isLoading = true;
        const payload = {
            room_name: 'Bedroom 1', // Or make this dynamic if needed
            beds: this.beds.filter(b => b.count > 0)
        };
        try {
            let res = await fetch('{{ route('partner.property.bedroom.store', $property) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify(payload)
            });
            let data = await res.json();
            if (res.ok && data.success) {
                window.location.href = '{{ route('partner.property.step2', ['category' => 'apartment', 'property' => $property->id]) }}';
            } else {
                alert('Error: ' + (data.message || 'Could not save bedroom.'));
            }
        } catch (err) {
            alert('AJAX error: ' + err.message);
        } finally {
            this.isLoading = false;
        }
    }
}" class="max-w-3xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
<h2 class="text-3xl font-bold text-gray-900 mt-8">Bedroom 1</h2>
  <!-- Bed Types Container (2/3 width) -->
<div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ">
  <label class="block font-medium text-gray-700 mb-2">Which beds are available in this room?</label>

 @php
    $mainBeds = $bedTypes->take(4);
    $extraBeds = $bedTypes->slice(4);
@endphp


@foreach ($mainBeds as $bed)
  <div class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/famicons_bed.svg') }}" alt="Icon" class="w-5 h-5" />
      <div>
        <p class="text-sm font-medium">{{ $bed->name }}</p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" @click="decrement({{ $bed->id }})"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="beds.find(b => b.id === {{ $bed->id }}).count"></span>
      <button type="button" @click="increment({{ $bed->id }})"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
    </div>
  </div>
@endforeach

<!-- Toggle Link -->
<button type="button"
        @click="showMoreBeds = !showMoreBeds"
        class="text-sm text-blue-600 hover:underline focus:outline-none">
  <span x-show="!showMoreBeds">More bed options ▼</span>
  <span x-show="showMoreBeds">Fewer bed options ▲</span>
</button>

<!-- Extra Beds -->
<div x-show="showMoreBeds"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 max-h-0"
     x-transition:enter-end="opacity-100 max-h-screen"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 max-h-screen"
     x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
     class="space-y-4 pt-2">
  @foreach ($extraBeds as $bed)
    <div class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
      <div class="flex items-start gap-2">
        <img src="{{ asset('assets/famicons_bed.svg') }}" alt="Icon" class="w-5 h-5" />
        <div>
          <p class="text-sm font-medium">{{ $bed->name }}</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <button type="button" @click="decrement({{ $bed->id }})"
                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
        <span class="mx-4 text-sm font-semibold" x-text="beds.find(b => b.id === {{ $bed->id }}).count"></span>
        <button type="button" @click="increment({{ $bed->id }})"
                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
      </div>
    </div>
  @endforeach
</div>

  </div>

  
</div>
<div class="mt-8 flex justify-between items-center">
  <a href="{{ url('/partner/property/apartment/step2/' . $property->id) }}">
    <!-- Back Button -->
    <button type="button" class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
    </button>
  </a>

  <!-- Continue Button slightly aligned to the left -->
  <div class="pr-40"> <!-- This padding pulls it slightly to the left -->
    
   
    <button
      type="button"
      @click="save"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
    >
      Save and Continue
    </button>
    
  </div>
</div>




    </body>
    </html>