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
  <div x-data="bedroomApp()" class="max-w-3xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
    
    <h2 class="text-3xl font-bold text-gray-900 mt-8" x-text="pageTitle">Add Bedroom</h2>
    


    <!-- Bed Types Container -->
    <div class="bg-white rounded-lg border border-gray-300 p-6 space-y-4 max-w-2xl">
      <label class="block font-medium text-gray-700 mb-6 text-lg">Which beds are available in this room?</label>

      <!-- Main Beds -->
      <template x-for="bed in mainBeds" :key="bed.id">
        <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0">
          <div class="flex items-center gap-4">
                         <!-- Bed Icon -->
             <div class="w-12 h-12 flex items-center justify-center">
               <svg class="w-10 h-6 text-gray-400" fill="currentColor" viewBox="0 0 48 24">
                 <rect x="2" y="8" width="24" height="12" rx="2" fill="currentColor"/>
                 <rect x="4" y="6" width="20" height="2" rx="1" fill="currentColor"/>
               </svg>
             </div>
            
            <div>
              <p class="font-medium text-gray-900" x-text="bed.name + ' bed(s)'"></p>
              <p class="text-sm text-gray-500" x-text="bed.description"></p>
            </div>
          </div>
          
          <div class="flex items-center gap-3">
            <button type="button" 
                    @click="decrement(bed.id)"
                    class="w-10 h-10 flex items-center justify-center text-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full border border-gray-200 focus:outline-none transition-colors">
              −
            </button>
            <span class="mx-2 text-lg font-semibold min-w-[24px] text-center" x-text="bed.count"></span>
            <button type="button" 
                    @click="increment(bed.id)"
                    class="w-10 h-10 flex items-center justify-center text-xl text-blue-500 hover:text-blue-600 hover:bg-blue-50 rounded-full border border-gray-200 focus:outline-none transition-colors">
              +
            </button>
          </div>
        </div>
      </template>

      <!-- Toggle Link -->
      <button type="button"
              @click="showMoreBeds = !showMoreBeds"
              class="text-blue-500 hover:text-blue-600 focus:outline-none flex items-center gap-1 pt-4">
        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
          <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
        </svg>
        <span x-show="!showMoreBeds">More bed options</span>
        <span x-show="showMoreBeds">Fewer bed options</span>
      </button>

      <!-- Extra Beds -->
      <div x-show="showMoreBeds"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 max-h-0"
           x-transition:enter-end="opacity-100 max-h-screen"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 max-h-screen"
           x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
           class="space-y-0 pt-2 border-t border-gray-100">
        <template x-for="bed in extraBeds" :key="bed.id">
          <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0">
            <div class="flex items-center gap-4">
                             <!-- Bed Icon -->
               <div class="w-12 h-12 flex items-center justify-center">
                 <svg class="w-10 h-6 text-gray-400" fill="currentColor" viewBox="0 0 48 24">
                   <rect x="2" y="8" width="24" height="12" rx="2" fill="currentColor"/>
                   <rect x="4" y="6" width="20" height="2" rx="1" fill="currentColor"/>
                 </svg>
               </div>
              
              <div>
                <p class="font-medium text-gray-900" x-text="bed.name + ' bed(s)'"></p>
                <p class="text-sm text-gray-500" x-text="bed.description"></p>
              </div>
            </div>
            
            <div class="flex items-center gap-3">
              <button type="button" 
                      @click="decrement(bed.id)"
                      class="w-10 h-10 flex items-center justify-center text-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full border border-gray-200 focus:outline-none transition-colors">
                −
              </button>
              <span class="mx-2 text-lg font-semibold min-w-[24px] text-center" x-text="bed.count"></span>
              <button type="button" 
                      @click="increment(bed.id)"
                      class="w-10 h-10 flex items-center justify-center text-xl text-blue-500 hover:text-blue-600 hover:bg-blue-50 rounded-full border border-gray-200 focus:outline-none transition-colors">
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
    // Make bedroomApp available globally before Alpine.js loads
    window.bedroomApp = function() {
      return {
        beds: [
          { id: 1, name: 'Twin', count: 0, description: '35-51 inches wide' },
          { id: 2, name: 'Full', count: 0, description: '52-59 inches wide' },
          { id: 3, name: 'Queen', count: 0, description: '60-70 inches wide' },
          { id: 4, name: 'King', count: 0, description: '71-81 inches wide' },
          { id: 5, name: 'Sofa Bed', count: 0, description: 'Convertible sofa to bed' },
          { id: 6, name: 'Bunk Bed', count: 0, description: 'Stacked sleeping arrangement' },
          { id: 7, name: 'Murphy Bed', count: 0, description: 'Wall-mounted foldable bed' }
        ],
        roomType: 'bedroom', // Always bedroom since we removed room type selection
        showMoreBeds: false,
        isLoading: false,
        testValue: 'Alpine.js is working!',
        pageTitle: 'Add Bedroom',
        
        get selectedBedsCount() {
          return this.beds.filter(b => b.count > 0).length;
        },
        
        get totalBeds() {
          return this.beds.reduce((sum, bed) => sum + bed.count, 0);
        },
        
        get mainBeds() {
          return this.beds.slice(0, 4); // First 4 beds (Twin, Full, Queen, King)
        },
        
        get extraBeds() {
          return this.beds.slice(4); // Remaining beds (Sofa Bed, Bunk Bed, Murphy Bed)
        },
        
        goBack() {
          const source = '{{ request('source') }}';
          const step = '{{ request('step') }}';
          const propertyId = '{{ $property->id ?? 'new' }}';
          const wizardState = '{{ request('wizardState') }}';
          
          if (source === 'multiple') {
            window.location.href = `/partner/multiple-apartment-2/${propertyId}`;
          } else if (source === 'single') {
            // Return with wizard state preservation
            const returnUrl = `/partner/property/apartment/step2/${propertyId}?step=${step}&returnFromBedroom=true&wizardState=${encodeURIComponent(wizardState)}`;
            window.location.href = returnUrl;
          } else {
            // Fallback to browser back
            window.history.back();
          }
        },
        
        init() {
          // Parse wizard state to see what rooms are available
          const urlParams = new URLSearchParams(window.location.search);
          const wizardStateParam = urlParams.get('wizardState');
          
          if (wizardStateParam) {
            try {
              const wizardState = JSON.parse(decodeURIComponent(wizardStateParam));
              
              // Count bedrooms specifically
              const bedroomKeys = Object.keys(wizardState.rooms || {}).filter(key => key.startsWith('bedroom'));
              
              // Extract bedroom numbers
              const bedroomNumbers = bedroomKeys.map(key => {
                const match = key.match(/bedroom(\d+)/);
                return match ? parseInt(match[1]) : 0;
              }).filter(num => num > 0);
              
              if (bedroomNumbers.length > 0) {
                const nextNumber = Math.max(...bedroomNumbers) + 1;
                // Next bedroom number calculated
              } else {
                // No bedroom numbers found, next should be: 1
              }
            } catch (error) {
              console.error('Error parsing wizard state:', error);
            }
          } else {
            // Use backend rooms data if no wizard state
            const backendRooms = @json($rooms ?? []);
            
            if (backendRooms && Object.keys(backendRooms).length > 0) {
              const bedroomKeys = Object.keys(backendRooms).filter(key => key.startsWith('bedroom'));
              
              const bedroomNumbers = bedroomKeys.map(key => {
                const match = key.match(/bedroom(\d+)/);
                return match ? parseInt(match[1]) : 0;
              }).filter(num => num > 0);
              
              if (bedroomNumbers.length > 0) {
                const nextNumber = Math.max(...bedroomNumbers) + 1;
                this.pageTitle = `Add Bedroom ${nextNumber}`;
              } else {
                this.pageTitle = 'Add Bedroom 1';
              }
            }
          }
          
                      // Check for incoming room data for editing
            const roomDataParam = urlParams.get('roomData');
            
            if (roomDataParam) {
              try {
                const roomData = JSON.parse(decodeURIComponent(roomDataParam));
                this.loadRoomData(roomData);
              } catch (error) {
                console.error('Error parsing room data:', error);
              }
            } else {
              // This is a new bedroom - calculate the next bedroom number from wizard state
              if (wizardStateParam) {
                try {
                  const wizardState = JSON.parse(decodeURIComponent(wizardStateParam));
                  this.calculateNextBedroomNumber(wizardState);
                } catch (error) {
                  console.error('Error parsing wizard state:', error);
                  this.calculateNextBedroomNumber();
                }
              } else {
                this.calculateNextBedroomNumber();
              }
              // Auto-select one bed for testing (only for new rooms)
              if (this.beds.length > 0) {
                this.beds[0].count = 1;
              }
            }
        },
        
            loadRoomData(roomData) {
      // Set room type
      this.roomType = roomData.type || 'bedroom';
      
      // Set page title based on room name
      if (roomData.room_name) {
        this.pageTitle = `Edit ${roomData.room_name}`;
      }
      
      // Load bed counts - handle both new format (beds array) and old format (individual properties)
      if (roomData.beds && Array.isArray(roomData.beds)) {
        // New format: beds array
        roomData.beds.forEach(bed => {
          const bedIndex = this.beds.findIndex(b => b.name === bed.name);
          if (bedIndex !== -1) {
            this.beds[bedIndex].count = bed.count;
          }
        });
      } else {
        // Old format: individual bed properties
        const bedMappings = {
          'twin': 'Twin',
          'full': 'Full', 
          'queen': 'Queen',
          'king': 'King',
          'bunk': 'Bunk Bed',
          'sofa': 'Sofa Bed',
          'futon': 'Murphy Bed'
        };
        
        Object.keys(bedMappings).forEach(key => {
          if (roomData[key] && roomData[key] > 0) {
            const bedIndex = this.beds.findIndex(b => b.name === bedMappings[key]);
            if (bedIndex !== -1) {
              this.beds[bedIndex].count = roomData[key];
            }
          }
        });
      }
            },
        
        calculateNextBedroomNumber(wizardState = null) {
          let nextBedroomNumber = 1;
          
          if (wizardState && wizardState.rooms) {
            // Count existing bedrooms from rooms object
            const bedroomKeys = Object.keys(wizardState.rooms).filter(key => key.startsWith('bedroom'));
            
            if (bedroomKeys.length > 0) {
              const bedroomNumbers = bedroomKeys
                .map(key => {
                  const match = key.match(/bedroom(\d+)/);
                  return match ? parseInt(match[1]) : 0;
                })
                .filter(num => num > 0);
              
              if (bedroomNumbers.length > 0) {
                nextBedroomNumber = Math.max(...bedroomNumbers) + 1;
              }
            }
          } else {
            // Fallback to URL parameter
            const wizardStateParam = '{{ request('wizardState') }}';
            
            if (wizardStateParam) {
              try {
                const wizardState = JSON.parse(decodeURIComponent(wizardStateParam));
                
                // Count existing bedrooms from rooms object
                if (wizardState.rooms) {
                  const bedroomKeys = Object.keys(wizardState.rooms).filter(key => key.startsWith('bedroom'));
                  
                  if (bedroomKeys.length > 0) {
                    const bedroomNumbers = bedroomKeys
                      .map(key => {
                        const match = key.match(/bedroom(\d+)/);
                        return match ? parseInt(match[1]) : 0;
                      })
                      .filter(num => num > 0);
                    
                    if (bedroomNumbers.length > 0) {
                      nextBedroomNumber = Math.max(...bedroomNumbers) + 1;
                    }
                  }
                }
                
              } catch (error) {
                console.error('Error parsing wizard state:', error);
              }
            }
          }
          
          // Only set page title if it hasn't been set by backend data
          if (!this.pageTitle || this.pageTitle === 'Add Bedroom') {
            this.pageTitle = `Add Bedroom ${nextBedroomNumber}`;
          }
        },
        
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
          
          try {
            const selectedBeds = this.beds.filter(b => b.count > 0);
            
            if (selectedBeds.length === 0) {
              alert('Please select at least one bed type.');
              return;
            }
            
            // Generate bedroom name
            let roomName = '';
            
            // Check if we're editing an existing room or creating a new one
            const urlParams = new URLSearchParams(window.location.search);
            const roomDataParam = urlParams.get('roomData');
            
            if (roomDataParam) {
              // Editing existing room - use the existing name
              try {
                const roomData = JSON.parse(decodeURIComponent(roomDataParam));
                roomName = roomData.room_name || 'Bedroom 1';
              } catch (error) {
                console.error('Error parsing room data:', error);
                roomName = 'Bedroom 1';
              }
            } else {
              // Creating new bedroom - calculate next number from backend rooms data
              const backendRooms = @json($rooms ?? []);
              let nextBedroomNumber = 1;
              
              if (backendRooms && Object.keys(backendRooms).length > 0) {
                const bedroomKeys = Object.keys(backendRooms).filter(key => key.startsWith('bedroom'));
                
                if (bedroomKeys.length > 0) {
                  const bedroomNumbers = bedroomKeys
                    .map(key => {
                      const match = key.match(/bedroom(\d+)/);
                      return match ? parseInt(match[1]) : 0;
                    })
                    .filter(num => num > 0);
                  
                  if (bedroomNumbers.length > 0) {
                    nextBedroomNumber = Math.max(...bedroomNumbers) + 1;
                  }
                }
              }
              
              roomName = 'Bedroom ' + nextBedroomNumber;
            }
                
            const payload = {
              room_name: roomName,
              beds: selectedBeds,
              source: '{{ request('source') }}',
              step: '{{ request('step') }}'
            };
             
            // Make real API call
            let res = await fetch(`/partner/property/bedroom/{{ $property->id ?? 'new' }}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
              },
              body: JSON.stringify(payload)
            });
            
            let data = await res.json();
            
            if (res.ok && data.success) {
              // Redirect based on source and step from the response
              const source = data.source || '{{ request('source') }}';
              const step = data.step || '{{ request('step') }}';
              const propertyId = '{{ $property->id }}';
              
              if (source === 'multiple') {
                window.location.href = `/partner/multiple-apartment-2/${propertyId}`;
              } else if (source === 'single') {
                // Redirect back to the form with the correct step and wizard state
                const wizardState = data.wizardState || '{{ request('wizardState') }}';
                const bedroomData = {
                  room_name: roomName,
                  beds: selectedBeds,
                  room_type: this.roomType
                };
                // Always redirect to Property Wizard Step 1 (bedroom section) after saving a bedroom
                const returnUrl = `/partner/property/apartment/step2/${propertyId}?step=2&propertyWizardStep=1&returnFromBedroom=true&wizardState=${encodeURIComponent(wizardState)}&bedroomData=${encodeURIComponent(JSON.stringify(bedroomData))}`;
                window.location.href = returnUrl;
              } else {
                window.location.href = `/partner-apartment-create-2`;
              }
            } else {
              alert('Error: ' + (data.message || 'Could not save bedroom.'));
            }
           
          } catch (err) {
            console.error('Save error:', err);
            alert('Error saving bedroom configuration: ' + err.message);
          } finally {
            this.isLoading = false;
          }
        }
      };
    }
    
    function toggleLanguageModal() {
      const modal = document.getElementById('language-modal');
      modal.classList.toggle('hidden');
    }
  </script>
</body>
</html>