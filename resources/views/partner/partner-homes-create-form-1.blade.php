<!DOCTYPE html>
<html lang="en" x-data="{ step: 1, selectedBox: null }" xmlns:x-bind="http://www.w3.org/1999/xlink">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>create homes</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                        <a href="/" class="text-2xl font-bold font-poppins">
                            {{ config('app.name') }}
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
                        <!-- Logout Link -->
                        <form action="{{ route('partner.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-200 hover:underline"
                                title="Logout">
                                Logout
                            </button>
                        </form>

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

    <!-- Start Form -->
<div class="max-w-6xl p-4 ml-14 bg-gray-100" x-data="{ propertyId: null, selected: '',  propertyName: '',description: '',availableLanguages: {{ Js::from($languages) }} }">

        <!-- Step 1: Main Form Step -->
        <form class="p-6 rounded-lg space-y-6" @submit.prevent>
            <div class="flex justify-between mb-6 text-sm font-medium hidden">
                <template x-for="n in 10" :key="n">
                    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
                        Step <span x-text="n"></span>
                    </div>
                </template>
            </div>


            <!-- Main Step 1 Content -->
            <div x-show="step === 1" x-cloak x-data="{

                subcategories: {{ Js::from($subcategories) }},
                async submitStep1() {
                    if (this.selected === '') return;

                    try {
                        const response = await fetch('{{ route('partner.property.step1.store_new') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                apartment_type: this.selected,
                                subcategory_id: this.selected,
                                category_id: '{{ $categoryId }}'
                            })
                        });

                        const contentType = response.headers.get('content-type');
                        if (!response.ok || !contentType.includes('application/json')) {
                            const text = await response.text();
                            console.error('Server did not return JSON:', text);
                            alert('Unexpected server response');
                            return;
                        }

                        const data = await response.json();
                        this.propertyId = data.property_id;
                        this.step = 2;
                        await this.fetchSubtypes(this.selected);
                        alert(data.message || 'Property created successfully');

                    } catch (error) {
                        console.error('Request failed:', error);
                        alert('Request failed: ' + error.message);
                    }
                },
                    async fetchSubtypes(subcategoryId) {
                        try {
                            const response = await fetch(`/partner/property_subtype/${subcategoryId}`);
                            const data = await response.json();
                            console.log('Fetched subtypes:', data);
                            this.subtypes = data;
                        } catch (err) {
                            console.error('Failed to fetch subtypes:', err);
                        }
                    }

                }">
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow">
                    <div class="max-w-xl mx-auto p-4 space-y-6">
                        <h2 class="text-2xl font-bold text-center">@lang('messages.what_can_guests_book')</h2>

                        <div class="space-y-4">
                            <template x-for="subcategory in subcategories" :key="subcategory.id">
                                <label
                                    :class="selected === subcategory.id ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white relative"
                                    @click="selected = subcategory.id">

                                    <template x-if="selected === subcategory.id">
                                        <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
                                    </template>

                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="Icon"
                                            class="w-10 h-10" />
                                        <div>
                                            <span class="text-lg text-gray-800 font-semibold"
                                                x-text="subcategory.name"></span>
                                            <p class="text-sm text-gray-600" x-text="subcategory.desc"></p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="category_id" value="{{ $categoryId }}">

                                    <input type="radio" name="subcategory_id" :value="subcategory.id"
                                        x-model="selected" class="hidden" />
                                </label>
                            </template>

                            <div class="flex items-center justify-between pt-4">
                                <button type="button"
                                    @click="window.location.href = '{{ route('partner.property.category') }}'"
                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                    ←
                                </button>
                                <button type="button" @click="submitStep1()"
                                    class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"
                                    :disabled="selected === ''"
                                    :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''">
                                    @lang('messages.continue')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Step 2: Selection Container -->
            <div id="selection-container" x-show="step === 2" x-cloak class="container mx-auto px-4 py-8 max-w-6xl"
                x-data="{
                    async submitStep2() {
                        if (!this.selectedBox || !this.propertyId) return;

                        const response = await fetch(`/partner/property/${this.selectedBox}/step2/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                subtype_id: this.selectedBox,
                                property_id: this.propertyId
                            })
                        });

                        if (response.ok) {
                            const data = await response.json();
                            this.step = 3;
                            console.log('Step 2 selectedBox:', this.selectedBox);
                            alert(data.message || 'Step 2 saved successfully');
                        } else {
                            const error = await response.json();
                            alert(error.message || 'Error in Step 2');
                        }
                    }
                }">
                <h2 class="text-2xl font-bold mb-8 text-left">
                    @lang('messages.which_property_category_similar')
                </h2>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Cards -->
                        <template x-for="(property, index) in subtypes" :key="property.id">
                            <div @click="selectedBox = property.id"
                                :class="selectedBox === property.id ? 'border-blue-500 bg-gray-100' : 'border border-gray-300'"
                                class="relative rounded p-4 cursor-pointer transition-all duration-200">

                                <h3 class="text-base font-bold text-gray-800 mb-4" x-text="property.title"></h3>
                                <p class="text-sm text-gray-800" x-text="property.desc"></p>

                                <div class="tick-box absolute top-2 right-2" x-show="selectedBox === property.id">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                <!-- Help Link -->
                <div class="mt-8 text-left">
                    <a href="#" class="flex items-center space-x-2 text-sm text-blue-500 hover:underline">
                        <img src="{{ asset('assets/iconoir_question-mark-circle.svg') }}" class="w-5 h-5" />
                        <span class="text-base">@lang('messages.i_dont_see_my_property_type')</span>
                    </a>

                </div>

                <template x-if="step === 2">
                    <div class="flex items-center justify-between pt-4">
                        <button type="button" @click="step = 1"
                            class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
                            ←
                        </button>

                        <button id="continueBtn" @click="submitStep2()" :disabled="!selectedBox"
                            :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' :
                                'bg-[#3CC0E9] hover:bg-blue-600 cursor-pointer'"
                            class="py-3 px-8 rounded transition-all duration-200 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold"
                            type="button">
                            @lang('messages.continue')
                        </button>

                    </div>
                </template>


            </div>

            <!-- Step 3+: Property Details Sections -->
            <template x-if="step === 3" @step-change.window="step = $event.detail">
                <div>
                    <!-- Apartment -->
                    <section
                        x-init="if (selectedBox === 3) window.location.href = '{{ route('partner.property.subcategory', 2) }}'"
                        x-show="false">
                    </section>



                    <section x-data="wizard(selectedBox)" x-show="[1, 2, 4, 5, 6].includes(selectedBox)" x-cloak>
                        <form class="p-6 rounded-lg" enctype="multipart/form-data" @submit.prevent>
                            <!-- Step 1: Choose one or multiple -->
                            <template x-if="step === 1">
                                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow space-y-6 ">
                                    <h2 class="text-xl font-bold text-left" x-text="headingLabel"></h2>

                                    <div class="space-y-4">
                                        <label
                                            :class="selected === 'one' ? 'border-blue-600 border-2' :
                                                'border border-gray-300'"
                                            class="block rounded p-4 cursor-pointer bg-white"
                                            @click="selectOption('one')">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <img src="{{ asset('images/aprt-b.png') }}" class="w-14 h-10" />
                                                    <span class="text-lg" x-text="singleLabel"></span>
                                                </div>
                                                <template x-if="selected === 'one'">
                                                    <div class="text-blue-600 text-xl font-bold">✔</div>
                                                </template>
                                            </div>
                                        </label>

                                        <label
                                            :class="selected === 'multiple' ? 'border-blue-600 border-2' :
                                                'border border-gray-300'"
                                            class="block rounded p-4 cursor-pointer bg-white"
                                            @click="selectOption('multiple')">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <img src="{{ asset('images/aprt-a.png') }}" class="w-14 h-10" />
                                                    <span class="text-lg" x-text="multipleLabel"></span>
                                                </div>
                                                <template x-if="selected === 'multiple'">
                                                    <div class="text-blue-600 text-xl font-bold">✔</div>
                                                </template>
                                            </div>
                                        </label>
                                    </div>

                                    <div x-show="selected === 'multiple'" x-cloak
                                        class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
                                        <h3 class="text-lg font-semibold">Are these properties in the same address?
                                        </h3>

                                        <label
                                            :class="sameAddress === 'yes' ? 'border-blue-600 border-2' :
                                                'border border-gray-300'"
                                            class="block rounded p-4 cursor-pointer bg-white"
                                            @click="sameAddress = 'yes'">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ asset('images/accomm_single_address@2x.png') }}"
                                                    class="w-10 h-10" />
                                                <span>Yes, same address or building</span>
                                            </div>
                                        </label>

                                        <label
                                            :class="sameAddress === 'no' ? 'border-blue-600 border-2' :
                                                'border border-gray-300'"
                                            class="block rounded p-4 cursor-pointer bg-white"
                                            @click="sameAddress = 'no'">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ asset('images/accomm_multiple_address@2x.png') }}"
                                                    class="w-14 h-10" />
                                                <span>No, different addresses or buildings</span>
                                            </div>
                                        </label>

                                        <div>
                                            <label class="block font-medium mb-1">Number of properties</label>
                                            <input type="number" min="2" x-model.number="propertyCount"
                                                class="border rounded w-24 p-2" />
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-4">
                                        <button type="button"
                                            @click="$dispatch('step-change', 2)"
                                            class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
                                            ←
                                        </button>

                                        <button type="button"
                                            @click="nextStep"
                                            :disabled="selected === ''"
                                            :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''"
                                            class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-3 px-8 rounded">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Steps 2+ -->
                            <template x-if="step > 1">
                                <div class=" max-w-2xl">


                                    <div>
                                        <!-- Steps for 'one' -->
                                        <template x-if="step === 2 && selected === 'one'">
                                            <div>
                                                <div
                                                    class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                                                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                                                    <!-- Icon -->
                                                    <div class="flex justify-center mb-8">
                                                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}"
                                                            alt="Multiple Apartments" class="w-16 h-16" />
                                                    </div>

                                                    <!-- Heading -->
                                                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                                                        Multiple apartments in the same location where guests can book
                                                        an entire apartment
                                                    </h2>

                                                    <!-- Description -->
                                                    <p class="text-gray-700 mb-8">Does this sound like your property?
                                                    </p>

                                                    <!-- Buttons -->
                                                    <template x-if="step === 2">
                                                        <div class="space-y-2">
                                                            <button type="button" @click="nextStep"
                                                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                                                Continue
                                                            </button>
                                                            <button type="button" @click="prevStep"
                                                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                                                No, I need to make a change
                                                            </button>
                                                        </div>
                                                    </template>

                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="step === 3 && selected === 'one'">
                                            <div>
                                                <div x-data="{
                                                    selectedChannels: [],
                                                    get showImportSection() {
                                                        return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
                                                    }
                                                }"
                                                    class="bg-white max-w-xl w-full p-6 rounded-lg shadow space-y-6">

                                                    <!-- Title -->
                                                    <h2 class="text-2xl font-bold text-gray-900">Where else is your
                                                        property listed?</h2>

                                                    <!-- Info -->
                                                    <p class="text-sm text-gray-700">
                                                        If your property is listed on Airbnb or Vrbo, you can speed up
                                                        registration by importing it directly to Booking.com.
                                                    </p>

                                                    <!-- Checkboxes -->
                                                    <div class="space-y-4 text-left">
                                                        <label class="flex items-center space-x-3">
                                                            <input type="checkbox" value="Airbnb"
                                                                x-model="selectedChannels"
                                                                class="form-checkbox h-5 w-5 text-blue-600">
                                                            <span>Airbnb</span>
                                                        </label>
                                                        <label class="flex items-center space-x-3">
                                                            <input type="checkbox" value="TripAdvisor"
                                                                x-model="selectedChannels"
                                                                class="form-checkbox h-5 w-5 text-blue-600">
                                                            <span>TripAdvisor</span>
                                                        </label>
                                                        <label class="flex items-center space-x-3">
                                                            <input type="checkbox" value="Vrbo"
                                                                x-model="selectedChannels"
                                                                class="form-checkbox h-5 w-5 text-blue-600">
                                                            <span>Vrbo</span>
                                                        </label>
                                                        <label class="flex items-center space-x-3">
                                                            <input type="checkbox" value="Another"
                                                                x-model="selectedChannels"
                                                                class="form-checkbox h-5 w-5 text-blue-600">
                                                            <span>Another website</span>
                                                        </label>
                                                        <label class="flex items-center space-x-3 text-gray-400"
                                                            :class="{ 'text-gray-900': !selectedChannels.length }">
                                                            <input type="checkbox" value="None"
                                                                x-model="selectedChannels"
                                                                class="form-checkbox h-5 w-5 text-blue-600"
                                                                :disabled="selectedChannels.length > 0">
                                                            <span>My property isn't listed on any other websites</span>
                                                        </label>
                                                    </div>

                                                    <!-- Conditional Airbnb/Vrbo import section -->
                                                    <div x-show="showImportSection" x-transition
                                                        class="border-t pt-6 space-y-4">
                                                        <h3 class="font-semibold text-gray-800">Import property details
                                                            from Airbnb or Vrbo</h3>

                                                        <label class="block text-sm font-medium text-gray-700">Paste
                                                            the link to your Airbnb or Vrbo listing</label>
                                                        <div x-data="{ url: '' }" class="flex gap-2">
                                                            <input type="url" name="import_url" x-model="url"
                                                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                                                                placeholder="https://www.airbnb.com/rooms/xxxxx or https://www.vrbo.com/xxxxx"
                                                                required>
                                                            <button type="button" class="px-4 py-2 rounded"
                                                                :class="url ?
                                                                    'bg-blue-500 text-white cursor-pointer hover:bg-[#29ACD5]' :
                                                                    'bg-gray-300 text-gray-600 cursor-not-allowed'"
                                                                :disabled="!url">
                                                                Apply
                                                            </button>
                                                        </div>

                                                        <p class="text-xs text-gray-600">
                                                            Example links:<br>
                                                            https://www.airbnb.com/rooms/xxxxxxx<br>
                                                            https://www.vrbo.com/xxxxxx
                                                        </p>
                                                        <a href="#"
                                                            class="text-blue-600 text-sm hover:underline">Where can I
                                                            find this link?</a>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <template x-if="step === 3">
                                                        <div class="flex items-center justify-between pt-4">
                                                            <button type="button" @click="prevStep"
                                                                class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded  ">
                                                                ←
                                                            </button>
                                                            <button type="button" @click="nextStep"
                                                                :disabled="selectedChannels.length === 0"
                                                                :class="selectedChannels.length === 0 ?
                                                                    'bg-gray-300 text-gray-600 cursor-not-allowed' :
                                                                    'bg-[#3CC0E9] hover:bg-[#29ACD5] text-white cursor-pointer'"
                                                                class="font-semibold py-3 px-6 rounded transition duration-200">
                                                                Continue
                                                            </button>

                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="step === 4 && selected === 'one'">
                                            <div class="space-y-6">
                                                <h3 class="text-xl font-bold">Name Your Property</h3>

                                                <div>
                                                    <label for="propertyName" class="block text-sm font-medium text-gray-700 mb-1">Property Name</label>
                                                    <div class="relative rounded-md shadow-sm">
                                                        <input
                                                            id="propertyName"
                                                            type="text"
                                                            x-model="propertyName"
                                                            placeholder="e.g., Ocean View Apartment"
                                                            class="pl-4 pr-4 py-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500" />

                                                    </div>
                                                    <p class="text-sm text-gray-500 mt-1">Choose a name that helps guests identify your property.</p>
                                                    <textarea
                                                        id="description"
                                                        x-model="description"
                                                        class="pl-4 pr-4 py-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500"
                                                        name="description"
                                                        rows="4"
                                                        placeholder="Enter your property description here..."></textarea>

                                                    <p class="text-sm text-gray-500 mt-1">Provide a brief description of your property.</p>
                                                </div>

                                                <div class="flex justify-between pt-4">
                                                    <button type="button"
                                                        @click="prevStep"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded">
                                                        ←
                                                    </button>

                                                    <button
                                                        type="button"
                                                        @click="nextStep"
                                                        class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold px-6 py-2 rounded shadow">
                                                        Continue →
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="step === 5 && selected === 'one'">
                                            <div class="space-y-6">
                                                <h3 class="text-lg font-bold">Upload Photos</h3>

                                                <!-- Stylish Upload Box -->
                                                <div
                                                    class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-blue-400 transition"
                                                    @dragover.prevent
                                                    @drop.prevent>
                                                    <svg class="w-12 h-12 text-blue-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 16.5V18a2.5 2.5 0 002.5 2.5h13a2.5 2.5 0 002.5-2.5v-1.5M16.5 12L12 7.5 7.5 12M12 7.5V18" />
                                                    </svg>

                                                    <p class="text-gray-600 text-sm">Drag and drop your images here, or</p>

                                                    <label class="mt-2 cursor-pointer inline-block bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded font-medium">
                                                        Browse files
                                                        <input
                                                            type="file"
                                                            multiple
                                                            x-ref="photoInput"
                                                            @change="handlePreview"
                                                            accept="image/*"
                                                            class="hidden" />
                                                    </label>

                                                    <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG, WebP. Max size: 5MB each</p>
                                                </div>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4" x-show="previewFiles.length">
                                                    <template x-for="(file, index) in previewFiles" :key="index">
                                                        <img :src="file" class="rounded shadow object-cover w-full h-32 border border-gray-300" />
                                                    </template>
                                                </div>


                                                <!-- Navigation Buttons -->
                                                <div class="flex justify-between pt-4">
                                                    <button type="button"
                                                        @click="prevStep"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded">
                                                        ←
                                                    </button>

                                                    <button
                                                        type="button"
                                                        @click="nextStep"
                                                        class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold px-6 py-2 rounded shadow">
                                                        Continue →
                                                    </button>
                                                </div>
                                            </div>
                                        </template>





                                        <template x-if="step === 6 && selected === 'one'">
                                            <div>
                                                <div
                                                    class="relative w-[1400px] h-auto overflow-hidden rounded-lg shadow mx-auto -mt-14 -ml-16">

                                                    <!-- Google Maps iframe full background -->
                                                    <iframe class="absolute inset-0 w-full h-full" loading="lazy"
                                                        src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                                                        allowfullscreen>
                                                    </iframe>

                                                    <!-- Optional overlay for readability -->
                                                    <div class="absolute inset-0"></div>

                                                    <!-- Form content centered on map -->
                                                    <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                                                        <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                                                            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                                                            <form x-data="{
                                                                            addressForm: {
                                                                                address: '',
                                                                                apartment: '',
                                                                                city: '',
                                                                                zipcode: '',
                                                                                country: 'Sri Lanka'
                                                                            }
                                                                            }">
                                                                <div class="mb-4">
                                                                    <label for="address"
                                                                        class="block text-sm font-medium text-gray-700">Find
                                                                        your address</label>
                                                                    <input type="text" id="address"
                                                                        x-model="addressForm.address" name="address"
                                                                        value="Sri Lanka"
                                                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="apartment"
                                                                        class="block text-sm font-medium text-gray-700">Apartment
                                                                        or floor number (optional)</label>
                                                                    <input type="text" id="apartment"
                                                                        x-model="addressForm.apartment"
                                                                        name="apartment" value="aaa"
                                                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                                                                    <select id="country" x-model="addressForm.country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                        <option value="Sri Lanka" selected>Sri Lanka</option>
                                                                    </select>

                                                                </div>
                                                                <div class="flex flex-col md:flex-row gap-4">
                                                                    <div class="flex-1">
                                                                        <label for="city"
                                                                            class="block text-sm font-medium text-gray-700">City</label>
                                                                        <input type="text" id="city"
                                                                            x-model="addressForm.city" name="city"
                                                                            value="a"
                                                                            class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                    </div>
                                                                    <div class="flex-1">
                                                                        <label for="zipcode"
                                                                            class="block text-sm font-medium text-gray-700">Post
                                                                            code / Zip code</label>
                                                                        <input type="text" id="zipcode"
                                                                            x-model="addressForm.zipcode"
                                                                            name="zipcode" value="80400"
                                                                            class="mt-1 p-2 w-full border border-gray-300 rounded">
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center mt-4">
                                                                    <input id="update_address" type="checkbox"
                                                                        name="update_address" checked class="mr-2">
                                                                    <label for="update_address"
                                                                        x-model="addressForm.update_address"
                                                                        class="text-sm text-gray-700">Update the
                                                                        address when moving the pin on the map.</label>
                                                                </div>

                                                                <!-- Dismissible message box -->
                                                                <div x-data="{ showMessage: true }" x-show="showMessage"
                                                                    class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                                                                    role="alert">
                                                                    <strong class="font-bold">Note:</strong>
                                                                    <span class="block sm:inline">Make sure the pin
                                                                        location is accurate before continuing.</span>
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
                                                                    Is the red pin location incorrect? Uncheck the
                                                                    option above and click or press on the map to move
                                                                    the pin.
                                                                </p>

                                                                <!-- Buttons -->
                                                                <div
                                                                    class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                                                                    <button type="button" @click="prevStep"
                                                                        class="w-full sm:w-auto border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                        ←
                                                                    </button>
                                                                    <button type="button" @click="nextStep"
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
                                        <!-- Step 5 -->
                                        <template x-if="step === 7 && selected === 'one'">
                                            <div>
                                                <div class="max-w-5xl mx-auto px-4 py-8">
                                                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a
                                                        channel manager</h1>

                                                    <!-- Question Section -->
                                                    <div
                                                        class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                                                        <h2 class="text-lg font-semibold mb-2">
                                                            Do you want to connect this listing to your channel
                                                            manager?
                                                        </h2>
                                                        <p class="text-gray-700 mb-6">
                                                            A channel manager is a third-party tool that lets
                                                            you manage rates and availability across different
                                                            sites you might list your place on, including
                                                            Booking.com. If you're already using a channel
                                                            manager, you can select 'Yes' to connect it to your
                                                            listing.
                                                        </p>

                                                        <!-- Radio Buttons -->
                                                        <div
                                                            class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                                                            <!-- Yes Option -->
                                                            <div>
                                                                <input type="radio" id="yes"
                                                                    name="channel_manager" value="yes"
                                                                    class="mr-2" x-model="channelManager">
                                                                <label for="yes" class="text-gray-700">
                                                                    Yes, I will connect this listing to my
                                                                    channel manager
                                                                </label>
                                                            </div>

                                                            <!-- Tooltip only if Yes is selected -->
                                                            <div x-show="channelManager === 'yes'"
                                                                x-transition>
                                                                <div
                                                                    class="bg-red-100 border border-red-300 rounded p-2 mt-2">
                                                                    <div
                                                                        class="flex items-start text-sm text-red-700 space-x-2">
                                                                        <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                                                            alt="Help"
                                                                            class="w-5 h-5 md:w-6 md:h-6 mt-1" />
                                                                        <p>
                                                                            Select 'Yes' only if you are already
                                                                            using a channel manager.
                                                                            You'll be able to connect your
                                                                            channel manager after your
                                                                            registration is complete – please
                                                                            continue to the next step.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- No Option -->
                                                            <div>
                                                                <input type="radio" id="no"
                                                                    name="channel_manager" value="no"
                                                                    class="mr-2" x-model="channelManager">
                                                                <label for="no" class="text-gray-700">
                                                                    No, I won't be using a channel manager at
                                                                    this time
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Buttons -->
                                                        <div class="flex justify-between mt-6">
                                                            <button type="button" @click="prevStep"
                                                                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                ←
                                                            </button>
                                                            <button type="button" @click="nextStep"
                                                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                Continue
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>


                                        <!-- Step 5 -->
                                        <template x-if="step === 8 &&  selected === 'one'">
                                            <div>
                                                <section class="mb-8">
                                                    <h1 class="text-xl text-gray-700 font-bold mb-4">What can
                                                        guests use at your place?</h1>

                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                        <!-- Property Name Input + Checkboxes (2/3 Width) -->
                                                        <div class="md:col-span-2 flex">
                                                            <div
                                                                class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">


                                                                <!-- 9 Checkboxes Section -->

                                                                <div class="mt-2">
                                                                    <h3
                                                                        class="text-gray-700 font-semibold mb-2">
                                                                        Select property type(s)</h3>
                                                                    <div
                                                                        class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                                                        @foreach ($amenities as $amenity)
                                                                        <label class="flex items-center space-x-2">
                                                                            <input type="checkbox"
                                                                                name="amenities[]"
                                                                                value="{{ $amenity['id'] }}"
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
                                                                    your holiday homes.
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- Buttons Row (Outside grid, full width) -->
                                                    <!-- Buttons Row aligned with Checkbox Section -->
                                                    <div class="flex  mt-6">
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                            ←
                                                        </button>
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold  text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[290px]">
                                                            Continue
                                                        </button>
                                                    </div>

                                                </section>
                                            </div>
                                        </template>
                                        <!-- Step 5 -->
                                        <template x-if="step === 9 && selected === 'one'">
                                            <div>
                                                <div class="container mx-auto px-4 py-4 max-w-6xl mb-8">

                                                    <!-- Header -->
                                                    <h2
                                                        class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
                                                        Services at your property
                                                    </h2>

                                                    <!-- Sections stacked vertically, aligned with header -->
                                                    <div class="max-w-xl ml-6 flex flex-col space-y-8">
                                                        <!-- Breakfast Section -->
                                                        <div class="bg-white shadow-md rounded-lg p-6">
                                                            <h3 class="text-lg  mb-4 font-bold">Breakfast</h3>
                                                            <hr class="border-gray-300 mb-4" />
                                                            <p class="text-gray-700 mb-2 font-bold text-base">
                                                                Do you serve guests breakfast?
                                                            </p>
                                                            <div class="space-y-2">
                                                                <label
                                                                    class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="breakfast"
                                                                        value="yes" class="mr-2" />
                                                                    <span>Yes</span>
                                                                </label>
                                                                <label
                                                                    class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="breakfast"
                                                                        value="no" class="mr-2"
                                                                        checked />
                                                                    <span>No</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Parking Section -->
                                                        <div class="bg-white shadow-md rounded-lg p-6">
                                                            <h3 class="text-lg  mb-4 font-bold">Parking</h3>
                                                            <hr class="border-gray-300 mb-4" />
                                                            <p class="text-gray-700 mb-2 font-bold">
                                                                Is parking available to guests?
                                                            </p>
                                                            <div class="space-y-2">
                                                                <label
                                                                    class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="parking"
                                                                        value="free" class="mr-2" />
                                                                    <span>Yes, free</span>
                                                                </label>
                                                                <label
                                                                    class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="parking"
                                                                        value="paid" class="mr-2" />
                                                                    <span>Yes, paid</span>
                                                                </label>
                                                                <label
                                                                    class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="parking"
                                                                        value="no" class="mr-2"
                                                                        checked />
                                                                    <span>No</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Navigation Buttons below sections -->
                                                    <div class="mt-8 flex justify-between max-w-xl ml-6">
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                            Continue
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <!-- Step 5 -->
                                        <template x-if="step === 10 && selected === 'one'">
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
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Arabic
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">
                                                                        Bulgarian</li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Catalan
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Chinese
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Croatian
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Czech
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Danish
                                                                    </li>
                                                                    <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                        onclick="selectLanguage(this)">Dutch
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Toggle Button for Additional Languages -->
                                                        <a href="#"
                                                            onclick="event.preventDefault(); toggleAdditionalLanguages();"
                                                            class="text-blue-500 hover:underline mt-4 block">
                                                            Add additional languages
                                                        </a>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <div class="mt-8 flex justify-between">
                                                        <!-- Back Button on the left -->
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>

                                                        <!-- Continue Button on the right -->
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                            Continue
                                                        </button>
                                                    </div>

                                                </div>

                                                <script>
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

                                                    function selectLanguage(element) {
                                                        const input = document.getElementById("languageInput");
                                                        input.value = element.textContent;
                                                        hideDropdown();
                                                    }

                                                    // Close dropdown when clicking outside
                                                    document.addEventListener("click", function(event) {
                                                        const dropdown = document.getElementById("languageDropdown");
                                                        const input = document.getElementById("languageInput");
                                                        const container = document.getElementById("additionalLanguagesSection");
                                                        if (
                                                            !container.contains(event.target)
                                                        ) {
                                                            hideDropdown();
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </template>
                                        <!-- Step 5 -->
                                        <template x-if="step === 11 && selected === 'one'">
                                            <div>
                                                <div class="container mx-auto px-4 py-8 max-w-6xl">
                                                    <!-- Header -->
                                                    <h2 class="text-2xl font-bold mb-8 text-left">House rules
                                                    </h2>

                                                    <div class="flex flex-col md:flex-row gap-6">
                                                        <!-- Left Section -->
                                                        <div
                                                            class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
                                                            <!-- Toggle Switches -->
                                                            <div class="space-y-4">
                                                                <label
                                                                    class="flex items-center justify-between cursor-pointer">
                                                                    <span>Smoking allowed</span>
                                                                    <div class="relative">
                                                                        <input type="checkbox" name="smoking_allowed" id="smoking_allowed" class="sr-only peer" />
                                                                        <div
                                                                            class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                        </div>
                                                                        <div
                                                                            class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                        </div>
                                                                    </div>
                                                                </label>

                                                                <label
                                                                    class="flex items-center justify-between cursor-pointer">
                                                                    <span>Children allowed</span>
                                                                    <div class="relative">
                                                                        <input type="checkbox" name="children_allowed" id="children_allowed" class="sr-only peer" />
                                                                        <div
                                                                            class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                        </div>
                                                                        <div
                                                                            class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                        </div>
                                                                    </div>
                                                                </label>

                                                                <label
                                                                    class="flex items-center justify-between cursor-pointer">
                                                                    <span>Parties/events allowed</span>
                                                                    <div class="relative">
                                                                        <input type="checkbox" name="parties_allowed" id="parties_allowed" class="sr-only peer" />
                                                                        <div
                                                                            class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                        </div>
                                                                        <div
                                                                            class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <hr class="my-6 border-t border-gray-300">
                                                            <!-- Pet Policy -->
                                                            <div class="mt-6">
                                                                <h3 class="text-base font-semibold mb-2">Do you
                                                                    allow pets?</h3>
                                                                <div class="space-y-2">
                                                                    <label
                                                                        class="flex items-center cursor-pointer">
                                                                        <input type="radio" name="pets_allowed"
                                                                            value="yes" class="mr-2">
                                                                        <span>Yes</span>
                                                                    </label>
                                                                    <label
                                                                        class="flex items-center cursor-pointer">
                                                                        <input type="radio" name="pets_allowed"
                                                                            value="upon_request"
                                                                            class="mr-2">
                                                                        <span>Upon request</span>
                                                                    </label>
                                                                    <label
                                                                        class="flex items-center cursor-pointer">
                                                                        <input type="radio" name="pets_allowed"
                                                                            value="no" class="mr-2"
                                                                            checked>
                                                                        <span>No</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <hr class="my-6 border-t border-gray-300">

                                                            <!-- Check-in -->
                                                            <div class="mt-6">
                                                                <h3 class="text-base font-semibold mb-2">Check
                                                                    in</h3>
                                                                <div class="flex space-x-4">
                                                                    <div class="w-full">
                                                                        <label
                                                                            class="block text-sm font-medium mb-1">From</label>
                                                                        <input type="time" id="check_in_from" value="15:00"
                                                                            class="w-full border rounded p-2" />
                                                                    </div>
                                                                    <div class="w-full">
                                                                        <label
                                                                            class="block text-sm font-medium mb-1">Until</label>
                                                                        <input type="time" id="check_in_until" value="18:00"
                                                                            class="w-full border rounded p-2" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Check-out -->
                                                            <div class="mt-6">
                                                                <h3 class="text-base font-semibold mb-2">Check
                                                                    out</h3>
                                                                <div class="flex space-x-4">
                                                                    <div class="w-full">
                                                                        <label
                                                                            class="block text-sm font-medium mb-1">From</label>
                                                                        <input type="time" value="08:00" id="check_out_from"
                                                                            class="w-full border rounded p-2" />
                                                                    </div>
                                                                    <div class="w-full">
                                                                        <label
                                                                            class="block text-sm font-medium mb-1">Until</label>
                                                                        <input type="time" value="11:00" id="check_out_until"
                                                                            class="w-full border rounded p-2" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Right Section: Tip Box -->
                                                        <div x-data="{ show: true }" x-show="show"
                                                            class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
                                                            <div class="flex justify-between items-start">
                                                                <div class="flex items-center space-x-2">
                                                                    <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                                                        alt="Help"
                                                                        class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                                    <h3
                                                                        class="text-gray-800 font-semibold text-base">
                                                                        What if my house rules change?</h3>
                                                                </div>
                                                                <button @click="show = false"
                                                                    class="text-gray-400 hover:text-gray-600">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <p class="text-sm text-gray-700 mt-3">
                                                                You can easily customise these house rules later
                                                                and additional house rules can be set on the
                                                                Policies page of the extranet after you complete
                                                                registration.
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <div class="mt-8 flex ">
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>
                                                        <button type="button" @click="nextStep"
                                                            class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[250px]">
                                                            Continue
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>


                                        <template x-if="step === 12 && selected === 'one'">
                                            <div>
                                                <!-- Main Content -->
                                                <main class="container mx-auto px-4 py-8 max-w-4xl">
                                                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-left">
                                                        Host profile
                                                    </h2>

                                                    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                                                        <p class="text-gray-700 mb-4 text-sm md:text-base">
                                                            Help your listing stand out by telling potential
                                                            guests a bit more about yourself, your property and
                                                            your neighbourhood. This information will be shown
                                                            on your property page.
                                                        </p>

                                                        <div class="space-y-3">
                                                            <label
                                                                class="flex items-start sm:items-center cursor-pointer">
                                                                <input type="radio" name="profile-info"
                                                                    value="property"
                                                                    class="mr-3 mt-1 sm:mt-0">
                                                                <span class="text-sm sm:text-base">The
                                                                    property</span>
                                                            </label>

                                                            <label
                                                                class="flex items-start sm:items-center cursor-pointer">
                                                                <input type="radio" name="profile-info"
                                                                    value="host" class="mr-3 mt-1 sm:mt-0">
                                                                <span class="text-sm sm:text-base">The
                                                                    host</span>
                                                            </label>

                                                            <label
                                                                class="flex items-start sm:items-center cursor-pointer">
                                                                <input type="radio" name="profile-info"
                                                                    value="neighbourhood"
                                                                    class="mr-3 mt-1 sm:mt-0">
                                                                <span class="text-sm sm:text-base">The
                                                                    neighbourhood</span>
                                                            </label>

                                                            <label
                                                                class="flex items-start sm:items-center cursor-pointer">
                                                                <input type="radio" name="profile-info"
                                                                    value="later" class="mr-3 mt-1 sm:mt-0"
                                                                    checked>
                                                                <span class="text-sm sm:text-base">None of the
                                                                    above/I'll add these later</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <div class="mt-8 flex justify-between">
                                                        <!-- Back Button on the left -->
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>

                                                        <!-- Continue Button on the right -->
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                            Continue
                                                        </button>
                                                    </div>

                                                </main>
                                            </div>
                                        </template>

                                        <template x-if="step === 13 && selected === 'one'"
                                            x-data="{
                                                    newRoom: {
                                                        room_type_id: '',
                                                        name: '',
                                                        price_per_night: 0,
                                                        max_guests: 1,
                                                        bathroom_count: 0,
                                                        size_sq_m: 0,
                                                        beds: {}
                                                    },
                                                    rooms: [],
                                                    roomTypes: [],
                                                    bedTypes: [],
                                                }"
                                            x-init="
                                                    roomTypes = @js($roomTypes);
                                                    bedTypes = @js($bedTypes)
                                                ">
                                            <div>
                                                <!-- Main Content -->
                                                <main class="container mx-auto px-4 py-8 max-w-4xl">
                                                    <h2 class="text-2xl md:text-3xl font-bold mb-6 text-left">
                                                        Room Details
                                                    </h2>

                                                    <div class="bg-white shadow-md rounded-lg p-6 md:p-8 space-y-6">

                                                        <p class="text-gray-700 text-sm md:text-base">
                                                            Add information about each room in your property. Include room type, number of guests it can host,
                                                            price, and bed configuration.
                                                        </p>

                                                        <!-- Room Type -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                                            <select x-model="newRoom.room_type_id" class="w-full border rounded px-3 py-2">
                                                                <template x-for="type in roomTypes" :key="type.id">
                                                                    <option :value="type.id" x-text="type.name"></option>
                                                                </template>
                                                            </select>
                                                        </div>

                                                        <!-- Room Name -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Room Name</label>
                                                            <input type="text" x-model="newRoom.name"
                                                                class="w-full border border-gray-300 rounded px-3 py-2" placeholder="E.g. Master Bedroom" />
                                                        </div>

                                                        <!-- Price -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Price per Night (LKR)</label>
                                                            <input type="number" x-model="newRoom.price_per_night" min="0" step="0.01"
                                                                class="w-full border border-gray-300 rounded px-3 py-2" />
                                                        </div>

                                                        <!-- Max Guests -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
                                                            <input type="number" x-model="newRoom.max_guests" min="1"
                                                                class="w-full border border-gray-300 rounded px-3 py-2" />
                                                        </div>

                                                        <!-- Bathroom Count -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Bathroom Count</label>
                                                            <input type="number" x-model="newRoom.bathroom_count" min="0"
                                                                class="w-full border border-gray-300 rounded px-3 py-2" />
                                                        </div>

                                                        <!-- Size -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Size (sq. meters)</label>
                                                            <input type="number" x-model="newRoom.size_sq_m" min="0"
                                                                class="w-full border border-gray-300 rounded px-3 py-2" />
                                                        </div>

                                                        <!-- Bed Types -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Beds</label>
                                                            <template x-for="(bedType, index) in bedTypes" :key="bedType.id">
                                                                <div class="flex items-center mb-2">
                                                                    <label class="w-1/2 text-gray-600 text-sm" x-text="bedType.name"></label>
                                                                    <input type="number" min="0"
                                                                        class="w-1/2 border border-gray-300 rounded px-3 py-1 ml-2"
                                                                        @input="newRoom.beds[bedType.id] = +$event.target.value" />

                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <div class="mt-8 flex justify-between">
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>
                                                        <button type="button" @click="addRoom"
                                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                            + Add Room
                                                        </button>
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                            Save Room & Continue
                                                        </button>
                                                    </div>

                                                    <div class="mt-6 border-t pt-4">
                                                        <h3 class="font-semibold mb-2">Added Rooms:</h3>
                                                        <template x-for="(room, index) in rooms" :key="index">
                                                            <div class="border p-2 rounded mb-2 bg-gray-50">
                                                                <p><strong>Name:</strong> <span x-text="room.name"></span></p>
                                                                <p><strong>Type:</strong> <span x-text="roomTypes.find(rt => rt.id == room.room_type_id)?.name"></span></p>
                                                                <p><strong>Price:</strong> Rs. <span x-text="room.price_per_night"></span></p>

                                                                <button
                                                                    @click="if(confirm('Are you sure you want to remove this room?')) rooms.splice(index, 1)"
                                                                    class="ml-4 bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-3 py-1 rounded">
                                                                    ✕ Remove
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </main>
                                            </div>
                                        </template>

                                        <template x-if="step === 14 && selected === 'one'">
                                            <div>
                                                <!-- Include Alpine.js -->
                                                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                                                <div x-data="{
                                                                    type: '',
                                                                    individual: {
                                                                        full_name: '',
                                                                        national_id: ''
                                                                    },
                                                                    business: {
                                                                        company_name: '',
                                                                        registration_number:    ''
                                                }}"
                                                    class="px-4 py-8 max-w-3xl mx-auto space-y-6">

                                                    <h1 class="text-2xl sm:text-3xl font-semibold">Partner
                                                        verification</h1>

                                                    <!-- Instruction + Select Box -->
                                                    <div
                                                        class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                        <p class="text-gray-700">
                                                            In order to comply with various legal and regulatory
                                                            requirements, we need to collect and verify some
                                                            information about you and your property.
                                                        </p>

                                                        <label class="block font-medium text-gray-800">
                                                            Is the accommodation owned by an individual or a
                                                            business entity?
                                                        </label>
                                                        <select x-model="type"
                                                            class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            <option value="">Select an option</option>
                                                            <option value="individual">I am an individual
                                                                running a business</option>
                                                            <option value="business">I represent a business
                                                                entity</option>
                                                        </select>
                                                    </div>

                                                    <!-- Individual Form -->
                                                    <div x-show="type === 'individual'" x-transition
                                                        class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                        <h2 class="text-lg font-semibold text-gray-800">
                                                            Individual Details</h2>
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label class="block text-sm text-gray-700">Full
                                                                    Name</label>
                                                                <input type="text" x-model="individual.full_name"
                                                                    class="w-full mt-1 border rounded px-3 py-2"
                                                                    placeholder="Enter your full name">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm text-gray-700">National
                                                                    ID or Passport</label>
                                                                <input type="text" x-model="individual.national_id"
                                                                    class="w-full mt-1 border rounded px-3 py-2"
                                                                    placeholder="Enter ID number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Business Form -->
                                                    <div x-show="type === 'business'" x-transition
                                                        class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                        <h2 class="text-lg font-semibold text-gray-800">
                                                            Business Entity Details</h2>
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label
                                                                    class="block text-sm text-gray-700">Company
                                                                    Name</label>
                                                                <input type="text" x-model="business.company_name"
                                                                    class="w-full mt-1 border rounded px-3 py-2"
                                                                    placeholder="Enter company name">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm text-gray-700">Business
                                                                    Registration Number</label>
                                                                <input type="text" x-model="business.registration_number"
                                                                    class="w-full mt-1 border rounded px-3 py-2"
                                                                    placeholder="Enter registration number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Navigation Buttons -->
                                                    <div class="mt-8 flex justify-between">
                                                        <!-- Back Button on the left -->
                                                        <button type="button" @click="prevStep"
                                                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                            ←
                                                        </button>

                                                        <!-- Continue Button on the right -->
                                                        <button type="button" @click="nextStep"
                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                            Continue
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                        </template>
                                        <template x-if="step === 15 && selected === 'one'">
                                            <div>
                                                <h3 class="text-lg font-bold mb-2">Upload Additional Documents
                                                </h3>
                                                <input type="file" multiple
                                                    class="border p-2 rounded w-full" />
                                            </div>
                                        </template>

                                        <!-- Steps for 'multiple' -->
                                        <template x-if="selected === 'multiple'"
                                            x-data="{ 
                                                        currentUnit: 1, unitFacilities: Array.from({ length: propertyCount }, () => []),unitServices: Array.from({ length: 3 }, () => ({ breakfast: '', parking: '',hostprofile: '' ,languages: [], houseRules: {
                                                        smokingAllowed: false,
                                                        childrenAllowed: true,
                                                        partiesAllowed: false,
                                                        petsPolicy: 'no',
                                                        checkInFrom: '15:00',
                                                        checkInUntil: '18:00',
                                                        checkOutFrom: '08:00',
                                                        checkOutUntil: '11:00'
                                                        }})),
                                                        address: '',
                                                        addresses:[],
                                                        selectedAmenities: [],
                                                        type: '',
                                                        individual: { name: '', id: '' },
                                                        business: { company_name: '', reg_no: '' },
                                                        newRoom: {
                                                            room_type_id: '',
                                                            name: '',
                                                            price_per_night: 0,
                                                            max_guests: 1,
                                                            bathroom_count: 0,
                                                            size_sq_m: 0,
                                                            beds: {}
                                                        },
                                                        rooms: [],
                                                        roomTypes: [],
                                                        bedTypes: [],
                                                        unitAddresses: Array(propertyCount).fill(''),
                                                        toggleLanguage(lang) {
                                                            const index = this.unitServices[this.currentUnit - 1].languages.indexOf(lang);
                                                            if (index === -1) {
                                                                this.unitServices[this.currentUnit - 1].languages.push(lang);
                                                            } else {
                                                                this.unitServices[this.currentUnit - 1].languages.splice(index, 1);
                                                            }
                                                            console.log(this.unitServices); // Log updated structure
                                                        },
                                                        handleUnitPhotoUpload(unitId, event) {
                                                            const files = Array.from(event.target.files);
                                                            if (!this.unitPhotos[unitId]) this.unitPhotos[unitId] = [];
                                                            if (!this.previewUnitPhotos[unitId]) this.previewUnitPhotos[unitId] = [];

                                                            files.forEach(file => {
                                                                // Save actual file
                                                                this.unitPhotos[unitId].push(file);

                                                                // Preview
                                                                const reader = new FileReader();
                                                                reader.onload = () => {
                                                                    this.previewUnitPhotos[unitId].push(reader.result);
                                                                };
                                                                reader.readAsDataURL(file);
                                                            });
                                                        },

                                                    }">
                                            <div>



                                                <!-- Step 2 -->
                                                <template x-if="step === 2 && selected === 'multiple'">
                                                    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                                                        <p class="text-base text-gray-600 mb-8">You're listing:</p>

                                                        <!-- Icon -->
                                                        <div class="flex justify-center mb-8">
                                                            <template x-if="sameAddress === 'yes'">
                                                                <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Same Location" class="w-16 h-16" />
                                                            </template>
                                                            <template x-if="sameAddress === 'no'">
                                                                <img src="{{ asset('images/accomm_multiple_location@2x.png') }}" alt="Different Locations" class="w-16 h-16" />
                                                            </template>
                                                        </div>

                                                        <!-- Heading -->
                                                        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8" x-text="sameAddress === 'yes' 
                                                            ? 'Multiple holiday homes in the same location where guests can book an entire home' 
                                                            : 'Multiple holiday homes in different locations that guests can book separately'">
                                                        </h2>

                                                        <!-- Description -->
                                                        <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                                                        <!-- Buttons -->
                                                        <div class="space-y-2">
                                                            <button type="button" @click="nextStep"
                                                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                                                Continue
                                                            </button>
                                                            <button type="button" @click="prevStep"
                                                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] font-semibold py-2 px-4 rounded mb-6">
                                                                No, I need to make a change
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>


                                                <!-- Step 3 -->
                                                <template x-if="step === 3 && selected === 'multiple'">
                                                    <div>
                                                        <!-- Main Content -->
                                                        <div class="max-w-xl ml-4 mr-auto">
                                                            <!-- White Box -->
                                                            <div class="bg-white shadow-md p-6 text-left">
                                                                <template x-if="sameAddress === 'yes'">
                                                                    <p class="text-base text-gray-700">
                                                                        Great, since your holiday homes are located at the same address, there should be some settings that apply to all of them. Let's start with those general settings.
                                                                    </p>
                                                                </template>
                                                                <template x-if="sameAddress === 'no'">
                                                                    <p class="text-base text-gray-700">
                                                                        Since your holiday homes are at different addresses, we'll help you set up each one individually, starting with some shared preferences.
                                                                    </p>
                                                                </template>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-6 flex justify-between">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button" @click="nextStep"
                                                                    class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
                                                                    Continue
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Step 4 -->
                                                <template x-if="step === 4">
                                                    <div class="relative w-[1400px] h-auto overflow-hidden rounded-lg shadow mx-auto -mt-14 -ml-16">
                                                        <!-- Google Maps iframe background -->
                                                        <iframe class="absolute inset-0 w-full h-full"
                                                            loading="lazy"
                                                            src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                                                            allowfullscreen>
                                                        </iframe>

                                                        <div class="absolute inset-0"></div>

                                                        <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                                                            <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-[700px] p-6 md:p-8 h-auto mb-4 overflow-y-auto max-h-[80vh]">

                                                                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>

                                                                <template x-if="selected === 'one' || sameAddress === 'yes'">
                                                                    <!-- Shared address form -->
                                                                    <div>
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700">Find your address</label>
                                                                            <input type="text" x-model="address" class="mt-1 p-2 w-full border border-gray-300 rounded" placeholder="Address" />
                                                                        </div>
                                                                    </div>
                                                                </template>

                                                                <template x-if="selected === 'multiple' && sameAddress === 'no'">
                                                                    <!-- Multiple address forms -->
                                                                    <template x-for="i in propertyCount" :key="i">
                                                                        <div class="mb-8 border border-gray-200 rounded p-4">
                                                                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Property <span x-text="i"></span></h3>

                                                                            <!-- Inline address form -->
                                                                            <div class="mb-4">
                                                                                <label class="block text-sm font-medium text-gray-700">Find your address</label>
                                                                                <input type="text" :id="`property-address-${i - 1}`" x-model="unitAddresses[i - 1]" class="mt-1 p-2 w-full border border-gray-300 rounded" placeholder="Address" />
                                                                            </div>
                                                                            <!-- Repeat other address fields as needed -->
                                                                        </div>
                                                                    </template>

                                                                </template>

                                                                <!-- Navigation buttons -->
                                                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
                                                                    <button type="button" @click="prevStep"
                                                                        class="w-full sm:w-auto border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                        ←
                                                                    </button>
                                                                    <button type="button" @click="nextStep"
                                                                        class="w-full sm:w-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                        Continue
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Step 5 -->
                                                <template x-if="step === 5">
                                                    <div>
                                                        <div class="max-w-5xl mx-auto px-4 py-8">
                                                            <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a
                                                                channel manager</h1>

                                                            <!-- Question Section -->
                                                            <div
                                                                class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                                                                <h2 class="text-lg font-semibold mb-2">
                                                                    Do you want to connect this listing to your channel
                                                                    manager?
                                                                </h2>
                                                                <p class="text-gray-700 mb-6">
                                                                    A channel manager is a third-party tool that lets
                                                                    you manage rates and availability across different
                                                                    sites you might list your place on, including
                                                                    Booking.com. If you're already using a channel
                                                                    manager, you can select 'Yes' to connect it to your
                                                                    listing.
                                                                </p>

                                                                <!-- Radio Buttons -->
                                                                <div
                                                                    class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                                                                    <!-- Yes Option -->
                                                                    <div>
                                                                        <input type="radio" id="yes"
                                                                            name="channel_manager" value="yes"
                                                                            class="mr-2" x-model="channelManager">
                                                                        <label for="yes" class="text-gray-700">
                                                                            Yes, I will connect this listing to my
                                                                            channel manager
                                                                        </label>
                                                                    </div>

                                                                    <!-- Tooltip only if Yes is selected -->
                                                                    <div x-show="channelManager === 'yes'"
                                                                        x-transition>
                                                                        <div
                                                                            class="bg-red-100 border border-red-300 rounded p-2 mt-2">
                                                                            <div
                                                                                class="flex items-start text-sm text-red-700 space-x-2">
                                                                                <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                                                                    alt="Help"
                                                                                    class="w-5 h-5 md:w-6 md:h-6 mt-1" />
                                                                                <p>
                                                                                    Select 'Yes' only if you are already
                                                                                    using a channel manager.
                                                                                    You'll be able to connect your
                                                                                    channel manager after your
                                                                                    registration is complete – please
                                                                                    continue to the next step.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- No Option -->
                                                                    <div>
                                                                        <input type="radio" id="no"
                                                                            name="channel_manager" value="no"
                                                                            class="mr-2" x-model="channelManager">
                                                                        <label for="no" class="text-gray-700">
                                                                            No, I won't be using a channel manager at
                                                                            this time
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <!-- Buttons -->
                                                                <div class="flex justify-between mt-6">
                                                                    <button type="button" @click="prevStep"
                                                                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                        ←
                                                                    </button>
                                                                    <button type="button" @click="nextStep"
                                                                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                        Continue
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>


                                                <!-- Step 5 -->
                                                <template x-if="step === 6">
                                                    <div>
                                                        <section class="mb-8">
                                                            <h1 class="text-xl text-gray-700 font-bold mb-4">
                                                                What can guests use at Unit <span x-text="currentUnit"></span>?
                                                            </h1>

                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                                <!-- Property Name Input + Checkboxes (2/3 Width) -->
                                                                <div class="md:col-span-2 flex">
                                                                    <div
                                                                        class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">


                                                                        <!-- 9 Checkboxes Section -->

                                                                        <div class="mt-2">
                                                                            <h3
                                                                                class="text-gray-700 font-semibold mb-2">
                                                                                Select property type(s)</h3>
                                                                            <div
                                                                                class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                                                                @foreach ($amenities as $amenity)
                                                                                <label class="flex items-center space-x-2">
                                                                                    <input type="checkbox"
                                                                                        :value="{{ $amenity['id'] }}"
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
                                                                            your holiday homes.
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <!-- Buttons Row (Outside grid, full width) -->
                                                            <!-- Buttons Row aligned with Checkbox Section -->
                                                            <div class="flex  mt-6">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold  text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[290px]">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </section>
                                                    </div>
                                                </template>
                                                <!-- Step 7 -->
                                                <template x-if="step === 7">
                                                    <div>
                                                        <div class="container mx-auto px-4 py-4 max-w-6xl mb-8">

                                                            <!-- Header -->
                                                            <h2
                                                                class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
                                                                Services at your property <span x-text="currentUnit"></span>
                                                            </h2>

                                                            <!-- Sections stacked vertically, aligned with header -->
                                                            <div class="max-w-xl ml-6 flex flex-col space-y-8">
                                                                <!-- Breakfast Section -->
                                                                <div class="bg-white shadow-md rounded-lg p-6">
                                                                    <h3 class="text-lg  mb-4 font-bold">Breakfast</h3>
                                                                    <hr class="border-gray-300 mb-4" />
                                                                    <p class="text-gray-700 mb-2 font-bold text-base">
                                                                        Do you serve guests breakfast?
                                                                    </p>
                                                                    <div class="space-y-2">
                                                                        <label
                                                                            class="flex items-center cursor-pointer">
                                                                            <input type="radio"
                                                                                :name="`breakfast_unit_${currentUnit}`"
                                                                                value="yes" class="mr-2"
                                                                                x-model="unitServices[currentUnit - 1].breakfast" />
                                                                            <span>Yes</span>
                                                                        </label>
                                                                        <label
                                                                            class="flex items-center cursor-pointer">
                                                                            <input type="radio"
                                                                                :name="`breakfast_unit_${currentUnit}`"
                                                                                value="no" class="mr-2"
                                                                                x-model="unitServices[currentUnit - 1].breakfast" />
                                                                            <span>No</span>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <!-- Parking Section -->
                                                                <div class="bg-white shadow-md rounded-lg p-6">
                                                                    <h3 class="text-lg  mb-4 font-bold">Parking</h3>
                                                                    <hr class="border-gray-300 mb-4" />
                                                                    <p class="text-gray-700 mb-2 font-bold">
                                                                        Is parking available to guests?
                                                                    </p>
                                                                    <div class="space-y-2">
                                                                        <label
                                                                            class="flex items-center cursor-pointer">
                                                                            <input type="radio" name="parking"
                                                                                value="free" class="mr-2" />
                                                                            <span>Yes, free</span>
                                                                        </label>
                                                                        <label
                                                                            class="flex items-center cursor-pointer">
                                                                            <input type="radio" name="parking"
                                                                                value="paid" class="mr-2" />
                                                                            <span>Yes, paid</span>
                                                                        </label>
                                                                        <label
                                                                            class="flex items-center cursor-pointer">
                                                                            <input type="radio" name="parking"
                                                                                value="no" class="mr-2"
                                                                                checked />
                                                                            <span>No</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons below sections -->
                                                            <div class="mt-8 flex justify-between max-w-xl ml-6">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <!-- Step 8 -->
                                                <template x-if="step === 8">
                                                    <div>
                                                        <div class="container mx-auto px-4 py-8 max-w-6xl">
                                                            <!-- Header -->
                                                            <h2 class="text-2xl font-bold mb-8 text-left">
                                                                What languages do you or your staff in property <span x-text="currentUnit"></span> speak?
                                                            </h2>

                                                            <!-- Language Selection Section -->
                                                            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                                                                <h3 class="text-lg  mb-4 font-bold">Select languages
                                                                </h3>
                                                                <div class="space-y-2">
                                                                    @foreach ($languages as $lang)
                                                                    <label class="flex items-center cursor-pointer">
                                                                        <input type="checkbox"
                                                                            class="mr-2"
                                                                            :value="'{{ $lang['name'] }}'"
                                                                            x-model="unitServices[currentUnit - 1].languages" />
                                                                        <span>{{ $lang['name'] }}</span>
                                                                    </label>
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
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Arabic
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">
                                                                                Bulgarian</li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Catalan
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Chinese
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Croatian
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Czech
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Danish
                                                                            </li>
                                                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                                                onclick="selectLanguage(this)">Dutch
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Toggle Button for Additional Languages -->
                                                                <a href="#"
                                                                    onclick="event.preventDefault(); toggleAdditionalLanguages();"
                                                                    class="text-blue-500 hover:underline mt-4 block">
                                                                    Add additional languages
                                                                </a>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <!-- Back Button on the left -->
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <!-- Continue Button n tohe right -->
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </div>

                                                        <script>
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



                                                            function selectLanguage(element) {
                                                                const selected = element.textContent.trim();
                                                                const unitIndex = Alpine.store('stepForm').currentUnit - 1;
                                                                const langArray = Alpine.store('stepForm').unitServices[unitIndex].languages;

                                                                if (!langArray.includes(selected)) {
                                                                    langArray.push(selected);
                                                                }
                                                                console.log(`Selected language: ${selected}`);

                                                                // clear input and hide dropdown
                                                                document.getElementById("languageInput").value = "";
                                                                hideDropdown();
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

                                                            function selectLanguage(element) {
                                                                const input = document.getElementById("languageInput");
                                                                input.value = element.textContent;
                                                                hideDropdown();
                                                            }

                                                            // Close dropdown when clicking outside
                                                            document.addEventListener("click", function(event) {
                                                                const dropdown = document.getElementById("languageDropdown");
                                                                const input = document.getElementById("languageInput");
                                                                const container = document.getElementById("additionalLanguagesSection");
                                                                if (
                                                                    !container.contains(event.target)
                                                                ) {
                                                                    hideDropdown();
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </template>
                                                <!-- Step 9 -->
                                                <template x-if="step === 9">
                                                    <div>
                                                        <div class="container mx-auto px-4 py-8 max-w-6xl">
                                                            <!-- Header -->
                                                            <h2 class="text-2xl font-bold mb-8 text-left">House rules of property <span x-text="currentUnit"></span>
                                                            </h2>

                                                            <div class="flex flex-col md:flex-row gap-6">
                                                                <!-- Left Section -->
                                                                <div
                                                                    class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
                                                                    <!-- Toggle Switches -->
                                                                    <div class="space-y-4">
                                                                        <label
                                                                            class="flex items-center justify-between cursor-pointer">
                                                                            <span>Smoking allowed</span>
                                                                            <div class="relative">
                                                                                <input type="checkbox"
                                                                                    class="sr-only peer"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.smokingAllowed" />

                                                                                <div
                                                                                    class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                                </div>
                                                                                <div
                                                                                    class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                                </div>
                                                                            </div>
                                                                        </label>

                                                                        <label
                                                                            class="flex items-center justify-between cursor-pointer">
                                                                            <span>Children allowed</span>
                                                                            <div class="relative">
                                                                                <input type="checkbox"
                                                                                    class="sr-only peer"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.childrenAllowed" />

                                                                                <div
                                                                                    class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                                </div>
                                                                                <div
                                                                                    class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                                </div>
                                                                            </div>
                                                                        </label>

                                                                        <label
                                                                            class="flex items-center justify-between cursor-pointer">
                                                                            <span>Parties/events allowed</span>
                                                                            <div class="relative">
                                                                                <input type="checkbox"
                                                                                    class="sr-only peer"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.partiesAllowed" />

                                                                                <div
                                                                                    class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                                                </div>
                                                                                <div
                                                                                    class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>

                                                                    <hr class="my-6 border-t border-gray-300">
                                                                    <!-- Pet Policy -->
                                                                    <div class="mt-6">
                                                                        <h3 class="text-base font-semibold mb-2">Do you
                                                                            allow pets?</h3>
                                                                        <div class="space-y-2">
                                                                            <label
                                                                                class="flex items-center cursor-pointer">
                                                                                <input type="radio" name="pets" value="yes"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.petsPolicy" />
                                                                                <span>Yes</span>
                                                                            </label>
                                                                            <label
                                                                                class="flex items-center cursor-pointer">
                                                                                <input type="radio" name="pets" value="upon_request"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.petsPolicy" />
                                                                                <span>Upon request</span>
                                                                            </label>
                                                                            <label
                                                                                class="flex items-center cursor-pointer">
                                                                                <input type="radio" name="pets" value="no"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.petsPolicy" />
                                                                                <span>No</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <hr class="my-6 border-t border-gray-300">

                                                                    <!-- Check-in -->
                                                                    <div class="mt-6">
                                                                        <h3 class="text-base font-semibold mb-2">Check
                                                                            in</h3>
                                                                        <div class="flex space-x-4">
                                                                            <div class="w-full">
                                                                                <label
                                                                                    class="block text-sm font-medium mb-1">From</label>
                                                                                <input type="time"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.checkInFrom"
                                                                                    class="w-full border rounded p-2" />
                                                                            </div>
                                                                            <div class="w-full">
                                                                                <label
                                                                                    class="block text-sm font-medium mb-1">Until</label>
                                                                                <input type="time"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.checkInUntil"
                                                                                    class="w-full border rounded p-2" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Check-out -->
                                                                    <div class="mt-6">
                                                                        <h3 class="text-base font-semibold mb-2">Check
                                                                            out</h3>
                                                                        <div class="flex space-x-4">
                                                                            <div class="w-full">
                                                                                <label
                                                                                    class="block text-sm font-medium mb-1">From</label>
                                                                                <input type="time"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.checkOutFrom"
                                                                                    class="w-full border rounded p-2" />
                                                                            </div>
                                                                            <div class="w-full">
                                                                                <label
                                                                                    class="block text-sm font-medium mb-1">Until</label>
                                                                                <input type="time"
                                                                                    x-model="unitServices[currentUnit - 1].houseRules.checkOutUntil"
                                                                                    class="w-full border rounded p-2" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Right Section: Tip Box -->
                                                                <div x-data="{ show: true }" x-show="show"
                                                                    class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
                                                                    <div class="flex justify-between items-start">
                                                                        <div class="flex items-center space-x-2">
                                                                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                                                                alt="Help"
                                                                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                                            <h3
                                                                                class="text-gray-800 font-semibold text-base">
                                                                                What if my house rules change?</h3>
                                                                        </div>
                                                                        <button @click="show = false"
                                                                            class="text-gray-400 hover:text-gray-600">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-5 w-5" viewBox="0 0 20 20"
                                                                                fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <p class="text-sm text-gray-700 mt-3">
                                                                        You can easily customise these house rules later
                                                                        and additional house rules can be set on the
                                                                        Policies page of the extranet after you complete
                                                                        registration.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex ">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button" @click="nextStep"
                                                                    class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[250px]">
                                                                    Continue
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>


                                                <template x-if="step === 10">
                                                    <div>
                                                        <!-- Main Content -->
                                                        <main class="container mx-auto px-4 py-8 max-w-4xl">
                                                            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-left">Host profile of property <span x-text="currentUnit"></span> </h2>

                                                            <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                                                                <p class="text-gray-700 mb-4 text-sm md:text-base">
                                                                    Help your listing stand out by telling potential guests a bit more about yourself, your property and your neighbourhood. This information will be shown on your property page.
                                                                </p>

                                                                <div class="space-y-3">
                                                                    <label class="flex items-start sm:items-center cursor-pointer">
                                                                        <input type="radio" name="profile-info" value="property"
                                                                            class="mr-3 mt-1 sm:mt-0"
                                                                            x-model="unitServices[currentUnit - 1].hostProfile">
                                                                        <span class="text-sm sm:text-base">The property</span>
                                                                    </label>

                                                                    <label class="flex items-start sm:items-center cursor-pointer">
                                                                        <input type="radio" name="profile-info" value="host"
                                                                            class="mr-3 mt-1 sm:mt-0"
                                                                            x-model="unitServices[currentUnit - 1].hostProfile">
                                                                        <span class="text-sm sm:text-base">The host</span>
                                                                    </label>

                                                                    <label class="flex items-start sm:items-center cursor-pointer">
                                                                        <input type="radio" name="profile-info" value="neighbourhood"
                                                                            class="mr-3 mt-1 sm:mt-0"
                                                                            x-model="unitServices[currentUnit - 1].hostProfile">
                                                                        <span class="text-sm sm:text-base">The neighbourhood</span>
                                                                    </label>

                                                                    <label class="flex items-start sm:items-center cursor-pointer">
                                                                        <input type="radio" name="profile-info" value="later"
                                                                            class="mr-3 mt-1 sm:mt-0"
                                                                            x-model="unitServices[currentUnit - 1].hostProfile">
                                                                        <span class="text-sm sm:text-base">None of the above/I'll add these later</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>
                                                        </main>
                                                    </div>
                                                </template>

                                                <template x-if="step === 11">
                                                    <div>
                                                        <div class="max-w-5xl mx-auto px-4 py-10 space-y-32">
                                                            <section class="mb-8">
                                                                <h1 class="text-2xl text-gray-700 font-bold mb-4">
                                                                    What's the name of your place <span x-text="currentUnit"></span>?</h1>

                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                                    <!-- Property Name Input (2/3 Width) -->
                                                                    <div class="md:col-span-2 flex">
                                                                        <div
                                                                            class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base ">
                                                                            <label for="property_name"
                                                                                class="block text-gray-700">Property
                                                                                name</label>
                                                                            <input type="text" id="property_name"
                                                                                name="property_name"
                                                                                x-model="formData.propertyName"
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
                                                                    <button type="button" @click="prevStep"
                                                                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                        ←
                                                                    </button>



                                                                    <!-- Continue Button -->
                                                                    <!-- Continue Button (inside input field container, aligned right) -->
                                                                    <div class="flex justify-end mt-4">
                                                                        <button type="button" @click="nextStep()"
                                                                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                            Continue
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </section>

                                                        </div>
                                                    </div>

                                                </template>
                                                <template x-if="step === 12 ">
                                                    <div class="space-y-6">
                                                        <h3 class="text-lg font-bold">Upload Photos for Unit <span x-text="currentUnit"></span></h3>

                                                        <!-- Upload Box -->
                                                        <div
                                                            class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-blue-400 transition"
                                                            @dragover.prevent
                                                            @drop.prevent>
                                                            <svg class="w-12 h-12 text-blue-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 16.5V18a2.5 2.5 0 002.5 2.5h13a2.5 2.5 0 002.5-2.5v-1.5M16.5 12L12 7.5 7.5 12M12 7.5V18" />
                                                            </svg>

                                                            <p class="text-gray-600 text-sm">Drag and drop your images here, or</p>

                                                            <label class="mt-2 cursor-pointer inline-block bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded font-medium">
                                                                Browse files
                                                                <input
                                                                    type="file"
                                                                    multiple
                                                                    x-ref="unitPhotoInput"
                                                                    @change="handleUnitPhotoUpload(currentUnit, $event)"
                                                                    accept="image/*"
                                                                    class="hidden" />
                                                            </label>

                                                            <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG, WebP. Max size: 5MB each</p>
                                                        </div>

                                                        <!-- Photo Previews -->
                                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4" x-show="previewUnitPhotos[currentUnit]?.length">
                                                            <template x-for="(file, index) in previewUnitPhotos[currentUnit]" :key="index">
                                                                <img :src="file" class="rounded shadow object-cover w-full h-32 border border-gray-300" />
                                                            </template>
                                                        </div>

                                                        <!-- Navigation Buttons -->
                                                        <div class="flex justify-between pt-4">
                                                            <button type="button"
                                                                @click="prevStep"
                                                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded">
                                                                ←
                                                            </button>

                                                            <button
                                                                type="button"
                                                                @click="nextStep"
                                                                class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold px-6 py-2 rounded shadow">
                                                                Continue →
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>

                                                <template x-if="step === 15">
                                                    <div>
                                                        <!-- AlpineJS is required -->
                                                        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                                                        <div x-data="{ bookingOption: 'instant' }"
                                                            class="px-4 py-8 max-w-4xl mx-auto space-y-6">

                                                            <h1 class="text-2xl sm:text-3xl font-semibold">How you
                                                                receive bookings for Unit <span x-text="currentUnit"></span></h1>

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
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <!-- Continue Button on the right -->
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </template>

                                                <template x-if="step === 13 "

                                                        x-init="
                                                        roomTypes = @js($roomTypes);
                                                        bedTypes = @js($bedTypes)
                                                    ">
                                                    <div>
                                                        <!-- Main Content -->
                                                        <main class="container mx-auto px-4 py-8 max-w-4xl">
                                                            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-left">
                                                                Room Details for Unit <span x-text="currentUnit"></span>
                                                            </h2>

                                                            <div class="bg-white shadow-md rounded-lg p-6 md:p-8 space-y-6">

                                                                <p class="text-gray-700 text-sm md:text-base">
                                                                    Add information about each room in your property. Include room type, number of guests it can host,
                                                                    price, and bed configuration.
                                                                </p>

                                                                <!-- Room Type -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                                                    <select x-model="newRoom.room_type_id" class="w-full border rounded px-3 py-2">
                                                                        <template x-for="type in roomTypes" :key="type.id">
                                                                            <option :value="type.id" x-text="type.name"></option>
                                                                        </template>
                                                                    </select>
                                                                </div>

                                                                <!-- Room Name -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Name</label>
                                                                    <input type="text" x-model="newRoom.name"
                                                                        class="w-full border border-gray-300 rounded px-3 py-2" placeholder="E.g. Master Bedroom" />
                                                                </div>

                                                                <!-- Price -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price per Night (LKR)</label>
                                                                    <input type="number" x-model="newRoom.price_per_night" min="0" step="0.01"
                                                                        class="w-full border border-gray-300 rounded px-3 py-2" />
                                                                </div>

                                                                <!-- Max Guests -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
                                                                    <input type="number" x-model="newRoom.max_guests" min="1"
                                                                        class="w-full border border-gray-300 rounded px-3 py-2" />
                                                                </div>

                                                                <!-- Bathroom Count -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bathroom Count</label>
                                                                    <input type="number" x-model="newRoom.bathroom_count" min="0"
                                                                        class="w-full border border-gray-300 rounded px-3 py-2" />
                                                                </div>

                                                                <!-- Size -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Size (sq. meters)</label>
                                                                    <input type="number" x-model="newRoom.size_sq_m" min="0"
                                                                        class="w-full border border-gray-300 rounded px-3 py-2" />
                                                                </div>

                                                                <!-- Bed Types -->
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Beds</label>
                                                                    <template x-for="(bedType, index) in bedTypes" :key="bedType.id">
                                                                        <div class="flex items-center mb-2">
                                                                            <label class="w-1/2 text-gray-600 text-sm" x-text="bedType.name"></label>
                                                                            <input type="number" min="0"
                                                                                class="w-1/2 border border-gray-300 rounded px-3 py-1 ml-2"
                                                                                @input="newRoom.beds[bedType.id] = +$event.target.value" />

                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>
                                                                <button type="button" @click="addRoom"
                                                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                                    + Add Room
                                                                </button>
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Save Room & Continue
                                                                </button>
                                                            </div>

                                                            <div class="mt-6 border-t pt-4">
                                                                <h3 class="font-semibold mb-2">Added Rooms:</h3>
                                                                <template x-for="(room, index) in rooms" :key="index">
                                                                    <div class="border p-2 rounded mb-2 bg-gray-50">
                                                                        <p><strong>Name:</strong> <span x-text="room.name"></span></p>
                                                                        <p><strong>Type:</strong> <span x-text="roomTypes.find(rt => rt.id == room.room_type_id)?.name"></span></p>
                                                                        <p><strong>Price:</strong> Rs. <span x-text="room.price_per_night"></span></p>

                                                                        <button
                                                                            @click="if(confirm('Are you sure you want to remove this room?')) rooms.splice(index, 1)"
                                                                            class="ml-4 bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-3 py-1 rounded">
                                                                            ✕ Remove
                                                                        </button>
                                                                    </div>
                                                                </template>
                                                            </div>

                                                        </main>
                                                    </div>
                                                </template>
                                                <template x-if="step === 14">
                                                    <div>
                                                        <!-- Include Alpine.js -->
                                                        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                                                        <div x-data="{ type: '' }"
                                                            class="px-4 py-8 max-w-3xl mx-auto space-y-6">

                                                            <h1 class="text-2xl sm:text-3xl font-semibold">Partner
                                                                verification for <span x-text="currentUnit"></span> </h1>

                                                            <!-- Instruction + Select Box -->
                                                            <div
                                                                class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                                <p class="text-gray-700">
                                                                    In order to comply with various legal and regulatory
                                                                    requirements, we need to collect and verify some
                                                                    information about you and your property.
                                                                </p>

                                                                <label class="block font-medium text-gray-800">
                                                                    Is the accommodation owned by an individual or a
                                                                    business entity?
                                                                </label>
                                                                <select x-model="type"
                                                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                    <option value="">Select an option</option>
                                                                    <option value="individual">I am an individual
                                                                        running a business</option>
                                                                    <option value="business">I represent a business
                                                                        entity</option>
                                                                </select>
                                                            </div>

                                                            <!-- Individual Form -->
                                                            <div x-show="type === 'individual'" x-transition
                                                                class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                                <h2 class="text-lg font-semibold text-gray-800">
                                                                    Individual Details</h2>
                                                                <div class="space-y-4">
                                                                    <div>
                                                                        <label class="block text-sm text-gray-700">Full
                                                                            Name</label>
                                                                        <input type="text" x-model="individual.name"
                                                                            class="w-full mt-1 border rounded px-3 py-2"
                                                                            placeholder="Enter your full name">
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm text-gray-700">National
                                                                            ID or Passport</label>
                                                                        <input type="text" x-model="individual.id"
                                                                            class="w-full mt-1 border rounded px-3 py-2"
                                                                            placeholder="Enter ID number">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Business Form -->
                                                            <div x-show="type === 'business'" x-transition
                                                                class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
                                                                <h2 class="text-lg font-semibold text-gray-800">
                                                                    Business Entity Details</h2>
                                                                <div class="space-y-4">
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm text-gray-700">Company
                                                                            Name</label>
                                                                        <input type="text" x-model="business.company_name"
                                                                            class="w-full mt-1 border rounded px-3 py-2"
                                                                            placeholder="Enter company name">
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm text-gray-700">Business
                                                                            Registration Number</label>
                                                                        <input type="text" x-model="business.reg_no"
                                                                            class="w-full mt-1 border rounded px-3 py-2"
                                                                            placeholder="Enter registration number">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Navigation Buttons -->
                                                            <div class="mt-8 flex justify-between">
                                                                <!-- Back Button on the left -->
                                                                <button type="button" @click="prevStep"
                                                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                    ←
                                                                </button>

                                                                <!-- Continue Button on the right -->
                                                                <button type="button" @click="nextStep"
                                                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </template>
                                                <template x-if="step === 16 ">
                                                    <div>
                                                        <h3 class="text-lg font-bold mb-2">Upload Additional Documents
                                                        </h3>
                                                        <input type="file" multiple
                                                            class="border p-2 rounded w-full" />

                                                        <div class="flex justify-between mt-8">
                                                            <button type="button" @click="prevStep"
                                                                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                                                ←
                                                            </button>
                                                            <button type="button" @click="nextStep"
                                                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                                                                Continue
                                                            </button>
                                                        </div>
                                                    </div>

                                                </template>
                                            </div>
                                        </template>





                                    </div>


                                </div>
                            </template>
                        </form>

                        <script>
                            function wizard(selectedBoxValue) {
                                return {
                                    step: 1,
                                    selectedBox: selectedBoxValue,
                                    selected: '',
                                    sameAddress: 'yes',
                                    propertyCount: 2,
                                    totalSteps: 16,
                                    currentUnit: 1,
                                    unitPhotos: {}, // Holds all photo arrays per unit
                                    previewUnitPhotos: {}, // Holds base64 previews per unit
                                    unitFacilities: [],
                                    unitServices: [],
                                    previewFiles: [],
                                    formData: {
                                        propertyName: '',
                                        description: '',
                                        addressForm: {
                                            address_line_1: '',
                                            address_line_2: '',
                                            city: '',
                                            state: '',
                                            country: '',
                                            postal_code: ''
                                        }
                                    },
                                    addRoom() {


                                        // Clone the current newRoom and push to rooms
                                        const roomCopy = JSON.parse(JSON.stringify(this.newRoom));
                                        this.rooms.push(roomCopy);

                                        // Reset newRoom
                                        this.newRoom = {
                                            room_type_id: '',
                                            name: '',
                                            price_per_night: 0,
                                            max_guests: 1,
                                            bathroom_count: 0,
                                            size_sq_m: 0,
                                            beds: {}
                                        };
                                    },
                                    handlePreview(event) {
                                        this.previewFiles = [];
                                        const files = event.target.files;

                                        for (let i = 0; i < files.length; i++) {
                                            const reader = new FileReader();
                                            reader.onload = e => {
                                                this.previewFiles.push(e.target.result);
                                            };
                                            reader.readAsDataURL(files[i]);
                                        }
                                    },

                                    selectOption(option) {
                                        this.selected = option;
                                        // Reset step if needed
                                        console.log('Selected:', this.selected);
                                    },

                                    get headingLabel() {
                                        switch (this.selectedBox) {
                                            case 1:
                                                return 'How many chalets are you listing?';
                                            case 2:
                                                return 'How many villas are you listing?';
                                            case 4:
                                                return 'How many holiday homes are you listing?';
                                            case 5:
                                                return 'How many apart hotels are you listing?';
                                            default:
                                                return 'How many holiday parks are you listing?';
                                        }
                                    },


                                    get singleLabel() {
                                        console.log('Selected Box:', this.selectedBox);
                                        switch (this.selectedBox) {
                                            case 1:
                                                return 'One Villa';
                                            case 2:
                                                return 'One Chalet';
                                            case 4:
                                                return 'One Holiday home';
                                            case 5:
                                                return 'One Apart hotel';
                                            default:
                                                return 'One Holiday park';
                                        }
                                    },

                                    get multipleLabel() {
                                        console.log('Selected Box:', this.selectedBox);
                                        switch (this.selectedBox) {
                                            case 1:
                                                return 'Multiple Villas';
                                            case 2:
                                                return 'Multiple Chalets';
                                            case 4:
                                                return 'Multiple Holiday homes';
                                            case 5:
                                                return 'Multiple Apart hotels';
                                            default:
                                                return 'Multiple Holiday parks';
                                        }
                                    },



                                    async nextStep() {
                                        if ((this.step === 1 && this.selected === 'one')) {
                                            try {

                                                console.log('Addtress type:', this.step);
                                                const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                            .getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        address_type_id: this.selected === 'one' ? 1 : 2, // ✅ correct value: "one" or "multiple"
                                                        propertyId: this.propertyId
                                                    })

                                                });
                                                const result = await response.json();
                                                if (result.success) {
                                                    console.log('Address type saved:', result);
                                                    this.step++;
                                                } else {
                                                    alert('Failed to save address step: ' + result.message);
                                                }
                                            } catch (e) {
                                                console.error('Error saving step 2:', e);
                                            }
                                        } else if (this.step === 4 && this.selected === 'one') {
                                            console.log(`Submitting property name ${this.propertyName} and description ${this.description} for property ID:`, this.propertyId);

                                            if (!this.propertyName || this.propertyName.trim() === '') {
                                                alert('Please enter a property name.');
                                                return;
                                            }

                                            fetch(`/partner/property/step3/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        title: this.propertyName,
                                                        description: this.description,
                                                        property_id: this.propertyId
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(result => {
                                                    if (result.success) {
                                                        console.log('Property name saved:', result);
                                                        this.step++; // move to next step
                                                    } else {
                                                        alert(result.message || 'Failed to save property name.');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error saving property name:', error);
                                                    alert('Something went wrong while saving the property name.');
                                                });
                                        } else if (this.step === 5 && this.selected === 'one') {
                                            console.log('Submitting photos for property ID:', this.propertyId);
                                            const files = this.$refs.photoInput.files;
                                            if (!files.length) {
                                                alert('Please upload at least one photo.');
                                                return;
                                            }

                                            const formData = new FormData();
                                            formData.append('property_id', this.propertyId);

                                            for (let i = 0; i < files.length; i++) {
                                                formData.append('photos[]', files[i]);
                                            }

                                            fetch('/partner/property/upload-photos', {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: formData
                                                })
                                                .then(response => response.json())
                                                .then(result => {
                                                    if (result.success) {
                                                        console.log('Photos uploaded');
                                                        this.step++;
                                                    } else {
                                                        alert(result.message || 'Upload failed');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Upload error:', error);
                                                    alert('Something went wrong while uploading photos.');
                                                });
                                        } else if (this.step === 6 && this.selected === 'one') {
                                            try {
                                                console.log('Submitting form:', this.addressForm);

                                                const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                            .getAttribute('content')
                                                    },
                                                    body: JSON.stringify(this.addressForm, this.propertyId)
                                                });
                                                const result = await response.json();
                                                if (result.success) {
                                                    console.log('Addtress saved:', result);
                                                    this.step++;
                                                } else {
                                                    alert('Failed to save address step: ' + result.message);
                                                }
                                            } catch (e) {
                                                console.error('Error saving step 2:', e);
                                            }
                                        } else if (this.step === 8 && this.selected === 'one') {
                                            try {
                                                // Get all checked amenity IDs
                                                const selectedAmenities = Array.from(document.querySelectorAll('input[name="amenities[]"]:checked'))
                                                    .map(input => parseInt(input.value));
                                                console.log('Selected amenities:', selectedAmenities);

                                                const response = await fetch(`/partner/property/save-amenities/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        amenities: selectedAmenities,
                                                        property_id: this.propertyId
                                                    })
                                                });

                                                const result = await response.json();

                                                if (result.success) {
                                                    console.log('Amenities saved:', result);
                                                    this.step++; // go to next step
                                                } else {
                                                    alert('Failed to save amenities: ' + result.message);
                                                }
                                            } catch (e) {
                                                console.error('Error saving amenities:', e);
                                            }
                                        } else if (this.step === 11 && this.selected === 'one') {
                                            try {
                                                const smokingAllowed = document.querySelector('#smoking_allowed').checked;
                                                const petsValue = document.querySelector('input[name="pets_allowed"]:checked')?.value || 'no';
                                                const partiesAllowed = document.querySelector('#parties_allowed').checked;

                                                const checkInFromTime = document.querySelector('#check_in_from').value;
                                                const checkInUntilTime = document.querySelector('#check_in_until').value;
                                                const checkOutFromTime = document.querySelector('#check_out_from').value;
                                                const checkOutUntilTime = document.querySelector('#check_out_until').value;

                                                const response = await fetch(`/partner/property/save-policy/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        smoking_allowed: smokingAllowed,
                                                        parties_allowed: partiesAllowed,
                                                        pets_allowed: petsValue, // convert to boolean
                                                        check_in_from: checkInFromTime,
                                                        check_in_until: checkInUntilTime,
                                                        check_out_from: checkOutFromTime,
                                                        check_out_until: checkOutUntilTime,
                                                        cancellation_policy: 'flexible', // hardcoded for now; you can make this dynamic
                                                        property_id: this.propertyId
                                                    }),
                                                });

                                                const result = await response.json();

                                                if (result.success) {
                                                    console.log('Policy saved:', result);
                                                    this.step++;
                                                } else {
                                                    alert('Failed to save policy: ' + result.message);
                                                }
                                            } catch (e) {
                                                console.error('Error saving policy:', e);
                                            }
                                        } else if (this.step === 13 && this.selected === 'one') {
                                            console.log('Saving room details for property ID:', this.propertyId);

                                            if (this.rooms.length === 0) {
                                                alert('Please add at least one room before continuing.');
                                                return;
                                            }

                                            console.log('Saving room details:', {
                                                rooms: this.rooms

                                            });


                                            fetch(`/partner/save-rooms/${this.propertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        property_id: this.propertyId,
                                                        rooms: this.rooms

                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(result => {
                                                    if (result.success) {
                                                        console.log('Room saved:', result);
                                                        this.step++; // Move to step 15
                                                    } else {
                                                        alert(result.message || 'Failed to save room.');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error saving room:', error);
                                                    alert('Something went wrong while saving the room.');
                                                });
                                        } else if (this.step === 14 && this.selected === 'one') {
                                            console.log('Submitting partner verification details for property ID:', this.propertyId);
                                            const payload = {
                                                property_id: this.propertyId,
                                                type: this.type,
                                                full_name: this.type === 'individual' ? this.individual.full_name : null,
                                                national_id: this.type === 'individual' ? this.individual.national_id : null,
                                                company_name: this.type === 'business' ? this.business.company_name : null,
                                                registration_number: this.type === 'business' ? this.business.registration_number : null,
                                            };

                                            fetch(`/partner/partner-verification`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify(payload)
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log(data);
                                                    alert('Partner verification details saved successfully');
                                                    window.location.href = '/partner/list-your-property';

                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                });
                                        } else if (this.step === 4 && this.selected === 'multiple') {
                                            if (this.sameAddress === 'yes') {
                                                console.log('Saving same address for all properties with ID:', this.propertyId);
                                                fetch('/property/save-address-same', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        },
                                                        body: JSON.stringify({
                                                            property_id: this.propertyId,
                                                            count: this.propertyCount,
                                                            address: this.address
                                                        })
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        console.log('Saved:', data);
                                                        this.step++;
                                                    });
                                            } else {
                                                // Different address for each property
                                                console.log('Saving multiple addresses for properties with ID:', this.propertyId);
                                                const allAddresses = Array.from({
                                                    length: this.propertyCount
                                                }, (_, i) => {
                                                    const input = document.querySelector(`#property-address-${i}`);
                                                    return input ? input.value : '';
                                                });

                                                fetch('/property/save-address-multiple', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        },
                                                        body: JSON.stringify({
                                                            first_property_id: this.propertyId,
                                                            addresses: allAddresses
                                                        })
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        alert('Addresses saved successfully');
                                                        console.log('Saved Multiple:', data);
                                                        this.step++;
                                                    });
                                            }
                                        } else if (this.step === 6 && this.selected === 'multiple') {
                                            console.log('Saving amenities for property ID:', this.propertyId);
                                            console.log('currentUnit:', this.currentUnit);
                                            console.log('propertyCount:', this.propertyCount);
                                            if (this.currentUnit < this.propertyCount) {
                                                const currentPropertyId = this.propertyId + this.currentUnit - 1;

                                                console.log('Saving amenities for unit:', this.currentUnit);

                                                fetch(`/save-amenities/${currentPropertyId}`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        },
                                                        body: JSON.stringify({
                                                            property_id: currentPropertyId,
                                                            amenities: this.selectedAmenities
                                                        })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            console.log("Amenities saved for property " + currentPropertyId);
                                                            this.currentUnit++;
                                                            this.step--;
                                                        } else {
                                                            console.error("Error:", data.message);
                                                            alert("Failed to save amenities.");
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error("Fetch error:", error);
                                                    });

                                                // Repeat for next unit
                                            } else {
                                                console.log('Saving amenities for last unit:', this.currentUnit);
                                                const currentPropertyId = this.propertyId + 1;
                                                fetch(`/save-amenities/${currentPropertyId}`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        },
                                                        body: JSON.stringify({
                                                            property_id: this.propertyId,
                                                            amenities: this.selectedAmenities
                                                        })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            console.log("Amenities saved for property " + currentPropertyId);
                                                            this.currentUnit = 1;
                                                            this.step++;
                                                        } else {
                                                            console.error("Error:", data.message);
                                                            alert("Failed to save amenities.");
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error("Fetch error:", error);
                                                    });
                                            }
                                        } else if (this.step === 8 && this.selected === 'multiple') {
    const currentPropertyId = this.propertyId + this.currentUnit - 1;
    const selectedLanguages = this.unitServices[this.currentUnit - 1].languages || [];
                                        
    // Replace language names with corresponding language IDs
    const languageIds = selectedLanguages.map(lang => {
        const langEntry = this.availableLanguages.find(l => l.name === lang);
        return langEntry ? langEntry.id : null;
    }).filter(id => id !== null);

    fetch(`/partner/save-languages/${currentPropertyId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            languages: languageIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`Languages saved for property ${currentPropertyId}:`, data.selected_languages);

            if (this.currentUnit < this.propertyCount) {
                this.currentUnit++;
            } else {
                this.currentUnit = 1;
                this.step++;
            }
        } else {
            console.error('Error saving languages:', data.message);
            alert('Failed to save languages.');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}

                                        else if (this.step === 9 && this.selected === 'multiple') {
                                            console.log('Saving policy for property ID:', this.propertyId);
                                            console.log('currentUnit:', this.currentUnit);
                                            console.log('propertyCount:', this.propertyCount);

                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;
                                            const houseRules = this.unitServices[this.currentUnit - 1].houseRules;

                                            fetch(`/partner/property/save-policy/${currentPropertyId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        property_id: currentPropertyId,
                                                        smoking_allowed: houseRules.smokingAllowed,
                                                        children_allowed: houseRules.childrenAllowed,
                                                        parties_allowed: houseRules.partiesAllowed,
                                                        pets_allowed: houseRules.petsPolicy,
                                                        check_in_from: houseRules.checkInFrom,
                                                        check_in_until: houseRules.checkInUntil,
                                                        check_out_from: houseRules.checkOutFrom,
                                                        check_out_until: houseRules.checkOutUntil,
                                                    })


                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        console.log("Policy saved for property " + currentPropertyId);

                                                        if (this.currentUnit < this.propertyCount) {
                                                            this.currentUnit++;
                                                            this.step--; // stay on the same step to show next unit's form
                                                        } else {
                                                            this.currentUnit = 1;
                                                            this.step++; // move to next step
                                                        }
                                                    } else {
                                                        console.error("Error:", data.message);
                                                        alert("Failed to save policy.");
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error("Fetch error:", error);
                                                });
                                        } else if (this.step === 10 && this.selected === 'multiple') {
                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;
                                            const hostProfile = this.unitServices[this.currentUnit - 1].hostProfile;

                                            // Prepare default boolean values based on selected option
                                            let show_property = false;
                                            let show_host = false;
                                            let show_neighborhood = false;
                                            let none_selected = false;

                                            switch (hostProfile) {
                                                case 'property':
                                                    show_property = true;
                                                    break;
                                                case 'host':
                                                    show_host = true;
                                                    break;
                                                case 'neighbourhood':
                                                    show_neighborhood = true;
                                                    break;
                                                case 'later':
                                                default:
                                                    none_selected = true;
                                                    break;
                                            }

                                            fetch(`/partner/property/${currentPropertyId}/host-profile`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        property_id: currentPropertyId,
                                                        show_property: show_property,
                                                        show_host: show_host,
                                                        show_neighborhood: show_neighborhood,
                                                        none_selected: none_selected
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        console.log(`Host profile saved for property ${currentPropertyId}`);
                                                        if (this.currentUnit < this.propertyCount) {
                                                            this.currentUnit++;
                                                        } else {
                                                            this.currentUnit = 1;
                                                            this.step++; // move to next step
                                                        }
                                                    } else {
                                                        console.error("Error saving host profile:", data.message);
                                                        alert("Failed to save host profile.");
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error("Fetch error:", error);
                                                });
                                        } else if (this.step === 11 && this.selected === 'multiple') {
                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;
                                            const title = this.formData.propertyName;

                                            fetch(`/property/${currentPropertyId}/update-title`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({
                                                        title: title
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        console.log(`Title updated for property ${currentPropertyId}: ${title}`);

                                                        if (this.currentUnit < this.propertyCount) {
                                                            this.currentUnit++;
                                                            // Stay on step 11 for next property
                                                        } else {
                                                            this.currentUnit = 1;
                                                            this.step++; // Proceed to step 12
                                                        }
                                                    } else {
                                                        console.error('Error saving title:', data);
                                                        alert('Failed to save title.');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Fetch error:', error);
                                                });
                                        } else if (this.step === 12 && this.selected === 'multiple') {
                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;
                                            const files = this.$refs.unitPhotoInput.files;
                                            if (files.length > 0) {
                                                const formData = new FormData();
                                                formData.append('property_id', currentPropertyId);
                                                formData.append('unit_number', this.currentUnit);

                                                for (let file of files) {
                                                    formData.append('photos[]', file);
                                                }

                                                await fetch('/partner/property/upload-photos', {
                                                    method: 'POST',
                                                    body: formData,
                                                    headers: {
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                    }
                                                });
                                            }

                                            if (this.currentUnit < this.propertyCount) {
                                                this.currentUnit++;
                                            } else {
                                                this.step++;
                                                this.currentUnit = 1;
                                            }
                                        } else if (this.step === 13 && this.selected === 'multiple') {
                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;

                                            if (this.rooms.length === 0) {
                                                alert('Please add at least one room before continuing.');
                                                return;
                                            }

                                            const formData = new FormData();
                                            formData.append('property_id', parseInt(currentPropertyId));
                                            formData.append('unit_number', this.currentUnit);

                                            this.rooms.forEach((room, index) => {
                                                formData.append(`rooms[${index}][room_type_id]`, parseInt(room.room_type_id));
                                                formData.append(`rooms[${index}][name]`, room.name);
                                                formData.append(`rooms[${index}][price_per_night]`, parseFloat(room.price_per_night));
                                                formData.append(`rooms[${index}][max_guests]`, parseInt(room.max_guests));
                                                formData.append(`rooms[${index}][bathroom_count]`, parseInt(room.bathroom_count)); // ✅ fix
                                                formData.append(`rooms[${index}][size_sq_m]`, parseFloat(room.size_sq_m));

                                                if (room.beds) {
                                                    Object.keys(room.beds).forEach((bedTypeId) => {
                                                        formData.append(`rooms[${index}][beds][${bedTypeId}]`, parseInt(room.beds[bedTypeId]));
                                                    });
                                                }
                                            });


                                            await fetch(`/partner/save-rooms/${currentPropertyId}`, {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                }
                                            });

                                            // Move to next unit or step
                                            if (this.currentUnit < this.propertyCount) {
                                                this.currentUnit++;
                                            } else {
                                                this.step++;
                                                this.currentUnit = 1;
                                            }

                                            // Reset room data for next unit
                                            this.rooms = [];
                                        } else if (this.step === 14 && this.selected === 'multiple') {
                                            const currentPropertyId = this.propertyId + this.currentUnit - 1;

                                            const formData = new FormData();
                                            formData.append('property_id', currentPropertyId);
                                            formData.append('type', this.type);

                                            if (this.type === 'individual') {
                                                formData.append('full_name', this.individual.name);
                                                formData.append('national_id', this.individual.id);
                                            } else if (this.type === 'business') {
                                                formData.append('company_name', this.business.company_name);
                                                formData.append('registration_number', this.business.reg_no);
                                            }

                                            await fetch('/partner/partner-verification', {
                                                    method: 'POST',
                                                    body: formData,
                                                    headers: {
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                    }
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        console.log('Partner verification details saved:', data)
                                                        window.location.href = '/partner/list-your-property';

                                                    } else {
                                                        alert('Failed to save partner verification details: ' + data.message)
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error saving partner verification details:', error)
                                                    alert('Something went wrong while saving partner verification details.')
                                                });

                                            if (this.currentUnit < this.propertyCount) {
                                                this.currentUnit++;
                                            } else {
                                                this.step++;
                                                this.currentUnit = 1;
                                            }
                                        } else {
                                            if (this.step === 1 && this.selected === '') return;

                                            if (this.step < this.totalSteps) {
                                                this.step++;
                                                propertyId = this.propertyId;
                                                console.log('Property ID:', propertyId);
                                            }
                                        }

                                    },

                                    prevStep() {
                                        if (this.step > 1) {
                                            this.step--;
                                        }
                                    }
                                }
                            }
                        </script>
                    </section>



                </div>
            </template>
        </form>
    </div>
    <script>
        function stepWizard() {
            return {
                step: 1,
                selected: '', // subcategory id from step 1
                selectedBox: '',
                propertyId: null,
                subtypes: [],

                init() {
                    // Initial setup
                },

                // async submitStep1() {
                //     if (this.selected === '') return;

                //     const response = await fetch('{{ route('partner.property.step1.store_new') }}', {
                //         method: 'POST',
                //         headers: {
                //             'Content-Type': 'application/json',
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //             'Accept': 'application/json',
                //         },
                //         body: JSON.stringify({
                //             apartment_type: this.selected
                //         })
                //     });

                //     if (response.ok) {
                //         const data = await response.json();
                //         this.propertyId = data.property_id;
                //         this.step = 2;

                //         // Fetch subtypes based on subcategory
                //         await this.fetchSubtypes(this.selected);
                //     } else {
                //         const error = await response.json();
                //         alert(error.message || 'Error in Step 1');
                //     }
                // },

                async fetchSubtypes(subcategoryId) {
                    try {
                        const response = await fetch(`/partner/property_subtype/${subcategoryId}`);
                        const data = await response.json();
                        console.log('Fetched subtypes:', data);
                        this.subtypes = data;
                    } catch (err) {
                        console.error('Failed to fetch subtypes:', err);
                    }
                },

                //     async submitStep2() {
                //         if (!this.selectedBox || !this.propertyId) return;

                //         const response = await fetch(`/property-apartment/step2/${this.propertyId}`, {
                //             method: 'POST',
                //             headers: {
                //                 'Content-Type': 'application/json',
                //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //                 'Accept': 'application/json',
                //             },
                //             body: JSON.stringify({
                //                 category_id: this.selectedBox,
                //                 property_id: this.propertyId
                //             })
                //         });

                //         if (response.ok) {
                //             const data = await response.json();
                //             this.step = 3;
                //             alert(data.message || 'Step 2 saved successfully');
                //         } else {
                //             const error = await response.json();
                //             alert(error.message || 'Error in Step 2');
                //         }
                //     }
                // };
            }
        }
    </script>

</body>

</html>