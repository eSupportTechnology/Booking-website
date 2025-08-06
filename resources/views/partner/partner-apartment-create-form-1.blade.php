
@extends('partner.partner-layout')

@section('title', 'Apartment Create | ' . config('domains.app_name'))

<body class="bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class=" text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Container flex with items-start for vertical alignment -->
            <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">

                <!-- Left Section -->
                <div class="w-full md:w-auto">
                    <div class="flex flex-col items-start">
                        <!-- Logo -->
                        @php
                            $host = config('domains.app_name');

   
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if ($host == 'BookinTour')
                                <h1>Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
                        </a>




                        <!-- Push nav a bit down to separate from logo -->
                        @php
                            $currentRoute = request()->route()->getName(); // Get current route name
                        @endphp

                        <nav class="flex flex-wrap gap-4 text-sm md:text-base mt-6 ">
                            <!-- Stays Link -->
                            <a href="{{ route('stays') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border
          text-white transition
          {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
                            </a>


                            <!-- Car Rentals Link -->
                            <a href="{{ route('car.rentals') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border
          text-white transition
          {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
                            </a>


                            <!-- Airport Taxis Link -->
                            <a href="{{ route('airport.taxis') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Airport taxis</span>
                            </a>

                            <a href="{{ route('airport.tours') }}"
                                class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
                                <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Tour packages</span>
                            </a>

                        </nav>


                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Currency display button -->
                    <!-- Currency display and button -->
                    <div class="flex items-center space-x-2">
                        <span id="current-currency" class="font-semibold cursor-pointer select-none"
                            title="Click to change currency">
                            LKR
                        </span>
                    </div>

                    <!-- Currency Modal -->
                    <div id="currency-modal"
                        class="fixed inset-0 hidden z-50 flex items-start justify-center px-4 py-8 bg-black bg-opacity-50 overflow-y-auto">
                        <div class="relative w-full max-w-sm p-6 bg-white rounded-lg shadow">
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Select Currency</h3>
                                <button id="currency-close-btn" type="button"
                                    class="text-gray-400 hover:text-gray-900 text-2xl font-bold leading-none"
                                    aria-label="Close modal">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="grid grid-cols-2 gap-4">
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="LKR">
                                    LKR - Sri Lankan Rupee
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="USD">
                                    USD - US Dollar
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="EUR">
                                    EUR - Euro
                                </button>
                                <button class="p-2 rounded hover:bg-gray-100" data-currency="GBP">
                                    GBP - British Pound
                                </button>
                                <!-- Add more currencies as needed -->
                            </div>
                        </div>
                    </div>

                    <!-- Language Button -->

                    <button id="language-button" type="button"
                        class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
                        <img src="" alt="" class="w-full h-full object-cover rounded-full" />
                    </button>

                    <!-- Language Modal -->
                    <div id="language-modal"
                        class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                            <!-- Modal Header -->
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Select your language
                                </h3>
                                <button type="button"
                                    class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="mt-4">
                                <p class="mb-4 text-base text-gray-500 dark:text-gray-400">
                                    Suggested for you
                                </p>
                                <div class="grid grid-cols-2 gap-4">

                                    <a href="/">
                                        <button
                                            class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="" alt="" class="h-5 w-5" />
                                            <span></span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="">
                        <img src="{{ asset('assets/question.svg') }}" alt="Taxi" class="w-5 h-5 cursor-pointer" />
                    </a>

                    <a href="/list-your-property" class="hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">List your property</a>


                    <!-- Profile dropdown -->
                    <div class="relative group">
                        <button class=" text-[#3CC0E9] font-base px-4 py-2 rounded  flex items-center space-x-2">
                            <!-- Profile Icon with Border -->
                            <div class="bg-white p-2 border border-[#3CC0E9] rounded-full">
                                <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" alt="Profile" />
                            </div>

                            <!-- My Account Link -->
                            <a href="/my-account" class="text-white hover:underline"
                                style="font-family: 'Noto Sans', sans-serif;">
                                Your Account
                            </a>
                        </button>

                        <!-- Dropdown -->
                        <div
                            class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible transition-all duration-200 invisible z-50">
                            <a href="/profile"
                                class="block px-4 text-base py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/mynaui_user.svg') }}" alt="My Account Icon"
                                    class="w-5 h-5" />
                                <span style="font-family: 'Noto Sans', sans-serif;">My Account</span>
                            </a>
                            <a href="/profile"
                                class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/streamline_baggage.svg') }}" alt="My Account Icon"
                                    class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Bookings & Trips</span>
                            </a>
                            <a href="/profile"
                                class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/mynaui_letter-g-circle.svg') }}" alt="My Account Icon"
                                    class="w-5 h-5" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Genius loyalty programme</span>
                            </a>
                            <a href="/profile"
                                class="block px-4 py-2 text-gray-700  text-base  hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/lets-icons_wallet-light.svg') }}" alt="My Account Icon"
                                    class="w-5 h-5" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Rewards & Wallet</span>
                            </a>
                            <a href="/profile"
                                class="block px-4 py-2 text-gray-700  text-base  hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/fluent_person-feedback-20-regular.svg') }}"
                                    alt="My Account Icon" class="w-5 h-5" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Reviews</span>
                            </a>
                            <a href="/profile"
                                class="block px-4 py-2 text-gray-700  text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/mdi-light_heart.svg') }}" alt="My Account Icon"
                                    class="w-5 h-5" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Saved</span>
                            </a>

                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-700 text-base hover:bg-gray-100 flex items-center gap-2">
                                <img src="{{ asset('assets/simple-line-icons_logout.svg') }}" alt="Logout Icon"
                                    class="w-4 h-4" />
                                <span style="font-family: 'Noto Sans', sans-serif;">Logout</span>
                            </button>

                        </div>
                    </div>
                    <!-- Guest buttons -->
                    <a href="" class="bg-white font-base px-4 py-2 rounded hover:bg-blue-100"
                        style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">Register</a>
                    <a href="" class="bg-white font-base px-4 py-2 rounded hover:bg-blue-100"
                        style="font-family: 'Noto Sans', sans-serif; color:#3CC0E9;">Sign in</a>


                </div>

            </div>
        </div>
    </section>
</header>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Currency modal logic
        const currentCurrency = document.getElementById("current-currency");
        const currencyModal = document.getElementById("currency-modal");
        const currencyCloseBtn = document.getElementById("currency-close-btn");

        if (currentCurrency && currencyModal && currencyCloseBtn) {
            // Open currency modal on clicking the currency span
            currentCurrency.addEventListener("click", () => {
                currencyModal.classList.remove("hidden");
            });

            // Close currency modal on close button click
            currencyCloseBtn.addEventListener("click", () => {
                currencyModal.classList.add("hidden");
            });

            // Close currency modal on clicking outside the modal content
            window.addEventListener("click", (e) => {
                if (e.target === currencyModal) {
                    currencyModal.classList.add("hidden");
                }
            });

            // Change currency when a currency button is clicked
            currencyModal.querySelectorAll("button[data-currency]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const selectedCurrency = btn.getAttribute("data-currency");
                    currentCurrency.textContent = selectedCurrency;
                    currencyModal.classList.add("hidden");
                });
            });
        }

        // Language modal logic
        const languageButton = document.getElementById("language-button");
        const languageModal = document.getElementById("language-modal");
        const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

        if (languageButton && languageModal && closeBtn) {
            // Open the language modal
            languageButton.addEventListener("click", () => {
                languageModal.classList.remove("hidden");
            });

            // Close language modal on close button click
            closeBtn.addEventListener("click", () => {
                languageModal.classList.add("hidden");
            });

            // Close language modal on clicking outside the modal content
            window.addEventListener("click", (event) => {
                if (event.target === languageModal) {
                    languageModal.classList.add("hidden");
                }
            });
        }
    });
</script>

    <!--Start Form-->
    <div class="max-w-6xl p-4 ml-14  " x-data="{
        step: 1,
        categoryId: null,
        addressTypeId: null,
        showProgress: false,
        selected: '',
        sameAddress: 'yes',
        propertyCount: 2,
        selectedChannels: [],
        url: '',
        showImportSection() {
            return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
        }
    }">

        <!-- Add CSRF token meta tag -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form method="POST" action="{{ route('partner.property.step1.store_new') }}"
            class=" p-6 rounded-lg  space-y-6" enctype="multipart/form-data"             @submit="
                console.log('Form submit event triggered');
                // Ensure addressTypeId is set correctly before submission
                if (selected === 'One') {
                    addressTypeId = 1;
                } else if (selected === 'Multiple') {
                    if (sameAddress === 'no') {
                        addressTypeId = 3;
                    } else {
                        addressTypeId = 2;
                    }
                }
                console.log('Form submission - selected:', selected, 'sameAddress:', sameAddress, 'addressTypeId:', addressTypeId);
                console.log('Form action:', event.target.action);
                console.log('Form data being submitted:', {
                    categoryId: categoryId,
                    propertyCount: propertyCount,
                    addressTypeId: addressTypeId,
                    selectedChannels: selectedChannels
                });
                
                // For multiple apartments with same address, we need to handle the redirect after form submission
                console.log('Checking condition - selected:', selected, 'sameAddress:', sameAddress);
                console.log('Condition result:', selected === 'Multiple' && sameAddress === 'yes');
                
                if (selected === 'Multiple' && sameAddress === 'yes') {
                    console.log('AJAX submission triggered');
                    // Prevent default form submission and handle it manually
                    event.preventDefault();
                    
                    // Submit form via AJAX
                    const formData = new FormData(event.target);
                    fetch(event.target.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Form submission response:', data);
                        if (data.success) {
                            // Redirect to multiple apartment form with property ID
                            console.log('Redirecting to multiple apartment form with property ID:', data.property_id);
                            window.location.href = '/partner/partner-multiple-apartment/' + data.property_id;
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving the property.');
                    });
                }
            ">
            @csrf

            <!-- Hidden fields for DTO data -->
            <input type="hidden" name="category_id" :value="categoryId">
            <input type="hidden" name="property_count" :value="propertyCount">
            <input type="hidden" name="address_type_id" :value="addressTypeId">
            <input type="hidden" name="selected_channels" :value="selectedChannels.join(',')">

            <!-- Progress bar -->
            <div x-show="showProgress" class="flex justify-between mb-6 text-sm font-medium">
                <template x-for="n in 10" :key="n">
                    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
                        Step <span x-text="n"></span>
                    </div>
                </template>
            </div>


            <!-- Main Step 1 (How many apartments)-->
            <div x-show="step === 1" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow ">
                    <div class="max-w-xl mx-auto p-4 space-y-6">

                        <h2 class="text-2xl font-bold text-center">How many apartments are you listing?</h2>

                        <!-- Apartment type options -->
                        <div class="space-y-4">
                            @foreach ($subcategories as $subcategory)
                                <label
                                    :class="selected === '{{ $subcategory->name }}' ? 'border-blue-600 border-2' :
                                        'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white"
                                    @click="selected = '{{ $subcategory->name }}'; categoryId = {{ $subcategory->category_id ?? 'null' }}; addressTypeId = {{ $subcategory->name === 'One' ? 1 : 2 }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @if ($subcategory->name === 'One')
                                                <img src="{{ asset('images/aprt-b.png') }}" alt="One Apartment"
                                                    class="w-14 h-10" />
                                                <span class="text-lg text-gray-800">One apartment</span>
                                            @elseif($subcategory->name === 'Multiple')
                                                <img src="{{ asset('images/aprt-a.png') }}" alt="Multiple Apartments"
                                                    class="w-14 h-10" />
                                                <span class="text-lg text-gray-800">Multiple apartments</span>
                                            @else
                                                <span class="text-lg text-gray-800">{{ $subcategory->name }}</span>
                                            @endif
                                        </div>
                                        <template x-if="selected === '{{ $subcategory->name }}'">
                                            <div class="text-blue-600 text-xl font-bold">✔</div>
                                        </template>
                                    </div>
                                    <input type="radio" name="apartment_type" value="{{ $subcategory->name }}"
                                        x-model="selected" class="hidden" />
                                </label>
                            @endforeach
                        </div>

                        <!-- Conditional fields for multiple apartments -->
                        <div x-show="selected === 'Multiple'" x-transition
                            class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
                            <h3 class="text-lg font-semibold">Are these properties in the same address or building?
                            </h3>

                            <!-- Same address option -->
                            <label
                                :class="sameAddress === 'yes' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                class="block rounded p-4 cursor-pointer bg-white"
                                @click="sameAddress = 'yes'; addressTypeId = 2">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/accomm_single_address@2x.png') }}"
                                        alt="Multiple Apartments" class="w-10 h-10" />
                                    <span>Yes, these apartments are at the same address or building</span>
                                </div>
                            </label>

                            <!-- Different addresses option -->
                            <label
                                :class="sameAddress === 'no' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                class="block rounded p-4 cursor-pointer bg-white"
                                @click="sameAddress = 'no'; addressTypeId = 3">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/accomm_multiple_address@2x.png') }}"
                                        alt="Multiple Apartments" class="w-14 h-10" />
                                    <span>No, these apartments are at different addresses or buildings</span>
                                </div>
                            </label>

                            <!-- Number of properties -->
                            <div>
                                <label class="block font-medium mb-1">Number of properties</label>
                                <input type="number" min="2" x-model="propertyCount"
                                    @input="formData.property_count = propertyCount" name="property_count"
                                    class="border rounded w-24 p-2" />
                            </div>
                        </div>
                        <!-- Navigation Buttons for Step 1 -->
                        <template x-if="step === 1">
                            <div class="flex items-center justify-between pt-4">
                                <button type="button" @click="step--"
                                    class="border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                    ←
                                </button>
                                <button type="button"
                                    @click="
                                        if(selected === 'One') {
                                            step = 2;
                                        } else if(selected === 'Multiple') {
                                            step = 3;
                                        }
                                    "
                                    class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"
                                    :class="!selected ? 'opacity-50 cursor-not-allowed' : ''">
                                    Continue
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!--Main Step 1 End-->

            <!-- Confirmation Step for ONE Apartment (Step 2) -->
            <div x-show="step === 2 && selected === 'One'" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/aprt-b.png') }}" alt="One Apartment"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        One apartment where guests can book the entire apartment
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="button" @click="step = 4"
                            class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                            Continue
                        </button>
                        <button type="button" @click="step = 1"
                            class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded mb-6">
                            No, I need to make a change
                        </button>
                    </div>
                </div>
            </div>

            <!-- Confirmation Step for MULTIPLE Apartments (Step 3) -->
            <div x-show="step === 3 && selected === 'Multiple'" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        <span x-text="sameAddress === 'yes' ? 'Multiple apartments in the same location' : 'Multiple apartments in different locations'"></span>
                        where guests can book an entire apartment
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="submit" x-show="sameAddress === 'yes'"
                            class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                            Continue
                        </button>
                        <button type="button" x-show="sameAddress === 'no'"
                            @click="step = 4"
                            class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                            Continue
                        </button>
                        <button type="button" @click="step = 1"
                            class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded mb-6">
                            No, I need to make a change
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Step 4 (Where else is your property listed? - For ONE apartment)-->
            <div x-show="step === 4" x-cloak>
                <div x-data="{
                    selectedChannels: [],
                    get showImportSection() {
                        return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
                    }
                }" class="bg-white max-w-xl w-full p-6 rounded-lg shadow space-y-6">

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-gray-900" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Where else are your properties listed?' : 'Where else is your property listed?'"></h2>

                    <!-- Info -->
                    <p class="text-sm text-gray-700">
                        <span x-text="selected === 'Multiple' && sameAddress === 'no' ? 'If your properties are listed on Airbnb or Vrbo, you can speed up registration by importing them' : 'If your property is listed on Airbnb or Vrbo, you can speed up registration by importing it'"></span>
                        directly to {{ config('domains.subdomain') }}.
                    </p>

                    <!-- Checkboxes -->
                    <div class="space-y-4 text-left">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Airbnb" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Airbnb</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="TripAdvisor" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>TripAdvisor</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Vrbo" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Vrbo</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Another" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Another website</span>
                        </label>
                        <label class="flex items-center space-x-3 text-gray-400"
                            :class="{ 'text-gray-900': !selectedChannels.length }">
                            <input type="checkbox" value="None" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600" :disabled="selectedChannels.length > 0">
                            <span x-text="selected === 'Multiple' && sameAddress === 'no' ? 'My properties aren\'t listed on any other websites' : 'My property isn\'t listed on any other websites'"></span>
                        </label>
                    </div>

                    <!-- Conditional Airbnb/Vrbo import section -->
                    <div x-show="showImportSection" x-transition class="border-t pt-6 space-y-4">
                        <h3 class="font-semibold text-gray-800">Import property details from Airbnb or Vrbo</h3>

                        <label class="block text-sm font-medium text-gray-700" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Paste the links to your Airbnb or Vrbo listings' : 'Paste the link to your Airbnb or Vrbo listing'"></label>
                        <div x-data="{ url: '' }" class="flex gap-2">
                            <input type="url" x-model="url" :disabled="true"
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                                placeholder="https://www.airbnb.com/rooms/xxxxx or https://www.vrbo.com/xxxxx">
                            <button type="button" class="px-4 py-2 rounded"
                                :class="url ? 'bg-blue-500 text-white cursor-pointer hover:bg-[#29ACD5]' :
                                    'bg-gray-300 text-gray-600 cursor-not-allowed'"
                                :disabled="!url">
                                Apply
                            </button>
                        </div>

                        <p class="text-xs text-gray-600">
                            Example links:<br>
                            https://www.airbnb.com/rooms/xxxxxxx<br>
                            https://www.vrbo.com/xxxxxx
                            <span x-show="selected === 'Multiple' && sameAddress === 'no'"><br><em>Note: You can add multiple property links during the next steps.</em></span>
                        </p>
                        <a href="#" class="text-blue-600 text-sm hover:underline" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Where can I find these links?' : 'Where can I find this link?'"></a>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between pt-4">
                        <button type="button" @click="selected === 'Multiple' && sameAddress === 'no' ? step = 3 : step = 2"
                            class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                            ←
                        </button>
                        <button type="submit" :disabled="selectedChannels.length === 0"
                            :class="selectedChannels.length === 0 ?
                                'bg-gray-300 text-gray-600 cursor-not-allowed' :
                                'bg-[#3CC0E9] hover:bg-[#29ACD5] text-white cursor-pointer'"
                            class="font-semibold py-3 px-6 rounded transition duration-200">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
            <!--Main Step 4 End-->



        </form>
    </div>
@endsection