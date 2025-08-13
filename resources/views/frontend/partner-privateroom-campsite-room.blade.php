@extends('partner.partner-layout')

@section('title', ' Hotels Rooms | ' . config('domains.app_name'))

@section('content')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <div x-data="{ step: 1 }">
  
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500" :style="'width:' + (step * 100 / 7) + '%'"></div>
    </div>

    <!-- Step Content Wrapper -->
    <div x-data>

        <template x-if="step === 1">
      <form class="p-4 space-y-6 mt-8 ml-">



              <!-- Section Title -->
<h2 class="text-2xl font-bold ml-32 mb-4">Room details</h2>

<!-- Unit Type + Count Section -->
<div class="w-full max-w-xl bg-white rounded-lg border border-gray-200 shadow-sm ml-32 p-6">
         
            
 <!-- Unit Type -->
    <div class="w-full">
      <label for="unit_type" class="block text-sm font-semibold text-gray-700 mb-1">
        What type of unit is this?
      </label>
      <div class="relative">
        <select
          id="unit_type"
          name="unit_type"
          class="appearance-none w-full border border-gray-300 text-sm rounded-md shadow-sm bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200"
        >
          <option value="">Select a type</option>
          <option value="Twin">Twin</option>
          <option value="Single">Single</option>
          <option value="Double">Double</option>
          <option value="Twin/Double">Twin/Double</option>
          <option value="Triple">Triple</option>
          <option value="Quadruple">Quadruple</option>
         <option value="Bungalow">Bungalow</option>
          <option value="Chalet">Chalet</option>
          <option value="Family">Family</option>
          <option value="Mobile Home">Mobile Home</option>
          <option value="Tent">Tent</option>
        </select>

        <!-- Optional: Custom dropdown arrow -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 14a1 1 0 01-.707-.293l-4-4a1 1 0 111.414-1.414L10 11.586l3.293-3.293a1 1 0 111.414 1.414l-4 4A1 1 0 0110 14z" clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>



                        <br>
                        <!-- Room Count -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1 whitespace-nowrap">
                             How many rooms of this type do you have?
                            </label>

                            <input type="number" min="1" step="1" inputmode="numeric" pattern="\d*"
                                x-model="propertyCount" name="property_count"
                                class="w-[20%] border border-gray-300 rounded-md shadow-sm px-3 py-2" />
                        </div>

</div>



                <!-- Horizontal Layout Container -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                    <!-- Bed Types Container (2/3 width) -->
                    <div x-data="{ showMoreBeds: false }"
                        class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Which beds are available in this
                            room?</label>

                        @php
                            $mainBeds = [
                                ['label' => 'Single bed', 'desc' => '90 - 130 cm wide'],
                                ['label' => 'Double bed', 'desc' => '131 - 150 cm wide'],
                                ['label' => 'Large bed (King size)', 'desc' => '151 - 180 cm wide'],
                                ['label' => 'Extra-large double bed (Super-king size)', 'desc' => '181 - 210 cm wide'],
                            ];

                            $extraBeds = [
                                ['label' => 'Bunk bed', 'desc' => 'Variable size'],
                                ['label' => 'Sofa bed', 'desc' => 'Variable size'],
                                ['label' => 'Futon bed(s)', 'desc' => 'Variable size'],
                            ];
                        @endphp


                        @foreach ($mainBeds as $bed)
                            @php
                                $labelLower = strtolower($bed['label']);
                                $icon = 'famicons_bed.svg'; // default

                                if (str_contains($labelLower, 'sofa')) {
                                    $icon = 'famicons_sofa.svg';
                                } elseif (str_contains($labelLower, 'bunk')) {
                                    $icon = 'famicons_bunk-bed.svg';
                                }
                            @endphp

                            <div x-data="{ guests: 0 }"
                                class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
                                <div class="flex items-start gap-2">
                                    <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

                                    <div>
                                        <p class="text-sm font-medium">{{ $bed['label'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" @click="if (guests > 0) guests--"
                                        class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
                                    <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
                                    <button type="button" @click="guests++"
                                        class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
                                </div>
                            </div>
                        @endforeach






                        <!-- Toggle Link -->
                        <button type="button" @click="showMoreBeds = !showMoreBeds"
                            class="text-sm text-blue-600 hover:underline focus:outline-none">
                            <span x-show="!showMoreBeds">More bed options ▼</span>
                            <span x-show="showMoreBeds">Fewer bed options ▲</span>
                        </button>

                        <!-- Extra Beds -->
                        <div x-show="showMoreBeds" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0 overflow-hidden" class="space-y-4 pt-2">
                            @foreach ($extraBeds as $bed)
                                @php
                                    $labelLower = strtolower($bed['label']);
                                    $icon = 'famicons_bed.svg'; // default

                                    if (str_contains($labelLower, 'sofa')) {
                                        $icon = 'mdi_sofa.svg';
                                    } elseif (str_contains($labelLower, 'bunk')) {
                                        $icon = 'mdi_bunk-bed.svg';
                                    }
                                @endphp

                                <div x-data="{ guests: 0 }"
                                    class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
                                    <div class="flex items-start gap-2">
                                        <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

                                        <div>
                                            <p class="text-sm font-medium">{{ $bed['label'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="if (guests > 0) guests--"
                                            class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
                                        <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
                                        <button type="button" @click="guests++"
                                            class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>



                    <!-- Tip Box Container (1/3 width) -->
                    <div x-data="{ showTip: true }" x-show="showTip" x-transition:leave="transition ease duration-300"
                        x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
                        class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit max-w-[300px] -ml-64">

                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help"
                                    class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                <h3 class="text-gray-700 text-sm font-bold">Do you offer other sleeping arrangements?
                                </h3>
                            </div>
                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Text Content Column -->
                        <div class="flex flex-col gap-4">
                            <p class="text-xs text-gray-700">
                                Right now, you just need to add your basic sleeping arrangements.
                                Cots, additional beds and other sleeping arrangements can be added in the extranet, the
                                platform you’ll use to manage your property.
                            </p>

                            <h3 class="text-gray-700 text-sm font-bold">Do you have specific policies for children?
                            </h3>

                            <p class="text-xs text-gray-700">
                                You can set up your property’s child policies, including maximum age and price
                                adjustments, in the extranet after you finish registration.
                            </p>
                        </div>
                    </div>



                    <div x-data="{ guests: 2,offerCots: 'yes', costType: 'Fixed', cotsAvailable: 1 }"
                        class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
                        <label class="block font-semibold text-sm text-gray-700 mb-2">How many guests can stay in this tent?</label>

                        <div class="flex items-center w-20 border rounded-md px-2 py-1">
                            <button type="button" @click="if (guests > 1) guests--"
                                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>

                            <span class="mx-4 text-lg font-semibold" x-text="guests"></span>

                            <button type="button" @click="guests++"
                                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
                        </div>
                         <!-- Children Policy -->

    
    <!-- Do you offer cots? -->
    <div>
        <p class="text-sm font-semibold text-gray-700 mb-1">Do you offer cots?</p>
        <p class="text-xs text-gray-500 mb-1">
            Cots sleep most infants 0–3 years old and can be made available to guests on request.
        </p>
        <label class="mr-4 text-sm">
            <input type="radio" name="offer_cots" value="yes" x-model="offerCots"> Yes
        </label>
        <label class="text-sm">
            <input type="radio" name="offer_cots" value="no" x-model="offerCots"> No
        </label>
    </div>

    <!-- Cots details - visible only if Yes -->
    <template x-if="offerCots === 'yes'">
        <div class="space-y-4">
            <!-- How many cots are available -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-1">How many cots are available?</p>
                <div class="flex items-center space-x-4 mt-1">
                    <button @click="if (cotsAvailable > 1) cotsAvailable--"
                        class="border px-3 py-1 rounded text-base">−</button>
                    <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="cotsAvailable"></span>
                    <button @click="cotsAvailable++"
                        class="border px-3 py-1 rounded text-base">+</button>
                </div>
            </div>

            <!-- Cost per night -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-1">How much does one cot cost per night?</p>
                <p class="text-xs text-gray-500">
                    This policy is set at the property level – any changes made will be applied to all apartments.
                </p>
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mt-2 space-y-2 sm:space-y-0">
                   <select x-model="costType" class="w-24 border border-gray-300 rounded-md px-2 py-2 text-sm">
    <option>Fixed</option>
    <option>Free</option>
</select>

                    <template x-if="costType === 'Fixed'">
                        <div class="flex items-center  px-1 py-1 w-full sm:w-auto">
                            <span class="text-gray-500 mr-1">US$</span>
                            <input type="number" step="0.01" class="w-full border rounded-md border-gray-300 text-sm" placeholder="0.00">
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>






                    <!-- Room Size -->
                    <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
                        <div class="flex flex-col lg:flex-row gap-4 items-end"> <!-- ensure vertical alignment -->

                            <!-- Apartment Size Dropdown -->
                            <div class="w-full lg:w-2/4">
                                <label class="block font-semibold text-sm text-gray-700 mb-1">How big is this
                                    room?</label>
                                <p class="text-xs text-gray-500 ">Room size - optional</p>

                                <input type="number" min="1" step="1" inputmode="numeric"
                                    pattern="\d*" x-model="propertyCount" name="property_count"
                                    class="w-full border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2">



                            </div>

                            <!-- Size Unit Dropdown -->
                            <div class="w-full lg:w-1/4">
                                <label class="block text-sm text-transparent mb-1">Unit</label>
                                <!-- invisible label for spacing -->
                                <select
                                    class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2  px-2 py-2">
                                    <option>square meters</option>
                                    <option>square feet</option>
                                </select>
                            </div>

                        </div>
                          
                        <label class="block font-semibold text-sm text-gray-700 mb-1">Is smoking allowed in this
                            tent?</label>
                        <div class="flex gap-6 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="smoking" class="form-radio text-blue-500" checked>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="smoking" class="form-radio text-blue-500">
                                <span class="ml-2">No</span>
                            </label>
                       
                    </div>
                    <!-- Smoking Allowed -->
                 
                    </div>



                    <!-- Navigation Buttons -->
                    <div class="lg:col-span-2  max-w-xl ml-32">
                        <div class="flex justify-between mt-6">

                            <!-- Back Button (Left-aligned) -->
                            <a href="{{ route('partner.hotels.create.2') }}">
                                <button type="button" @click="step > 1 ? step-- : step"
                                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                    class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded">
                                    ←
                                </button></a>

                            <!-- Continue Button (Right-aligned) -->
                            <button type="submit" @click="step < 9 ? step++ : step" :disabled="step === 9"
                                class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                                Continue
                            </button>

                        </div>
                    </div>

            </form>
</template>





        <template x-if="step === 2">
           <div class="max-w-3xl ml-32 mt-16">
                <!-- Bathroom Details Wrapper -->
                <div class="max-w-6xl mx-auto p-4 space-y-6">

                    <!-- Title -->
                    <h2 class="text-2xl font-bold">Bathroom details</h2>

                    <!-- Two-Column Layout: Main Content + Tip -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- Main Content Container -->
                        <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-300 space-y-6">

                            <!-- Bathroom Privacy -->
                            <div>
                                <label class="block font-semibold text-gray-700 mb-3">Is the bathroom private?</label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" name="bathroom_private"
                                            class="form-radio text-blue-500" checked>
                                        <span class="text-sm">Yes</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" name="bathroom_private"
                                            class="form-radio text-blue-500">
                                        <span class="text-sm">No, it's shared</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Bathroom Amenities -->
                            <div>
                                <hr class="my-4">
                                <label class="block font-semibold text-gray-700 mb-3">Which bathroom items are
                                    available in this tent?</label>

                                @php
                                    $amenities = [
                                        'Toilet paper',
                                        'Shower',
                                        'Toilet',
                                        'Hairdryer',
                                        'Bath',
                                        'Free toiletries',
                                        'Bidet',
                                        'Slippers',
                                        'Bathrobe',
                                        'Spa bath',
                                    ];
                                @endphp

                                <div class="space-y-2">
                                    @foreach ($amenities as $item)
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" class="form-checkbox text-blue-500">
                                            <span class="text-sm">{{ $item }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Tip Box Outside of Main Box -->
                        <div x-data="{ showTip: true }" x-show="showTip"
                            x-transition:leave="transition ease duration-300"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
                            class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit">
                            <div class="flex justify-between items-start">
                                <!-- Icon + Text -->
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon"
                                        class="w-5 h-5" />
                                    <strong class="font-semibold">Still deciding?</strong>
                                </div>
                                <button type="button" @click="showTip = false"
                                    class="text-gray-400 hover:text-black text-sm font-bold text-xl leading-none">
                                    &times;
                                </button>
                            </div>
                            <p class="mt-2">Don’t worry, you can update the bathroom items available at your place
                                later.</p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex  mt-6">
                        <!-- Back Button -->
                        <button type="button" @click="step < 9 ? step-- : step"
                            class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-50">
                            ←
                        </button>

                        <!-- Continue Button -->
                        <button type="submit" @click="step < 9 ? step++ : step"
                            class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[316px]">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
        </template>


        <template x-if="step === 3">
           <div class="max-w-3xl ml-32 mt-16">
        <!-- Bathroom Details Wrapper -->
        <div class="max-w-6xl mx-auto p-4 space-y-6">

            <!-- Title -->
            <h2 class="text-2xl font-bold">What can guests use in this room?</h2>

            <!-- Two-Column Layout: Main Content + Tip -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ viewSelected: false }">

                <!-- Main Content Container -->
                <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-300 space-y-6">

                    <!-- Bathroom Amenities -->
                    <div>
                        <label class="block font-semibold text-sm text-gray-700 mb-3">General Amenities</label>

                        @php
                            $amenities = [
                                'Towels',
                                'Linen',
                                'Seating Area',
                                'Heating',
                                'Air conditioning',
                                'Wardrobe or closet',
                                'Clothes rack',
                                'Flat-screen TV',
                            ];
                        @endphp

                        <div class="space-y-2">
                            @foreach ($amenities as $item)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="form-checkbox text-blue-500">
                                    <span class="text-sm">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <hr class="my-4">
                        <label class="block font-semibold text-sm text-gray-700 mb-3">Outdoors and Views</label>

                        @php
                            $outdoorAmenities = ['Outdoor dining area', 'Outdoor furniture', 'View'];
                        @endphp

                        <div class="space-y-2">
                            @foreach ($outdoorAmenities as $item)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox"
                                           class="form-checkbox text-blue-500"
                                           @if ($item === 'View')
                                               @click="viewSelected = $event.target.checked"
                                           @endif
                                    >
                                    <span class="text-sm">{{ $item }}</span>
                                </label>
                            @endforeach

                            <!-- Dropdown for View (Only shown if 'View' is checked) -->
                            <div x-show="viewSelected" x-transition>
                                <label class="block font-semibold text-sm text-gray-700">Select View Type</label>
                                <select class="form-select mt-1 block w-full border border-gray-300 rounded-lg p-2 text-sm">
                                    <option value="">Select view type</option>
                                   <option value="Sea view">Sea view</option>
<option value="Mountain view">Mountain view</option>
<option value="City view">City view</option>
<option value="Garden view">Garden view</option>
<option value="Pool view">Pool view</option>
<option value="Lake view">Lake view</option>
<option value="Landmark view">Landmark view</option>
<option value="River view">River view</option>
<option value="Inner courtyard view">Inner courtyard view</option>
<option value="Quiet street view">Quiet street view</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <hr class="my-4">
                        <label class="block font-semibold text-sm text-gray-700 mb-3">Food and Drink</label>

                        @php
                            $foodAmenities = [
                                'Barbecue',
                                'Dining table',
                                'Dining area',
                                'Electric kettle',
                                'Tea/Coffee maker',
                                'Refrigerator',
                                'Kitchenware',
                            ];
                        @endphp

                        <div class="space-y-2">
                            @foreach ($foodAmenities as $item)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="form-checkbox text-blue-500">
                                    <span class="text-sm">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tip Box -->
                <div x-data="{ showTip: true }" x-show="showTip"
                    x-transition:leave="transition ease duration-300"
                    x-transition:leave-start="opacity-100 max-h-screen"
                    x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
                    class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon"
                                class="w-5 h-5" />
                            <strong class="font-semibold">Still deciding?</strong>
                        </div>
                        <button type="button" @click="showTip = false"
                            class="text-gray-400 hover:text-black text-sm font-bold text-xl leading-none">
                            &times;
                        </button>
                    </div>
                    <p class="mt-2">Don’t worry, you can update the bathroom items available at your place later.</p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex mt-6">
                <!-- Back Button -->
                <button type="button" @click="step < 9 ? step-- : step"
                    class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-50">
                    ←
                </button>

                <!-- Continue Button -->
                <button type="submit" @click="step < 9 ? step++ : step"
                    class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[315px]">
                    Continue
                </button>
            </div>
        </div>
    </div>
        </template>
        <template x-if="step === 4">
        <div class="max-w-3xl ml-40 px-4 py-8 mt-10">
                <section class="mb-8">
                    <h1 class="text-2xl text-gray-700 font-bold mb-4">What’s the name of this room?</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                        <!-- Left Box (2/3 width) -->
                        <div class="md:col-span-2">
                            <div class="bg-white p-6 rounded shadow-md min-h-[450px] flex flex-col justify-start">
                                <div class="w-full">
                                    <p class="text-sm mb-4">
                                        This is the name that guests will see on your property page. Choose a name that
                                        most accurately describes this room.
                                    </p>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1 mt-6">Room
                                        Name</label>
                                    <select
                                        class="w-full border border-gray-300 text-sm rounded-md shadow-sm focus:ring focus:ring-blue-200 px-3 py-2">
                                        <option>Double Room</option>
                                        <option>Double Room with Balcony</option>
                                        <option>Double Room with Private Bathroom</option>
                                        <option>Budget Double Room</option>
                                        <option>Business Double Room with Gym Access</option>
                                        <option>Deluxe Double Room</option>
                                        <option>Deluxe Double Room (1 adult + 1 child)</option>
                                        <option>Deluxe Double Room (1 adult + 2 children)</option>
                                        <option>Deluxe Double Room (2 Adults + 1 Child)</option>
                                        <option>Deluxe Double Room with Balcony</option>
                                        <option>Deluxe Double Room with Balcony and Sea View</option>
                                        <option>Deluxe Double Room with Bath</option>
                                        <option>Deluxe Double Room with Castle View</option>
                                        <option>Deluxe Double Room with Extra Bed</option>
                                        <option>Deluxe Double Room with Sea View</option>
                                        <option>Deluxe Double Room with Shower</option>
                                        <option>Deluxe Double Room with Side Sea View</option>
                                        <option>Deluxe Double or Twin Room</option>
                                        <option>Deluxe King Room</option>
                                        <option>Deluxe Queen Room</option>
                                        <option>Deluxe Room</option>
                                        <option>Deluxe Room (1 adult + 1 child)</option>
                                        <option>Deluxe Room (1 adult + 2 children)</option>
                                        <option>Deluxe Room (2 Adults + 1 Child)</option>
                                        <option>Double Room (1 Adult + 1 Child)</option>
                                        <option>Double Room - Disability Access</option>
                                        <option>Double Room with Balcony (2 Adults + 1 Child)</option>
                                        <option>Double Room with Balcony (3 Adults)</option>
                                        <option>Double Room with Balcony and Sea View</option>
                                        <option>Double Room with Garden View</option>
                                        <option>Double Room with Lake View</option>
                                        <option>Double Room with Mountain View</option>
                                        <option>Double Room with Patio</option>
                                        <option>Double Room with Pool View</option>
                                        <option>Double Room with Private External Bathroom</option>
                                        <option>Double Room with Sea View</option>
                                        <option>Double Room with Shared Bathroom</option>
                                        <option>Double Room with Shared Toilet</option>
                                        <option>Double Room with Spa Bath</option>
                                        <option>Double Room with Terrace</option>
                                        <option>Queen Room - Disability Access</option>
                                        <option>Queen Room with Balcony</option>
                                        <option>Queen Room with Garden View</option>
                                        <option>Queen Room with Pool View</option>
                                        <option>Queen Room with Sea View</option>
                                        <option>Queen Room with Shared Bathroom</option>
                                        <option>Queen Room with Spa Bath</option>
                                        <option>Small Double Room</option>
                                        <option>Standard Double Room</option>
                                        <option>Standard Double Room with Fan</option>
                                        <option>Standard Double Room with Shared Bathroom</option>
                                        <option>Standard King Room</option>
                                        <option>Standard Queen Room</option>
                                        <option>Superior Double Room</option>
                                        <option>Superior King Room</option>
                                        <option>Superior Queen Room</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tip Box (1/3 width) -->
                        <div class="flex flex-col gap-4">
                            <div x-data="{ show: true }" x-show="show"
                                class="bg-white p-4 border border-gray-200 rounded w-full md:w-[300px] lg:w-[350px]">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                            alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                        <h3 class="text-gray-700 text-sm font-bold">Why can't I use a custom room name?
                                        </h3>
                                    </div>
                                    <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-700">
                                    Standardised room names have a lot of benefits over custom names:
                                </p>
                                <ul class="list-disc pl-6 text-sm text-gray-700 mt-2">
                                    <li>They’re more descriptive</li>
                                    <li>They're consistent across the site, allowing guests to quickly find and compare
                                        rooms</li>
                                    <li>They’re understood by guests from all backgrounds and nationalities</li>
                                    <li>They’re translated into 43 languages</li>
                                </ul>
                                <p class="text-sm text-gray-700 mt-4">
                                    After registration, you’ll have the option to add custom room names. Guests won’t
                                    see these, but they can be used for your internal reference.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex mt-6">
                        <button type="button" @click="step > 1 ? step-- : step"
                            :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                            ←
                        </button>
                        <button type="button" @click="step < 9 ? step++ : step"
                            class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[335px]">
                            Continue
                        </button>
                    </div>
                </section>
            </div>
        </template>


        <template x-if="step === 5">
           <div class="max-w-4xl ml-40 px-4 py-8 mt-6">
        <div class="max-w-4xl mx-auto px-4 py-8 space-y-6" x-data="{ showTip1: true, showTip2: true }">

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-800">Set the price per night for this mobile home</h2>

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

<div x-data="{ feedback: null }" class="pt-2 text-sm text-gray-700">
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
                        <select
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 focus:outline-none border border-gray-300 rounded-md">
                            <option value="usd">US$</option>
                            <option value="eur">€</option>
                            <option value="gbp">£</option>
                            <option value="lkr">Rs</option>
                        </select>

                        <!-- Input Field -->
                        <input type="text" value="120.00"
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

                    <p class="text-sm text-gray-800 font-medium border-t pt-3">US$17.00 Your earnings (including taxes)</p>
                </div>

            
            </div>

            <!-- Discount and Tip 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

               <!-- Discount card -->
<div x-data="{ showDiscount: false }" class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">

  <!-- Checkbox -->
  <label class="inline-flex items-center">
    <input type="checkbox" class="form-checkbox text-blue-600 rounded-md"
           @change="showDiscount = !showDiscount" />
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
        <del class="text-gray-500">US$ 20.00</del>
        <span class="text-green-600 font-semibold">US$ 16.00 per night</span>
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
                <button type="button" @click="step < 9 ? step++ : step"
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
                                    This policy is set at the property level – any changes made will be applied to all mobile homes.
                                </p>
                                      <p class="text-xs text-green-600 mb-4">
                                  You’re 91% more likely to get bookings with the pre-selected cancellation policy settings than with a 30-day cancellation policy
                                </p>
                                  
                            </div>
                            
   <a href="{{ route('partner.alternative.single.campsite.cancel-policies') }}">
                            
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

   <a href="{{ route('partner.boat.price.per.group') }}">
    <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">
        Edit
    </button>
</a>


                                
                      
                            </div>
                         <p class="text-xs text-amber-800 mb-4">
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
                                    <td class="py-2 text-sm">US$ 20.00</td>
                                </tr>
                                <tr>
                                    <td class="py-2">
                                        <div class="flex items-center gap-1">
                                            <img src="{{ asset('assets/guidance_user-1 (1).svg') }}" alt="User Icon"
                                                class="w-5 h-5">
                                            <span>x 1</span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-sm">US$ 20.00</td>
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
                        <a href="{{ route('partner.hotels.non.refundable.rate') }}">
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
                            <span>Guests cannot cancel their bookings for free at any time</span>
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
                          <a href="{{ route('partner.campsite.weekly.rate') }}">
                        <button
                            class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
                    </div>
                         <p class="text-xs text-green-600 mb-4 mt-4">
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
                    <a href="{{ route('partner.alternative.single.campsite.edit') }}">
                        <button
                            class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
                            Continue
                        </button></a>
                </div>


            </div>
        </template>






    </div>

</div>
@endsection