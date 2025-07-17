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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
    // Step navigation
    step: 1,
    wizardStep: 1,
    propertyWizardStep: 1,
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
            // Additional details for the new table
            guests: this.guests,
            bathrooms: this.bathrooms,
            allow_children: this.allowChildren,
            offer_cribs: this.offerCribs,
            apartment_size: this.apartmentSize,
            apartment_unit: this.apartmentUnit,
        };
        this.isLoading = true;
        fetch(`/partner/property/${this.propertyId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.propertyWizardStep++;
            } else {
                alert('Error: ' + (data.message || 'Could not update property details.'));
            }
        })
        .catch(err => {
            alert('AJAX error: ' + err.message);
        })
        .finally(() => {
            this.isLoading = false;
        });
    },
    // Photo upload methods
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
        };
        this.isLoading = true;
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
    },
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
                x-for="(label, index) in ['Basic information', 'Property setup', 'Photos', 'Pricing and calendar', 'Legal information', 'Review and complete']"
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
          <section x-show="step === 2">
            <div class="w-full max-w-xl p-4 ml-32">
              <template x-if="propertyWizardStep === 1">
                <div>
                  <!-- Header -->
                  <h2 class="text-2xl font-bold mb-6">Property details</h2>
                  <p class="text-gray-600 mb-4">Where can people sleep?</p>
                  <!-- Bedroom Cards -->
                  <div class="space-y-4">
                    <!-- Loop through rooms to display cards -->
                    <template x-for="(room, id) in rooms" :key="id">
                      <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                        <div>
                          <h3 class="text-lg font-medium" x-text="room.name"></h3>
                          <p class="text-sm text-gray-600" x-text="getBedSummary(id)"></p>
                        </div>
                        <button
                          @click="openBedTypeSelector(id)"
                          class="bg-gray-200 hover:bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-full focus:outline-none"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                            />
                          </svg>
                        </button>
                      </div>
                    </template>
                  </div>
                  <!-- Add Bedroom Button -->
                  <div class="flex items-center mt-6">
                    <button
                      @click="addBedroom()"
                      class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      Add bedroom
                    </button>
                  </div>
                  <!-- Bed Type Selector Modal -->
                  <div
                    x-show="showBedTypeSelector"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                  >
                    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                      <h3
                        class="text-xl font-semibold mb-2"
                        x-text="rooms[currentEditingRoomId]?.name || 'New Bedroom'"
                      ></h3>
                      <p class="text-gray-600 mb-6">Which beds are available in this room?</p>
                      <div class="space-y-4">
                        <!-- If editing Living room, only show Sofa bed -->
                        <template x-if="currentEditingRoomId === 'livingRoom'">
                          <div class="flex justify-between items-center py-3 border-b">
                            <div>
                              <div class="font-medium">Sofa bed(s)</div>
                              <div class="text-sm text-gray-500">Varying sizes</div>
                            </div>
                            <div class="flex items-center space-x-3">
                              <button @click="if(tempBedCounts.sofa > 0) tempBedCounts.sofa--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                              </button>
                              <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.sofa"></span>
                              <button @click="tempBedCounts.sofa++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                              </button>
                            </div>
                          </div>
                        </template>
                        <!-- For all other rooms, show standard and more bed options as before -->
                        <template x-if="currentEditingRoomId !== 'livingRoom'">
                          <div>
                            <!-- Standard Bed Options (Twin, Full, Queen, King) -->
                            <div class="space-y-4">
                              <!-- Twin Bed -->
                              <div class="flex justify-between items-center py-3 border-b">
                                <div>
                                  <div class="font-medium">Twin bed(s)</div>
                                  <div class="text-sm text-gray-500">35–51 inches wide</div>
                                </div>
                                <div class="flex items-center space-x-3">
                                  <button @click="if(tempBedCounts.twin > 0) tempBedCounts.twin--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                  </button>
                                  <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.twin"></span>
                                  <button @click="tempBedCounts.twin++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                  </button>
                                </div>
                              </div>
                              <!-- Full Bed -->
                              <div class="flex justify-between items-center py-3 border-b">
                                <div>
                                  <div class="font-medium">Full bed(s)</div>
                                  <div class="text-sm text-gray-500">52–59 inches wide</div>
                                </div>
                                <div class="flex items-center space-x-3">
                                  <button @click="if(tempBedCounts.full > 0) tempBedCounts.full--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                  </button>
                                  <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.full"></span>
                                  <button @click="tempBedCounts.full++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                  </button>
                                </div>
                              </div>
                              <!-- Queen Bed -->
                              <div class="flex justify-between items-center py-3 border-b">
                                <div>
                                  <div class="font-medium">Queen bed(s)</div>
                                  <div class="text-sm text-gray-500">60–70 inches wide</div>
                                </div>
                                <div class="flex items-center space-x-3">
                                  <button @click="if(tempBedCounts.queen > 0) tempBedCounts.queen--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                  </button>
                                  <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.queen"></span>
                                  <button @click="tempBedCounts.queen++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                  </button>
                                </div>
                              </div>
                              <!-- King Bed -->
                              <div class="flex justify-between items-center py-3 border-b">
                                <div>
                                  <div class="font-medium">King bed(s)</div>
                                  <div class="text-sm text-gray-500">71–81 inches wide</div>
                                </div>
                                <div class="flex items-center space-x-3">
                                  <button @click="if(tempBedCounts.king > 0) tempBedCounts.king--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                  </button>
                                  <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.king"></span>
                                  <button @click="tempBedCounts.king++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                  </button>
                                </div>
                              </div>
                            </div>
                            <!-- More bed options toggle -->
                            <div class="py-3">
                              <button
                                @click="showAllBedTypesInModal = !showAllBedTypesInModal"
                                class="text-blue-600 hover:text-blue-800 font-medium p-0 h-auto"
                              >
                                <span x-text="showAllBedTypesInModal ? 'Fewer bed options' : 'More bed options'"></span>
                              </button>
                            </div>
                            <!-- More Bed Types (Bunk, Sofa, Futon) -->
                            <template x-if="showAllBedTypesInModal">
                              <div class="space-y-4">
                                <!-- Bunk Bed -->
                                <div class="flex justify-between items-center py-3 border-b">
                                  <div>
                                    <div class="font-medium">Bunk bed(s)</div>
                                    <div class="text-sm text-gray-500">Varying sizes</div>
                                  </div>
                                  <div class="flex items-center space-x-3">
                                    <button @click="if(tempBedCounts.bunk > 0) tempBedCounts.bunk--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.bunk"></span>
                                    <button @click="tempBedCounts.bunk++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                  </div>
                                </div>
                                <!-- Sofa Bed -->
                                <div class="flex justify-between items-center py-3 border-b">
                                  <div>
                                    <div class="font-medium">Sofa bed(s)</div>
                                    <div class="text-sm text-gray-500">Varying sizes</div>
                                  </div>
                                  <div class="flex items-center space-x-3">
                                    <button @click="if(tempBedCounts.sofa > 0) tempBedCounts.sofa--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.sofa"></span>
                                    <button @click="tempBedCounts.sofa++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                  </div>
                                </div>
                                <!-- Futon Bed -->
                                <div class="flex justify-between items-center py-3 border-b">
                                  <div>
                                    <div class="font-medium">Futon bed(s)</div>
                                    <div class="text-sm text-gray-500">Varying sizes</div>
                                  </div>
                                  <div class="flex items-center space-x-3">
                                    <button @click="if(tempBedCounts.futon > 0) tempBedCounts.futon--" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="font-bold text-lg w-6 text-center" x-text="tempBedCounts.futon"></span>
                                    <button @click="tempBedCounts.futon++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </template>
                          </div>
                        </template>
                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-6 pt-4 border-t">
                          <button
                            @click="cancelBedTypes()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium"
                          >
                            Cancel
                          </button>
                          <button
                            @click="saveBedTypes()"
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700"
                          >
                            Save
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="bg-white p-6 rounded-lg shadow-sm mt-8">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">How many guests can stay?</h3>
                    <div class="flex items-center justify-center space-x-4">
                      <button
                        type="button"
                        @click="guests = Math.max(1, guests - 1)"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                        aria-label="Decrease guests"
                      >-</button>
                      <span class="text-2xl font-bold w-12 text-center" x-text="guests"></span>
                      <button
                        type="button"
                        @click="guests = guests + 1"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                        aria-label="Increase guests"
                      >+</button>
                    </div>
                  </div>

                  <div class="bg-white p-6 rounded-lg shadow-sm mt-8">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">How many bathrooms are there?</h3>
                    <div class="flex items-center justify-center space-x-4">
                      <button
                        type="button"
                        @click="bathrooms = Math.max(0, bathrooms - 1)"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                        aria-label="Decrease bathrooms"
                      >-</button>
                      <span class="text-2xl font-bold w-12 text-center" x-text="bathrooms"></span>
                      <button
                        type="button"
                        @click="bathrooms = bathrooms + 1"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center"
                        aria-label="Increase bathrooms"
                      >+</button>
                    </div>
                  </div>

                  <div class="bg-white p-6 rounded-lg shadow-sm space-y-6 mt-8">
                  
                    <div>
                      <h3 class="text-base font-semibold text-gray-800 mb-4">Do you allow children?</h3>
                      <div class="flex space-x-6">
                        <label class="flex items-center space-x-2">
                          <input type="radio" x-model="allowChildren" value="yes" />
                          <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                          <input type="radio" x-model="allowChildren" value="no" />
                          <span>No</span>
                        </label>
                      </div>
                    </div>

                   
                    <div>
                      <h3 class="text-base font-semibold text-gray-800 mb-4">Do you offer cribs?</h3>
                      <p class="text-sm text-gray-600 mb-4">
                        Cribs sleep most infants 0–3 years old and are available to guests on request.
                      </p>
                      <div class="flex space-x-6">
                        <label class="flex items-center space-x-2">
                          <input type="radio" x-model="offerCribs" value="yes" />
                          <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                          <input type="radio" x-model="offerCribs" value="no" />
                          <span>No</span>
                        </label>
                      </div>
                    </div>
                  </div>

                 
                  <div class="bg-white p-6 rounded-lg shadow-sm mt-8">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">How big is this apartment?</h3>
                    <div class="flex items-center space-x-4">
                      <div class="flex-1">
                        <label for="apartment-size" class="sr-only">Apartment size</label>
                        <input
                          type="number"
                          id="apartment-size"
                          x-model="apartmentSize"
                          placeholder="Apartment size - optional"
                          class="w-full border border-gray-300 rounded p-2"
                        />
                      </div>
                      <select x-model="apartmentUnit" class="w-[150px] border border-gray-300 rounded p-2">
                        <option value="" disabled>Select unit</option>
                        <option value="square meters">square meters</option>
                        <option value="square feet">square feet</option>
                      </select>
                    </div>
                  </div>
                  <!-- Navigation buttons -->
                  <div class="flex justify-between mt-8">
                    <button
                      @click="propertyWizardStep--"
                      class="text-blue-600 border border-blue-600 px-4 py-2 rounded hover:bg-blue-50"
                    >
                      Back
                    </button>
                    <button
                      @click="saveAdditionalDetails()"
                      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                      Next
                    </button>
                  </div>
                </div>
              </template>
              <template x-if="propertyWizardStep === 2">
                <div class="max-w-4xl mx-auto space-y-8">
                  <!-- Heading -->
                  <h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>
                  <!-- Amenities Section Container -->
                  <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                    @php
                      $amenities = [
                          'Highlights' => ['Private bathroom', 'Sea views', 'Family rooms', 'Airport shuttle', 'Spa and wellness center'],
                          'General' => ['Air conditioning', 'Heating', 'Free WiFi', 'Electric vehicle charging station'],
                          'Cooking and cleaning' => ['Kitchen', 'Microwave', 'Washing machine'],
                          'Entertainment' => ['Flat-screen TV', 'Swimming Pool', 'Hot tub', 'Minibar', 'Sauna'],
                          'Outside and view' => ['Balcony', 'Garden view', 'Terrace', 'View'],
                      ];
                    @endphp
                    @foreach ($amenities as $category => $items)
                      <div class="space-y-3">
                        <h3 class="text-base font-semibold text-gray-800">{{ $category }}</h3>
                        <div class="flex flex-col space-y-2">
                          @foreach ($items as $item)
                            <label class="flex items-center space-x-2 text-gray-700 text-sm">
                              <input type="checkbox" name="amenities[]" value="{{ $item }}" class="form-checkbox h-5 w-5 text-blue-600" />
                              <span>{{ $item }}</span>
                            </label>
                          @endforeach
                        </div>
                        @if (!$loop->last)
                          <hr class="border-t border-gray-200 mt-4" />
                        @endif
                      </div>
                    @endforeach
                  </div>
                  <div class="flex justify-between mt-6">
                    <!-- Back Button -->
                    <button
                      type="button"
                      @click="propertyWizardStep--"
                      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded"
                    >
                      ←
                    </button>
                    <!-- Continue Button -->
                    <!-- Continue Button (inside input field container, aligned right) -->
                    <div class="flex justify-end">
                      <button
                        type="submit"
                        @click="propertyWizardStep++"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                      >
                        Continue
                      </button>
                    </div>
                  </div>
                </div>
              </template>
              <template x-if="propertyWizardStep === 3">
                <div class="space-y-4">
                  <h2 class="text-xl font-semibold text-gray-800">Step 3: Facilities</h2>
                  <!-- Facilities Checkboxes -->
                  <div class="space-y-2">
                    <label class="block"><input type="checkbox" class="mr-2" />Wi-Fi</label>
                    <label class="block"><input type="checkbox" class="mr-2" />Parking</label>
                    <label class="block"><input type="checkbox" class="mr-2" />Swimming Pool</label>
                  </div>
                  <div class="flex justify-between mt-4">
                    <button
                      @click="propertyWizardStep--"
                      class="text-blue-600 border border-blue-600 px-4 py-2 rounded hover:bg-blue-50"
                    >
                      Back
                    </button>
                    <button
                      @click="propertyWizardStep++"
                      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                      Next
                    </button>
                  </div>
                </div>
              </template>
              <template x-if="propertyWizardStep === 4">
                <div class="max-w-4xl mx-auto space-y-8">
                  <div class="container ml-24 px-4 py-8 max-w-2xl">
                    <!-- Header -->
                    <h2 class="text-2xl font-bold mb-8 text-left">What languages do you or your staff speak?</h2>
                    <!-- Language Selection Section -->
                    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                      <h3 class="text-lg mb-4 font-bold">Select languages</h3>
                      <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                          <input type="checkbox" class="mr-2" />
                          <span>English</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                          <input type="checkbox" class="mr-2" />
                          <span>French</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                          <input type="checkbox" class="mr-2" />
                          <span>German</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                          <input type="checkbox" class="mr-2" />
                          <span>Hindi</span>
                        </label>
                      </div>
                      <!-- Add Additional Languages -->
                      <div id="additionalLanguagesSection" class="mt-4 hidden relative">
                        <h3 class="text-lg font-medium mb-2">Add additional languages</h3>
                        <!-- Searchable dropdown container -->
                        <div class="relative w-full max-w-md">
                          <input
                            type="text"
                            id="languageInput"
                            oninput="filterDropdown()"
                            onclick="toggleDropdown()"
                            placeholder="Search languages..."
                            autocomplete="off"
                            class="w-full border rounded p-2 pr-10 cursor-pointer"
                            readonly
                          />
                          <!-- Dropdown arrow -->
                          <button
                            type="button"
                            onclick="toggleDropdown()"
                            class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
                            tabindex="-1"
                          >
                            ▼
                          </button>
                          <!-- Dropdown list -->
                          <ul
                            id="languageDropdown"
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg hidden"
                          >
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Arabic</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Bulgarian</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Catalan</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Chinese</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Croatian</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Czech</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Danish</li>
                            <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Dutch</li>
                          </ul>
                        </div>
                      </div>
                      <!-- Toggle Button for Additional Languages -->
                      <a
                        href="#"
                        onclick="event.preventDefault(); toggleAdditionalLanguages();"
                        class="text-blue-500 hover:underline mt-4 block"
                      >
                        Add additional languages
                      </a>
                    </div>
                    <!-- Navigation Buttons -->
                    <div class="mt-8 flex justify-between">
                      <!-- Back Button on the left -->
                      <button
                        type="button"
                        @click="propertyWizardStep--"
                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded"
                      >
                        ←
                      </button>
                      <!-- Continue Button on the right -->
                      <button
                        type="button"
                        @click="propertyWizardStep++"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                      >
                        Continue
                      </button>
                    </div>
                  </div>
                  <script>
                    function toggleAdditionalLanguages() {
                      const section = document.getElementById('additionalLanguagesSection');
                      section.classList.toggle('hidden');
                      if (!section.classList.contains('hidden')) {
                        document.getElementById('languageInput').focus();
                        showDropdown();
                      } else {
                        hideDropdown();
                      }
                    }
                    function toggleDropdown() {
                      const dropdown = document.getElementById('languageDropdown');
                      dropdown.classList.toggle('hidden');
                    }
                    function showDropdown() {
                      document.getElementById('languageDropdown').classList.remove('hidden');
                    }
                    function hideDropdown() {
                      document.getElementById('languageDropdown').classList.add('hidden');
                    }
                    function filterDropdown() {
                      const input = document.getElementById('languageInput');
                      const filter = input.value.toLowerCase();
                      const ul = document.getElementById('languageDropdown');
                      const items = ul.getElementsByTagName('li');
                      ul.classList.remove('hidden');
                      let visibleCount = 0;
                      for (let i = 0; i < items.length; i++) {
                        const txtValue = items[i].textContent || items[i].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                          items[i].style.display = '';
                          visibleCount++;
                        } else {
                          items[i].style.display = 'none';
                        }
                      }
                      // Hide dropdown if no matches
                      if (visibleCount === 0) {
                        ul.classList.add('hidden');
                      }
                    }
                    function selectLanguage(element) {
                      const input = document.getElementById('languageInput');
                      input.value = element.textContent;
                      hideDropdown();
                    }
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function (event) {
                      const dropdown = document.getElementById('languageDropdown');
                      const input = document.getElementById('languageInput');
                      const container = document.getElementById('additionalLanguagesSection');
                      if (!container.contains(event.target)) {
                        hideDropdown();
                      }
                    });
                  </script>
                </div>
              </template>
              <template x-if="propertyWizardStep === 5">
                <div class="space-y-4">
                  <h2 class="text-xl font-semibold text-gray-800">Step 5: Confirm Details</h2>
                  <p class="text-gray-600">Review and confirm the details you've entered.</p>
                  <!-- Just placeholder review text -->
                  <ul class="list-disc list-inside text-gray-700">
                    <li>Property: Villa</li>
                    <li>Rooms: 3</li>
                    <li>Facilities: Wi-Fi, Parking</li>
                  </ul>
                  <div class="flex justify-between mt-4">
                    <button
                      @click="propertyWizardStep--"
                      class="text-blue-600 border border-blue-600 px-4 py-2 rounded hover:bg-blue-50"
                    >
                      Back
                    </button>
                    <button
                      @click="step = 3; propertyWizardStep = 1"
                      class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    >
                      Finish & Continue →
                    </button>
                  </div>
                </div>
              </template>
              <template x-if="propertyWizardStep === 6">
                <div class="space-y-4">
                  <h2 class="text-xl font-semibold text-gray-800">Step 5: Confirm Details</h2>
                  <p class="text-gray-600">Review and confirm the details you've entered.</p>
                  <!-- Just placeholder review text -->
                  <ul class="list-disc list-inside text-gray-700">
                    <li>Property: Villa</li>
                    <li>Rooms: 3</li>
                    <li>Facilities: Wi-Fi, Parking</li>
                  </ul>
                  <div class="flex justify-between mt-4">
                    <button
                      @click="propertyWizardStep--"
                      class="text-blue-600 border border-blue-600 px-4 py-2 rounded hover:bg-blue-50"
                    >
                      Back
                    </button>
                    <button
                      @click="step = 3; propertyWizardStep = 1"
                      class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    >
                      Finish & Continue →
                    </button>
                  </div>
                </div>
              </template>
            </div>
          </section>
          <!-- ✅ Step 3: Photos Upload Section -->
          <!-- ✅ Step 3: Photos Upload Section -->
          <!-- ✅ Step 3: Photos Upload Section -->
          <section
            x-show="step === 3"
            class="px-4 py-6 md:px-8 lg:px-16 flex justify-center"
            x-data="{
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
                  >
                    ←
                  </button>
                  <button
                    :disabled="uploadedPhotos.length < 3"
                    :class="{
                      'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700':
                        uploadedPhotos.length >= 3,
                      'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3,
                    }"
                    class="px-6 py-2 text-white rounded"
                  >
                    Continue
                  </button>
                </div>
              </div>
            </section>
            <!-- ✅ Step 4: Pricing and Calendar -->
            <section x-show="step === 4">
              <h2 class="text-2xl font-bold text-blue-700 mb-4">Pricing and calendar</h2>
              <p class="text-gray-600">Set your nightly rates, availability, and booking rules.</p>
              <!-- Add your pricing and calendar form here -->
            </section>
            <!-- ✅ Step 5: Legal Information -->
            <section x-show="step === 5">
              <h2 class="text-2xl font-bold text-blue-700 mb-4">Legal information</h2>
              <p class="text-gray-600">Provide required legal documents and compliance information.</p>
              <!-- Add your legal details form here -->
            </section>
            <!-- ✅ Step 6: Review and Complete -->
            <section x-show="step === 6">
              <h2 class="text-2xl font-bold text-blue-700 mb-4">Review and complete</h2>
              <p class="text-gray-600">Review all details you've entered before publishing your property listing.</p>
              <!-- Add summary and submit button here -->
            </section>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>