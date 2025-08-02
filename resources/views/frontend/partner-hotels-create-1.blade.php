
@extends('partner.partner-layout')

@section('title', ' Hotels Create | ' . config('domains.app_name'))

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ step: 1, selectedBox: null, unitType: null, showMore: false }">
    <!-- STEP 1 -->
    <div x-show="step === 1" x-cloak class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-2xl font-bold mb-6 mt-8">Which property category is most similar to your place?</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Main cards -->
                <template
                    x-for="(property, index) in [
          { id: 'hotel', title: 'Hotel', desc: 'Accommodation for travellers often offering restaurants, meeting rooms and other guest services' },
          { id: 'guesthouse', title: 'Guest house', desc: 'Private home with separate living facilities for host and guest' },
          { id: 'bnb', title: 'Bed and breakfast', desc: 'Private home offering overnight stays and breakfast' },
          { id: 'homestay', title: 'Homestay', desc: 'Private home with shared living facilities for host and guest' },
          { id: 'hostel', title: 'Hostel', desc: 'Budget accommodation with mostly dorm-style bedding and a social atmosphere' },
          { id: 'aparthotel', title: 'Aparthotel', desc: 'A self-catering apartment with some hotel facilities like a reception desk' },
          { id: 'capsule', title: 'Capsule hotel', desc: 'Extremely small units or capsules offering cheap and basic overnight accommodation' }
        ]"
                    :key="index">
                    <div @click="selectedBox = property.id"
                        :class="selectedBox === property.id ? 'border-2 border-blue-500 bg-blue-50' : 'border border-gray-300'"
                        class="flex flex-col justify-between min-h-[140px] h-full p-4 rounded cursor-pointer relative transition hover:shadow">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2" x-text="property.title"></h3>
                            <p class="text-sm text-gray-700" x-text="property.desc"></p>
                        </div>
                        <div class="absolute top-2 right-2" x-show="selectedBox === property.id">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </template>

                <!-- Extra cards -->
                <template x-if="showMore">
                    <template
                        x-for="(property, index) in [
            { id: 'countryhouse', title: 'Country house', desc: 'Private home with simple accommodation in the countryside' },
            { id: 'farm', title: 'Farm stay', desc: 'Private farm with simple accommodation' },
            { id: 'inn', title: 'Inn', desc: 'Small and basic accommodation with a rustic feel' },
            { id: 'lovehotel', title: 'Love hotel', desc: 'Adult-only accommodation rented per hour or night' },
            { id: 'motel', title: 'Motel', desc: 'Roadside hotel usually for motorists, with direct access to parking and little to no amenities' },
            { id: 'resort', title: 'Resort', desc: 'A place for relaxation with onsite restaurants, activities and often with a luxury feel' },
            { id: 'riad', title: 'Riad', desc: 'Traditional Moroccan accommodation with a courtyard and luxury feel' },
             { id: 'ryokan', title: 'Ryokan', desc: 'Traditional Japanese-style accommodation with meal options' },
                 { id: 'lodge', title: 'Lodge', desc: 'Private home with accommodation surrounded by nature, such as mountains or forest' }
          ]"
                        :key="index">
                        <div @click="selectedBox = property.id"
                            :class="selectedBox === property.id ? 'border-2 border-blue-500 bg-blue-50' :
                                'border border-gray-300'"
                            class="flex flex-col justify-between min-h-[140px] h-full p-4 rounded cursor-pointer relative transition hover:shadow">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2" x-text="property.title"></h3>
                                <p class="text-sm text-gray-700" x-text="property.desc"></p>
                            </div>
                            <div class="absolute top-2 right-2" x-show="selectedBox === property.id">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </template>
                </template>

                <!-- Toggle Button -->
                <div @click="showMore = !showMore"
                    class="border border-gray-300 rounded p-4 cursor-pointer text-blue-600 hover:bg-gray-50 flex items-center justify-center font-medium transition">
                    <span x-text="showMore ? '– Show less' : '+ More options'"></span>
                </div>
            </div>


        </div>
        <!-- Help Link -->
        <div class="mt-8 text-left">
            <a href="#" class="flex items-center space-x-2 text-sm text-blue-500 hover:underline">
                <img src="{{ asset('assets/iconoir_question-mark-circle.svg') }}" class="w-5 h-5" />
                <span class="text-base">I don't see my property type on the list</span>
            </a>

        </div>
        <template x-if="step === 1">
            <div class="flex items-center justify-between pt-4">
                <button type="button" @click="step = 1"
                    class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
                    ←
                </button>
                <button @click="if(selectedBox) step = 2" :disabled="!selectedBox"
                    :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                    class="py-3 px-8   rounded transition-all duration-200 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold"
                    type="button">
                    Continue
                </button>
            </div>
        </template>
    </div>

    <!-- STEP 2 -->
    <div x-show="step === 2" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
        <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow space-y-6 ">
            <h2 class="text-xl font-bold text-left">How many hotels are you listing?</h2>

            <div class="space-y-4">
                <!-- One -->
                <label :class="unitType === 'one' ? 'border-blue-500 border-2' : 'border-gray-300'"
                    class="block border rounded p-4 bg-white cursor-pointer" @click="unitType = 'one'">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/aprt-b.png') }}" class="w-14 h-10" />
                            <span class="text-base">One hotel with one or multiple rooms that guests can book</span>
                        </div>
                        <template x-if="unitType === 'one'">
                            <span class="text-blue-500 font-bold text-xl">✔</span>
                        </template>
                    </div>
                </label>

                <!-- Multiple -->
                <label :class="unitType === 'multiple' ? 'border-blue-500 border-2' : 'border-gray-300'"
                    class="block border rounded p-4 bg-white cursor-pointer" @click="unitType = 'multiple'">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/aprt-a.png') }}" class="w-14 h-10" />
                            <span class="text-base">Multiple hotels with one or multiple rooms that guests can
                                book</span>
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
                    class="border border-[#3CC0E9] text-[#3CC0E9] px-4 py-2 rounded font-semibold">← </button>
                <button @click="if(unitType) step = 3" :disabled="!unitType"
                    :class="!unitType ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                    class="text-white px-6 py-2 rounded font-semibold">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 3 -->
    <div x-show="step === 3" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
        <template x-if="unitType === 'one'">
            <div>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        One hotel where guests can book a room
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->

                    <div class="space-y-2">
                        <a href="{{ route('partner.hotels.create.2') }}">
                            <button type="button"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button></a>
                        <button type="button" @click="step = 2"
                            class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                            No, I need to make a change
                        </button>
                    </div>
        </template>

        <template x-if="unitType === 'multiple'">
            <div>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        Multiple hotels where guests can book a room
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->

                    <div class="space-y-2">
                        <a href="{{ route('partner.hotels.multiple') }}">
                            <button type="button"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button></a>
                        <button type="button" @click="step = 2"
                            class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                            No, I need to make a change
                        </button>
                    </div>
        </template>

    </div>

</div>
@endsection