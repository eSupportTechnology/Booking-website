@php
    $amenities = $amenities ?? [];
@endphp
<!DOCTYPE html>
<html lang="en"     x-data="{ 
    step: 1, 
    selectedBox: null,
    // Amenities
    selectedAmenities: [],
    
    // Languages
    selectedLanguages: [],
    availableLanguages: [],
    showAdditionalLanguages: false,
    searchTerm: '',
    showDropdown: false,
    filteredLanguages: [],
    
    // House Rules
    smokingAllowed: false,
    partiesAllowed: false,
    petsAllowed: 'no',
    petsFees: '',
    checkInFrom: '15:00',
    checkInUntil: '18:00',
    checkOutFrom: '08:00',
    checkOutUntil: '11:00',
    
    // Host Profile
    hostProfile: {
        about_property: '',
        about_host: '',
        about_neighborhood: '',
        show_property: false,
        show_host: false,
        show_neighborhood: false,
        none_selected: false,
        host_name: ''
    },
    
    // Pricing
    pricing: {
        booking_type: 'instant',
        price_per_night: '',
        currency: 'USD',
        discount_enabled: false,
        discount_percent: ''
    },
    
    // Address data
    addressData: {
        address: 'Sri Lanka',
        apartment: 'aaa',
        country: 'Sri Lanka',
        city: 'a',
        postcode: '80400',
        update_address: true
    },
    
    // Channel manager data
    channelManager: 'yes',
    
    // Methods
    async savePropertyName() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const propertyName = document.getElementById('property_name').value;
            
            const response = await fetch(`/property/${propertyId}/update-title`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: propertyName
                })
            });
            
            if (response.ok) {
                console.log('Property name saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save property name');
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Error saving property name:', error);
        }
    },

    async saveBookingOption() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}/pricing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    property_id: propertyId,
                    booking_type: this.bookingOption,
                    price_per_night: null,
                    currency: 'usd',
                    discount_enabled: false,
                    discount_percent: 0
                })
            });
            
            if (response.ok) {
                console.log('Booking option saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save booking option');
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Error saving booking option:', error);
        }
    },

    savePartnerVerification() {
        savePartnerVerificationFromStep11(this);
    },

    async saveAddress() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    address: this.addressData.address,
                    city: this.addressData.city,
                    country: this.addressData.country,
                    apartment: this.addressData.apartment,
                    zipcode: this.addressData.postcode
                })
            });
            
            if (response.ok) {
                const data = await response.json();
                console.log('Address saved successfully:', data);
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save address');
                const errorData = await response.json();
                alert('Error: ' + (errorData.message || 'Failed to save address'));
            }
        } catch (error) {
            console.error('Error saving address:', error);
            alert('An error occurred while saving the address.');
        }
    },
    
    async saveLanguages() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}/languages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    languages: this.selectedLanguages
                })
            });
            
            if (response.ok) {
                console.log('Languages saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save languages');
            }
        } catch (error) {
            console.error('Error saving languages:', error);
        }
    },
    

    
    async saveHostProfile() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}/host-profile`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    ...this.hostProfile,
                    property_id: propertyId
                })
            });
            
            if (response.ok) {
                console.log('Host profile saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save host profile');
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Error saving host profile:', error);
        }
    },
    
    async savePricing() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}/pricing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify(this.pricing)
            });
            
            if (response.ok) {
                console.log('Pricing saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save pricing');
            }
        } catch (error) {
            console.error('Error saving pricing:', error);
        }
    },
    
    async saveChannelManager() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    channel_manager: this.channelManager
                })
            });
            
            if (response.ok) {
                console.log('Channel manager saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save channel manager');
                const errorData = await response.json();
                alert('Error: ' + (errorData.message || 'Failed to save channel manager'));
            }
        } catch (error) {
            console.error('Error saving channel manager:', error);
            alert('An error occurred while saving the channel manager.');
        }
    },
    
    async saveAmenities() {
        try {
            const propertyId = @json($property->id ?? 'new');
            const response = await fetch(`/partner/property/${propertyId}/amenities`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    amenities: this.selectedAmenities
                })
            });
            
            if (response.ok) {
                console.log('Amenities saved successfully');
                this.step = Math.min(this.step + 1, 13);
            } else {
                console.error('Failed to save amenities');
                const errorData = await response.json();
                alert('Error: ' + (errorData.message || 'Failed to save amenities'));
            }
        } catch (error) {
            console.error('Error saving amenities:', error);
            alert('An error occurred while saving the amenities.');
        }
    },
    

}" xmlns:x-bind="http://www.w3.org/1999/xlink">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Multiple Apartments</title>
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
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <!-- Logo -->
                    <div class="w-full md:w-auto md:ml-6">
                        <!-- Logo -->
                        @php
                            $host = config('domains.app_name');

                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if ($host == 'BookinTour')
                                <h1>Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
                        </a>
                    </div>
                    <!-- Right Section -->
                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
                        <!-- Help Icon -->
                        <a href="/help" title="Help">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>
                        <!-- Language Button -->
                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
                            title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                                class="w-full h-full object-cover rounded-full" />
                        </button>
                        <!-- Language Modal -->
                        <div id="language-modal"
                            class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal Body -->
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)"
                                                class="h-5 w-5" />
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
<!-- Blade + Alpine.js + Tailwind CSS -->
<div x-data="{ 
    step: 1,
    selectedLanguages: [],
    languages: window.languagesData || [],
    getLanguageName(id) {
        const language = this.languages.find(lang => lang.id == id);
        return language ? language.name : 'Unknown';
    },
    removeLanguage(id) {
        this.selectedLanguages = this.selectedLanguages.filter(langId => langId != id);
    },
        handleContinue() {
        handleContinueLogic(this);
    }
}" class="max-w-3xl mx-auto lg:ml-32 px-4 py-8 space-y-6">

    

    <!-- Step 1 - Welcome -->
    <template x-if="step === 1">
          <div>
                                                        <!-- Main Content -->
                                                        <div class="max-w-xl ml-4 mr-auto">
                                                            <!-- White Box -->
                                                            <div class="bg-white shadow-md  p-6 text-left">
                                                                <h2 class="text-2xl font-bold mb-4">Multiple Apartments</h2>
                                                                <p class=" text-base text-gray-700 mb-6">
                                                                    Great! Since your multiple apartments are at the same address, let's start filling in the general settings that apply to all of them.
                                                                </p>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-6 flex justify-between">
                                                                <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                    class= "border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button"   @click="step = Math.min(step + 1, 13)"
                                                                    class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
                                                                    Continue
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
    </template>



    <!-- Step 2 -->
    <template x-if="step === 2">
        <div>
                                                        <div
                                                            class="relative w-[1400px] h-auto overflow-hidden rounded-lg shadow mx-auto -mt-14 -ml-16">

                                                            <!-- Google Maps iframe full background -->
                                                            <iframe class="absolute inset-0 w-full h-full"
                                                                loading="lazy"
                                                                src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                                                                allowfullscreen>
                                                            </iframe>

                                                            <!-- Optional overlay for readability -->
                                                            <div class="absolute inset-0"></div>

                                                            <!-- Form content centered on map -->
                                                            <div
                                                                class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                                                                <div
                                                                    class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                                                                    <h2
                                                                        class="text-2xl font-semibold mb-4 text-gray-800">
                                                                        Where is your property?</h2>
                                                                    <form @submit.prevent="saveAddress()">
                                                                        <div class="mb-4">
                                                                            <label for="address"
                                                                                class="block text-sm font-medium text-gray-700">Find
                                                                                your address</label>
                                                                            <input type="text" id="address"
                                                                                name="address" x-model="addressData.address"
                                                                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                        </div>
                                                                        <div class="mb-4">
                                                                            <label for="apartment"
                                                                                class="block text-sm font-medium text-gray-700">Apartment
                                                                                or floor number (optional)</label>
                                                                            <input type="text" id="apartment"
                                                                                name="apartment" x-model="addressData.apartment"
                                                                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                        </div>
                                                                        <div class="mb-4">
                                                                            <label for="country"
                                                                                class="block text-sm font-medium text-gray-700">Country/region</label>
                                                                            <select id="country" name="country"
                                                                                x-model="addressData.country"
                                                                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                                <option value="Sri Lanka" selected>Sri Lanka</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="flex flex-col md:flex-row gap-4">
                                                                            <div class="flex-1">
                                                                                <label for="city"
                                                                                    class="block text-sm font-medium text-gray-700">City</label>
                                                                                <input type="text" id="city"
                                                                                    name="city" x-model="addressData.city"
                                                                                    class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                            </div>
                                                                            <div class="flex-1">
                                                                                <label for="postcode"
                                                                                    class="block text-sm font-medium text-gray-700">Post
                                                                                    code / Zip code</label>
                                                                                <input type="text" id="postcode"
                                                                                    name="postcode" x-model="addressData.postcode"
                                                                                    class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex items-center mt-4">
                                                                            <input id="update_address" type="checkbox"
                                                                                name="update_address" x-model="addressData.update_address"
                                                                                class="mr-2">
                                                                            <label for="update_address"
                                                                                class="text-sm text-gray-700">Update
                                                                                the address when moving the pin on the
                                                                                map.</label>
                                                                        </div>

                                                                        <!-- Dismissible message box -->
                                                                        <div x-data="{ showMessage: true }"
                                                                            x-show="showMessage"
                                                                            class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                                                                            role="alert">
                                                                            <strong class="font-bold">Note:</strong>
                                                                            <span class="block sm:inline">Make sure the
                                                                                pin location is accurate before
                                                                                continuing.</span>
                                                                            <span @click="showMessage = false"
                                                                                class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                                                                                <svg class="fill-current h-6 w-6 text-yellow-800"
                                                                                    role="button"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 20 20">
                                                                                    <title>Close</title>
                                                                                    <path
                                                                                        d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                                                                                </svg>
                                                                            </span>
                                                                        </div>

                                                                        <p class="text-sm text-gray-600 mt-2">
                                                                            Is the red pin location incorrect? Uncheck
                                                                            the option above and click or press on the
                                                                            map to move the pin.
                                                                        </p>

                                                                        <!-- Buttons -->
                                                                        <div
                                                                            class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                                                                            <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                                class="w-full sm:w-auto border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                                ←
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="w-full sm:w-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                                Continue
                                                                            </button>
                                                                        </div>


                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    </template>
    <template x-if="step === 3">
     <div>
            <section class="mb-12" x-data="{ channelManager: 'yes' }">
                <div class="max-w-5xl mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

                    <!-- Question Section -->
                    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                        <h2 class="text-lg font-semibold mb-2">
                            Do you want to connect this listing to your channel manager?
                        </h2>
                        <p class="text-gray-700 mb-6">
                            A channel manager is a third-party tool that lets you manage rates and availability across
                            different sites you might list your place on, including {{ config('domains.subdomain') }}. If you're already using
                            a channel manager, you can select 'Yes' to connect it to your listing.
                        </p>


                        <!-- Radio Buttons -->
                        <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                            <!-- Yes Option -->
                            <div>
                                <input type="radio" id="yes" name="channel_manager" value="yes"
                                    class="mr-2" x-model="channelManager">
                                <label for="yes" class="text-gray-700">
                                    Yes, I will connect this listing to my channel manager
                                </label>
                            </div>

                            <!-- Tooltip only if Yes is selected -->
                            <div x-show="channelManager === 'yes'" x-transition>
                                <div class="bg-red-100 border border-red-300 rounded p-2">
                                    <div class="flex items-start text-sm text-red-700 space-x-2">
                                        <!-- Inline icon -->
                                        <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                            alt="Help" class="w-5 h-5 md:w-6 md:h-6 mt-1" />

                                        <!-- Text block -->
                                        <p>
                                            Select 'Yes' only if you are already using a channel manager.
                                            You'll be able to connect your channel manager after your registration is
                                            complete – please continue to the next step.
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <!-- No Option -->
                            <div>
                                <input type="radio" id="no" name="channel_manager" value="no"
                                    class="mr-2" x-model="channelManager">
                                <label for="no" class="text-gray-700">
                                    No, I won't be using a channel manager at this time
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-between mt-6">
                            <!-- Back Button (Left) -->

                            <button type="button" @click="step = Math.max(step - 1, 1)"
                                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                ←
                            </button>


                            <!-- Continue Button (Right) -->
                            <button type="button"  @click="saveChannelManager()"
                                :class="step === 9 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                :disabled="step === 9"
                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                                Continue
                            </button>
                        </div>
                    </div>
            </section>
        </div>
</template>
<template x-if="step === 4">
   <div>
                                                        <section class="mb-8">
                                                            <h1 class="text-xl text-gray-700 font-bold mb-4">What can
                                                                guests use at your place?</h1>

                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                                <!-- Property Name Input + Checkboxes (2/3 Width) -->
                                                                <div class="md:col-span-2 flex">
                                                                    <div
                                                                        class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">


                                                                        <!-- Amenities Checkboxes Section -->

                                                                        <div class="mt-2">
                                                                            <h3
                                                                                class="text-gray-700 font-semibold mb-2">
                                                                                Select amenities</h3>
                                                                            <div
                                                                                class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                                                                @foreach($amenities as $amenity)
                                                                                <label
                                                                                    class="flex items-center space-x-2">
                                                                                    <input type="checkbox"
                                                                                        name="amenities[]"
                                                                                        value="{{ $amenity['id'] }}"
                                                                                        x-model="selectedAmenities"
                                                                                        class="text-blue-500" />
                                                                                    <span>{{ $amenity['name'] }}</span>
                                                                                </label>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Tips and Information (1/3 Width) -->
                                                                <div class="flex flex-col gap-4">

                                                                    <!-- Tip Box 1 -->
                                                                    <div x-data="{ show: true }" x-show="show"
                                                                        class="bg-white p-4 border border-gray-200 rounded w-full md:w-[350px] lg:w-[400px]">

                                                                        <div
                                                                            class="flex items-center justify-between mb-2">
                                                                            <div class="flex items-center space-x-2">
                                                                                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                                                                    alt="Help"
                                                                                    class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                                                <h3
                                                                                    class="text-gray-700 text-sm text-bold">
                                                                                    What if I don't see a facility I
                                                                                    offer?</h3>
                                                                            </div>
                                                                            <button @click="show = false"
                                                                                class="text-gray-500 hover:text-gray-700">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    class="h-5 w-5"
                                                                                    viewBox="0 0 20 20"
                                                                                    fill="currentColor">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                        clip-rule="evenodd" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                        <p class="text-sm text-gray-700">
                                                                            The facilities listed here are the ones most
                                                                            searched for by guests. After you complete
                                                                            your registration, you can add more
                                                                            facilities from a larger list in the
                                                                            extranet, the platform you'll use to manage
                                                                            your property.
                                                                            <br>
                                                                            The ones selected here will apply to all of
                                                                            your apartments.
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <!-- Buttons Row (Outside grid, full width) -->
                                                            <!-- Buttons Row aligned with Checkbox Section -->
                                                            <div class="flex  mt-6">
                                                                <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button"     @click="saveAmenities()"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold  text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[330px]">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </section>
                                                    </div>
</template>
<template x-if="step === 5">
    <div x-data="{
            servesBreakfast: false,
            breakfastIncluded: '',
            selectedBreakfasts: [],
            breakfastPrice: '',
            breakfastOptions: ['À la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental', 'Full English/Irish', 'Gluten-free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'],
            toggleBreakfastOption(option) {
                if (this.selectedBreakfasts.includes(option)) {
                    this.selectedBreakfasts = this.selectedBreakfasts.filter(o => o !== option);
                } else {
                    this.selectedBreakfasts.push(option);
                }
            }
        }"
        class="container mx-auto px-4 py-4 max-w-6xl mb-8">

        <!-- Header -->
        <h2 class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
            Services at your property
        </h2>

        <!-- Sections stacked vertically -->
        <div class="max-w-xl ml-6 flex flex-col space-y-8">

            <!-- Breakfast Section -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg mb-4 font-bold">Breakfast</h3>
                <hr class="border-gray-300 mb-4" />

                <!-- Serve breakfast -->
                <p class="text-gray-700 mb-2 font-bold text-base">
                    Do you serve guests breakfast?
                </p>
                <div class="space-y-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="breakfast" value="yes" class="mr-2"
                            @click="servesBreakfast = true" />
                        <span>Yes</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="breakfast" value="no" class="mr-2"
                            checked @click="servesBreakfast = false; breakfastIncluded=''; selectedBreakfasts=[]; breakfastPrice=''" />
                        <span>No</span>
                    </label>
                </div>

                <!-- Include in price -->
                <div x-show="servesBreakfast" x-transition class="mt-6">
                    <p class="text-gray-700 mb-2 font-bold text-base">
                        Is breakfast included in the price guests pay?
                    </p>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="breakfast_included" value="included" class="mr-2"
                                @click="breakfastIncluded = 'included'" />
                            <span>Yes, it's included</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="breakfast_included" value="extra" class="mr-2"
                                @click="breakfastIncluded = 'extra'" />
                            <span>No, it costs extra</span>
                        </label>
                    </div>
                </div>

                <!-- Breakfast price -->
                <div x-show="servesBreakfast && breakfastIncluded === 'extra'" x-transition class="mt-6">
                    <p class="text-gray-700 mb-2 font-bold text-base">
                        Breakfast price per person, per day
                    </p>
                    <input type="text" x-model="breakfastPrice"
                        class="border border-gray-300 px-3 py-2 rounded w-full mb-1" placeholder="US$" />
                    <p class="text-sm text-gray-500">Including all fees and taxes</p>
                </div>

                <!-- Type of breakfast -->
                <div x-show="servesBreakfast" x-transition class="mt-6">
                    <p class="text-gray-700 mb-2 font-bold text-base">
                        What type of breakfast do you offer?
                    </p>
                    <p class="text-sm text-gray-500 mb-2">Select all that apply</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="option in breakfastOptions" :key="option">
                            <button type="button"
                                @click="toggleBreakfastOption(option)"
                                :class="selectedBreakfasts.includes(option) ? 'bg-blue-100 border-blue-500 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="border px-3 py-1 rounded-full text-sm flex items-center space-x-1 transition">
                                <span x-text="option"></span>
                                <template x-if="selectedBreakfasts.includes(option)">
                                    <span class="ml-1 font-bold text-lg leading-none">×</span>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Parking Section -->
<div x-data="{ parking: 'no' }" class="container bg-white mx-auto px-4 py-4 max-w-6xl mb-8">
    <h3 class="text-lg mb-4 font-bold">Parking</h3>
    <hr class="border-gray-300 mb-4" />

    <!-- Main Question -->
    <p class="text-gray-700 mb-2 font-bold">
        Is parking available to guests?
    </p>
    <div class="space-y-2 mb-4">
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="free" x-model="parking" class="mr-2" />
            <span>Yes, free</span>
        </label>
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="paid" x-model="parking" class="mr-2" />
            <span>Yes, paid</span>
        </label>
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="no" x-model="parking" class="mr-2" />
            <span>No</span>
        </label>
    </div>

    <!-- Extra Fields for Free or Paid Parking -->
    <div x-show="parking === 'free' || parking === 'paid'" x-transition class="space-y-4">
        <!-- Reservation Needed -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">Do they need to reserve a parking spot?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="reservation_needed" value="yes" class="mr-2" />
                    <span>Reservation needed</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="reservation_needed" value="no" class="mr-2" />
                    <span>No reservation needed</span>
                </label>
            </div>
        </div>

        <!-- Parking Location -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">Where is the parking located?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="location" value="on_site" class="mr-2" />
                    <span>On site</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="location" value="off_site" class="mr-2" />
                    <span>Off site</span>
                </label>
            </div>
        </div>

        <!-- Parking Type -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">What type of parking is it?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="type" value="private" class="mr-2" />
                    <span>Private</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="type" value="public" class="mr-2" />
                    <span>Public</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Paid Parking - Cost Input -->
    <div x-show="parking === 'paid'" x-transition class="mt-4">
        <label class="block text-gray-700 font-semibold mb-1">How much does parking cost?</label>
        <input type="text" name="cost" placeholder="e.g., $10 per day" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>
</div>

        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between max-w-xl ml-6">
            <button type="button" @click="step = Math.max(step - 1, 1)"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                ←
            </button>
            <button type="button" @click="handleContinue()"
                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                Continue
            </button>
        </div>
    </div>
</template>


<template x-if="step === 6">
   <div>
                                                        <div class="container mx-auto px-4 py-8 max-w-6xl">
                                                            <!-- Header -->
                                                            <h2 class="text-2xl font-bold mb-8 text-left">
                                                                What languages do you or your staff speak?
                                                            </h2>

                                                            <!-- Language Selection Section -->
                                                            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                                                                <h3 class="text-lg  mb-4 font-bold">Select languages
                                                                </h3>
                                                                <div class="space-y-2">
                                                                    <!-- Main Languages -->
                                                                    @php
                                                                        $mainLanguages = ['English', 'French', 'German', 'Hindi', 'Spanish', 'Italian'];
                                                                        $mainLanguageIds = [];
                                                                        $additionalLanguages = [];
                                                                        
                                                                        foreach($languages as $language) {
                                                                            if (in_array($language['name'], $mainLanguages)) {
                                                                                $mainLanguageIds[] = $language['id'];
                                                                            } else {
                                                                                $additionalLanguages[] = $language;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    
                                                                    @foreach($languages as $language)
                                                                        @if(in_array($language['name'], $mainLanguages))
                                                                        <label class="flex items-center cursor-pointer">
                                                                            <input type="checkbox" x-model="selectedLanguages" value="{{ $language['id'] }}" class="mr-2" />
                                                                            <span>{{ $language['name'] }}</span>
                                                                        </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>

                                                                <!-- Add Additional Languages -->
                                                                <div id="additionalLanguagesSection"
                                                                    class="mt-4 hidden relative">
                                                                    <h3 class="text-lg font-medium mb-2 ">Add
                                                                        additional languages</h3>

                                                                    <!-- Searchable dropdown container -->
                                                                    <div class="relative w-full max-w-md">
                                                                        <input type="text" id="languageInput"
                                                                            oninput="filterDropdown()"
                                                                            onclick="toggleDropdown()"
                                                                            placeholder="Search languages..."
                                                                            autocomplete="off"
                                                                            class="w-full border rounded p-2 pr-10 cursor-pointer"
                                                                            readonly />
                                                                        <!-- Dropdown arrow -->
                                                                        <button type="button"
                                                                            onclick="toggleDropdown()"
                                                                            class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
                                                                            tabindex="-1">
                                                                            ▼
                                                                        </button>

                                                                        <!-- Dropdown list -->
                                                                        <ul id="languageDropdown"
                                                                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg hidden">
                                                                            @foreach($additionalLanguages as $language)
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this, {{ $language['id'] }}, '{{ $language['name'] }}')"
                                                                                data-id="{{ $language['id'] }}"
                                                                                data-name="{{ $language['name'] }}">
                                                                                {{ $language['name'] }}
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Toggle Button for Additional Languages -->
                                                                <a href="#"
                                                                    onclick="event.preventDefault(); toggleAdditionalLanguages();"
                                                                    class="text-blue-500 hover:underline mt-4 block">
                                                                    Add additional languages
                                                                </a>
                                                                
                                                                <!-- Selected Additional Languages Display -->
                                                                <div x-show="selectedLanguages.length > 0" class="mt-4">
                                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Additional Languages:</h4>
                                                                    <div class="flex flex-wrap gap-2">
                                                                        <template x-for="langId in selectedLanguages" :key="langId">
                                                                            <template x-if="!['1', '2', '3', '4', '5', '6'].includes(langId.toString())">
                                                                                <div class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm flex items-center">
                                                                                    <span x-text="getLanguageName(langId)"></span>
                                                                                    <button @click="removeLanguage(langId)" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                                                                                </div>
                                                                            </template>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <!-- Back Button on the left -->
                                                                <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <!-- Continue Button on the right -->
                                                                <button type="button"    @click="saveLanguages()"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </div>

                                                        <script>
                                                            // Set languages data globally
                                                            window.languagesData = {{ Js::from($languages) }};
                                                            

                                                            function toggleAdditionalLanguages() {
                                                                const section = document.getElementById("additionalLanguagesSection");
                                                                section.classList.toggle("hidden");
                                                                if (!section.classList.contains("hidden")) {
                                                                    document.getElementById("languageInput").focus();
                                                                    showDropdown();
                                                                } else {
                                                                    hideDropdown();
                                                                }
                                                            }

                                                            function toggleDropdown() {
                                                                const dropdown = document.getElementById("languageDropdown");
                                                                dropdown.classList.toggle("hidden");
                                                            }

                                                            function showDropdown() {
                                                                document.getElementById("languageDropdown").classList.remove("hidden");
                                                            }

                                                            function hideDropdown() {
                                                                document.getElementById("languageDropdown").classList.add("hidden");
                                                            }

                                                            function filterDropdown() {
                                                                const input = document.getElementById("languageInput");
                                                                const filter = input.value.toLowerCase();
                                                                const ul = document.getElementById("languageDropdown");
                                                                const items = ul.getElementsByTagName("li");
                                                                ul.classList.remove("hidden");
                                                                let visibleCount = 0;
                                                                for (let i = 0; i < items.length; i++) {
                                                                    const txtValue = items[i].textContent || items[i].innerText;
                                                                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                                                        items[i].style.display = "";
                                                                        visibleCount++;
                                                                    } else {
                                                                        items[i].style.display = "none";
                                                                    }
                                                                }
                                                                // Hide dropdown if no matches
                                                                if (visibleCount === 0) {
                                                                    ul.classList.add("hidden");
                                                                }
                                                            }

                                                            function selectLanguage(element, languageId, languageName) {
                                                                const input = document.getElementById("languageInput");
                                                                input.value = languageName;
                                                                hideDropdown();
                                                                
                                                                // Add the language to selectedLanguages if not already selected
                                                                const mainData = Alpine.$data(document.querySelector('[x-data*="step"]'));
                                                                if (mainData && !mainData.selectedLanguages.includes(languageId)) {
                                                                    mainData.selectedLanguages.push(languageId);
                                                                    console.log('Language added:', languageName, 'ID:', languageId);
                                                                    console.log('Selected languages:', mainData.selectedLanguages);
                                                                }
                                                            }

                                                            // Close dropdown when clicking outside
                                                            document.addEventListener("click", function(event) {
                                                                const dropdown = document.getElementById("languageDropdown");
                                                                const input = document.getElementById("languageInput");
                                                                const container = document.getElementById("additionalLanguagesSection");
                                                                if (
                                                                    container && !container.contains(event.target)
                                                                ) {
                                                                    hideDropdown();
                                                                }
                                                            });
                                                        </script>
                                                    </div>
</template>
    <template x-if="step === 7">
     <div x-data="{ 
         petPolicy: 'no',
         smokingAllowed: false,
         childrenAllowed: true,
         partiesAllowed: false,
         petsFees: null,
         checkInFrom: '15:00',
         checkInUntil: '18:00',
         checkOutFrom: '08:00',
         checkOutUntil: '11:00',
         
         saveHouseRules() {
             saveHouseRulesFromStep7(this);
         }
     }">
        <div class="container mx-auto px-4 py-8 max-w-6xl">
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
                                 <input type="checkbox" x-model="smokingAllowed" class="sr-only peer" />
                                 <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                                 <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                             </div>
                         </label>

                                                 <label class="flex items-center justify-between cursor-pointer">
                             <span>Children allowed</span>
                             <div class="relative">
                                 <input type="checkbox" x-model="childrenAllowed" class="sr-only peer" />
                                 <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                                 <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                             </div>
                         </label>

                                                 <label class="flex items-center justify-between cursor-pointer">
                             <span>Parties/events allowed</span>
                             <div class="relative">
                                 <input type="checkbox" x-model="partiesAllowed" class="sr-only peer" />
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
                                <input type="radio" name="pets" value="yes" class="mr-2" @click="petPolicy = 'yes'">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="pets" value="upon_request" class="mr-2" @click="petPolicy = 'upon_request'">
                                <span>Upon request</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="pets" value="no" class="mr-2" @click="petPolicy = 'no'" checked>
                                <span>No</span>
                            </label>
                        </div>

                        <!-- Additional Charges for Pets -->
                        <template x-if="petPolicy === 'yes' || petPolicy === 'upon_request'">
                            <div class="mt-4">
                                <h4 class="text-sm font-semibold mb-2">Are there additional charges for pets?</h4>
                                                                 <label class="flex items-center cursor-pointer mb-1">
                                     <input type="radio" name="pets_fees" value="free" x-model="petsFees" class="mr-2">
                                     <span>Pets can stay for free</span>
                                 </label>
                                 <label class="flex items-center cursor-pointer">
                                     <input type="radio" name="pets_fees" value="charges" x-model="petsFees" class="mr-2">
                                     <span>Charges may apply</span>
                                 </label>
                            </div>
                        </template>
                    </div>

                    <hr class="my-6 border-t border-gray-300">

                    <!-- Check-in -->
                    <div class="mt-6">
                        <h3 class="text-base font-semibold mb-2">Check in</h3>
                        <div class="flex space-x-4">
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">From</label>
                                <input type="time" x-model="checkInFrom" class="w-full border rounded p-2" />
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">Until</label>
                                <input type="time" x-model="checkInUntil" class="w-full border rounded p-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Check-out -->
                    <div class="mt-6">
                        <h3 class="text-base font-semibold mb-2">Check out</h3>
                        <div class="flex space-x-4">
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">From</label>
                                <input type="time" x-model="checkOutFrom" class="w-full border rounded p-2" />
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium mb-1">Until</label>
                                <input type="time" x-model="checkOutUntil" class="w-full border rounded p-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Tip Box -->
                <div x-data="{ show: true }" x-show="show" class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                            <h3 class="text-gray-800 font-semibold text-base">
                                What if my house rules change?</h3>
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

            <!-- Navigation Buttons -->
            <div class="mt-8 flex">
                <button type="button" @click="step = Math.max(step - 1, 1)" class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                    ←
                </button>
                <button type="button" @click="handleContinue()" class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[285px]">
                    Continue
                </button>
            </div>
        </div>
    </div>
</template>
<template x-if="step === 8">
      <div class="max-w-2xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8 lg:ml-32 py-6">
       <h2 class="text-2xl font-bold mb-8 text-left">Host Profile</h2>
        <div class="bg-white shadow-md rounded-lg p-4 space-y-6">
            <h2 class="text-base text-gray-800">
                Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood. This info will appear on your property page.
            </h2>

            <!-- The Property Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.show_property" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-sm ">The property</span>
                </label>

                <div class="mt-2" x-show="hostProfile.show_property">
                    <label class="block text-sm font-semibold text-gray-700">About the property</label>
                    <textarea rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
                        x-model="hostProfile.about_property"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- The Host Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.show_host" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The host</span>
                </label>

                <div class="mt-2 space-y-2" x-show="hostProfile.show_host">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Host name</label>
                        <input type="text" maxlength="80"
                            x-model="hostProfile.host_name"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <p class="text-right text-xs text-gray-500">0/80</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">About the host</label>
                        <textarea rows="4" maxlength="1200" placeholder="What are your interests? What do you like about hosting?"
                            x-model="hostProfile.about_host"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>
            </div>

            <!-- The Neighborhood Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.show_neighborhood" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The neighborhood</span>
                </label>

                <div class="mt-2" x-show="hostProfile.show_neighborhood">
                    <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
                    <textarea rows="4" maxlength="1200" placeholder="What's the area like? Are there any attractions nearby?"
                        x-model="hostProfile.about_neighborhood"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- None of the Above Option -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.none_selected" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">None of the above / I'll add these later</span>
                </label>
            </div>
        </div>
        <div class="mt-12 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="step = Math.max(step - 1, 1)"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="saveHostProfile()"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 "
  >
    Continue
  </button>
</div>
    </div>
</template>
<template x-if="step === 9">
   <div>
                                                        <div class="max-w-5xl mx-auto px-4 py-10 space-y-32">
                                                            <section class="mb-8">
                                                                <h1 class="text-2xl text-gray-700 font-bold mb-4">
                                                                    What's the name of your place?</h1>

                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                                    <!-- Property Name Input (2/3 Width) -->
                                                                    <div class="md:col-span-2 flex">
                                                                        <div
                                                                            class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base ">
                                                                            <label for="property_name"
                                                                                class="block text-gray-700">Property
                                                                                name</label>
                                                                            <input type="text" id="property_name"
                                                                                name="property_name" value="ccc"
                                                                                class="w-full h-16 border border-gray-300 rounded p-4 mt-3 text-lg focus:outline-none focus:border-blue-500"
                                                                                placeholder="e.g., Sunset Villa"
                                                                                required>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Tips and Information (1/3 Width) -->
                                                                    <div class="flex flex-col gap-4">

                                                                        <!-- Tip Box 1 -->
                                                                        <div x-data="{ show: true }" x-show="show"
                                                                            class="bg-white p-4 border border-gray-200 rounded">
                                                                            <div
                                                                                class="flex items-center justify-between mb-2">
                                                                                <div
                                                                                    class="flex items-center space-x-2">
                                                                                    <img src="{{ asset('assets/ei_like.svg') }}"
                                                                                        alt="Help"
                                                                                        class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                                                    <h3 class="text-gray-700 text-sm">
                                                                                        What should I consider when
                                                                                        choosing a name?</h3>
                                                                                </div>
                                                                                <button @click="show = false"
                                                                                    class="text-gray-500 hover:text-gray-700">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        class="h-5 w-5"
                                                                                        viewBox="0 0 20 20"
                                                                                        fill="currentColor">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                            clip-rule="evenodd" />
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                            <ul
                                                                                class="list-disc pl-5 text-sm text-gray-700">
                                                                                <li>Keep it short and catchy</li>
                                                                                <li>Avoid abbreviations</li>
                                                                                <li>Stick to the facts</li>
                                                                            </ul>
                                                                        </div>

                                                                        <!-- Tip Box 2 -->
                                                                        <div x-data="{ show: true }" x-show="show"
                                                                            class="bg-white p-4 border border-gray-200 rounded flex-1">
                                                                            <div
                                                                                class="flex items-center justify-between mb-2">
                                                                                <div
                                                                                    class="flex items-center space-x-2">
                                                                                    <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                                                                        alt="Help"
                                                                                        class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                                                    <h3 class="text-gray-700 text-sm">
                                                                                        Why do I need to name my
                                                                                        property?</h3>
                                                                                </div>
                                                                                <button @click="show = false"
                                                                                    class="text-gray-500 hover:text-gray-700">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        class="h-5 w-5"
                                                                                        viewBox="0 0 20 20"
                                                                                        fill="currentColor">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                            clip-rule="evenodd" />
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                            <p class="text-sm text-gray-700">
                                                                                This is the name that will appear as the
                                                                                title of your listing. Be specific and
                                                                                avoid including private details.
                                                                            </p>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <!-- Buttons Row (Outside grid, full width) -->
                                                                <div class="flex justify-between mt-6">
                                                                    <!-- Back Button -->
                                                                    <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                        ←
                                                                    </button>



                                                                    <!-- Continue Button -->
                                                                    <!-- Continue Button (inside input field container, aligned right) -->
                                                                    <div class="flex justify-end mt-4">
                                                                        <button type="submit"     @click="savePropertyName()"
                                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                            Continue
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </section>

                                                        </div>
                                                    </div>
</template>
<template x-if="step === 10">
    <div>
                                                        <!-- AlpineJS is required -->
                                                        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                                                        <div x-data="{ bookingOption: 'instant' }"
                                                            class="px-4 py-8 max-w-4xl mx-auto space-y-6">

                                                            <h1 class="text-2xl sm:text-3xl font-semibold">How you
                                                                receive bookings</h1>

                                                            <!-- Safety Info Box -->
                                                            <div class="bg-white border rounded-lg p-6 shadow-sm">
                                                                <h2 class="font-semibold mb-4">We're here to ensure you
                                                                    can receive bookings safely:</h2>
                                                                <ul class="space-y-2 text-gray-700">
                                                                    <li class="flex items-start"><span
                                                                            class="text-green-600 font-bold mr-2">✓</span>
                                                                        Set house rules guest must agree to before they
                                                                        stay</li>
                                                                    <li class="flex items-start"><span
                                                                            class="text-green-600 font-bold mr-2">✓</span>
                                                                        Request damage deposits for extra security</li>
                                                                    <li class="flex items-start"><span
                                                                            class="text-green-600 font-bold mr-2">✓</span>
                                                                        Report guest misconduct if something goes wrong
                                                                    </li>
                                                                    <li class="flex items-start"><span
                                                                            class="text-green-600 font-bold mr-2">✓</span>
                                                                        Receive protection against liability claims from
                                                                        guests and neighbours up to US$1,000,000 for
                                                                        every reservation</li>
                                                                </ul>
                                                            </div>

                                                            <!-- Booking Option Box -->
                                                            <div
                                                                class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                                <h2 class="font-semibold">How can guests book your
                                                                    holiday home?</h2>

                                                                <div
                                                                    class="space-y-3 text-sm sm:text-base text-gray-700">
                                                                    <label class="flex items-start space-x-2">
                                                                        <input type="radio" name="booking_option"
                                                                            value="instant" x-model="bookingOption"
                                                                            class="mt-1 accent-blue-600">
                                                                        <div>
                                                                            <span>All guests can book instantly</span>
                                                                            <span
                                                                                class="text-green-600 text-sm ml-2 font-medium bg-green-50 px-2 py-0.5 rounded">Recommended</span>
                                                                        </div>
                                                                    </label>

                                                                    <label class="flex items-start space-x-2">
                                                                        <input type="radio" name="booking_option"
                                                                            value="request" x-model="bookingOption"
                                                                            class="mt-1 accent-blue-600">
                                                                        <span>All guests will need to request to
                                                                            book</span>
                                                                    </label>
                                                                </div>

                                                                <!-- Conditional Info Box -->
                                                                <div x-show="bookingOption === 'request'" x-transition
                                                                    class="mt-4 space-y-4 text-sm sm:text-base">
                                                                    <div
                                                                        class="border border-gray-300 bg-gray-50 p-4 rounded-lg">
                                                                        <div class="flex items-start space-x-2">
                                                                            <span
                                                                                class="text-gray-600 mt-0.5">ℹ️</span>
                                                                            <div class="text-gray-700">
                                                                                <p class="mb-2 font-medium">When using
                                                                                    request to book, the booking process
                                                                                    will be as follows:</p>
                                                                                <ol
                                                                                    class="list-decimal ml-6 space-y-1">
                                                                                    <li>Guests who want to make a
                                                                                        booking with a check-in that is
                                                                                        more than 48 hours in the future
                                                                                        will be able to find your
                                                                                        holiday home and send a booking
                                                                                        request</li>
                                                                                    <li>You'll have 24 hours to accept
                                                                                        or decline the request</li>
                                                                                    <li>Guests will have 24 hours to
                                                                                        finish their booking and confirm
                                                                                        their stay</li>
                                                                                </ol>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="border border-orange-300 bg-orange-50 p-4 rounded-lg">
                                                                        <p class="text-orange-800 font-semibold">Are
                                                                            you sure you want to require your guests to
                                                                            request to book?</p>
                                                                        <p class="text-orange-800 mt-1">
                                                                            Properties that require Request to book have
                                                                            fewer confirmed bookings and a longer time
                                                                            until their first booking. They also require
                                                                            more operational workload, as you'll need to
                                                                            respond to each request.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <!-- Back Button on the left -->
                                                                <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <!-- Continue Button on the right -->
                                                                <button type="button"     @click="saveBookingOption()"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
</template>
<template x-if="step === 11">
     <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ ownershipType: '', individual: { firstName: '', lastName: '', dob: '', altNames: [] }, business: { businessName: '', tradingName: '', address: '', zipCode: '', city: '', country: '', owners: [{ firstName: '', lastName: '', dob: '', altNames: [] }] } }">

            <h2 class="text-3xl font-bold text-gray-800">Partner verification</h2>

            <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
                <p class="text-sm text-gray-800">
                    In order to comply with various legal and regulatory requirements, we need to collect and verify
                    some information about you and your property.
                </p>

                <div>
                    <label class="block font-semibold text-gray-900 mb-2">
                        Is the accommodation owned by an individual or business entity?
                    </label>
                    <select x-model="ownershipType"
                        class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
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
                <button  @click="step = Math.max(step - 1, 1)"
                    class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">

                    ←
                </button>
                <button     @click="savePartnerVerification()"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                    Continue
                </button>
            </div>
        </div>
                                                        </template>

                                                        <template x-if="step === 12">
    <div x-data="{ allowLongStays: null, showTip: true, availabilityOption: '365' }">
        <div class="max-w-2xl mx-auto px-4 py-8 space-y-6">
            <h1 class="text-3xl font-bold text-gray-900">Availability</h1>

            <!-- Availability Options -->
            <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
                <h2 class="text-lg font-semibold">How would you like to open up dates for booking?</h2>
                <div class="space-y-3">
                    <label class="flex items-center space-x-3">
                        <input type="radio" name="availability_mode" value="continuous"
                               class="form-radio text-blue-500"
                               checked>
                        <span>Continuously extend my availability to:</span>
                        <select x-model="availabilityOption"
                                class="ml-2 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option value="30">30 days</option>
                            <option value="90">90 days</option>
                            <option value="180">180 days</option>
                            <option value="365">365 days</option>
                        </select>
                    </label>

                    <label class="flex items-center space-x-3">
                        <input type="radio" name="availability_mode" value="18months"
                               class="form-radio text-blue-500">
                        <span>Only open up the first 18 months</span>
                    </label>
                </div>
            </div>

            <!-- Stay Options + Tip Box in horizontal layout -->
            <div class="md:flex md:space-x-6">
                <!-- 30+ Night Stays Section -->
              <!-- 30+ Night Stays Section -->
<div class="bg-white shadow-md rounded-lg p-6 space-y-4 flex-1 max-w-full">
    <h2 class="text-lg font-semibold">Do you want to allow 30+ night stays?</h2>
    <p class="text-sm text-gray-600">
        Allowing guests to stay for up to 90 nights can help you fill your calendar
        and tap into the trend of guests working remotely.
    </p>

    <div>
        <p class="font-semibold text-gray-800">Will you accept reservations for stays over 30 nights?</p>
        <div class="flex items-center space-x-6 mt-2">
            <label class="inline-flex items-center space-x-2">
                <input type="radio" name="allow_long_stays" value="yes" class="form-radio text-blue-500"
                       @click="allowLongStays = true">
                <span>Yes</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="radio" name="allow_long_stays" value="no" class="form-radio text-blue-500"
                       @click="allowLongStays = false">
                <span>No</span>
            </label>
        </div>
    </div>

    <!-- Conditional max nights input -->
    <template x-if="allowLongStays">
        <div>
            <label for="max_nights" class="block font-semibold text-gray-800 mt-4 mb-2">
                What's the maximum number of nights you want guests to be able to book?
            </label>
            <input type="number" id="max_nights" name="max_nights"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                   placeholder="90" min="31" max="90" />
        </div>
    </template>

    <!-- Tip Box (Now inside this section) -->
    <template x-if="showTip">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-4 relative">
            <button @click="showTip = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
            <div class="flex items-start space-x-3">
              

                <!-- Tip Content -->
                <div class="text-sm text-gray-700">
                    <p class="font-semibold mb-1">What if I want to change my selection later on?</p>
                    <p>Your selection here isn’t final. You can always change it by heading to the Policies section after you’ve registered.</p>
                    <a href="#" class="text-blue-600 hover:underline mt-1 inline-block">Read more about 30+ night stays</a>
                </div>
            </div>
        </div>
    </template>
</div>

            </div>

            <!-- Navigation -->
            <div class="flex justify-between pt-4">
                <button @click="step = Math.max(step - 1, 1)"
                        class="flex items-center border border-[#3CC0E9] text-[#3CC0E9] hover:bg-blue-50 font-semibold px-4 h-12 rounded">
                    ←
                </button>
                <button @click="handleContinue()"
                        class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">
                    Continue
                </button>
            </div>
        </div>
    </div>
</template>                                          </template>
<template x-if="step === 13">
      <div>
                                                        <!-- Main Content -->
                                                        <div class="max-w-xl ml-4 mr-auto">
                                                            <!-- White Box -->
                                                            <div class="bg-white shadow-md  p-6 text-left">
                                                                <p class=" text-base text-gray-700">
                                                                    Now let's start setting up your first apartment
You will be able to add more apartments or duplicate this one when you finish filling in the details.
                                                                </p>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-6 flex justify-between">
                                                                <button type="button"  @click="step = Math.max(step - 1, 1)"
                                                                    class= "border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                                                    ←
                                                                </button>
                                                                <a href="{{ route('partner.multiple.apartment.2', ['propertyId' => $property->id ?? null]) }}">
                                                                    <button type="button"
                                                                        class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
                                                                        Continue
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
</template>
</div>



                        </body>

                        <script>
                            // Function to save languages data
                            function saveLanguages(propertyId) {
                                return new Promise((resolve, reject) => {
                                    console.log('saveLanguages called with propertyId:', propertyId);
                                    
                                    // Get Alpine.js data from the main component
                                    const mainData = Alpine.$data(document.querySelector('[x-data*="step"]'));
                                    console.log('Main Alpine data:', mainData);
                                    
                                    if (!mainData) {
                                        console.error('Could not find Alpine.js data');
                                        reject('Could not find Alpine.js data');
                                        return;
                                    }

                                    const languagesData = {
                                        languages: mainData.selectedLanguages || []
                                    };

                                    console.log('Languages data to be sent:', languagesData);

                                    // Get CSRF token
                                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                    console.log('CSRF token:', csrfToken);

                                    // Send data to backend
                                    fetch(`/partner/property/${propertyId}/languages`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: JSON.stringify(languagesData)
                                    })
                                    .then(response => {
                                        console.log('Response status:', response.status);
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Response data:', data);
                                        if (data.success) {
                                            console.log('Languages saved successfully');
                                            resolve('Languages saved successfully!');
                                        } else {
                                            console.error('Error saving languages:', data.message);
                                            reject('Error saving languages: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Fetch error:', error);
                                        reject('Error saving languages: ' + error.message);
                                    });
                                });
                            }

                            // Function to save house rules data
                            function saveHouseRules(propertyId) {
                                return new Promise((resolve, reject) => {
                                    console.log('saveHouseRules called with propertyId:', propertyId);
                                    
                                    // Get Alpine.js data from the step 7 template
                                    const step7Element = document.querySelector('[x-data*="petPolicy"]');
                                    console.log('Step 7 element found:', step7Element);
                                    
                                    if (!step7Element) {
                                        console.error('Could not find Alpine.js element for step 7');
                                        reject('Could not find Alpine.js element for step 7');
                                        return;
                                    }
                                    
                                    const step7Data = Alpine.$data(step7Element);
                                    console.log('Step 7 Alpine data:', step7Data);
                                    
                                    if (!step7Data) {
                                        console.error('Could not find Alpine.js data for step 7');
                                        reject('Could not find Alpine.js data for step 7');
                                        return;
                                    }

                                    // Get form data from Alpine.js data
                                    const smokingAllowed = step7Data.smokingAllowed || false;
                                    const childrenAllowed = step7Data.childrenAllowed || true;
                                    const partiesAllowed = step7Data.partiesAllowed || false;
                                    const petsAllowed = step7Data.petPolicy || 'no';
                                    const petsFees = step7Data.petsFees || null;
                                    const checkInFrom = step7Data.checkInFrom || '15:00';
                                    const checkInUntil = step7Data.checkInUntil || '18:00';
                                    const checkOutFrom = step7Data.checkOutFrom || '08:00';
                                    const checkOutUntil = step7Data.checkOutUntil || '11:00';

                                    const houseRulesData = {
                                        smoking_allowed: smokingAllowed,
                                        children_allowed: childrenAllowed,
                                        parties_allowed: partiesAllowed,
                                        pets_allowed: petsAllowed,
                                        pets_fees: petsFees,
                                        check_in_from: checkInFrom,
                                        check_in_until: checkInUntil,
                                        check_out_from: checkOutFrom,
                                        check_out_until: checkOutUntil
                                    };

                                    console.log('House rules data to be sent:', houseRulesData);
                                    console.log('Step 7 Alpine data:', step7Data);
                                    console.log('smokingAllowed:', smokingAllowed);
                                    console.log('childrenAllowed:', childrenAllowed);
                                    console.log('partiesAllowed:', partiesAllowed);
                                    console.log('petsAllowed:', petsAllowed);
                                    console.log('petsFees:', petsFees);

                                    // Get CSRF token
                                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                    console.log('CSRF token:', csrfToken);

                                    // Send data to backend
                                    fetch(`/partner/property/${propertyId}/house-rules`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: JSON.stringify(houseRulesData)
                                    })
                                    .then(response => {
                                        console.log('Response status:', response.status);
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Response data:', data);
                                        if (data.success) {
                                            console.log('House rules saved successfully');
                                            resolve('House rules saved successfully!');
                                        } else {
                                            console.error('Error saving house rules:', data.message);
                                            reject('Error saving house rules: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Fetch error:', error);
                                        reject('Error saving house rules: ' + error.message);
                                    });
                                });
                            }

                            // Function to save services data
                            function saveServices(propertyId) {
                                return new Promise((resolve, reject) => {
                                    console.log('saveServices called with propertyId:', propertyId);
                                    
                                    // Get Alpine.js data from the step 5 template
                                    const step5Element = document.querySelector('[x-data*="servesBreakfast"]');
                                    console.log('Step 5 element found:', step5Element);
                                    
                                    if (!step5Element) {
                                        console.error('Could not find Alpine.js element for step 5');
                                        reject('Could not find Alpine.js element for step 5');
                                        return;
                                    }
                                    
                                    // Get Alpine.js data using the correct method
                                    const step5Data = Alpine.$data(step5Element);
                                    console.log('Step 5 Alpine data:', step5Data);
                                    
                                    if (!step5Data) {
                                        console.error('Could not find Alpine.js data for step 5');
                                        reject('Could not find Alpine.js data for step 5');
                                        return;
                                    }

                                    // Get parking data from DOM
                                    const parkingAvailable = document.querySelector('input[name="parking"]:checked')?.value || 'no';
                                    const parkingCost = document.querySelector('input[name="cost"]')?.value || null;
                                    const parkingReservation = document.querySelector('input[name="reservation_needed"]:checked')?.value || null;
                                    const parkingLocation = document.querySelector('input[name="location"]:checked')?.value || null;
                                    const parkingType = document.querySelector('input[name="type"]:checked')?.value || null;

                                    // Convert boolean for servesBreakfast
                                    const servesBreakfast = step5Data.servesBreakfast === true || step5Data.servesBreakfast === 'true';

                                    const servicesData = {
                                        serve_breakfast: servesBreakfast,
                                        breakfast_included: step5Data.breakfastIncluded || null,
                                        breakfast_type: step5Data.selectedBreakfasts || [],
                                        breakfast_price: step5Data.breakfastPrice || null,
                                        parking_available: parkingAvailable,
                                        parking_cost: parkingCost,
                                        parking_reservation: parkingReservation,
                                        parking_location: parkingLocation,
                                        parking_type: parkingType
                                    };

                                    console.log('Services data to be sent:', servicesData);
                                    console.log('Raw Alpine data:', step5Data);
                                    console.log('servesBreakfast type:', typeof step5Data.servesBreakfast);
                                    console.log('servesBreakfast value:', step5Data.servesBreakfast);

                                    // Get CSRF token
                                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                    console.log('CSRF token:', csrfToken);

                                    // Send data to backend
                                    fetch(`/partner/property/${propertyId}/services`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: JSON.stringify(servicesData)
                                    })
                                    .then(response => {
                                        console.log('Response status:', response.status);
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Response data:', data);
                                        if (data.success) {
                                            console.log('Services saved successfully');
                                            resolve('Services saved successfully!');
                                        } else {
                                            console.error('Error saving services:', data.message);
                                            reject('Error saving services: ' + data.message);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Fetch error:', error);
                                        reject('Error saving services: ' + error.message);
                                    });
                                });
                            }

                            // Function to handle continue logic
                            function handleContinueLogic(alpineData) {
                                alert('handleContinue called on step ' + alpineData.step);
                                console.log('=== handleContinue called ===');
                                console.log('Current step:', alpineData.step);
                                const propertyId = {{ $property->id ?? 'null' }};
                                console.log('Property ID:', propertyId);
                                console.log('handleContinue called, step:', alpineData.step, 'propertyId:', propertyId);
                                
                                if (alpineData.step === 5 && propertyId) {
                                    console.log('Saving services on step 5');
                                    saveServices(propertyId)
                                        .then(result => {
                                            console.log('Services saved:', result);
                                            alpineData.step = Math.min(alpineData.step + 1, 13);
                                        })
                                        .catch(error => {
                                            console.error('Error saving services:', error);
                                            alert('Error saving services: ' + error);
                                        });
                                } else if (alpineData.step === 6 && propertyId) {
                                    console.log('Saving languages on step 6');
                                    saveLanguages(propertyId)
                                        .then(result => {
                                            console.log('Languages saved:', result);
                                            alpineData.step = Math.min(alpineData.step + 1, 13);
                                        })
                                        .catch(error => {
                                            console.error('Error saving languages:', error);
                                            alert('Error saving languages: ' + error);
                                        });
                                } else if (alpineData.step === 7 && propertyId) {
                                    console.log('Saving house rules on step 7');
                                    // Call the step 7's saveHouseRules function
                                    const step7Element = document.querySelector('[x-data*="petPolicy"]');
                                    if (step7Element) {
                                        const step7Data = Alpine.$data(step7Element);
                                        if (step7Data && step7Data.saveHouseRules) {
                                            step7Data.saveHouseRules();
                                        } else {
                                            console.error('Could not find step 7 saveHouseRules function');
                                            alpineData.step = Math.min(alpineData.step + 1, 13);
                                        }
                                    } else {
                                        console.error('Could not find step 7 element');
                                        alpineData.step = Math.min(alpineData.step + 1, 13);
                                    }
                                } else if (alpineData.step === 12 && propertyId) {
                                    console.log('Saving availability settings on step 12');
                                    saveAvailabilitySettingsFromStep12(alpineData);
                                } else {
                                    // Proceed to next step immediately for other steps
                                    alpineData.step = Math.min(alpineData.step + 1, 13);
                                }
                            }

                            // Function to save house rules from step 7
                            async function saveHouseRulesFromStep7(step7Data) {
                                try {
                                    const propertyId = {{ $property->id ?? 'null' }};
                                    const response = await fetch(`/partner/property/${propertyId}/house-rules`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            smoking_allowed: step7Data.smokingAllowed,
                                            children_allowed: step7Data.childrenAllowed,
                                            parties_allowed: step7Data.partiesAllowed,
                                            pets_allowed: step7Data.petPolicy,
                                            pets_fees: step7Data.petsFees,
                                            check_in_from: step7Data.checkInFrom,
                                            check_in_until: step7Data.checkInUntil,
                                            check_out_from: step7Data.checkOutFrom,
                                            check_out_until: step7Data.checkOutUntil
                                        })
                                    });
                                    
                                    console.log('Sending data:', {
                                        smoking_allowed: step7Data.smokingAllowed,
                                        children_allowed: step7Data.childrenAllowed,
                                        parties_allowed: step7Data.partiesAllowed,
                                        pets_allowed: step7Data.petPolicy,
                                        pets_fees: step7Data.petsFees,
                                        check_in_from: step7Data.checkInFrom,
                                        check_in_until: step7Data.checkInUntil,
                                        check_out_from: step7Data.checkOutFrom,
                                        check_out_until: step7Data.checkOutUntil
                                    });
                                    
                                    if (response.ok) {
                                        console.log('House rules saved successfully');
                                        
                                        // Try multiple approaches to find and update the step
                                        let stepUpdated = false;
                                        
                                        // Approach 1: Look for the main container with step data
                                        // Try to find the element that contains the step variable and also has the handleContinue function
                                        const mainContainer = document.querySelector('[x-data*="handleContinue"]');
                                        if (mainContainer) {
                                            const mainData = Alpine.$data(mainContainer);
                                            if (mainData && typeof mainData.step !== 'undefined') {
                                                console.log('Found main container with step:', mainData.step);
                                                // Only update if we're actually on step 7
                                                if (mainData.step === 7) {
                                                    mainData.step = Math.min(mainData.step + 1, 13);
                                                    console.log('Step updated to:', mainData.step);
                                                    stepUpdated = true;
                                                } else {
                                                    console.log('Found step data but not on step 7, current step:', mainData.step);
                                                }
                                            }
                                        }
                                        
                                        // Approach 2: If first approach failed, try to find any element with step
                                        if (!stepUpdated) {
                                            const allElements = document.querySelectorAll('[x-data]');
                                            for (let element of allElements) {
                                                const data = Alpine.$data(element);
                                                if (data && typeof data.step !== 'undefined') {
                                                    console.log('Found step data in fallback element, step:', data.step);
                                                    // Only update if we're actually on step 7
                                                    if (data.step === 7) {
                                                        data.step = Math.min(data.step + 1, 13);
                                                        console.log('Step updated to:', data.step);
                                                        stepUpdated = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        
                                        // Approach 3: If still not found, try to trigger the continue button
                                        if (!stepUpdated) {
                                            console.log('Trying to trigger continue button');
                                            const continueButton = document.querySelector('[x-on\\:click*="handleContinue"]');
                                            if (continueButton) {
                                                continueButton.click();
                                                stepUpdated = true;
                                            }
                                        }
                                        
                                        if (!stepUpdated) {
                                            console.error('Could not update step - all approaches failed');
                                        }
                                    } else {
                                        console.error('Failed to save house rules');
                                    }
                                } catch (error) {
                                    console.error('Error saving house rules:', error);
                                }
                            }

                            // Function to save availability settings from step 12
                            async function saveAvailabilitySettingsFromStep12(alpineData) {
                                try {
                                    const propertyId = {{ $property->id ?? 'null' }};
                                    console.log('saveAvailabilitySettingsFromStep12 called with propertyId:', propertyId);
                                    
                                    // Get the step 12 data
                                    const step12Element = document.querySelector('[x-data*="allowLongStays"]');
                                    if (!step12Element) {
                                        console.error('Could not find step 12 element');
                                        return;
                                    }
                                    
                                    const step12Data = Alpine.$data(step12Element);
                                    console.log('Step 12 data found:', step12Data);
                                    
                                    const availabilityData = {
                                        property_id: propertyId,
                                        availability_mode: step12Data.availabilityOption === '18months' ? '18months' : 'continuous',
                                        availability_days: parseInt(step12Data.availabilityOption),
                                        allow_long_stays: step12Data.allowLongStays,
                                        max_nights: step12Data.allowLongStays ? document.getElementById('max_nights')?.value : null,
                                        sync_tripadvisor: false // Default to false for now
                                    };
                                    
                                    console.log('Availability data to be sent:', availabilityData);
                                    
                                    const response = await fetch(`/partner/property/${propertyId}/availability-settings`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                        },
                                        body: JSON.stringify(availabilityData)
                                    });
                                    
                                    if (response.ok) {
                                        console.log('Availability settings saved successfully');
                                        alpineData.step = Math.min(alpineData.step + 1, 13);
                                    } else {
                                        console.error('Failed to save availability settings');
                                        const errorData = await response.json();
                                        console.error('Error details:', errorData);
                                    }
                                } catch (error) {
                                    console.error('Error saving availability settings:', error);
                                }
                            }

                            // Function to save partner verification from step 11
                            async function savePartnerVerificationFromStep11(alpineData) {
                                try {
                                    const propertyId = {{ $property->id ?? 'null' }};
                                    
                                    // Get the step 11 data
                                    const step11Element = document.querySelector('[x-data*="ownershipType"]');
                                    if (!step11Element) {
                                        console.error('Could not find step 11 element');
                                        return;
                                    }
                                    
                                    const step11Data = Alpine.$data(step11Element);
                                    let verificationData = {
                                        property_id: propertyId,
                                        type: step11Data.ownershipType
                                    };
                                    
                                    console.log('Initial verification data:', verificationData);
                                    
                                    if (step11Data.ownershipType === 'individual') {
                                        // For individual, use individual data
                                        if (step11Data.individual) {
                                            verificationData.full_name = `${step11Data.individual.firstName} ${step11Data.individual.lastName}`.trim();
                                            verificationData.national_id = step11Data.individual.dob; // Using DOB as national_id for now
                                            // Add owners array for individual
                                            verificationData.owners = [{
                                                first_name: step11Data.individual.firstName,
                                                last_name: step11Data.individual.lastName,
                                                dob: step11Data.individual.dob
                                            }];
                                        }
                                    } else if (step11Data.ownershipType === 'business') {
                                        // For business, use business data
                                        if (step11Data.business) {
                                            verificationData.company_name = step11Data.business.businessName;
                                            verificationData.registration_number = step11Data.business.address; // Using address as registration_number for now
                                            // Add owners array for business if available
                                            if (step11Data.business.owners && step11Data.business.owners.length > 0) {
                                                verificationData.owners = step11Data.business.owners.map(owner => ({
                                                    first_name: owner.firstName,
                                                    last_name: owner.lastName,
                                                    dob: owner.dob
                                                }));
                                            }
                                        }
                                    }
                                    
                                    console.log('Final verification data to be sent:', verificationData);
                                    
                                    const response = await fetch(`/partner/store-verification`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                        },
                                        body: JSON.stringify(verificationData)
                                    });
                                    
                                    if (response.ok) {
                                        console.log('Partner verification saved successfully');
                                        alpineData.step = Math.min(alpineData.step + 1, 13);
                                    } else {
                                        console.error('Failed to save partner verification');
                                        const errorData = await response.json();
                                        console.error('Error details:', errorData);
                                    }
                                } catch (error) {
                                    console.error('Error saving partner verification:', error);
                                }
                            }




                        </script>
                        </html>