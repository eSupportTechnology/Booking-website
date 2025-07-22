<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Homes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" x-data="stepForm()">

    <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
        <!-- header contents same as your original -->
    </header>

    <div class="max-w-6xl p-4 ml-14 bg-gray-100">
        <form class="p-6 rounded-lg space-y-6" @submit.prevent>
            <!-- STEP 1 -->
            <div x-show="step === 1" x-cloak class="container mx-auto px-4 py-8 max-w-6xl">
                <h2 class="text-2xl font-bold mb-6 mt-8">
                    Which property category is most similar to your place?
                </h2>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="subcategory in subcategories" :key="subcategory.id">
                            <div @click="selectedBox = subcategory.id"
                                :class="selectedBox === subcategory.id ? 'border-2 border-blue-500 bg-blue-50' :
                                    'border border-gray-300'"
                                class="block rounded p-4 cursor-pointer transition bg-white relative">
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-2" x-text="subcategory.name"></h3>
                                    <p class="text-sm text-gray-700">Choose this type</p>
                                </div>
                                <div class="absolute top-2 right-2" x-show="selectedBox === subcategory.id">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </template>

                        <div @click="showMore = !showMore"
                            class="border border-gray-300 rounded p-4 cursor-pointer text-blue-600 hover:bg-gray-50 flex items-center justify-center font-medium transition">
                            <span x-text="showMore ? '– Show less' : '+ More options'"></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="button" @click="step = 1"
                        class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded">
                        ←
                    </button>
                    <button @click="submitStep1()" :disabled="!selectedBox"
                        :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                        class="py-3 px-8 rounded transition-all duration-200 text-white font-semibold" type="button">
                        Continue
                    </button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div x-show="step === 2" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow space-y-6">
                    <h2 class="text-xl font-bold text-left">How many hotels are you listing?</h2>

                    <div class="space-y-4">
                        <label :class="unitType === 'one' ? 'border-blue-500 border-2' : 'border-gray-300'"
                            class="block border rounded p-4 bg-white cursor-pointer" @click="unitType = 'one'">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/aprt-b.png') }}" class="w-14 h-10" />
                                    <span class="text-base">One hotel with one or multiple rooms</span>
                                </div>
                                <template x-if="unitType === 'one'">
                                    <span class="text-blue-500 font-bold text-xl">✔</span>
                                </template>
                            </div>
                        </label>

                        <label :class="unitType === 'multiple' ? 'border-blue-500 border-2' : 'border-gray-300'"
                            class="block border rounded p-4 bg-white cursor-pointer" @click="unitType = 'multiple'">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/aprt-a.png') }}" class="w-14 h-10" />
                                    <span class="text-base">Multiple hotels with rooms</span>
                                </div>
                                <template x-if="unitType === 'multiple'">
                                    <span class="text-blue-500 font-bold text-xl">✔</span>
                                </template>
                            </div>
                        </label>
                    </div>

                    <div x-show="unitType === 'multiple'" x-transition class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
                        <div>
                            <label class="block mb-1">Number of properties</label>
                            <input type="number" min="2" value="2" class="border rounded w-24 p-2" />
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button @click="step = 1"
                            class="border border-[#3CC0E9] text-[#3CC0E9] px-4 py-2 rounded font-semibold">←</button>
                        <button @click="submitStep2()" :disabled="!unitType"
                            :class="!unitType ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                            class="text-white px-6 py-2 rounded font-semibold">Continue</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div x-show="step === 3" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
                <template x-if="unitType === 'one'">
                    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                        <p class="text-base text-gray-600 mb-8">You're listing:</p>
                        <div class="flex justify-center mb-8">
                            <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="One Hotel"
                                class="w-16 h-16" />
                        </div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                            One hotel where guests can book a room
                        </h2>
                        <p class="text-gray-700 mb-8">Does this sound like your property?</p>
                        <div class="space-y-2">
                            <button type="button" @click="submitStep3()"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button>
                            <button type="button" @click="step = 2"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="unitType === 'multiple'">
                    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                        <p class="text-base text-gray-600 mb-8">You're listing:</p>
                        <div class="flex justify-center mb-8">
                            <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Hotels"
                                class="w-16 h-16" />
                        </div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                            Multiple hotels where guests can book a room
                        </h2>
                        <p class="text-gray-700 mb-8">Does this sound like your property?</p>
                        <div class="space-y-2">
                            <button type="button" @click="submitStep3()"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button>
                            <button type="button" @click="step = 2"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="step === 4">
                <form @submit.prevent="submitStep4">
                    <div class="space-y-4">
                        <label class="block">
                            Property Title:
                            <input type="text" x-model="formData.title" class="w-full border rounded p-2">
                        </label>
                        <label class="block">
                            Description:
                            <textarea x-model="formData.description" class="w-full border rounded p-2"></textarea>
                        </label>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="step = 3" class="border text-blue-600 py-2 px-4 rounded">
                            ← Back
                        </button>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                            Continue
                        </button>
                    </div>
                </form>
            </template>

            <template x-if="step === 5">
                <form @submit.prevent="submitStep5">

                    <div class="relative w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-10 ">
                        <!-- Google Maps iframe full background -->
                        <iframe class="absolute inset-0 w-full h-full" loading="lazy"
                            src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                            allowfullscreen>
                        </iframe>

                        <!-- Optional overlay for readability -->
                        <div class="absolute inset-0 "></div>

                        <!-- Form content centered on map -->
                        <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                            <div
                                class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>

                                <div class="mb-4">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Find your
                                        address</label>
                                    <input type="text" x-model="property.address"
                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                </div>
                                <div class="mb-4">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment
                                        or
                                        floor number (optional)</label>
                                    <input type="text" x-model="property.apartment"
                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                </div>
                                <div class="mb-4">
                                    <label for="country"
                                        class="block text-sm font-medium text-gray-700">Country/region</label>
                                    <select x-model="property.country"
                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                        <option selected>Sri Lanka</option>
                                    </select>
                                </div>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="flex-1">
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" x-model="property.city"
                                            class="mt-1 p-2 w-full border border-gray-300 rounded">
                                    </div>
                                    <div class="flex-1">
                                        <label for="zipcode" class="block text-sm font-medium text-gray-700">Post
                                            code /
                                            Zip code</label>
                                        <input type="text" x-model="property.zipcode"
                                            class="mt-1 p-2 w-full border border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <input id="update_address" type="checkbox" name="update_address" checked
                                        class="mr-2">
                                    <label for="update_address" class="text-sm text-gray-700">Update the address when
                                        moving the pin on the map.</label>
                                </div>
                                <!-- Dismissible message box -->
                                <div x-data="{ showMessage: true }" x-show="showMessage"
                                    class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Note:</strong>
                                    <span class="block sm:inline">Make sure the pin location is accurate before
                                        continuing.</span>
                                    <span @click="showMessage = false"
                                        class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                                        <svg class="fill-current h-6 w-6 text-yellow-800" role="button"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <title>Close</title>
                                            <path
                                                d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                                        </svg>
                                    </span>
                                </div>

                                <p class="text-sm text-gray-600 mt-2">
                                    Is the red pin location incorrect? Uncheck the option above and click or press on
                                    the
                                    map to move the pin.
                                </p>
                                <div class="flex justify-between mt-6">
                                    <!-- Back Button (Left) -->
                                    <button type="button" @click="step > 1 ? step-- : step"
                                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                        class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                        ←
                                    </button>


                                    <!-- Continue Button (Right) -->
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </template>

            <template x-if="step === 6">
                <form @submit.prevent="submitStep6">
                    <section class="mb-12" x-data="{ channelManager: 'yes' }">
                        <div class="max-w-5xl mx-auto px-4 py-8">
                            <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

                            <!-- Question Section -->
                            <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                                <h2 class="text-lg font-semibold mb-2">
                                    Do you want to connect this listing to your channel manager?
                                </h2>
                                <p class="text-gray-700 mb-6">
                                    A channel manager is a third-party tool that lets you manage rates and availability
                                    across
                                    different sites you might list your place on, including Booking.com. If you're
                                    already using
                                    a channel manager, you can select 'Yes' to connect it to your listing.
                                </p>


                                <!-- Radio Buttons -->
                                <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                                    <!-- Yes Option -->
                                    <div>
                                        <input type="radio" id="yes" name="channel_manager" value="yes"
                                            class="mr-2" x-model="property.channel_manager">
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
                                                    You'll be able to connect your channel manager after your
                                                    registration is
                                                    complete – please continue to the next step.
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- No Option -->
                                    <div>
                                        <input type="radio" id="no" name="channel_manager" value="no"
                                            class="mr-2" x-model="property.channel_manager">
                                        <label for="no" class="text-gray-700">
                                            No, I won't be using a channel manager at this time
                                        </label>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-6">
                                    <!-- Back Button (Left) -->

                                    <button type="button" @click="step > 1 ? step-- : step"
                                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                        class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                        ←
                                    </button>


                                    <!-- Continue Button (Right) -->
                                    <button type="submit" @click="step < 9 ? step++ : step"
                                        :class="step === 9 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                        :disabled="step === 9"
                                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </template>
        </form>
    </div>

    <!-- Alpine Component Script -->
    <script>
        function stepForm() {
            return {
                step: 1,
                selectedBox: '',
                unitType: '',
                propertyId: null,
                subtypes: [],
                subcategories: @json($subcategories),
                showMore: false,

                property: {
                    address: '',
                    apartment: '',
                    country: 'Sri Lanka',
                    city: '',
                    zipcode: '',
                    channel_manager: 'yes',
                    // add other fields as needed
                },
                formData: {
                    title: '',
                    description: '',
                },

                async submitStep1() {
                    if (this.selectedBox === '') return;

                    try {
                        const response = await fetch('{{ route('partner.property.step1.store_new') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                apartment_type: this.selectedBox,
                                subcategory_id: this.selectedBox,
                                category_id: '{{ $categoryId }}'
                            })
                        });

                        const data = await response.json();
                        this.propertyId = data.property_id;
                        this.step = 2;
                        this.fetchSubtypes(this.selectedBox);
                        alert(data.message || 'Property created successfully');
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                },

                async fetchSubtypes(subcategoryId) {
                    try {
                        const response = await fetch(`/partner/property_subtype/${subcategoryId}`);
                        const data = await response.json();
                        this.subtypes = data;
                    } catch (err) {
                        console.error('Failed to fetch subtypes:', err);
                    }
                },

                async submitStep2() {
                    if (!this.unitType || !this.propertyId) {
                        alert('Please select a unit type');
                        return;
                    }

                    try {
                        const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                address_type_id: this.unitType === 'one' ? 1 : 2,
                                property_id: this.propertyId
                            })
                        });

                        const data = await response.json();
                        this.step = 3;
                        alert(data.message || 'Step 2 saved successfully');
                    } catch (error) {
                        alert('Error submitting step 2: ' + error.message);
                    }
                },

                async submitStep3() {
                    if (!this.propertyId) {
                        alert('Property ID missing!');
                        return;
                    }

                    try {
                        const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                property_id: this.propertyId,
                            }),
                        });

                        this.step = 4;

                    } catch (error) {
                        alert('Error submitting step 3: ' + error.message);
                    }
                },

                async submitStep4() {
                    try {
                        const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            alert(result.message || 'Step 4 saved successfully');
                            this.step = 5; // Move to next step if needed
                        } else {
                            alert(result.message || 'Something went wrong while saving step 4.');
                        }
                    } catch (error) {
                        console.error('Error submitting step 4:', error);
                        alert('Error submitting step 4: ' + error.message);
                    }
                },

                async submitStep5() {
                    try {
                        const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.property),
                        });

                        if (!response.ok) throw new Error('Failed to save step 5');

                        const data = await response.json();

                        if (data.propertyId) {
                            this.propertyId = data.propertyId;
                        }

                        this.step = 6; // Go to next step
                    } catch (error) {
                        console.error('Step 5 save failed:', error);
                    }
                },
                async submitStep6() {
                    try {
                        const response = await fetch(`/partner/property/step3/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.property),
                        });

                        if (!response.ok) throw new Error('Failed to save step 6');

                        const data = await response.json();

                        if (data.propertyId) {
                            this.propertyId = data.propertyId;
                        }

                        this.step = 7; // Go to next step
                    } catch (error) {
                        console.error('Step 5 save failed:', error);
                    }
                }

            };
        }
    </script>

</body>

</html>
