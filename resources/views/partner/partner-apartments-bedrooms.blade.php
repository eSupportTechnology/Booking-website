<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Apartment</title>
  <script src="https://cdn.tailwindcss.com"></script>
      <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js?v={{ time() }}" defer></script>
  <script>
    console.log('Alpine.js script loaded');
    document.addEventListener('alpine:init', () => {
      console.log('Alpine.js initialized');
    });
    
    // Error handling
    window.addEventListener('error', function(e) {
      console.error('JavaScript error:', e.error);
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
  <div x-data="{
    beds: [
      { id: 1, name: 'Twin', count: 0 },
      { id: 2, name: 'Full', count: 0 },
      { id: 3, name: 'Queen', count: 0 },
      { id: 4, name: 'King', count: 0 },
      { id: 5, name: 'Sofa Bed', count: 0 },
      { id: 6, name: 'Bunk Bed', count: 0 },
      { id: 7, name: 'Murphy Bed', count: 0 }
    ],
    roomType: 'bedroom',
    showMoreBeds: false,
    isLoading: false,
    testValue: 'Alpine.js is working!',
    
    init() {
      console.log('Alpine.js data initialized');
      console.log('Beds array:', this.beds);
      console.log('Beds length:', this.beds.length);
      
      // Auto-select one bed for testing
      if (this.beds.length > 0) {
        this.beds[0].count = 1;
        console.log('Auto-selected first bed for testing');
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
    
    async save() {
      console.log('=== SAVE FUNCTION START ===');
      this.isLoading = true;
      console.log('Save function called');
      
      try {
        const selectedBeds = this.beds.filter(b => b.count > 0);
        
        if (selectedBeds.length === 0) {
          alert('Please select at least one bed type.');
          return;
        }
        
        // Generate room name based on type
        let roomName = '';
        switch (this.roomType) {
          case 'bedroom':
            roomName = 'Bedroom 1';
            break;
          case 'living_room':
            roomName = 'Living Room';
            break;
          case 'other':
            roomName = 'Other Space';
            break;
          default:
            roomName = 'Room 1';
        }
        
        const payload = {
          room_name: roomName,
          beds: selectedBeds,
          source: '{{ request('source') }}',
          step: '{{ request('step') }}'
        };
        
                 console.log('Payload:', payload);
         console.log('CSRF Token:', document.querySelector('meta[name=csrf-token]').content);
         console.log('URL:', 'http://127.0.0.1:8000/partner/property/bedroom/116');
         
         // Make real API call
         let res = await fetch('http://127.0.0.1:8000/partner/property/bedroom/116', {
           method: 'POST',
           headers: {
             'Content-Type': 'application/json',
             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
           },
           body: JSON.stringify(payload)
         });
         
         console.log('Fetch request completed');
         console.log('Response status:', res.status);
         console.log('Response ok:', res.ok);
         
         let data = await res.json();
         console.log('Response data:', data);
         console.log('Response success:', data.success);
         
         if (res.ok && data.success) {
           console.log('Save successful, redirecting...');
           // Redirect based on source and step
           const source = '{{ request('source') }}';
           const step = '{{ request('step') }}';
           const propertyId = '{{ $property->id }}';
           
           console.log('Source:', source, 'Step:', step, 'Property ID:', propertyId);
           
           if (source === 'multiple') {
             console.log('Redirecting to multiple apartment step 2');
             window.location.href = `/partner/multiple-apartment-2/${propertyId}`;
           } else if (source === 'single') {
             console.log('Redirecting to single apartment form 2');
             window.location.href = `/partner-apartment-create-2`;
           } else {
             console.log('Fallback redirect to single apartment form 2');
             window.location.href = `/partner-apartment-create-2`;
           }
         } else {
           alert('Error: ' + (data.message || 'Could not save bedroom.'));
         }
        
      } catch (err) {
        console.error('Save error:', err);
        alert('Error saving bedroom configuration: ' + err.message);
      } finally {
        console.log('=== SAVE FUNCTION END ===');
        this.isLoading = false;
      }
    },
    
    get mainBeds() {
      return this.beds.slice(0, 4);
    },
    
    get extraBeds() {
      return this.beds.slice(4);
    },
    
    get selectedBedsCount() {
      return this.beds.filter(b => b.count > 0).length;
    },
    
    get totalBeds() {
      return this.beds.reduce((sum, bed) => sum + bed.count, 0);
    },
    
    goBack() {
      const source = '{{ request('source') }}';
      const step = '{{ request('step') }}';
      const propertyId = '{{ $property->id }}';
      
      console.log('Going back - Source:', source, 'Step:', step, 'Property ID:', propertyId);
      
      if (source === 'multiple') {
        window.location.href = `/partner/multiple-apartment-2/${propertyId}`;
      } else if (source === 'single') {
        window.location.href = `/partner-apartment-create-2`;
      } else {
        // Fallback to browser back
        window.history.back();
      }
    }
  }" class="max-w-3xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
    
    <h2 class="text-3xl font-bold text-gray-900 mt-8">Add Room</h2>
    
    <!-- Room Type Selection -->
    <div class="bg-white rounded-lg border border-gray-300 p-6 mb-6 max-w-xl">
      <label class="block font-medium text-gray-700 mb-4">What type of room is this?</label>
      <div class="grid grid-cols-1 gap-3">
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
          <input type="radio" name="roomType" value="bedroom" x-model="roomType" class="mr-3">
          <div>
            <div class="font-medium">Bedroom</div>
            <div class="text-sm text-gray-500">Sleeping area with beds</div>
          </div>
        </label>
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
          <input type="radio" name="roomType" value="living_room" x-model="roomType" class="mr-3">
          <div>
            <div class="font-medium">Living Room</div>
            <div class="text-sm text-gray-500">Common area that may have sofa beds</div>
          </div>
        </label>
        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
          <input type="radio" name="roomType" value="other" x-model="roomType" class="mr-3">
          <div>
            <div class="font-medium">Other Space</div>
            <div class="text-sm text-gray-500">Any other room type</div>
          </div>
        </label>
      </div>
    </div>
    
    <!-- Alpine.js Test -->
    <div class="text-sm text-green-600 mb-2" x-text="testValue"></div>
    <button @click="console.log('Test button clicked'); alert('Alpine.js is working!')" 
            class="bg-green-500 text-white px-3 py-1 rounded text-xs mb-4 hover:bg-green-600">
        Test Alpine.js
    </button>

    <!-- Debug Info -->
    <div class="text-xs text-gray-500 mb-4 p-2 bg-gray-100 rounded">
      <div>Selected beds: <span x-text="selectedBedsCount"></span></div>
      <div>Total bed count: <span x-text="totalBeds"></span></div>
      <div class="mt-1">Beds data: <span x-text="JSON.stringify(beds.map(b => ({name: b.name, count: b.count})))"></span></div>
    </div>

    <!-- Bed Types Container -->
    <div class="bg-white rounded-lg border border-gray-300 p-6 space-y-4 max-w-xl">
      <label class="block font-medium text-gray-700 mb-4">Which beds are available in this room?</label>

      <!-- Main Beds -->
      <template x-for="bed in mainBeds" :key="bed.id">
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
        <template x-for="bed in extraBeds" :key="bed.id">
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

    <!-- Navigation Buttons -->
    <div class="mt-8 flex justify-between items-center">
      <button type="button" 
              @click="goBack()"
              class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-6 py-3 flex items-center justify-center rounded transition-colors">
        ← Back
      </button>

      <!-- Continue Button -->
      <div class="pr-40">
        <button
          type="button"
          @click="console.log('Save button clicked'); save()"
          :disabled="isLoading || selectedBedsCount === 0"
          :class="isLoading || selectedBedsCount === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
          class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded focus:outline-none focus:ring focus:ring-blue-300 transition-colors"
        >
          <span x-show="!isLoading">Save and Continue</span>
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

  <script>
    function toggleLanguageModal() {
      const modal = document.getElementById('language-modal');
      modal.classList.toggle('hidden');
    }
  </script>
</body>
</html>