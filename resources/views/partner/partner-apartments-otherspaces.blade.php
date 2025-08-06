@extends('partner.partner-layout')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create apartment</title></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js?v={{ time() }}" defer></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    console.log('Other spaces page script loaded');
    document.addEventListener('alpine:init', () => {
      console.log('Alpine.js initialized on other spaces page');
    });
    
    // Error handling
    window.addEventListener('error', function(e) {
      console.error('JavaScript error on other spaces page:', e.error);
    });
  </script>
  
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
<div x-data="{
  showMoreBeds: false,
  isLoading: false,
  saveAttempted: false,
  lastError: null,
  beds: [
    { id: 1, name: 'Twin', count: 0 },
    { id: 2, name: 'Full', count: 0 },
    { id: 3, name: 'Queen', count: 0 },
    { id: 4, name: 'King', count: 0 },
    { id: 5, name: 'Sofa Bed', count: 0 },
    { id: 6, name: 'Bunk Bed', count: 0 },
    { id: 7, name: 'Murphy Bed', count: 0 }
  ],
  
  init() {
    console.log('Other spaces Alpine.js data initialized');
    console.log('Initial beds:', this.beds);
  },
  
  async save() {
    console.log('=== OTHER SPACES SAVE FUNCTION START ===');
    this.isLoading = true;
    this.saveAttempted = true;
    this.lastError = null;
    
    try {
      const selectedBeds = this.beds.filter(b => b.count > 0);
      console.log('Selected beds:', selectedBeds);
      
      if (selectedBeds.length === 0) {
        const errorMsg = 'Please select at least one bed type.';
        console.log('Validation failed:', errorMsg);
        alert(errorMsg);
        return;
      }
      
      // Get wizard state from URL parameters
      const urlParams = new URLSearchParams(window.location.search);
      const wizardStateParam = urlParams.get('wizardState');
      let wizardState = null;
      
      if (wizardStateParam) {
        try {
          wizardState = JSON.parse(decodeURIComponent(wizardStateParam));
          console.log('Wizard state found:', wizardState);
        } catch (error) {
          console.error('Error parsing wizard state:', error);
        }
      }
      
      const payload = {
                  room_name: 'otherSpaces',
        beds: selectedBeds,
        source: '{{ request('source') }}',
        step: '{{ request('step') }}'
      };
      
      // Update wizard state with bed counts
      if (wizardState && wizardState.rooms) {
        if (!wizardState.rooms.otherSpaces) {
          wizardState.rooms.otherSpaces = { name: 'Other spaces', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 };
        }
        
        // Map bed types to wizard state fields
        this.beds.forEach(bed => {
          switch(bed.name) {
            case 'Twin':
              wizardState.rooms.otherSpaces.twin = bed.count;
              break;
            case 'Full':
              wizardState.rooms.otherSpaces.full = bed.count;
              break;
            case 'Queen':
              wizardState.rooms.otherSpaces.queen = bed.count;
              break;
            case 'King':
              wizardState.rooms.otherSpaces.king = bed.count;
              break;
            case 'Sofa Bed':
              wizardState.rooms.otherSpaces.sofa = bed.count;
              break;
            case 'Bunk Bed':
              wizardState.rooms.otherSpaces.bunk = bed.count;
              break;
            case 'Murphy Bed':
              wizardState.rooms.otherSpaces.futon = bed.count; // Map Murphy to futon
              break;
          }
        });
        
        console.log('Updated wizard state with bed counts:', wizardState.rooms.otherSpaces);
      }
      
      console.log('Prepared payload:', JSON.stringify(payload, null, 2));
      
      // Check if CSRF token exists
      const csrfToken = document.querySelector('meta[name=csrf-token]');
      if (!csrfToken) {
        throw new Error('CSRF token not found');
      }
      console.log('CSRF Token found:', csrfToken.content);
      
      // Make real API call
      let res = await fetch('http://127.0.0.1:8000/partner/property/bedroom/{{ $property->id ?? 116 }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify(payload)
      });
      
      console.log('Fetch request completed');
      console.log('Response status:', res.status);
      
      let data = await res.json();
      console.log('Response data:', data);
      
      if (res.ok && data.success) {
        console.log('Save successful, redirecting...');
        const source = '{{ request('source') }}';
        const step = '{{ request('step') }}';
        
        console.log('Source:', source, 'Step:', step);
        
        // Get wizard state from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const wizardStateParam = urlParams.get('wizardState');
        
        if (wizardStateParam) {
          try {
            const wizardState = JSON.parse(decodeURIComponent(wizardStateParam));
            console.log('Wizard state found:', wizardState);
            
            // Update the wizard state with the bed counts
            if (wizardState.rooms && wizardState.rooms.otherSpaces) {
              // Map bed types to wizard state fields
              this.beds.forEach(bed => {
                switch(bed.name) {
                  case 'Twin':
                    wizardState.rooms.otherSpaces.twin = bed.count;
                    break;
                  case 'Full':
                    wizardState.rooms.otherSpaces.full = bed.count;
                    break;
                  case 'Queen':
                    wizardState.rooms.otherSpaces.queen = bed.count;
                    break;
                  case 'King':
                    wizardState.rooms.otherSpaces.king = bed.count;
                    break;
                  case 'Sofa Bed':
                    wizardState.rooms.otherSpaces.sofa = bed.count;
                    break;
                  case 'Bunk Bed':
                    wizardState.rooms.otherSpaces.bunk = bed.count;
                    break;
                  case 'Murphy Bed':
                    wizardState.rooms.otherSpaces.futon = bed.count; // Map Murphy to futon
                    break;
                }
              });
              console.log('Updated wizard state with bed counts:', wizardState.rooms.otherSpaces);
            }
            
            // Navigate back to the original form with the updated wizard state
            const updatedWizardState = encodeURIComponent(JSON.stringify(wizardState));
            const returnUrl = `/partner-apartment-create-2?wizardState=${updatedWizardState}&step=${wizardState.step || 2}`;
            console.log('Redirecting to:', returnUrl);
            window.location.href = returnUrl;
          } catch (error) {
            console.error('Error parsing wizard state:', error);
            // Fallback to original logic
            if (source === 'multiple') {
              console.log('Redirecting to multiple apartment step 2');
              window.location.href = 'http://127.0.0.1:8000/partner/multiple-apartment-2/{{ $property->id ?? 116 }}';
            } else if (source === 'single') {
              console.log('Redirecting to single apartment step 2');
              window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id ?? 116 }}';
            } else {
              console.log('Fallback redirect to step 2');
              window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id ?? 116 }}';
            }
          }
        } else {
          // Fallback to original logic if no wizard state
          if (source === 'multiple') {
            console.log('Redirecting to multiple apartment step 2');
            window.location.href = 'http://127.0.0.1:8000/partner/multiple-apartment-2/{{ $property->id ?? 116 }}';
          } else if (source === 'single') {
            console.log('Redirecting to single apartment step 2');
            window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id ?? 116 }}';
          } else {
            console.log('Fallback redirect to step 2');
            window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id ?? 116 }}';
          }
        }
        
      } else {
        throw new Error(data.message || 'Could not save other space.');
      }
      
    } catch (err) {
      console.error('Save error:', err);
      this.lastError = err.message;
      alert('Error saving other space configuration: ' + err.message);
    } finally {
      console.log('=== OTHER SPACES SAVE FUNCTION END ===');
      this.isLoading = false;
    }
  },
  
  increment(bedId) {
    const bed = this.beds.find(b => b.id === bedId);
    if (bed) {
      bed.count++;
      console.log(`Incremented ${bed.name} to ${bed.count}`);
    }
  },
  
  decrement(bedId) {
    const bed = this.beds.find(b => b.id === bedId);
    if (bed && bed.count > 0) {
      bed.count--;
      console.log(`Decremented ${bed.name} to ${bed.count}`);
    }
  },
  
  get selectedBedsCount() {
    return this.beds.filter(b => b.count > 0).length;
  },
  
  get totalBeds() {
    return this.beds.reduce((sum, bed) => sum + bed.count, 0);
  }
}" class="max-w-2xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  <h2 class="text-3xl font-bold text-gray-900 mt-8">Other spaces</h2>

  <!-- Debug Info -->
  <!-- <div class="text-xs text-gray-500 mb-4 p-2 bg-gray-100 rounded">
    <div>Selected beds: <span x-text="selectedBedsCount"></span></div>
    <div>Total bed count: <span x-text="totalBeds"></span></div>
    <div>Loading: <span x-text="isLoading"></span></div>
    <div x-show="lastError" class="text-red-600 mt-1">
      Last error: <span x-text="lastError"></span>
    </div>
  </div> -->

  <!-- Test Button -->
  <!-- <button @click="console.log('Test button clicked'); alert('Alpine.js is working!')" 
          class="bg-green-500 text-white px-3 py-1 rounded text-xs mb-4 hover:bg-green-600">
      Test Alpine.js
  </button> -->

  <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
    <p class="text-lg font-medium text-gray-800 mb-4">Which beds are available in this room?</p>

    <!-- Bed Types Container -->
    <div class="space-y-4">
      <!-- Main Beds -->
      <template x-for="bed in beds.slice(0, 4)" :key="bed.id">
        <div class="flex items-center justify-between border rounded-md px-4 py-3 mb-3 hover:bg-gray-50">
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
              <path d="M4 11h16v2H4zm0 4h16v6H4v-6zm0-8h16v2H4V7z"/>
            </svg>
            <div>
              <p class="text-sm font-medium" x-text="bed.name"></p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <button type="button" 
                    @click="decrement(bed.id)"
                    class="w-8 h-8 flex items-center justify-center text-xl text-gray-600 hover:text-gray-800 hover:bg-gray-200 rounded-full focus:outline-none transition-colors">
              −
            </button>
            <span class="mx-2 text-sm font-semibold min-w-[20px] text-center" x-text="bed.count"></span>
            <button type="button" 
                    @click="increment(bed.id)"
                    class="w-8 h-8 flex items-center justify-center text-xl text-gray-600 hover:text-gray-800 hover:bg-gray-200 rounded-full focus:outline-none transition-colors">
              +
            </button>
          </div>
        </div>
      </template>

      <!-- Toggle Link -->
      <button type="button"
              @click="showMoreBeds = !showMoreBeds"
              class="text-sm text-blue-600 hover:underline focus:outline-none flex items-center gap-1">
        <span x-show="!showMoreBeds">More bed options</span>
        <span x-show="showMoreBeds">Fewer bed options</span>
        <svg class="w-4 h-4 transition-transform" :class="showMoreBeds ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 24 24">
          <path d="M7 10l5 5 5-5z"/>
        </svg>
      </button>

      <!-- Extra Beds -->
      <div x-show="showMoreBeds"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 max-h-0"
           x-transition:enter-end="opacity-100 max-h-screen"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 max-h-screen"
           x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
           class="space-y-3 pt-2">
        <template x-for="bed in beds.slice(4)" :key="bed.id">
          <div class="flex items-center justify-between border rounded-md px-4 py-3 mb-3 hover:bg-gray-50">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4 11h16v2H4zm0 4h16v6H4v-6zm0-8h16v2H4V7z"/>
              </svg>
              <div>
                <p class="text-sm font-medium" x-text="bed.name"></p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <button type="button" 
                      @click="decrement(bed.id)"
                      class="w-8 h-8 flex items-center justify-center text-xl text-gray-600 hover:text-gray-800 hover:bg-gray-200 rounded-full focus:outline-none transition-colors">
                −
              </button>
              <span class="mx-2 text-sm font-semibold min-w-[20px] text-center" x-text="bed.count"></span>
              <button type="button" 
                      @click="increment(bed.id)"
                      class="w-8 h-8 flex items-center justify-center text-xl text-gray-600 hover:text-gray-800 hover:bg-gray-200 rounded-full focus:outline-none transition-colors">
                +
              </button>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <div class="mt-8 flex justify-between items-center">
    <!-- Back Button -->
    <button
      type="button"
      onclick="window.history.back()"
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-6 py-3 flex items-center justify-center rounded transition-colors"
    >
      ← Back
    </button>

    <!-- Save Button -->
    <div class="pr-30">
      <button
        type="button"
        @click="console.log('Save button clicked at:', new Date().toISOString()); save()"
        :disabled="isLoading || totalBeds === 0"
        :class="isLoading || totalBeds === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
        class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded focus:outline-none focus:ring focus:ring-blue-300 transition-colors"
      >
        <span x-show="!isLoading" class="flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          Save
        </span>
        <span x-show="isLoading" class="flex items-center gap-2">
          <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Saving...
        </span>
      </button>
    </div>
  </div>
</div>


@endsection

