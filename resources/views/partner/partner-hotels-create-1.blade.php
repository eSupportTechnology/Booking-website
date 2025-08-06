@extends('partner.partner-layout')

@section('title', ' Hotels Create | ' . config('domains.app_name'))


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


<div x-data="stepForm()">

   
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500" :style="'width:' + (step * 100 / 8) + '%'"></div>
    </div>

    <div class="max-w-6xl p-4 ml-14">
        <form class="p-6 rounded-lg space-y-6" @submit.prevent>
            <!-- STEP 1 -->
            <div x-show="step === 1" x-cloak class="container mx-auto px-4 py-8 max-w-6xl" x-data="{ showMore: false, selectedBox: null }">
                <h2 class="text-2xl font-bold mb-6 mt-8">
                    Which property category is most similar to your place?
                </h2>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Limit subcategories shown unless showMore is true -->
                        <template x-for="(subcategory, index) in showMore ? subcategories : subcategories.slice(0, 6)"
                            :key="subcategory.id">
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

                        <!-- Show More / Less Button -->
                        <div @click="showMore = !showMore"
                            class="border border-gray-300 rounded p-4 cursor-pointer text-blue-600 hover:bg-gray-50 flex items-center justify-center font-medium transition">
                            <span x-text="showMore ? '– Show less' : '+ More options'"></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="button" @click="window.location.href='{{ route('partner.property.category') }}'"
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
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </template>

            <template x-if="step === 7">
                <form @submit.prevent="submitStep7">
                    <div>
                        <div class="max-w-2xl ml-40 px-4 py-8  bg-white  rounded shadow mt-10">
                            <h1 class="text-2xl font-bold mb-6">Tell us about your hotel</h1>

                            <hr class="my-6" />

                            <!-- Star Rating -->
                            <div class="mb-6">
                                <label class="block font-medium text-gray-800 mb-2">What is the star rating of your
                                    hotel?</label>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="N/A"
                                            x-model="property.stars" />
                                        N/A
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="1"
                                            x-model="property.stars" />
                                        1 star <span class="text-yellow-400">★</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="2"
                                            x-model="property.stars" />
                                        2 stars <span class="text-yellow-400">★★</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="3"
                                            x-model="property.stars" />
                                        3 stars <span class="text-yellow-400">★★★</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="4"
                                            x-model="property.stars" />
                                        4 stars <span class="text-yellow-400">★★★★</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="stars" value="5"
                                            x-model="property.stars" />
                                        5 stars <span class="text-yellow-400">★★★★★</span>
                                    </label>
                                </div>
                            </div>

                            <hr class="my-6" />

                            <!-- Management Question -->
                            <div class="mb-6">
                                <label class="block font-medium text-gray-800 mb-2">Are you a property management
                                    company or part of a group or chain?</label>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="group" value="yes"
                                            x-model="property.group" />
                                        Yes
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="group" value="no"
                                            x-model="property.group" />
                                        No
                                    </label>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between items-center mt-8">
                                <button type="submit" @click="step < 9 ? step-- : step"
                                    class="border border-[#3CC0E9]  text-blue-600  hover:bg-blue-50 font-semibold py-2 px-4 rounded">←</button>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>

            <template x-if="step === 8" x-cloak>
                <form @submit.prevent="submitStep8">
                    <div class="max-w-4xl ml-40 px-4 py-8 mt-10">
                        <section class="mb-8">
                            <h1 class="text-xl text-gray-700 font-bold mb-4">What can guests use at your place?</h1>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Property Name Input + Checkboxes (2/3 Width) -->
                                <div class="md:col-span-2 flex">
                                    <div class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">

                                        <!-- 9 Checkboxes Section -->

                                        <div class="mt-2">
                                            <h3 class="text-gray-700 font-semibold mb-2">Select property type(s)</h3>
                                            <div class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                                <div
                                                    class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                                    @foreach ($amenities as $amenity)
                                                        <label class="flex items-center space-x-2">
                                                            <input type="checkbox" name="amenities[]"
                                                                value="{{ $amenity['id'] }}" class="text-blue-500" />
                                                            <span>{{ $amenity['name'] }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tips and Information (1/3 Width) -->
                                <div class="flex flex-col gap-4">

                                    <!-- Tip Box 1 -->
                                    <div x-data="{ show: true }" x-show="show"
                                        class="bg-white p-4 border border-gray-200 rounded w-full md:w-[350px] lg:w-[400px]">

                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                                    alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                                <h3 class="text-gray-700 text-sm text-bold">What if I don’t see a
                                                    facility
                                                    I offer?
                                                </h3>
                                            </div>
                                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-700">
                                            The facilities listed here are the ones most searched for by guests. After
                                            you
                                            complete
                                            your registration, you can add more facilities from a larger list in the
                                            extranet, the
                                            platform you'll use to manage your property.
                                            <br>
                                            The ones selected here will apply to all of your holiday homes.
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons Row (Outside grid, full width) -->
                            <!-- Buttons Row aligned with Checkbox Section -->
                            <div class="flex justify-between items-center mt-8">
                                <button type="button" @click="step > 1 ? step-- : step"
                                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                    class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                    ←
                                </button>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                    Continue
                                </button>
                            </div>

                        </section>
                    </div>
                </form>
            </template>

            <template x-if="step === 9">
                <form @submit.prevent="submitStep9">
                    <div>
                        <div>
                            <div class="container mx-auto px-4 py-4 max-w-6xl mb-8">

                                <!-- Header -->
                                <h2 class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
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
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="breakfast" value="yes" class="mr-2"
                                                    x-model="property.breakfast" />
                                                <span>Yes</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="breakfast" value="no" class="mr-2"
                                                    x-model="property.breakfast" checked />
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
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="parking" value="free" class="mr-2"
                                                    x-model="property.parking" />
                                                <span>Yes, free</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="parking" value="paid" class="mr-2"
                                                    x-model="property.parking" />
                                                <span>Yes, paid</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="parking" value="no" class="mr-2"
                                                    x-model="property.parking" checked />
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons below sections -->
                                <div class="mt-8 flex justify-between max-w-xl ml-6">
                                    <button type="button" @click="step > 1 ? step-- : step"
                                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                        class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                        ←
                                    </button>
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </template>

            <template x-if="step === 10" x-cloak>
                <form @submit.prevent="submitStep10">
                    <div>
                        <div class="container ml-32 px-4 py-8 max-w-2xl">
                            <!-- Header -->
                            <h2 class="text-2xl font-bold mb-8 text-left">
                                What languages do you or your staff speak?
                            </h2>

                            <!-- Language Selection Section -->
                            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                                <h3 class="text-lg  mb-4 font-bold">Select languages</h3>
                                <div class="space-y-2">
                                    @foreach ($languages as $language)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" name="languages[]" value="{{ $language['id'] }}"
                                                class="text-blue-500" />
                                            <span>{{ $language['name'] }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <!-- Add Additional Languages -->
                                <div id="additionalLanguagesSection" class="mt-4 hidden relative">
                                    <h3 class="text-lg font-medium mb-2 ">Add additional languages</h3>

                                    <!-- Searchable dropdown container -->
                                    <div class="relative w-full max-w-md">
                                        <input type="text" id="languageInput" oninput="filterDropdown()"
                                            onclick="toggleDropdown()" placeholder="Search languages..."
                                            autocomplete="off" class="w-full border rounded p-2 pr-10 cursor-pointer"
                                            readonly />
                                        <!-- Dropdown arrow -->
                                        <button type="button" onclick="toggleDropdown()"
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
                                                onclick="selectLanguage(this)">
                                                Catalan</li>
                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                onclick="selectLanguage(this)">
                                                Chinese</li>
                                            <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                                onclick="selectLanguage(this)">
                                                Croatian</li>
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
                                <a href="#" onclick="event.preventDefault(); toggleAdditionalLanguages();"
                                    class="text-blue-500 hover:underline mt-4 block">
                                    Add additional languages
                                </a>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between">
                                <!-- Back Button on the left -->
                                <button type="button" @click="step > 1 ? step-- : step"
                                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                    class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                    ←
                                </button>

                                <!-- Continue Button on the right -->
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
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
                </form>
            </template>

            <template x-if="step === 11">
                <form @submit.prevent="submitStep11">
                    <div>
                        <div class="container ml-32 px-4 py-8 max-w-4xl">
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
                                                <input type="checkbox" class="sr-only peer"
                                                    x-model="property.smoking_allowed" />
                                                <div
                                                    class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                </div>
                                                <div
                                                    class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                </div>
                                            </div>
                                        </label>

                                        <label class="flex items-center justify-between cursor-pointer">
                                            <span>Children allowed</span>
                                            <div class="relative">
                                                <input type="checkbox" class="sr-only peer"
                                                    x-model="property.children_allowed" />
                                                <div
                                                    class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                                </div>
                                                <div
                                                    class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                                </div>
                                            </div>
                                        </label>

                                        <label class="flex items-center justify-between cursor-pointer">
                                            <span>Parties/events allowed</span>
                                            <div class="relative">
                                                <input type="checkbox" class="sr-only peer"
                                                    x-model="property.parties_allowed" />
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
                                        <h3 class="text-base font-semibold mb-2">Do you allow pets?</h3>
                                        <div class="space-y-2">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="pets_allowed" value="yes"
                                                    x-model="property.pets_allowed" class="mr-2">
                                                <span>Yes</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="pets_allowed" value="upon_request"
                                                    x-model="property.pets_allowed" class="mr-2">
                                                <span>Upon request</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="pets_allowed" value="no"
                                                    x-model="property.pets_allowed" class="mr-2">
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="mt-6">
                                        <h3 class="text-base font-semibold mb-2">Are there additional fees for pets?
                                        </h3>
                                        <div class="space-y-2">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="pets_fees" value="free"
                                                    x-model="pets_fees" class="mr-2">
                                                <span>Pets can stay for free</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="pets_fees" value="fees"
                                                    x-model="pets_fees" class="mr-2">
                                                <span>Fees may apply</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <h3 class="text-base font-semibold mb-2">Cancellation Policy</h3>
                                        <select x-model="property.cancellation_policy"
                                            class="w-full border rounded p-2">
                                            <option value="flexible">Flexible</option>
                                            <option value="moderate">Moderate</option>
                                            <option value="strict">Strict</option>
                                        </select>
                                    </div>

                                    <hr class="my-6 border-t border-gray-300">

                                    <!-- Check-in -->
                                    <div class="mt-6">
                                        <h3 class="text-base font-semibold mb-2">Check in</h3>
                                        <div class="flex space-x-4">
                                            <div class="w-full">
                                                <label class="block text-sm font-medium mb-1">From</label>
                                                <input type="time" value="15:00" x-model="property.check_in_from"
                                                    class="w-full border rounded p-2" />
                                            </div>
                                            <div class="w-full">
                                                <label class="block text-sm font-medium mb-1">Until</label>
                                                <input type="time" value="18:00"
                                                    x-model="property.check_in_until"
                                                    class="w-full border rounded p-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Check-out -->
                                    <div class="mt-6">
                                        <h3 class="text-base font-semibold mb-2">Check out</h3>
                                        <div class="flex space-x-4">
                                            <div class="w-full">
                                                <label class="block text-sm font-medium mb-1">From</label>
                                                <input type="time" value="08:00"
                                                    x-model="property.check_out_from"
                                                    class="w-full border rounded p-2" />
                                            </div>
                                            <div class="w-full">
                                                <label class="block text-sm font-medium mb-1">Until</label>
                                                <input type="time" value="11:00"
                                                    x-model="property.check_out_until"
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
                                                alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                            <h3 class="text-gray-800 font-semibold text-base">What if my house rules
                                                change?</h3>
                                        </div>
                                        <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-3">
                                        You can easily customise these house rules later and additional house rules can
                                        be set on
                                        the Policies page of the extranet after you complete registration.
                                    </p>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="button" @click="step > 1 ? step-- : step"
                                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                    class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                                    ←
                                </button>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>

            <template x-if="step === 12">
                <form @submit.prevent="submitStep12">
                    <div class="mt-16">
                        <div class="max-w-3xl mx-auto p-4 space-y-4 ">

                            <!-- Step 1 - Completed -->
                            <div
                                class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                                        class="w-6 h-6 md:w-7 md:h-7" />
                                    <div>
                                        <p class="text-sm text-gray-500">Step 1</p>
                                        <h2 class="text-base font-semibold">Property details</h2>
                                        <p class="text-xs text-gray-600">The basics, Add your property name, address,
                                            facilities
                                            and more</p>
                                    </div>
                                </div>
                                <a href="#" class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
                            </div>

                            <!-- Step 2 -->
                            <div class="border border-gray-300  rounded-lg p-4 flex justify-between items-center ">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                                        class="w-6 h-6 md:w-7 md:h-7" />
                                    <div>
                                        <p class="text-sm text-gray-500">Step 2</p>
                                        <h2 class="text-base font-semibold">Rooms</h2>
                                        <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set
                                            one up you
                                            can add more.</p>
                                    </div>
                                </div>
                                <a href="{{ route('partner.hotels.room', ['id' => $categoryId]) }}"
                                    class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                                    Add room
                                </a>
                            </div>

                            <!-- Step 3 - Photos -->
                            <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                                    <div>
                                        <p class="text-sm text-gray-500">Step 3</p>
                                        <h2 class="text-base font-semibold">Photos</h2>
                                        <p class="text-xs text-gray-600">Share some photos of your property so guests
                                            know what to
                                            expect.</p>
                                    </div>
                                </div>
                                <a href="{{ route('partner.hotels.photos') }}"
                                    class="border border-sky-400 text-sky-400 text-sm font-semibold px-4 py-2 rounded hover:bg-sky-50">
                                    Add Photos
                                </a>

                            </div>

                            <!-- Step 4 - Final -->
                            <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                                    <div>
                                        <p class="text-sm text-gray-500">Step 4</p>
                                        <h2 class="text-base font-semibold">Final steps</h2>
                                        <p class="text-xs text-gray-600">Set up payments and invoicing before you open
                                            for
                                            bookings.</p>
                                    </div>
                                </div>
                                <a href="{{ route('partner.hotels.payments') }}"
                                    class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                                    Add final details
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </template>


            <template x-if="step === 13">
                <form @submit.prevent="submitStep13">
                    <div>
                        <h2 class="text-xl font-bold mb-4">Step 9: Review & Submit</h2>
                        <p class="text-sm text-gray-600 mb-4">Review your details before submission.</p>
                        <button
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">Submit</button>
                    </div>
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
                    stars: '',
                    group: '',
                    breakfast: 'no',
                    parking: 'no',
                    smoking_allowed: false,
                    children_allowed: false,
                    parties_allowed: false,
                    pets_allowed: '',
                    pets_fees: 'free',
                    check_in_from: '15:00',
                    check_in_until: '18:00',
                    check_out_from: '08:00',
                    check_out_until: '11:00',
                    cancellation_policy: 'flexible',

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
                },

                async submitStep7() {
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

                        if (!response.ok) throw new Error('Failed to save step 7');

                        const data = await response.json();

                        if (data.propertyId) {
                            this.propertyId = data.propertyId;
                        }

                        this.step = 8; // Go to next step
                    } catch (error) {
                        console.error('Step 7 save failed:', error);
                    }
                },

                async submitStep8() {
                    try {
                        // Get all checked amenity IDs
                        const selectedAmenities = Array.from(document.querySelectorAll(
                                'input[name="amenities[]"]:checked'))
                            .map(input => parseInt(input.value));
                        console.log('Selected amenities:', selectedAmenities);

                        const response = await fetch(`/partner/property/save-amenities/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                amenities: selectedAmenities,
                                property_id: this.propertyId
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            console.log('Amenities saved:', result);
                            this.step = 9; // go to next step
                        } else {
                            alert('Failed to save amenities: ' + result.message);
                        }
                    } catch (e) {
                        console.error('Error saving amenities:', e);
                    }
                },

                async submitStep9() {
                    try {
                        const response = await fetch(`/partner/property/${this.propertyId}/additional-details`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.property),
                        });

                        if (!response.ok) throw new Error('Failed to save step 9');

                        const data = await response.json();

                        if (data.propertyId) {
                            this.propertyId = data.propertyId;
                        }

                        this.step = 10; // Go to next step
                    } catch (error) {
                        console.error('Step 9 save failed:', error);
                    }
                },

                async submitStep10() {
                    try {
                        // Get all checked amenity IDs
                        const selectedLanguages = Array.from(document.querySelectorAll(
                                'input[name="languages[]"]:checked'))
                            .map(input => parseInt(input.value));
                        console.log('Selected languages:', selectedLanguages);

                        const response = await fetch(`/partner/property/save-languages/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                languages: selectedLanguages,
                                property_id: this.propertyId
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            console.log('Languages saved:', result);
                            this.step = 11; // go to next step
                        } else {
                            alert('Failed to save Languages: ' + result.message);
                        }
                    } catch (e) {
                        console.error('Error saving Languages:', e);
                    }
                },

                async submitStep11() {
                    try {
                        // Validate pets_allowed
                        const validPets = ['yes', 'no', 'upon_request'];
                        if (!validPets.includes(this.property.pets_allowed)) {
                            alert('Please select a valid pet policy.');
                            return;
                        }

                        const response = await fetch(`/partner/property/save-policy/${this.propertyId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(this.property),
                        });

                        if (!response.ok) throw new Error('Failed to save step 11');

                        const data = await response.json();

                        if (data.propertyId) {
                            this.propertyId = data.propertyId;
                        }

                        this.step = 12;
                    } catch (error) {
                        console.error('Step 11 save failed:', error);
                    }
                },


                async submitStep12() {
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

                        this.step = 13; // Go to next step
                    } catch (error) {
                        console.error('Step 12 save failed:', error);
                    }
                },

                async submitStep13() {
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

                        this.step = 14; // Go to next step
                    } catch (error) {
                        console.error('Step 13 save failed:', error);
                    }
                }

            };
        }
    </script>

    </div>
    @endsection
