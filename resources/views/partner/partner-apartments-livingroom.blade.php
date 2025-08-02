<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Apartment - Living Room</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    console.log('Living room page script loaded');
    document.addEventListener('alpine:init', () => {
      console.log('Alpine.js initialized on living room page');
    });
    
    // Error handling
    window.addEventListener('error', function(e) {
      console.error('JavaScript error on living room page:', e.error);
    });
  </script>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  
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
              <svg class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
              </svg>
            </a>

            <!-- Language Button -->
            <button
              id="language-button"
              type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language"
              onclick="toggleLanguageModal()"
            >
              <img src="https://flagcdn.com/w40/gb.png" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
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
                    onclick="toggleLanguageModal()"
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
   
  <!-- Main Content -->
  <div class="max-w-xl mt-16 px-4 sm:px-6 lg:ml-32" x-data="{
    sofaCount: 1,
    isLoading: false,
    saveAttempted: false,
    lastError: null,
    
    init() {
      console.log('Living room Alpine.js data initialized');
      console.log('Initial sofa count:', this.sofaCount);
    },
    
    async save() {
      console.log('=== LIVING ROOM SAVE FUNCTION START ===');
      this.isLoading = true;
      this.saveAttempted = true;
      this.lastError = null;
      
      try {
        console.log('Current sofa count:', this.sofaCount);
        
        if (this.sofaCount === 0) {
          const errorMsg = 'Please select at least one sofa bed.';
          console.log('Validation failed:', errorMsg);
          alert(errorMsg);
          return;
        }
        
        const payload = {
          room_name: 'Living Room',
          beds: [
            { id: 5, name: 'Sofa Bed', count: this.sofaCount }
          ],
          source: 'multiple',
          step: '2'
        };
        
        console.log('Prepared payload:', JSON.stringify(payload, null, 2));
        
        // Check if CSRF token exists
        const csrfToken = document.querySelector('meta[name=csrf-token]');
        if (!csrfToken) {
          throw new Error('CSRF token not found');
        }
        console.log('CSRF Token found:', csrfToken.content);
        
                 // Make real API call
         let res = await fetch('http://127.0.0.1:8000/partner/property/bedroom/{{ $property->id }}', {
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
           
           if (source === 'multiple') {
             console.log('Redirecting to multiple apartment step 2');
             window.location.href = 'http://127.0.0.1:8000/partner/multiple-apartment-2/{{ $property->id }}';
           } else if (source === 'single') {
             console.log('Redirecting to single apartment step 2');
             window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id }}';
           } else {
             console.log('Fallback redirect to step 2');
             window.location.href = 'http://127.0.0.1:8000/partner/property/apartment/step2/{{ $property->id }}';
           }
          
                 } else {
           throw new Error(data.message || 'Could not save living room.');
         }
        
      } catch (err) {
        console.error('Save error:', err);
        this.lastError = err.message;
        alert('Error saving living room configuration: ' + err.message);
      } finally {
        console.log('=== LIVING ROOM SAVE FUNCTION END ===');
        this.isLoading = false;
      }
    },
    
    incrementSofa() {
      this.sofaCount++;
      console.log('Incremented sofa count to:', this.sofaCount);
    },
    
    decrementSofa() {
      if (this.sofaCount > 0) {
        this.sofaCount--;
        console.log('Decremented sofa count to:', this.sofaCount);
      }
    }
  }">
    
    <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-8">Living room</h2>
    
    <!-- Alpine.js Test Button -->
    <button @click="console.log('Test button clicked'); alert('Alpine.js is working!')" 
            class="bg-green-500 text-white px-3 py-1 rounded text-xs mb-4 hover:bg-green-600">
        Test Alpine.js
    </button>
    
    <!-- Debug Info -->
    <div class="text-xs text-gray-500 mb-4 p-3 bg-gray-100 rounded border">
      <div class="mb-1"><strong>Debug Info:</strong></div>
      <div>Sofa count: <span x-text="sofaCount" class="font-semibold text-blue-600"></span></div>
      <div>Loading: <span x-text="isLoading" class="font-semibold" :class="isLoading ? 'text-orange-600' : 'text-green-600'"></span></div>
      <div>Save attempted: <span x-text="saveAttempted" class="font-semibold" :class="saveAttempted ? 'text-blue-600' : 'text-gray-600'"></span></div>
      <div x-show="lastError" class="text-red-600 mt-1">
        Last error: <span x-text="lastError"></span>
      </div>
    </div>
    
    <!-- Sofa Bed Selection -->
    <div class="bg-white border border-gray-300 rounded-lg p-6 flex justify-between items-center shadow-sm hover:shadow-md transition-shadow">
      <!-- Icon and Label -->
      <div class="flex items-center gap-3">
        <svg class="w-6 h-6 md:w-7 md:h-7 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
          <path d="M4 12h16v2H4v-2zm0-4h16v6H4V8zm0 8h16v2H4v-2z"/>
        </svg>
        <span class="font-medium text-gray-800">Sofa bed</span>
      </div>

      <!-- Counter -->
      <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
        <button
          type="button"
          @click="decrementSofa()"
          :disabled="sofaCount <= 0"
          :class="sofaCount <= 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="w-10 h-10 text-xl text-gray-600 transition-colors"
        >−</button>
        <span class="w-12 text-center text-gray-900 font-medium text-lg" x-text="sofaCount"></span>
        <button
          type="button"
          @click="incrementSofa()"
          class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100 transition-colors"
        >+</button>
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
          :disabled="isLoading || sofaCount === 0"
          :class="isLoading || sofaCount === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
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

    <!-- Additional Action Buttons for Testing -->
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
      <h4 class="text-sm font-semibold text-yellow-800 mb-2">Testing Controls:</h4>
      <div class="flex gap-2 flex-wrap">
        <button @click="sofaCount = 0; console.log('Reset sofa count to 0')" 
                class="px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">
          Reset to 0
        </button>
        <button @click="sofaCount = 5; console.log('Set sofa count to 5')" 
                class="px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
          Set to 5
        </button>
        <button @click="console.log('Current state:', { sofaCount, isLoading, saveAttempted, lastError })" 
                class="px-3 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600">
          Log State
        </button>
      </div>
    </div>
  </div>

  <script>
    function toggleLanguageModal() {
      const modal = document.getElementById('language-modal');
      modal.classList.toggle('hidden');
    }
  </script>
</body>
</html>
