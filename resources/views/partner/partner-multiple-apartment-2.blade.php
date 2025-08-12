@extends('frontend.partner-layout')

@section('title', 'Apartment Multiple Homes')

@section('content')

<!-- Add CSRF token meta tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Define Alpine.js data function -->
<script>
function apartmentForm2Data() {
    return {
        step: 1,
        selectedAmenities: [],
        propertyId: {{ $propertyId ?? 'null' }},
        propertyCount: 1,
        uploadedPhotos: @json($propertyData['photos'] ?? []),
        guests: 2,
        bathrooms: 1,
        allowChildren: 'yes',
        offerCribs: 'no',
        apartmentSize: 100,
        apartmentUnit: 'square meters',
        showTips: true,
        count: 2,
        showDetails: false,
        showTip1: true,
        showTip2: true,
        feedback: null,
        showDiscount: false,
        pricePerNight: 120.00,
        currency: 'USD',
        showDiscountOption: false,
        // Rate plans data
        standardRate: {
            cancellation_policy: 'flexible', // 1 day before arrival
            group_pricing: {
                '1': 27.00,
                '2': 30.00
            }
        },
        nonRefundableRate: {
            enabled: true,
            discount_percent: 10
        },
        weeklyRate: {
            enabled: true,
            discount_percent: 15,
            min_nights: 7
        },

        
        init() {
            // Initialize form data
        },
        
        async saveStep1Data() {
            if (!this.propertyId) {
                this.step++;
                return;
            }
            
            try {
                // First save step 1 data
                const step1Response = await fetch(`/partner/property/${this.propertyId}/step1-data`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guests: this.guests,
                        bathrooms: this.bathrooms,
                        property_count: this.propertyCount,
                        bedrooms: this.bedrooms
                    })
                });
                
                const step1Result = await step1Response.json();
                
                // Then save additional details
                const additionalDetailsResponse = await fetch(`/partner/property/${this.propertyId}/additional-details`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guests: this.guests,
                        bathrooms: this.bathrooms,
                        allow_children: this.allowChildren,
                        offer_cribs: this.offerCribs,
                        apartment_size: this.apartmentSize,
                        apartment_unit: this.apartmentUnit
                    })
                });
                
                const additionalDetailsResult = await additionalDetailsResponse.json();
                
                // Proceed to next step regardless of save results
                this.step++;
                
            } catch (error) {
                console.error('Error saving data:', error);
                // Proceed to next step even if save fails
                this.step++;
            }
        },
        
        async saveAmenities() {
            if (!this.propertyId) {
                this.step++;
                return;
            }
            
            try {
                // First save amenities
                if (this.selectedAmenities.length > 0) {
                    const amenitiesResponse = await fetch(`/partner/property/save-amenities/${this.propertyId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            amenities: this.selectedAmenities,
                            property_id: this.propertyId
                        })
                    });
                    
                    const amenitiesResult = await amenitiesResponse.json();
                    if (!amenitiesResult.success) {
                        alert('Failed to save amenities: ' + (amenitiesResult.message || 'Unknown error'));
                        return;
                    }
                }
                
                // Then save additional details
                const additionalDetailsResponse = await fetch(`/partner/property/${this.propertyId}/additional-details`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guests: this.guests,
                        bathrooms: this.bathrooms,
                        allow_children: this.allowChildren,
                        offer_cribs: this.offerCribs,
                        apartment_size: this.apartmentSize,
                        apartment_unit: this.apartmentUnit
                    })
                });
                
                const additionalDetailsResult = await additionalDetailsResponse.json();
                if (additionalDetailsResult.success) {
                    this.step++;
                } else {
                    alert('Failed to save additional details: ' + (additionalDetailsResult.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error saving data:', error);
                alert('Error saving data: ' + error.message);
            }
        },
        
        handleUpload(event) {
            const files = Array.from(event.target.files).slice(0, 5 - this.uploadedPhotos.length);
            files.forEach(file => {
                this.uploadedPhotos.push({ file, url: null });
            });
        },
        
        handleUploadDrop(event) {
            const dt = event.dataTransfer;
            if (!dt) return;
            const files = Array.from(dt.files).slice(0, 5 - this.uploadedPhotos.length);
            files.forEach(file => {
                this.uploadedPhotos.push({ file, url: null });
            });
        },
        
        removePhoto(index) {
            const photo = this.uploadedPhotos[index];
            // If it's a new photo with a file, revoke the object URL to free memory
            if (photo.file && photo.url) {
                URL.revokeObjectURL(photo.url);
            }
            this.uploadedPhotos.splice(index, 1);
        },
        
        async uploadPhotosAndContinue() {
            if (this.uploadedPhotos.length < 3) {
                alert('Please upload at least 3 photos');
                return;
            }
            
            if (!this.propertyId) {
                alert('No property ID available');
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('property_id', this.propertyId);
                
                // Only upload new photos (those with file property)
                const newPhotos = this.uploadedPhotos.filter(photo => photo.file);
                newPhotos.forEach((photo, index) => {
                    formData.append(`photos[${index}]`, photo.file);
                });
                
                // If there are new photos to upload, do the upload
                if (newPhotos.length > 0) {
                    const response = await fetch(`/partner/property/upload-photos`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        body: formData
                    });
                    
                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('Error uploading photos:', errorData);
                        alert('Error uploading photos: ' + (errorData.message || 'Unknown error'));
                        return;
                    }
                    console.log('New photos uploaded successfully');
                }
                
                console.log('Current step before:', this.step);
                this.step = 4; // Go to step 4 instead of redirecting
                console.log('Current step after:', this.step);
            } catch (error) {
                console.error('Error uploading photos:', error);
                alert('Error uploading photos: ' + error.message);
            }
        },
        
        async savePricing() {
            if (!this.propertyId) {
                this.step++;
                return;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}/pricing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        property_id: this.propertyId,
                        booking_type: 'instant',
                        price_per_night: this.pricePerNight,
                        currency: this.currency.toLowerCase(),
                        discount_enabled: this.showDiscountOption,
                        discount_percent: this.showDiscountOption ? 20 : 0
                    })
                });
                
                const result = await response.json();
                console.log('Pricing save response:', result);
                
                if (result.success) {
                    console.log('Pricing saved successfully, moving to next step');
                    this.step++;
                } else {
                    console.error('Pricing save failed:', result);
                    alert('Failed to save pricing: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error saving pricing:', error);
                // Don't show alert for network errors, just log them
                console.log('Network error occurred, but pricing may have been saved');
                // Still proceed to next step even if there's a network error
                this.step++;
            }
        },
        
        async saveRatePlans() {
            // For now, skip database save and directly redirect to final step
            const currentPropertyId = '{{ $propertyId ?? 116 }}';
            window.location.href = `/partner-apartments-final/${currentPropertyId}`;
        }
    }
}
</script>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js?v={{ time() }}&v={{ rand(1000, 9999) }}" defer></script>

<!-- Alpine Data Scope -->
<div x-data="apartmentForm2Data()">

    <!-- Full-width Progress Bar (just under header) -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500"
             :style="'width:' + (step * 100 / 5) + '%'">
        </div>
    </div>

    <!-- Step 1 -->
    <template x-if="step === 1">
        <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
            <h2 class="text-2xl font-bold text-gray-900 mt-8">Property details</h2>

            <!-- Where can people sleep -->
            <div class="bg-white p-4 rounded-lg shadow space-y-4">
                <h2 class="text-lg font-semibold">Where can people sleep?</h2>

                <div class="flex flex-col gap-4">
                    <!-- Bedroom -->
                    <a href="{{ route('partner.apartment.bedrooms', ['property' => $propertyId]) }}?source=multiple&step=2">
                        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                            <p class="text-sm">Bedroom 1</p>
                            <p class="text-sm text-gray-600">
                                @if(isset($roomDisplayData['bedroom']) && $roomDisplayData['bedroom']['has_beds'])
                                    {{ $roomDisplayData['bedroom']['bed_summary'] }}
                                @else
                                    No beds added
                                @endif
                            </p>
                        </div>
                    </a>

                    <!-- Living Room -->
                    <a href="{{ route('partner.apartment.livingroom', ['property' => $propertyId]) }}?source=multiple&step=2">
                        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                            <p class="text-sm">Living Room</p>
                            <p class="text-sm text-gray-600">
                                @if(isset($roomDisplayData['living_room']) && $roomDisplayData['living_room']['has_beds'])
                                    {{ $roomDisplayData['living_room']['bed_summary'] }}
                                @else
                                    No beds added
                                @endif
                            </p>
                        </div>
                    </a>

                    <!-- Other Spaces -->
                    <a href="{{ route('partner.apartment.otherspaces', ['property' => $propertyId]) }}?source=multiple&step=2">
                        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                            <p class="text-sm">Other spaces</p>
                            <p class="text-sm text-gray-600">
                                @if(isset($roomDisplayData['other']) && $roomDisplayData['other']['has_beds'])
                                    {{ $roomDisplayData['other']['bed_summary'] }}
                                @else
                                    No beds added
                                @endif
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Add Bedroom Button (navigate to 2nd page) -->
                <a href="{{ route('partner.apartment.bedrooms', ['property' => $propertyId]) }}?source=multiple&step=2" class="text-blue-600 hover:underline text-sm flex items-center space-x-1 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add Bedroom</span>
                </a>
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
                    <p class="font-medium text-sm">Do you offer cribs?</p>
                    <p class="text-xs text-gray-500">Cribs sleep most infants 0–3 years old and are available to guests on request.</p>
                    <label class="mr-4 text-sm"><input type="radio" name="infants" value="yes" x-model="offerCribs" checked> Yes</label>
                    <label class="text-sm"><input type="radio" name="infants" value="no" x-model="offerCribs"> No</label>
                </div>
            </div>

            <!-- Room Size -->
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4">
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
                            name="property_count"
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

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <button type="button" @click="step > 1 ? step-- : step"
                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                    ←
                </button>

                <button type="button" @click="saveStep1Data()"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    Continue
                </button>
            </div>
        </div>
    </template>

    <!-- Step 2 -->
  <template x-if="step === 2">
    <div class="max-w-2xl mx-auto lg:ml-32 px-4 space-y-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-gray-900 mt-10">
            What amenities does this room have?
        </h2>

       
        <!-- Amenities List -->
        <div class="bg-white p-6 space-y-3 shadow-sm rounded">
            @foreach ($amenities as $amenity)
                <label class="flex items-center space-x-3 text-gray-800 text-sm">
                    <input type="checkbox" 
                           x-model="selectedAmenities" 
                           value="{{ $amenity->id }}" 
                           class="h-4 w-4 text-blue-600">
                    <span>{{ $amenity->name }}</span>
                </label>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mb-10">
            <!-- Back Button -->
            <button
                type="button"
                @click="step--"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-5 py-2 rounded">
                ←
            </button>

            <!-- Continue Button -->
            <button
                type="button"
                @click="saveAmenities()"
                class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Continue
            </button>
        </div>
    </div>
</template>



    <!-- Step 3 -->
    <template x-if="step === 3">
    

    <!-- ✅ Single Step Section (no condition needed) -->
    <div class="px-4 py-8 mt-2 w-full max-w-6xl mx-auto lg:ml-24 space-y-6">

        <section class="px-4 py-6 md:px-8 lg:px-16 flex justify-center">
            <div class="w-full max-w-6xl">
                <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">What does your place look
                    like?</h2>

                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
                    <!-- 📸 Photo Upload Area -->
                    <div class="border rounded-lg p-6 bg-white shadow-sm">
                        <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
                        <p class="text-sm text-gray-600 mb-4">The more you upload, the more likely you are to get
                            bookings. You can add more later.</p>

                        <!-- Upload box with drag and drop -->
                        <div class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
                            @dragover.prevent @drop.prevent="handleUploadDrop($event)">
                            <div class="mb-4">
                                <!-- camera SVG -->
                            </div>
                            <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>

                            <label
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
                                for="fileInput">
                                <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload"
                                    class="w-4 h-4" />
                                <span>Upload photos</span>
                            </label>
                            <input id="fileInput" type="file" multiple accept="image/*" class="hidden"
                                @change="handleUpload" />


                            <p class="text-xs text-gray-500 mt-2">jpg/jpeg or png, maximum 47MB each, max 5 images</p>
                        </div>

                        <!-- Uploaded photo previews -->
                        <template x-if="uploadedPhotos.length > 0">
                            <div>
                                <!-- 📝 Instructions placed properly above the grid -->
                                <p class="text-sm font-semibold text-gray-700 mb-1">Choose a main photo that will give a
                                    good first impression</p>
                                <p class="text-sm font-semibold text-gray-700 mb-4">Click and drag the photos to arrange
                                    them in the order you would like the guests to see them</p>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    <template x-for="(photo, index) in uploadedPhotos" :key="index">
                                        <div class="relative group border rounded overflow-hidden" draggable="true"
                                            @dragstart="event.dataTransfer.setData('text/plain', index)"
                                            @dragover.prevent
                                            @drop="const from = Number(event.dataTransfer.getData('text/plain'));
                    const to = index;
                    if (from !== to) {
                      const moved = uploadedPhotos.splice(from, 1)[0];
                      uploadedPhotos.splice(to, 0, moved);
                    }">
                                            <!-- Badge for main photo -->
                                            <template x-if="index === 0">
                                                <span
                                                    class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main
                                                    Photo</span>
                                            </template>

                                            <!-- Remove Button -->
                                            <button @click="removePhoto(index)"
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75">
                                                &times;
                                            </button>

                                            <img :src="photo.file ? URL.createObjectURL(photo.file) : photo.url" alt="Uploaded photo"
                                                class="w-full h-32 object-cover" />
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>


                    </div>

                    <!-- ℹ️ Tips Box -->
                    <div>
                        <div x-show="showTips" x-transition
                            class="bg-white border rounded-none p-4 shadow-sm relative text-sm">

                            <button @click="showTips = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
                                aria-label="Close">
                                &times;
                            </button>

                            <h3 class="font-semibold text-gray-800 mb-2 text-base">What if I don't have professional
                                photos?</h3>
                            <p class="text-gray-600 mb-2">
                                No problem! You can use a smartphone or a digital camera.Here are some tips for taking
                                great photos of your property
                            </p>
                            <a href="#" class="text-[#3CC0E9] hover:underline block mb-2">
                                Here are some tips for taking great photos of your property
                            </a>
                            <p class="text-gray-600">
                                If you don’t know who took a photo, it's best not to use it. Only use photos others have
                                taken if you have permission.
                            </p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between">

                      
                            <!-- Back Button -->
<button @click="step < 5 ? step-- : step"
    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
    ←
</button>

<!-- Continue Button -->
<button 
    :disabled="uploadedPhotos.length < 3"
    @click="uploadPhotosAndContinue()"
    :class="{
        'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 cursor-pointer opacity-100': uploadedPhotos.length >= 3,
        'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3
    }"
    class="px-6 py-2 text-white rounded">
    Continue
</button>

                    </div>
                </div>
        </section>


    </div>

    </template>
  <template x-if="step === 4">
    <div class="max-w-xl mx-auto lg:ml-32 p-4 mt-12">
        
        <h2 class="text-xl md:text-2xl font-semibold mb-6 text-gray-900">
            How many apartments with this layout do you have?
        </h2>
        <div class="bg-white px-4 py-6  w-full max-w-3xl mx-auto shadow rounded-lg">
            <div class="space-y-6">

            <!-- Count Selector -->
            <div class="bg-white rounded-lg shadow p-4">
                <label class="block text-gray-800 font-medium mb-2">
                    Number of apartments with this layout
                </label>
                <div class="flex items-center space-x-4">
                    <button @click="count > 1 && count--"
                        class="text-lg w-10 h-10 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                        −
                    </button>
                    <span class="text-base font-bold w-8 text-center" x-text="count"></span>
                    <button @click="count++"
                        class="text-lg w-10 h-10 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                        +
                    </button>
                </div>
            </div>

            <!-- Apartment Details Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Card Header with Toggle -->
                <div @click="showDetails = !showDetails"
                    class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50">
                    <div>
                        <h3 class="font-semibold text-gray-900">Apartment</h3>
                        <p class="text-sm text-gray-600">
                            @if(isset($roomDisplayData))
                                @php
                                    $totalGuests = 0;
                                    $totalBeds = 0;
                                    $totalBathrooms = isset($propertyData['bathrooms_count']) ? $propertyData['bathrooms_count'] : 1;
                                    
                                    foreach($roomDisplayData as $roomType => $data) {
                                        $totalBeds += $data['total_beds'];
                                    }
                                    
                                    $totalGuests = isset($propertyData['guests_capacity']) ? $propertyData['guests_capacity'] : 2;
                                @endphp
                                {{ $totalGuests }} guests, {{ $totalBeds }} beds, {{ $totalBathrooms }} bathroom{{ $totalBathrooms > 1 ? 's' : '' }}
                            @else
                                2 guests, 1 bed, 1 bathroom
                            @endif
                        </p>
                    </div>
                    <svg :class="{'rotate-180': showDetails}" class="w-5 h-5 text-gray-500 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <!-- Expanded Section -->
                <div x-show="showDetails" x-collapse>
                  <!-- Image Container -->
<!-- Reduced Width Image Container -->
<div class="max-w-md mx-auto">
    <div class="w-full h-52 md:h-64 rounded-lg bg-gray-200 overflow-hidden">
        <template x-if="uploadedPhotos.length > 0">
            <img :src="uploadedPhotos[0].file ? URL.createObjectURL(uploadedPhotos[0].file) : uploadedPhotos[0].url" 
                 alt="Apartment" 
                 class="w-full h-full object-cover" />
        </template>
        <template x-if="uploadedPhotos.length === 0">
            <img src="{{ asset('assets/double-room.jpg') }}" alt="Apartment" class="w-full h-full object-cover" />
        </template>
    </div>
</div>

                    <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-700">
                        <div>
                            <span class="block font-bold">Guests</span>
                            @if(isset($propertyData['guests_capacity']))
                                {{ $propertyData['guests_capacity'] }}
                            @else
                                2
                            @endif
                        </div>
                        <div>
                            <span class="block font-bold">Beds</span>
                            @if(isset($roomDisplayData))
                                @php
                                    $totalBeds = 0;
                                    foreach($roomDisplayData as $roomType => $data) {
                                        $totalBeds += $data['total_beds'];
                                    }
                                @endphp
                                {{ $totalBeds }}
                            @else
                                1
                            @endif
                        </div>
                        <div>
                            <span class="block font-bold">Bathrooms</span>
                            @if(isset($propertyData['bathrooms_count']))
                                {{ $propertyData['bathrooms_count'] }}
                            @else
                                1
                            @endif
                        </div>
                        
                        <!-- Room Details -->
                        @if(isset($roomDisplayData))
                            @foreach($roomDisplayData as $roomType => $data)
                                @if($data['has_beds'])
                                    <div class="md:col-span-3">
                                        <span class="block font-bold">{{ $data['name'] }}</span>
                                        {{ $data['bed_summary'] }}
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="md:col-span-3">
                                <span class="block font-bold">Bedroom 1</span>
                                1 double bed
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
            </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            <button @click="step > 1 ? step-- : step"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                ←
            </button>
            <button @click="step++"
                class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500">
                Continue 
            </button>
        </div>
    </div>
</template>

 <template x-if="step === 5">
    <div class="max-w-4xl ml-40 px-4 py-8 mt-6">
        <div class="max-w-4xl mx-auto px-4 py-8 space-y-6">

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-800">Price per night</h2>

            <!-- Grid layout: Pricing insight + Tip box -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

                <!-- Pricing insight card (2/3 width) -->
                <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="font-semibold text-gray-800 text-base">
                        Make your price competitive to increase your chances of getting more bookings.
                    </h3>
                   <p class="text-xs text-gray-600 mt-4 mb-10">
    This is the price range for properties similar to yours.
    <a href="#" class="text-blue-600 underline hover:text-blue-800">Learn more</a>
</p>

<!-- Price Range Display -->
<div class="relative h-2 bg-gray-200 rounded-full mb-10">
    <!-- Active Bar Range (optional highlight bar if needed) -->
    <div class="absolute left-[15%] right-[15%] h-2 bg-blue-600 rounded-full"></div>

    <!-- Median Tag -->
    <div class="absolute left-1/2 transform -translate-x-1/2 -top-4 bg-blue-600 text-white text-xs px-1 py-1 rounded shadow">
        Median: US$3.02
    </div>

    <!-- Min Price -->
    <div class="absolute left-8 -bottom-6 text-sm bg-blue-600 text-white px-2 py-0.5 rounded font-medium shadow">
        US$1.18
    </div>

    <!-- Max Price -->
    <div class="absolute right-8 -bottom-6 text-sm bg-blue-600 text-white px-2 py-0.5 rounded font-medium shadow">
        US$6.55
    </div>
</div>

        <div class="pt-2 text-sm text-gray-700">
  <span>Did this help you decide on a price?</span>

  <!-- Like (Thumbs Up) -->
   <button @click="feedback = 'like'" class="ml-2 focus:outline-none">
    <img 
      :src="feedback === 'like' 
              ? '{{ asset('assets/iconamoon_like-thin (1).svg') }}' 
              : '{{ asset('assets/iconamoon_like-thin.svg') }}'" 
      alt="Like" class="w-5 h-5"
    />
  </button>

  <!-- Dislike (Thumbs Down) -->
    <!-- Dislike -->
  <button @click="feedback = 'dislike'" class="ml-1 focus:outline-none">
    <img 
      :src="feedback === 'dislike' 
              ? '{{ asset('assets/iconamoon_dislike-thin (1).svg') }}' 
              : '{{ asset('assets/iconamoon_dislike-thin.svg') }}'" 
      alt="Dislike" class="w-5 h-5"
    />
  </button>
</div>


                </div>

                <!-- Tip Box 1 (unchanged) -->
                <div x-show="showTip1"
                    class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                    <button @click="showTip1 = false"
                        class="absolute top-2 right-2 text-gray-500 font-semibold">✕</button>

                    <div class="flex items-center mb-2">
                        <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon"
                            class="w-6 h-6 mr-2">
                        <strong>What if I’m not sure about my price?</strong>
                    </div>

                    <p>Don't worry, you can always change it later. You can even set weekend, midweek, and
                        seasonal prices, giving you more control over what you earn.</p>
                </div>
            </div>

            <!-- Price input and Tip 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

                <!-- Price input card (2/3 width) -->
                <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
                    <label class="block font-semibold text-base text-gray-700">How much do you want to charge
                        per night?</label>
                    <div class="relative">
                        <label class="block text-sm text-gray-700 mb-1">Price guests pay</label>

                        <!-- Currency Select Dropdown -->
                        <select x-model="currency"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 focus:outline-none border border-gray-300 rounded-md">
                            <option value="USD">US$</option>
                            <option value="EUR">€</option>
                            <option value="GBP">£</option>
                            <option value="LKR">Rs</option>
                        </select>

                        <!-- Input Field -->
                        <input type="number" x-model="pricePerNight" step="0.01" min="0"
                            class="w-full border border-gray-400 rounded-md p-2 pl-16 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none" />

                        <p class="text-sm text-gray-500 mt-2">Including taxes, commission, and fees</p>
                    </div>

                    <!-- Topic paragraph -->
                    <p class="text-sm text-gray-600 pl-4">
                        <span class="text-gray-500">15.00%</span> {{ config('domains.subdomain') }} commission
                    </p>

                    <!-- Sub-items under topic -->
                    <ul class="text-sm text-gray-600 space-y-1 pl-8">
                        <li><span class="text-green-600 font-semibold">✓</span> 24/7 help in your language</li>
                        <li><span class="text-green-600 font-semibold">✓</span> Save time with automatically
                            confirmed bookings</li>
                        <li><span class="text-green-600 font-semibold">✓</span> We promote your place on Google
                        </li>
                    </ul>

                    <p class="text-sm text-gray-800 font-medium border-t pt-3">US$ 102.00 Your earnings
                        (including taxes)</p>
                </div>

               
            </div>

            <!-- Discount and Tip 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

               <!-- Discount card -->
        <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">

  <!-- Checkbox -->
  <label class="inline-flex items-center">
    <input type="checkbox" class="form-checkbox text-blue-600 rounded-md"
           x-model="showDiscountOption" />
    <span class="ml-2 font-medium text-gray-700 font-semibold">
      Get guests’ attention with a 20% discount
    </span>
  </label>

  <!-- Description -->
  <p class="text-sm text-gray-600">
    Give 20% off your first 3 bookings or for 90 days, whichever comes first.
    <a href="#" class="text-blue-600 underline">Learn more</a>
  </p>

  <!-- Conditional discount section -->
  <template x-if="showDiscount">
    <div>
      <hr class="my-4">
      <p class="text-sm text-gray-800">
        <del class="text-gray-500">US$ 120.00</del>
        <span class="text-green-600 font-semibold">US$ 96.00 per night</span>
      </p>
    </div>
  </template>
</div>


                <!-- Tip Box 2 (separate column) -->
                <div x-show="showTip2"
                    class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                    <button @click="showTip2 = false"
                        class="absolute top-2 right-3 text-gray-500 font-semibold mb-2">✕</button>
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}"
                            alt="Tip Icon" class="w-6 h-6 mr-2">
                        <strong>Rules for setting up a promotion</strong>
                    </div>
                    <p>
                        Make sure you're giving a genuine discount. It must represent a real discount in line
                        with consumer protection rules.
                        <a href="#" class="text-blue-600 underline">Learn More</a>
                    </p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex mt-1">
                <button type="button" @click="step > 1 ? step-- : step"
                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                    ←
                </button>
                <button type="button" @click="savePricing()"
                    class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[402px]">
                    Continue
                </button>
            </div>

        </div>
    </div>
</template>

      <template x-if="step === 6">
           <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

                <!-- Main Title -->
                <h2 class="text-3xl font-bold text-gray-800">Rate plans</h2>

                <!-- Intro Paragraph -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600">
                        To attract a wider range of guests, we suggest setting up multiple rate plans.
                        The recommended prices and policies for each plan are based on data from properties like yours,
                        but they can be edited now or after you complete registration.
                    </p>
                </div>

                <h2 class="text-xl font-semibold text-gray-800">Standard rate plan</h2>

                <!-- Rate Plan Card -->
                <div class="bg-white border rounded-lg p-6 shadow-sm space-y-6 w-full max-w-2xl mx-auto">

                    <!-- Cancellation Policy Section -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-semibold text-gray-700">Cancellation policy</h3>
                                    <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}"
                                        alt="Tip Icon" class="w-5 h-5">
                                </div>
                                <p class="text-xs text-gray-500 mb-4">
                                    This policy is set at the property level – any changes made will be applied to all
                                    rooms.
                                </p>
                                    <p class="text-xs text-green-600">
                                    You’re 91% more likely to get bookings with the pre-selected cancellation policy settings than with a 30-day cancellation policy
                                </p>
                            </div>
                            
   <a href="{{ route('partner.apartment.pricing.policies') }}">
                            
                            <button @click="$refs.section1.scrollIntoView({ behavior: 'smooth' })"
                                class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">
                                Edit
                            </button></a>
                        </div>
                        <hr class="my-4">
                        <ul class="text-gray-900 text-sm space-y-2">
                            <li class="flex items-start gap-2">
                                <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                    class="w-4 h-4 mt-1">
                                <span>Guests can cancel their bookings for free up to 1 day before their arrival</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                    class="w-4 h-4 mt-1">
                                <span>Guests who cancel within 24 hours will have their cancellation fee waived</span>
                            </li>
                        </ul>
                    </div>

                    <hr class="my-4">

                    <!-- Price Per Group Size Section -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold text-gray-700">Price per group size</h3>
                                <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}"
                                    alt="Tip Icon" class="w-5 h-5">
                           
                            </div>

   <a href="{{ route('partner.apartment.price.group') }}">
    <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">
        Edit
    </button>
</a>


                                
                      
                            </div>
                            <p class="text-sm text-yellow-900">
                               Set lower prices for smaller groups of guests to increase your chances of getting bookings
                                </p>
                        <hr class="my-4">
                        <table class="table-auto border-separate border-spacing-x-2 w-full text-left text-gray-700">
                            <tbody>
                                <tr>
                                    <td class="py-2 text-sm font-semibold">Occupancy</td>
                                    <td class="py-2 text-sm font-semibold">Guests pay</td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="flex items-center gap-1">
                                            <img src="{{ asset('assets/guidance_user-1 (1).svg') }}" alt="User Icon"
                                                class="w-5 h-5">
                                            <span>x 2</span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-sm">US$ 30.00</td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="flex items-center gap-1">
                                            <img src="{{ asset('assets/guidance_user-1 (1).svg') }}" alt="User Icon"
                                                class="w-5 h-5">
                                            <span>x 1</span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-sm">US$ 27.00</td>
                                </tr>
                            </tbody>
                        </table>


                    </div>


                </div>

                <h2 class="text-xl font-semibold text-gray-800">Non-refundable rate plan</h2>

                <!-- Second Rate Plan -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-semibold text-gray-700">Price and cancellation policy</h3>
                            <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon"
                                class="w-5 h-5">
                        </div>
                        <a href="{{ route('partner.apartment.refundable.rate') }}">
                        <button
                            class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
                    </div>
                    <hr class="my-4">
                    <ul class="text-gray-900 text-sm space-y-2">
                        <li class="flex items-start gap-2">
                            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                class="w-4 h-4 mt-1">
                            <span>Guests will pay 10% less than the standard rate for a non-refundable rate</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                class="w-4 h-4 mt-1">
                            <span>Guests can't cancel their bookings for free anytime</span>
                        </li>
                    </ul>
                </div>

                <h2 class="text-xl font-semibold text-gray-800">Weekly rate plan</h2>

                <!-- Third Rate Plan -->
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-semibold text-gray-700">Price and cancellation policy</h3>
                            <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon"
                                class="w-5 h-5">
                        </div>
                          <a href="{{ route('partner.apartment.weekly.rate') }}">
                        <button
                            class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
                    </div>
                         <p class="text-xs text-green-700">
                                    You’re 16% more likely to get bookings with the 15% pre-selected weekly rate than with none
                                </p>
                    <hr class="my-4">
                    <ul class="text-gray-900 text-sm space-y-2">
                        <li class="flex items-start gap-2">
                            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                class="w-4 h-4 mt-1">
                            <span>Guests will pay 15% less than the standard rate when they book for at least 7 nights</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick"
                                class="w-4 h-4 mt-1">
                            <span>Guests can cancel their bookings for free up to 1 day before their arrival (based on the standard rate cancellation policy)</span>
                        </li>
                    </ul>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-4">
                    <!-- Back Button -->
                    <button type="button" @click="step > 1 ? step-- : step"
                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                        ←
                    </button>

                    <!-- Continue Button -->
                    <button
                        @click="saveRatePlans()"
                        class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
                        Continue
                    </button>
                </div>


            </div>
</template>
</div>

@endsection
