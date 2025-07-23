<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>create apartment</title>
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
    <script>
      // Ensure CSRF token is always sent with fetch/AJAX requests
      document.addEventListener('DOMContentLoaded', function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (window.fetch) {
          const _fetch = window.fetch;
          window.fetch = function(resource, config = {}) {
            config.headers = config.headers || {};
            // Only add if not already present
            if (!config.headers['X-CSRF-TOKEN'] && !config.headers['x-csrf-token']) {
              config.headers['X-CSRF-TOKEN'] = token;
            }
            return _fetch(resource, config);
          };
        }
      });
    </script>
  </head>
  <body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="text-white px-4 py-2" style="background-color: #1f8fb2">
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
                x-data="{ isLanguageModalOpen: false }"
                @click="isLanguageModalOpen = true"
              >
                <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
              </button>
              <!-- Language Modal -->
              <div
                x-data="{ isLanguageModalOpen: false }"
                x-show="isLanguageModalOpen"
                x-transition
                id="language-modal"
                class="fixed inset-0 z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50"
              >
                <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                  <!-- Modal Header -->
                  <div class="flex items-start justify-between">
                    <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                    <button
                      type="button"
                      class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                      @click="isLanguageModalOpen = false"
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
    <!-- Alpine.js root with merged state and backend logic -->
    <div
      x-data="{
            // Wizard state// Language selection state (make sure these exist in main scope)
            selectedLanguages: [],
            availableLanguages: [],
            showAdditionalLanguages: false,
            searchTerm: '',
            showDropdown: false,
            filteredLanguages: [],
          // Step navigation
          step: 1,
          wizardStep: 1,
          propertyWizardStep: 1,
          pricingWizardStep:1,
          // Backend-connected state
          propertyId: '{{ $property->id ?? 'new' }}', // Use 'new' if $property->id is not set
          title: '{{ old('title', $property->title ?? '') }}',
          address: '{{ old('address', $property->address ?? '') }}',
          city: '{{ old('city', $property->city ?? '') }}',
          country: 'Sri Lanka', // <-- Set the default value!
          zipcode: '{{ old('zipcode', $property->zipcode ?? '') }}',
          description: '{{ old('description', $property->description ?? '') }}',
          channelManager: 'yes', // or 'no' as default
          isLoading: false,
          // Property services state
          breakfastServed: '', // 'yes' or 'no'
          breakfastIncluded: '', // 'included' or 'extra'
          breakfastTypes: [],
          parkingAvailable: '', // 'free', 'paid', 'no'
          parkingCost: '',
          parkingCurrency: 'usd',
          parkingRate: 'per_day',
          parkingReservation: '', // 'needed', 'not_needed'
          parkingLocation: '', // 'on_site', 'off_site'
          parkingType: '', // 'private', 'public'
          // Language selection state
          selectedLanguages: [],
          availableLanguages: [],
          // Photo upload state
          uploadedPhotos: [],

          // Room and Bed Management State
          rooms: {
              'bedroom1': { name: 'Bedroom 1', twin: 0, full: 1, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
              'livingRoom': { name: 'Living room', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
              'otherSpaces': { name: 'Other spaces', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 }
          },
          currentEditingRoomId: null, // Tracks which room is currently being edited
          tempBedCounts: { twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 }, // Temporary state for the modal
          nextRoomIndex: 2, // For generating unique IDs for new bedrooms (e.g., bedroom2, bedroom3)
          showBedTypeSelector: false,
          showAllBedTypesInModal: false, // New state to control showing all bed types in the modal

          // Methods for Room and Bed Management
          openBedTypeSelector(roomId) {
              this.currentEditingRoomId = roomId;
              this.tempBedCounts = { ...this.rooms[roomId] };
              // Set initial visibility of bed types based on the room
              if (roomId === 'livingRoom') {
                  this.showAllBedTypesInModal = false; // Start with only sofa bed visible
              } else {
                  this.showAllBedTypesInModal = true; // Start with all standard beds visible
              }
              this.showBedTypeSelector = true;
          },
          saveBedTypes() {
              if (this.currentEditingRoomId) {
                  // Save the temporary bed counts back to the actual room state
                  this.rooms[this.currentEditingRoomId] = { ...this.rooms[this.currentEditingRoomId], ...this.tempBedCounts };
              }
              this.showBedTypeSelector = false;
              this.currentEditingRoomId = null; // Clear the editing room
          },
          cancelBedTypes() {
              // Just close the modal without saving changes from tempBedCounts
              this.showBedTypeSelector = false;
              this.currentEditingRoomId = null;
          },
          addBedroom() {
              const newRoomId = `bedroom${this.nextRoomIndex++}`;
              this.rooms[newRoomId] = { name: `Bedroom ${this.nextRoomIndex -1}`, twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 };
              this.openBedTypeSelector(newRoomId);
          },
          getBedSummary(roomId) {
              const beds = this.rooms[roomId];
              if (!beds) return '0 beds'; // Handle newly added rooms before they are configured

              const summaryParts = [];
              if (beds.twin > 0) summaryParts.push(`${beds.twin} twin bed${beds.twin > 1 ? 's' : ''}`);
              if (beds.full > 0) summaryParts.push(`${beds.full} full bed${beds.full > 1 ? 's' : ''}`);
              if (beds.queen > 0) summaryParts.push(`${beds.queen} queen bed${beds.queen > 1 ? 's' : ''}`);
              if (beds.king > 0) summaryParts.push(`${beds.king} king bed${beds.king > 1 ? 's' : ''}`);
              if (beds.bunk > 0) summaryParts.push(`${beds.bunk} bunk bed${beds.bunk > 1 ? 's' : ''}`);
              if (beds.sofa > 0) summaryParts.push(`${beds.sofa} sofa bed${beds.sofa > 1 ? 's' : ''}`);
              if (beds.futon > 0) summaryParts.push(`${beds.futon} futon bed${beds.futon > 1 ? 's' : ''}`);

              return summaryParts.length > 0 ? summaryParts.join(', ') : '0 beds';
          },

          // Backend methods (simplified, removed actual fetch for this example)
          async saveName() {
              if (!this.title.trim()) {
                  alert('Please enter a property name');
                  return;
              }
              this.isLoading = true;
              // Simulate API call
              await new Promise(resolve => setTimeout(resolve, 500));
              this.isLoading = false;
              this.wizardStep = 2;
          },
          async saveLocation() {
              if (!this.address.trim() || !this.city.trim() || !this.country.trim()) {
                  alert('Please fill in all required location fields');
                  return;
              }
              this.isLoading = true;
              const payload = {
                  title: this.title,
                  address: this.address,
                  apartment: this.apartment || null,
                  city: this.city,
                  country: this.country,
                  zipcode: this.zipcode,
                  description: this.description,
                  subtype_id: this.subtype_id || null,
                  address_type_id: this.address_type_id || null,
                  channel_manager: this.channelManager,
                  bedrooms: Object.values(this.rooms).map(room => {
                      // Add room_type if not present
                      return {
                          room_type: room.name === 'Living room' ? 'living_room' : (room.name === 'Other spaces' ? 'other' : 'bedroom'),
                          name: room.name,
                          twin: room.twin || 0,
                          full: room.full || 0,
                          queen: room.queen || 0,
                          king: room.king || 0,
                          bunk: room.bunk || 0,
                          sofa: room.sofa || 0,
                          futon: room.futon || 0,
                      };
                  }),
              };
              console.log('Sending payload to backend:', payload);
              try {
                  let res = await fetch(`/partner/property/${this.propertyId}`, {
                      method: 'PATCH',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                      },
                      body: JSON.stringify(payload)
                  });
                  let data = await res.json();
                  if (res.ok && data.success) {
                      this.wizardStep = 3;
                  } else {
                      alert('Error: ' + (data.message || 'Could not update location.'));
                  }
              } catch (err) {
                  alert('AJAX error: ' + err.message);
              } finally {
                  this.isLoading = false;
              }
          },
          async saveChannelManager() {
              this.isLoading = true;
              // Simulate API call
              await new Promise(resolve => setTimeout(resolve, 500));
              this.isLoading = false;
              this.step = 2;
              this.propertyWizardStep = 1;
          },
          savePropertyDetails() {
    const payload = {
        title: this.title,
        address: this.address,
        apartment: this.apartment || null,
        city: this.city,
        country: this.country,
        zipcode: this.zipcode,
        description: this.description,
        subtype_id: this.subtype_id || null,
        address_type_id: this.address_type_id || null,
        channel_manager: this.channelManager,
        bedrooms: Object.values(this.rooms).map(room => ({
            room_type: room.name === 'Living room' ? 'living_room' : (room.name === 'Other spaces' ? 'other' : 'bedroom'),
            name: room.name,
            twin: room.twin || 0,
            full: room.full || 0,
            queen: room.queen || 0,
            king: room.king || 0,
            bunk: room.bunk || 0,
            sofa: room.sofa || 0,
            futon: room.futon || 0,
        })),
        guests: this.guests,
        bathrooms: this.bathrooms,
        allow_children: this.allowChildren,
        offer_cribs: this.offerCribs,
        apartment_size: this.apartmentSize,
        apartment_unit: this.apartmentUnit,
    };

    this.isLoading = true;

    // Helper to parse JSON safely
    const parseJsonResponse = async (res, contextLabel) => {
        const contentType = res.headers.get('content-type') || '';
        const text = await res.text();

        if (!res.ok) {
            throw new Error(`HTTP ${res.status}: ${text.substring(0, 300)}`);
        }

        if (contentType.includes('application/json')) {
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error(`${contextLabel} - JSON parse error`, text);
                throw new Error('Failed to parse JSON response from server.');
            }
        } else {
            console.error(`${contextLabel} - Expected JSON, got HTML/text:`, text);
            throw new Error(`Unexpected server response format from ${contextLabel}.`);
        }
    };

    // Main fetch
    fetch(`/partner/property/${this.propertyId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
        },
        body: JSON.stringify(payload)
    })
    .then(res => parseJsonResponse(res, 'property update'))
    .then(data => {
        if (data && data.success) {
            // Only save amenities if on step 2
            if (this.propertyWizardStep === 2) {
                return fetch(`/partner/property/${this.propertyId}/amenities`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ amenities: this.selectedAmenities })
                })
                .then(res => parseJsonResponse(res, 'amenities save'))
                .then(data => {
                    if (data && data.success) {
                        this.propertyWizardStep++;
                    } else {
                        alert(data.message || 'Could not save amenities.');
                    }
                });
            } else {
                this.propertyWizardStep++;
            }
        } else {
            throw new Error(data && data.message ? data.message : 'Could not update property details.');
        }
    })
    .catch(err => {
        alert('Error: ' + err.message);
        console.error(err);
    })
    .finally(() => {
        this.isLoading = false;
    });
},

          // Photo upload methods
          isUploading: false,
          uploadedPhotos: [],
          handleUpload(event) {
            const files = Array.from(event.target.files).slice(0, 5 - this.uploadedPhotos.length);
            files.forEach(file => {
              const url = URL.createObjectURL(file);
              this.uploadedPhotos.push({ file, url });
            });
          },
          handleUploadDrop(event) {
            const dt = event.dataTransfer;
            if (!dt) return;
            const files = Array.from(dt.files).slice(0, 5 - this.uploadedPhotos.length);
            files.forEach(file => {
              const url = URL.createObjectURL(file);
              this.uploadedPhotos.push({ file, url });
            });
          },
          removePhoto(index) {
            this.uploadedPhotos.splice(index, 1);
          },
          
          guests: 4,
          bathrooms: 2,
          allowChildren: 'yes',
          offerCribs: 'no',
          apartmentSize: 100,
          apartmentUnit: 'square meters',
          saveAdditionalDetails() {
              const payload = {
                  guests: this.guests,
                  bathrooms: this.bathrooms,
                  allow_children: this.allowChildren,
                  offer_cribs: this.offerCribs,
                  apartment_size: this.apartmentSize,
                  apartment_unit: this.apartmentUnit,
                  breakfast_served: this.breakfastServed,
                  breakfast_included: this.breakfastIncluded,
                  breakfast_types: this.breakfastTypes,
                  parking_available: this.parkingAvailable,
                  parking_cost: this.parkingCost,
                  parking_currency: this.parkingCurrency,
                  parking_rate: this.parkingRate,
                  parking_reservation: this.parkingReservation,
                  parking_location: this.parkingLocation,
                  parking_type: this.parkingType,
                  languages: this.selectedLanguages,
              };
              this.isLoading = true;

              // If on the services step, POST to /services, otherwise PATCH additional-details
              if (this.propertyWizardStep === 3) {
                  fetch(`/partner/property/${this.propertyId}/services`, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                      },
                      body: JSON.stringify(payload)
                  })
                  .then(async res => {
                      let text = await res.text();
                      try {
                          return JSON.parse(text);
                      } catch (e) {
                          console.error('Non-JSON response from services POST:', text);
                          alert('Server error (services save):\n' + text.substring(0, 500));
                          throw new Error('Non-JSON response from services POST');
                      }
                  })
                  .then(data => {
                      if (data && data.success) {
                          this.propertyWizardStep++;
                      } else {
                          alert('Error: ' + (data && data.message ? data.message : 'Could not save services.'));
                      }
                  })
                  .catch(err => {
                      alert('AJAX error: ' + err.message);
                  })
                  .finally(() => {
                      this.isLoading = false;
                  });
              } else {
                  fetch(`/partner/property/${this.propertyId}/additional-details`, {
                      method: 'PATCH',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                      },
                      body: JSON.stringify(payload)
                  })
                  .then(async res => {
                      const contentType = res.headers.get('content-type');
                      if (contentType && contentType.includes('application/json')) {
                          return res.json();
                      } else {
                          const text = await res.text();
                          throw new Error('Server did not return JSON: ' + text.substring(0, 200));
                      }
                  })
                  .then(data => {
                      if (data.success) {
                          this.propertyWizardStep++;
                      } else {
                          alert('Error: ' + (data.message || 'Could not update additional details.'));
                      }
                  })
                  .catch(err => {
                      alert('AJAX error: ' + err.message);
                  })
                  .finally(() => {
                      this.isLoading = false;
                  });
              }
          },
          selectedAmenities: [],
          propertyCount: 1,
          owners: [
            { firstName: '', address: '', zipCode: '', city: '', country: '' }
          ],
          ownershipType: '', // 'individual' or 'business'
          // For individual
          individual: { firstName: '', lastName: '', dob: '', altNames: [] },
          // For business entity
          business: {
            businessName: '',
            tradingName: '',
            address: '',
            zipCode: '',
            city: '',
            country: '',
            owners: [
              { firstName: '', lastName: '', dob: '', altNames: [] }
            ]
          },
          // Add these methods to your main x-data object (before the closing brace)
async loadLanguages() {
  try {
    const response = await fetch('/partner/languages');
    const languages = await response.json();
    this.availableLanguages = languages;
    this.filteredLanguages = languages;
  } catch (error) {
    console.error('Error loading languages:', error);
  }
},

filterLanguages() {
  if (!this.searchTerm) {
    this.filteredLanguages = this.availableLanguages;
  } else {
    this.filteredLanguages = this.availableLanguages.filter(lang => 
      lang.name.toLowerCase().includes(this.searchTerm.toLowerCase())
    );
  }
},

selectLanguage(languageId, languageName) {
  if (!this.selectedLanguages.includes(languageId)) {
    this.selectedLanguages.push(languageId);
  }
  this.showDropdown = false;
  this.searchTerm = '';
  this.filteredLanguages = this.availableLanguages;
},

removeLanguage(languageId) {
  const index = this.selectedLanguages.indexOf(languageId);
  if (index > -1) {
    this.selectedLanguages.splice(index, 1);
  }
},

getLanguageName(languageId) {
  const language = this.availableLanguages.find(lang => lang.id === languageId);
  return language ? language.name : '';
},

isLanguageSelected(languageId) {
  return this.selectedLanguages.includes(languageId);
},

toggleAdditionalLanguages() {
  this.showAdditionalLanguages = !this.showAdditionalLanguages;
  if (this.showAdditionalLanguages && this.availableLanguages.length === 0) {
    this.loadLanguages();
  }
}
      }"
      x-init="console.log('Wizard initialized', { title, address, city, country, zipcode, description })"
    >
      <div x-data="{ step: 1, wizardStep: 1 , propertyWizardStep: 1 }">
        <!-- Sticky Top Navbar -->
        <nav class="border-b shadow-sm sticky top-0 z-50">
          <div class="max-w-full mx-auto px-4 py-3">
            <!-- Scrollable/Responsive Nav Items -->
            <div
              class="flex flex-wrap sm:flex-nowrap overflow-x-auto space-x-6 sm:space-x-10 md:space-x-14 lg:space-x-20 xl:space-x-24 text-sm font-medium whitespace-nowrap"
            >
              <!-- Loop through nav steps -->
              <template
                x-for="(label, index) in ['Basic information', 'Property setup', 'Photos', 'Pricing and calendar', 'Legal information']"
                :key="index"
              >
                <div class="relative">
                  <!-- Tab Label -->
                  <div
                    @click="step = index + 1"
                    class="flex items-center space-x-1 cursor-pointer transition duration-200"
                    :class="step === index + 1 ? 'text-blue-600' : 'text-gray-700'"
                  >
                    <span x-text="label"></span>
                    <!-- Optional checkmark -->
                    <template x-if="index === 0 && wizardStep === 3">
                      <span class="text-green-600">✔️</span>
                    </template>

                     <!-- Optional checkmark -->
                    <template x-if="index === 1 && propertyWizardStep === 6">
                      <span class="text-green-600">✔️</span>
                    </template>
                  </div>
                  <!-- 🔵 Progress bar only under "Basic information" when active -->
                  <template x-if="index === 0 && step === 1">
                    <div
                      class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-46 lg:w-54 xl:w-62 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]"
                    >
                      <template x-for="i in 3">
                        <div
                          :class="wizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'"
                          class="h-1 flex-1 rounded-full"
                        ></div>
                      </template>
                    </div>
                  </template>
                  <!-- Progress bar under "Property setup" tab -->
                  <!-- Progress bar under "Property setup" tab -->
                  <template x-if="index === 1 && step === 2">
                    <div
                      class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-56 lg:w-64 xl:w-72 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]"
                    >
                      <template x-for="i in 6">
                        <div
                          :class="propertyWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'"
                          class="h-1 flex-1 rounded-full"
                        ></div>
                      </template>
                    </div>
                  </template>

                  <template x-if="index === 3 && step === 4">
                    <div class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-56 lg:w-64 xl:w-72 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]">
                      <template x-for="i in 4">
                        <div
                          :class="pricingWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'"
                          class="h-1 flex-1 rounded-full">
                        </div>
                      </template>
                    </div>
                  </template>
                </div>
              </template>
            </div>
          </div>
        </nav>
        <!-- 🧾 Page Content -->
        <div>
          <!-- ✅ Step 1: Basic Information -->
          <section x-show="step === 1">
            <div>
              <template x-if="wizardStep === 1">
                <div class="max-w-5xl mx-auto px-4 py-10 space-y-32">
                  <section class="mb-8">
                    <h1 class="text-xl text-gray-700 font-bold mb-4">What's the name of your place?</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                      <!-- Property Name Input (2/3 Width) -->
                      <div class="md:col-span-2 flex">
                        <div class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">
                          <label for="property_name" class="block text-gray-700">Property name</label>
                          <input
                            type="text"
                            id="property_name"
                            name="property_name"
                            x-model="title"
                            class="w-full h-16 border border-gray-300 rounded p-4 mt-3 text-lg focus:outline-none focus:border-blue-500"
                            placeholder="e.g., Sunset Villa"
                            required
                          />
                        </div>
                      </div>
                      <!-- Tips and Information (1/3 Width) -->
                      <div class="flex flex-col gap-4">
                        <!-- Tip Box 1 -->
                        <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded">
                          <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                              <img
                                src="{{ asset('assets/ei_like.svg') }}"
                                alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer"
                              />
                              <h3 class="text-gray-700 text-sm">What should I consider when choosing a name?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"
                                />
                              </svg>
                            </button>
                          </div>
                          <ul class="list-disc pl-5 text-sm text-gray-700">
                            <li>Keep it short and catchy</li>
                            <li>Avoid abbreviations</li>
                            <li>Stick to the facts</li>
                          </ul>
                        </div>
                        <!-- Tip Box 2 -->
                        <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded flex-1">
                          <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                              <img
                                src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer"
                              />
                              <h3 class="text-gray-700 text-sm">Why do I need to name my property?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"
                                />
                              </svg>
                            </button>
                          </div>
                          <p class="text-sm text-gray-700">
                            This is the name that will appear as the title of your listing. Be specific and avoid
                            including private details.
                          </p>
                        </div>
                      </div>
                    </div>
                    <!-- Buttons Row (Outside grid, full width) -->
                    <div class="flex justify-between mt-6">
                      <!-- Back Button -->
                      <button
                        type="button"
                        @click="step--"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded"
                      >
                        ←
                      </button>
                      <!-- Continue Button -->
                      <!-- Continue Button (inside input field container, aligned right) -->
                      <div class="flex justify-end mt-4">
                        <button
                          type="button"
                          @click="saveName"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          Continue
                        </button>
                      </div>
                    </div>
                  </section>
                </div>
              </template>
              <template x-if="wizardStep === 2">
                <div class="relative w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-10">
                  <!-- Google Maps iframe full background -->
                  <iframe
                    class="absolute inset-0 w-full h-full"
                    loading="lazy"
                    src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                    allowfullscreen
                  ></iframe>
                  <!-- Optional overlay for readability -->
                  <div class="absolute inset-0"></div>
                  <!-- Form content centered on map -->
                  <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                    <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                      <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                      <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Find your address</label>
                        <input
                          type="text"
                          id="address"
                          name="address"
                          x-model="address"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        />
                      </div>
                      <div class="mb-4">
                        <label for="apartment" class="block text-sm font-medium text-gray-700"
                          >Apartment or floor number (optional)</label
                        >
                        <input
                          type="text"
                          id="apartment"
                          name="apartment"
                          x-model="apartment"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        />
                      </div>
                      <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select
                          id="country"
                          name="country"
                          x-model="country"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        >
                          <option value="Sri Lanka">Sri Lanka</option>
                        </select>
                      </div>
                      <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                          <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                          <input
                            type="text"
                            id="city"
                            name="city"
                            x-model="city"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                          />
                        </div>
                        <div class="flex-1">
                          <label for="postcode" class="block text-sm font-medium text-gray-700"
                            >Post code / Zip code</label
                          >
                          <input
                            type="text"
                            id="postcode"
                            name="postcode"
                            x-model="zipcode"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                          />
                        </div>
                      </div>
                      <div class="flex items-center mt-4">
                        <input id="update_address" type="checkbox" name="update_address" checked class="mr-2" />
                        <label for="update_address" class="text-sm text-gray-700"
                          >Update the address when moving the pin on the map.</label
                        >
                      </div>
                      <!-- Dismissible message box -->
                      <div
                        x-data="{ showMessage: true }"
                        x-show="showMessage"
                        class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                        role="alert"
                      >
                        <strong class="font-bold">Note:</strong>
                        <span class="block sm:inline"
                          >Make sure the pin location is accurate before continuing.</span
                        >
                        <span @click="showMessage = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                          <svg
                            class="fill-current h-6 w-6 text-yellow-800"
                            role="button"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                          >
                            <title>Close</title>
                            <path
                              d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"
                            />
                          </svg>
                        </span>
                      </div>
                      <p class="text-sm text-gray-600 mt-2">
                        Is the red pin location incorrect? Uncheck the option above and click or press on the map to
                        move the pin.
                      </p>
                      <div class="flex justify-between mt-6">
                        <!-- Back Button (Left) -->
                        <button
                          type="button"
                          @click="wizardStep--"
                          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                        >
                          ←
                        </button>
                        <!-- Continue Button (Right) -->
                        <button
                          type="submit"
                          @click="saveLocation"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          Continue
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <template x-if="wizardStep === 3">
                <section class="mb-12">
                  <div class="max-w-5xl mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>
                    <!-- Question Section -->
                    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                      <h2 class="text-lg font-semibold mb-2">
                        Do you want to connect this listing to your channel manager?
                      </h2>
                      <p class="text-gray-700 mb-6">
                        A channel manager is a third-party tool that lets you manage rates and availability across
                        different sites you might list your place on, including Booking.com. If you're already using a
                        channel manager, you can select 'Yes' to connect it to your listing.
                      </p>
                      <!-- Radio Buttons -->
                      <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                        <!-- Yes Option -->
                        <div>
                          <input
                            type="radio"
                            id="yes"
                            name="channel_manager"
                            value="yes"
                            class="mr-2"
                            x-model="channelManager"
                          />
                          <label for="yes" class="text-gray-700">
                            Yes, I will connect this listing to my channel manager
                          </label>
                        </div>
                        <!-- Tooltip only if Yes is selected -->
                        <div x-show="channelManager === 'yes'" x-transition>
                          <div class="bg-red-100 border border-red-300 rounded p-2">
                            <div class="flex items-start text-sm text-red-700 space-x-2">
                              <!-- Inline icon -->
                              <img
                                src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                alt="Help"
                                class="w-5 h-5 md:w-6 md:h-6 mt-1"
                              />
                              <!-- Text block -->
                              <p>
                                Select 'Yes' only if you are already using a channel manager. You'll be able to connect
                                your channel manager after your registration is complete – please continue to the next
                                step.
                              </p>
                            </div>
                          </div>
                        </div>
                        <!-- No Option -->
                        <div>
                          <input
                            type="radio"
                            id="no"
                            name="channel_manager"
                            value="no"
                            class="mr-2"
                            x-model="channelManager"
                          />
                          <label for="no" class="text-gray-700">
                            No, I won't be using a channel manager at this time
                          </label>
                        </div>
                      </div>
                      <div class="flex justify-between mt-6">
                        <!-- Back Button (Left) -->
                        <button
                          type="button"
                          @click="wizardStep--"
                          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                        >
                          ←
                        </button>
                        <!-- Continue Button (Right) -->
                        <button
                          type="button"
                          @click="saveChannelManager"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          Continue
                        </button>
                      </div>
                    </div>
                  </div>
                </section>
              </template>
            </div>
          </section>
          <!-- Property Setup Section -->

          <!-- Property Setup Section -->
<!-- Property Setup Section -->
<section x-show="step === 2">

  <!-- Property Setup Step 1: Where can people sleep, guests, bathrooms, children, infants, apartment size/unit -->
  <template x-if="propertyWizardStep === 1">
    <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">

      <h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>
      <!-- Where can people sleep -->
      <div class="bg-white p-4 rounded-lg shadow space-y-4">
        <h2 class="text-lg font-semibold">Where can people sleep?</h2>
        <div class="flex flex-col gap-4">
          <template x-for="(room, roomId) in rooms" :key="roomId">
            <a
              :href="'/partner/property/apartment/bedrooms/' + propertyId + '/' + roomId"
              class="block"
            >
              <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer flex justify-between items-center">
                <div>
                  <p class="text-sm" x-text="room.name"></p>
                  <p class="text-sm text-gray-600" x-text="getBedSummary(roomId)"></p>
                </div>
                <span class="text-xs text-blue-600 hover:underline">Edit</span>
              </div>
            </a>
          </template>
        </div>
        <!-- Add Bedroom Button -->
        <button type="button" @click="addBedroom" class="text-blue-600 hover:underline text-sm flex items-center space-x-1 mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
          </svg>
          <a
            :href="'/partner/property/apartment/bedrooms/' + propertyId + '/create'"
            class="text-blue-600 hover:underline text-sm flex items-center space-x-1"
          >
            <span>Add Bedroom</span>
          </a>
        </button>
      </div>

      <!-- Guests and Bathrooms -->
      <div class="bg-white p-4 rounded-lg shadow space-y-4 w-full max-w-xl">
        <!-- Guests -->
        <div>
          <label class="block text-sm text-gray-800">How many guests can stay?</label>
          <div class="flex items-center space-x-4 mt-1">
            <button @click="if (guests > 1) guests--" class="border px-3 py-1 rounded text-base">−</button>
            <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="guests"></span>
            <button @click="guests++" class="border px-3 py-1 rounded text-base">+</button>
          </div>
        </div>
        <!-- Bathrooms -->
        <div>
          <label class="block text-sm text-gray-800">How many bathrooms are there?</label>
          <div class="flex items-center space-x-4 mt-1">
            <button @click="if (bathrooms > 0) bathrooms--" class="border px-3 py-1 rounded text-base">−</button>
            <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="bathrooms"></span>
            <button @click="bathrooms++" class="border px-3 py-1 rounded text-base">+</button>
          </div>
        </div>
      </div>

      <!-- Children Policy -->
      <div class="bg-white p-4 rounded-lg shadow space-y-4">
        <div>
          <p class="font-medium text-sm">Do you allow children?</p>
          <label class="mr-4 text-sm">
            <input type="radio" name="children" value="yes" x-model="allowChildren"> Yes
          </label>
          <label class="text-sm">
            <input type="radio" name="children" value="no" x-model="allowChildren"> No
          </label>
        </div>
        <div>
          <p class="font-medium text-sm">Do you allow infants?</p>
          <p class="text-xs text-gray-500">cribs sleep most infants 0–3 years old and are available to guests on request.</p>
          <label class="mr-4 text-sm">
            <input type="radio" name="infants" value="yes" x-model="offerCribs"> Yes
          </label>
          <label class="text-sm">
            <input type="radio" name="infants" value="no" x-model="offerCribs"> No
          </label>
        </div>
      </div>

      <!-- Room Size -->
      <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 ">
        <div class="flex flex-col lg:flex-row gap-4 items-end">
          <!-- Apartment Size Input -->
          <div class="w-full lg:w-2/4">
            <label class="block text-sm text-gray-700 mb-1">How big is this room?</label>
            <p class="text-xs text-gray-500">Apartment size - optional</p>
            <input
              type="number"
              min="1"
              step="1"
              inputmode="numeric"
              pattern="\d*"
              x-model="apartmentSize"
              name="apartment_size"
              class="w-full border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2"
            >
          </div>
          <!-- Size Unit Dropdown -->
          <div class="w-full lg:w-1/4">
            <label class="block text-sm text-transparent mb-1">Unit</label>
            <select x-model="apartmentUnit" class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2">
              <option value="square meters">square meters</option>
              <option value="square feet">square feet</option>
            </select>
          </div>
        </div>
      </div>

      <div class="mt-8 flex justify-between">
        <!-- Back Button on the left -->
        <button
          type="button" @click="propertyWizardStep--"
          :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
          ←
        </button>
        <!-- Continue Button on the right -->
        <button
          type="button"
          @click="savePropertyDetails"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
          Continue
        </button>
      </div>
    </div>
  </template>

    <template x-if="propertyWizardStep === 2">
      <div class="max-w-2xl mx-auto space-y-8 lg:ml-32">
        <!-- Heading -->
        <h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>
        <!-- Amenities Section Container -->
        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
          @foreach ($groupedAmenities as $category => $items)
            <div class="space-y-3">
              <h3 class="text-base font-semibold text-gray-800">{{ $category }}</h3>
              <div class="flex flex-col space-y-2">
                @foreach ($items as $amenity)
                  <label class="flex items-center space-x-2 text-gray-700 text-sm">
                    <input
                      type="checkbox"
                      :value="{{ $amenity->id }}"
                      x-model="selectedAmenities"
                      class="form-checkbox h-5 w-5 text-blue-600"
                    >
                    <span>{{ $amenity->name }}</span>
                  </label>
                @endforeach
              </div>
              @if (!$loop->last)
                <hr class="border-t border-gray-200 mt-4">
              @endif
            </div>
          @endforeach
        </div>
        <div class="flex justify-between mt-6">
          <!-- Back Button -->
          <button
            type="button"
            @click="propertyWizardStep--"
            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
            ←
          </button>
          <!-- Continue Button -->
          <div class="flex justify-end">
            <button
              type="button"
              @click="savePropertyDetails"
              class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
              Continue
            </button>
          </div>
        </div>
      </div>
    </template>

    <template x-if="propertyWizardStep === 3">
      <div class="space-y-8 max-w-2xl mx-auto p-4 lg:ml-32">
        <!-- Services at your property -->
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Services at your property</h2>
        <!-- Breakfast Section -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4 border">
          <h3 class="text-base font-semibold text-gray-700">Breakfast</h3>
          <hr class="my-6 border-t border-gray-300">
          <!-- Do you serve guests breakfast -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">Do you serve guests breakfast?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="serve_breakfast" value="yes" x-model="breakfastServed" class="mr-2"> Yes
              </label>
              <label>
                <input type="radio" name="serve_breakfast" value="no" x-model="breakfastServed" class="mr-2"> No
              </label>
            </div>
          </div>
          <!-- Is breakfast included -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">Is breakfast included in the price guests pay?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="breakfast_included" value="included" x-model="breakfastIncluded" class="mr-2"> Yes, it's included
              </label>
              <label>
                <input type="radio" name="breakfast_included" value="extra" x-model="breakfastIncluded" class="mr-2"> No, it costs extra
              </label>
            </div>
          </div>
          <hr class="my-6 border-t border-gray-300">
          <!-- Type of breakfast -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">
              What type of breakfast do you offer?
              <span class="text-sm text-gray-500">(Select all that apply)</span>
            </p>
            <div class="flex flex-wrap gap-2">
              @foreach(['A la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental', 'Full English/Irish', 'Gluten-Free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'] as $option)
                <label
                  :class="breakfastTypes && breakfastTypes.includes('{{ $option }}')
                    ? 'bg-[#3CC0E9] text-white'
                    : 'border border-gray-300 text-gray-700 hover:bg-gray-200'"
                  class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition"
                >
                  <input type="checkbox" class="hidden"
                         :value="'{{ $option }}'"
                         x-model="breakfastTypes">
                  {{ $option }}
                </label>
              @endforeach
            </div>
          </div>
        </div>
        <!-- Parking Section -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4 border">
          <h3 class="text-base font-semibold text-gray-700">Parking</h3>
          <hr class="my-6 border-t border-gray-300">
          <!-- Is parking available -->
          <div>
            <p class="text-sm font-semibold text-gray-800 mb-2">Is parking available to guests?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="parking_available" value="free" x-model="parkingAvailable" class="mr-2"> Yes, free
              </label>
              <label>
                <input type="radio" name="parking_available" value="paid" x-model="parkingAvailable" class="mr-2"> Yes, paid
              </label>
              <label>
                <input type="radio" name="parking_available" value="no" x-model="parkingAvailable" class="mr-2"> No
              </label>
            </div>
          </div>
          <hr class="my-6 border-t border-gray-300">
          <!-- Parking cost -->
          <div>
            <p class="text-sm font-semibold text-gray-800 mb-2">How much does parking cost?</p>
            <div class="flex flex-col sm:flex-row items-center gap-4">
              <!-- Input + Currency Select Wrapper -->
              <div class="relative w-full max-w-xs">
                <select x-model="parkingCurrency" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 pl-1 focus:outline-none">
                  <option value="usd">US$</option>
                  <option value="eur">€</option>
                  <option value="gbp">£</option>
                  <option value="lkr">Rs</option>
                </select>
                <input
                  type="text"
                  x-model="parkingCost"
                  class="w-full border border-gray-400 rounded-md pl-16 pr-2 py-2 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none"
                />
              </div>
              <!-- Rate Select -->
              <select x-model="parkingRate" class="border border-gray-300 rounded px-3 py-2 w-32 text-sm text-gray-700">
                <option value="per_day">Per day</option>
                <option value="per_stay">Per stay</option>
              </select>
            </div>
          </div>
          <!-- Reservation needed -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">Do guests need to reserve a parking spot?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="parking_reservation" value="needed" x-model="parkingReservation" class="mr-2"> Reservation needed
              </label>
              <label>
                <input type="radio" name="parking_reservation" value="not_needed" x-model="parkingReservation" class="mr-2"> No reservation needed
              </label>
            </div>
          </div>
          <!-- Parking location -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">Where is the parking located?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="parking_location" value="on_site" x-model="parkingLocation" class="mr-2"> On site
              </label>
              <label>
                <input type="radio" name="parking_location" value="off_site" x-model="parkingLocation" class="mr-2"> Off site
              </label>
            </div>
          </div>
          <!-- Parking type -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">What type of parking is it?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="parking_type" value="private" x-model="parkingType" class="mr-2"> Private
              </label>
              <label>
                <input type="radio" name="parking_type" value="public" x-model="parkingType" class="mr-2"> Public
              </label>
            </div>
          </div>
        </div>
        <div class="flex justify-between mt-6">
          <!-- Back Button -->
          <button
            type="button"
            @click="propertyWizardStep--"
            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
            ←
          </button>
          <!-- Continue Button -->
          <div class="flex justify-end">
            <button
              type="button"
              @click="saveAdditionalDetails"
              class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
              Continue
            </button>
          </div>
        </div>
      </div>
    </template>

    <template x-if="propertyWizardStep === 4">
  <div class="max-w-4xl mx-auto space-y-8 lg:ml-32" x-init="loadLanguages()">
    <div class="container ml-24 px-4 py-8 max-w-2xl">
      <!-- Header -->
      <h2 class="text-2xl font-bold mb-8 text-left">
        What languages do you or your staff speak?
      </h2>
      <!-- Language Selection Section -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h3 class="text-lg mb-4 font-bold">Select languages</h3>
        
        <!-- Common Languages (hardcoded for quick selection) -->
        <div class="space-y-2 mb-4">
          <template x-for="commonLang in ['English', 'French', 'German', 'Hindi']" :key="commonLang">
            <label class="flex items-center cursor-pointer">
              <input 
                type="checkbox" 
                class="mr-2" 
                :value="availableLanguages.find(lang => lang.name === commonLang)?.id"
                x-model="selectedLanguages" 
                :disabled="!availableLanguages.find(lang => lang.name === commonLang)"
              />
              <span x-text="commonLang"></span>
            </label>
          </template>
        </div>

        <!-- Selected Languages Display -->
        <template x-if="selectedLanguages.length > 0">
          <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Selected languages:</h4>
            <div class="flex flex-wrap gap-2">
              <template x-for="langId in selectedLanguages" :key="langId">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                  <span x-text="getLanguageName(langId)"></span>
                  <button 
                    @click="removeLanguage(langId)"
                    class="ml-2 text-blue-600 hover:text-blue-800"
                    type="button"
                  >
                    ×
                  </button>
                </span>
              </template>
            </div>
          </div>
        </template>
        
        <!-- Add Additional Languages -->
        <div x-show="showAdditionalLanguages" class="mt-4 relative">
          <h3 class="text-lg font-medium mb-2">Add additional languages</h3>
          <!-- Searchable dropdown container -->
          <div class="relative w-full max-w-md">
            <input
              type="text"
              x-model="searchTerm"
              @input="filterLanguages()"
              @focus="showDropdown = true"
              @click="showDropdown = true"
              placeholder="Search languages..."
              autocomplete="off"
              class="w-full border rounded p-2 pr-10 cursor-pointer"
            />
            <!-- Dropdown arrow -->
            <button
              type="button"
              @click="showDropdown = !showDropdown"
              class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
              tabindex="-1"
            >
              ▼
            </button>
            <!-- Dropdown list -->
            <ul
              x-show="showDropdown && filteredLanguages.length > 0"
              x-transition
              class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg"
              @click.away="showDropdown = false"
            >
              <template x-for="language in filteredLanguages" :key="language.id">
                <li 
                  @click="selectLanguage(language.id, language.name)"
                  class="p-2 hover:bg-blue-100 cursor-pointer"
                  :class="{ 'bg-gray-100 text-gray-500': isLanguageSelected(language.id) }"
                  x-text="language.name"
                ></li>
              </template>
            </ul>
          </div>
        </div>
        
        <!-- Toggle Button for Additional Languages -->
        <button
          type="button"
          @click="toggleAdditionalLanguages()"
          class="text-blue-500 hover:underline mt-4 block"
        >
          <span x-text="showAdditionalLanguages ? 'Hide additional languages' : 'Add additional languages'"></span>
        </button>
      </div>
      
      <!-- Navigation Buttons -->
      <div class="mt-8 flex justify-between">
        <!-- Back Button on the left -->
        <button
          type="button" @click="propertyWizardStep--"
          :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
          ←
        </button>
        <!-- Continue Button on the right -->
        <button
          type="button"
          @click="saveAdditionalDetails"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
          Continue
        </button>
      </div>
    </div>
  </div>
</template>
  <template x-if="propertyWizardStep === 5">
  <div class="max-w-4xl mx-auto space-y-8 lg:ml-32">
    <div class="container w-full max-w-4xl ml-4 md:ml-24 px-4 py-8">
      <!-- Header -->
      <h2 class="text-2xl font-bold mb-8 text-left">House rules</h2>

      <div class="flex flex-col md:flex-row gap-6">
        <!-- Left Section -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
          <!-- Toggle Switches -->
          <div class="space-y-4">
            <label class="flex items-center justify-between cursor-pointer">
              <span>Smoking allowed</span>
              <div class="relative">
                <input type="checkbox" class="sr-only peer" />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer">
              <span>Parties/events allowed</span>
              <div class="relative">
                <input type="checkbox" class="sr-only peer" />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>
          </div>

          <hr class="my-6 border-t border-gray-300">

          <!-- Pet Policy -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Do you allow pets?</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="yes" class="mr-2">
                <span>Yes</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="upon_request" class="mr-2">
                <span>Upon request</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="no" class="mr-2" checked>
                <span>No</span>
              </label>
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Are there additional fees for pets?</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="free" class="mr-2">
                <span>Pets can stay for free</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="fees" class="mr-2">
                <span>Fees may apply</span>
              </label>
            </div>
          </div>

          <hr class="my-6 border-t border-gray-300">

          <!-- Check-in -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check in</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="time" value="15:00" class="w-full border rounded p-2" />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" value="18:00" class="w-full border rounded p-2" />
              </div>
            </div>
          </div>

          <!-- Check-out -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check out</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="time" value="08:00" class="w-full border rounded p-2" />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" value="11:00" class="w-full border rounded p-2" />
              </div>
            </div>
          </div>
                 <!-- Navigation Buttons -->
<div class="mt-12 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 "
  >
    Continue
  </button>
</div>
        </div>

        <!-- Right Section: Tip Box -->
        <div x-data="{ show: true }" :class="show ? 'block' : 'invisible opacity-0'" class="bg-white shadow-md rounded-lg p-6 w-full h-[240px] md:w-1/3 relative">
          <div class="flex justify-between items-start">
            <div class="flex items-center space-x-2">
              <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
              <h3 class="text-gray-800 font-semibold text-base">What if my house rules change?</h3>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <p class="text-sm text-gray-700 mt-3">
            You can easily customise these house rules later and additional house rules can be set on the Policies page of the extranet after you complete registration.
          </p>

          
        </div>
      </div>


    </div>
  </div>
</template>


<template x-if="propertyWizardStep === 6">
    <div class="max-w-2xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8 lg:ml-32 py-6">
       <h2 class="text-2xl font-bold mb-8 text-left">Host Profile</h2>
        <div class="bg-white shadow-md rounded-lg p-4 space-y-6">
            <h2 class="text-base text-gray-800">
                Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood. This info will appear on your property page.
            </h2>

            <!-- The Property Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-sm ">The property</span>
                </label>

                <div class="mt-2">
                    <label class="block text-sm font-semibold text-gray-700">About the property</label>
                    <textarea rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- The Host Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The host</span>
                </label>

                <div class="mt-2 space-y-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Host name</label>
                        <input type="text" maxlength="80"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <p class="text-right text-xs text-gray-500">0/80</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">About the host</label>
                        <textarea rows="4" maxlength="1200" placeholder="What are your interests? What do you like about hosting?"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>
            </div>

            <!-- The Neighborhood Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The neighborhood</span>
                </label>

                <div class="mt-2">
                    <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
                    <textarea rows="4" maxlength="1200" placeholder="What's the area like? Are there any attractions nearby?"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- None of the Above Option -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">None of the above / I'll add these later</span>
                </label>
            </div>
        </div>
        <div class="mt-12 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 "
  >
    Continue
  </button>
</div>
    </div>
</template>


</section>
          <!-- ✅ Step 3: Photos Upload Section -->
          <!-- ✅ Step 3: Photos Upload Section -->
          <!-- ✅ Step 3: Photos Upload Section -->
<!-- ...existing code... -->
<section
  x-show="step === 3"
  class="px-4 py-6 md:px-8 lg:px-16 flex justify-center"
  x-data="{
    uploadedPhotos: [],
    isUploading: false,
    handleUpload(event) {
      const files = Array.from(event.target.files).slice(0, 5 - this.uploadedPhotos.length);
      files.forEach(file => {
        const url = URL.createObjectURL(file);
        this.uploadedPhotos.push({ file, url });
      });
    },
    handleUploadDrop(event) {
      const dt = event.dataTransfer;
      if (!dt) return;
      const files = Array.from(dt.files).slice(0, 5 - this.uploadedPhotos.length);
      files.forEach(file => {
        const url = URL.createObjectURL(file);
        this.uploadedPhotos.push({ file, url });
      });
    },
    removePhoto(index) {
      this.uploadedPhotos.splice(index, 1);
    },
    async uploadPhotosAndContinue() {
      if (this.uploadedPhotos.length < 3) {
        alert('Please upload at least 3 photos.');
        return;
      }
      this.isUploading = true;
      const formData = new FormData();
      formData.append('property_id', this.propertyId);
      this.uploadedPhotos.forEach(photo => {
        formData.append('photos[]', photo.file);
      });
      try {
        const res = await fetch('/partner/property/upload-photos', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
          },
          body: formData
        });
        const data = await res.json();
        if (data.success) {
          this.step = 4;
        } else {
          alert(data.message || 'Upload failed');
        }
      } catch (err) {
        alert('Upload error: ' + err.message);
      } finally {
        this.isUploading = false;
      }
    }
  }"
>
  <div class="w-full max-w-6xl">
    <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">
      What does your place look like?
    </h2>
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
      <!-- 📸 Photo Upload Area -->
      <div class="border rounded-lg p-6 bg-white shadow-sm">
        <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
          <p class="text-sm text-gray-600 mb-4">
            The more you upload, the more likely you are to get bookings. You can add more later.
          </p>
          <!-- Upload box with drag and drop -->
          <div
            class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
            @dragover.prevent
            @drop.prevent="handleUploadDrop($event)"
          >
            <div class="mb-4">
              <!-- camera SVG -->
            </div>
            <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>
            <label
              class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
              for="fileInput"
            >
              <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload" class="w-4 h-4" />
              <span>Upload photos</span></label
              ><input
                id="fileInput"
                type="file"
                multiple
                accept="image/*"
                class="hidden"
                @change="handleUpload"
              />
              <p class="text-xs text-gray-500 mt-2">jpg/jpeg or png, maximum 47MB each, max 5 images</p>
            </div>
                  <!-- Uploaded photo previews -->
                  <template x-if="uploadedPhotos.length > 0">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                      <template x-for="(photo, index) in uploadedPhotos" :key="index">
                        <div class="relative group border rounded overflow-hidden">
                          <!-- Badge for main photo -->
                          <template x-if="index === 0">
                            <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10"
                              >Main Photo</span
                            >
                          </template>
                          <!-- Remove Button -->
                          <button
                            @click="removePhoto(index)"
                            class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75"
                          >
                            &times;
                          </button>
                          <img :src="photo.url" alt="Uploaded photo" class="w-full h-32 object-cover" />
                        </div>
                      </template>
                    </div>
                  </template>
                </div>
                <!-- ℹ️ Tips Box -->
                <div x-data="{ showTips: true }">
                  <div x-show="showTips" x-transition class="bg-white border rounded-none p-4 shadow-sm relative text-sm">
                    <button
                      @click="showTips = false"
                      class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
                      aria-label="Close"
                    >
                      &times;
                    </button>
                    <h3 class="font-semibold text-gray-800 mb-2 text-base">
                      What if I don't have professional photos?
                    </h3>
                    <p class="text-gray-600 mb-2">No problem! You can use a smartphone or a digital camera.</p>
                    <a href="#" class="text-blue-600 hover:underline block mb-2">
                      Here are some tips for taking great photos of your property
                    </a>
                    <p class="text-gray-600">
                      If you don't know who took a photo, it's best to avoid using it. Only use photos others have taken
                      if you have permission.
                    </p>
                  </div>
                </div>
                <!-- Navigation Buttons -->
                <div class="mt-6 flex justify-between">
                  <button
                    @click="step--"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                    :disabled="isUploading"
                    >
                    ←
                  </button>
                  <button
                    @click="uploadPhotosAndContinue"
                    :disabled="uploadedPhotos.length < 3 || isUploading"
                    :class="{
                      'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700':
                        uploadedPhotos.length >= 3,
                      'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3,
                    }"
                    class="px-6 py-2 text-white rounded"
                  >
                   <span x-show="!isUploading">Continue</span>
                  <span x-show="isUploading">Uploading...</span>
                  </button>
                </div>
              </div>
            </section>



            <section x-show="step === 4">

  <template x-if="pricingWizardStep === 1">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 2">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 3">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 4">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
</section>



            <!-- ✅ Step 5: Legal Information -->
            <section x-show="step === 5">
               <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ ownershipType: '', owners: [{ firstName: '', lastName: '', dob: '' }] }">

    <h2 class="text-3xl font-bold text-gray-800">Partner verification</h2>

    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
      <p class="text-sm text-gray-800">
        In order to comply with various legal and regulatory requirements, we need to collect and verify some information about you and your property.
      </p>

      <div>
        <label class="block font-semibold text-gray-900 mb-2">
          Is the accommodation owned by an individual or business entity?
        </label>
        <select x-model="ownershipType" class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
          <option value="">Select an option</option>
          <option value="individual">I am an individual running a business</option>
          <option value="business">I represent a business entity</option>
        </select>
      </div>
    </div>

    <!-- Individual Form -->
    <div x-show="ownershipType === 'individual'" x-transition class="bg-white p-6 rounded-lg space-y-4">
      <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of the individual who owns the accommodation.
      </p>
      <div class="border p-4 rounded-lg space-y-4 bg-white">
        <div>
          <label class="block text-sm font-semibold text-gray-600">First Name</label>
          <input type="text" x-model="individual.firstName" placeholder="First Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Last Name</label>
          <input type="text" x-model="individual.lastName" placeholder="Last Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
          <input type="date" x-model="individual.dob" class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
        </div>
        <!-- Alt names if needed -->
        <div>
          <label class="block font-semibold text-sm text-gray-600">
            If the owner goes by an alternative name or names, please provide those details.
            <span class="text-gray-500">- (Optional)</span>
          </label>
          <input type="text" x-model="individual.altNames[0]" class="w-full p-2 border rounded text-sm" />
        </div>
      </div>
    </div>

    <!-- Business Form -->
    <div x-show="ownershipType === 'business'" x-transition class="bg-white p-6 rounded-lg shadow border space-y-4">
      <div class="border p-4 rounded-lg space-y-4 bg-white">
        <div>
          <label class="block text-sm font-semibold text-gray-600">Full name of business entity</label>
          <input type="text" x-model="business.businessName" placeholder="Business Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Trading Name (optional)</label>
          <input type="text" x-model="business.tradingName" placeholder="Trading Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Address of business entity</label>
          <input type="text" x-model="business.address" placeholder="Address" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Zip Code</label>
          <input type="text" x-model="business.zipCode" placeholder="Zip Code" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">City</label>
          <input type="text" x-model="business.city" placeholder="City" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Country</label>
          <select x-model="business.country" class="w-full p-2 border rounded text-sm">
            <option value="">Select a country</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="India">India</option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Australia">Australia</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-sm text-gray-600">
            If the company operates under a different name (e.g. "trading as" name) in relation to the accommodation, please provide those details.
            <span class="text-gray-500">- (Optional)</span>
          </label>
          <input type="text" x-model="business.tradingName" class="w-full p-2 border rounded text-sm" />
        </div>
      </div>
      <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of all individuals who own 25% or more of the accommodation.
      </p>
      <template x-for="(owner, index) in business.owners" :key="index">
        <div class="border p-4 rounded-lg space-y-4 bg-white">
          <div>
            <label class="block text-sm font-semibold text-gray-600">First Name</label>
            <input type="text" x-model="owner.firstName" placeholder="First Name" class="w-full p-2 border rounded text-sm" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-600">Last Name</label>
            <input type="text" x-model="owner.lastName" placeholder="Last Name" class="w-full p-2 border rounded text-sm" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
            <input type="date" x-model="owner.dob" class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
          </div>
          <div>
            <label class="block font-semibold text-sm text-gray-600">
              If any owners go by an alternative name or names, please provide those details.
              <span class="text-gray-500">- (Optional)</span>
            </label>
            <input type="text" x-model="owner.altNames[0]" class="w-full p-2 border rounded text-sm" />
          </div>
          <div x-show="business.owners.length > 1" class="text-right">
            <button @click="business.owners.splice(index, 1)" type="button" class="text-red-600 text-sm hover:underline">Remove</button>
          </div>
        </div>
      </template>
      <div>
        <button @click="business.owners.push({ firstName: '', lastName: '', dob: '', altNames: [] })" type="button" class="text-sky-600 text-sm font-medium hover:underline mt-2">+ Add another owner</button>
      </div>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between pt-4">
      <button @click="step--"
             class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">

            ←
      </button>
      <button @click="step++"
              class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
        Continue
      </button>
    </div>
  </div>
</section>





          </div>
        </div>
      </div>
    </div>
  </body>
</html>
