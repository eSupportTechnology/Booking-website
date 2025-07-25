@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')

<div x-data="{
    step: 1,
    selected: '',
    sameAddress: 'yes',
    propertyCount: 2,
    apartmentType: '',

    continueFromStep1() {
        if (!this.selected) {
            alert('Please select an option.');
            return;
        }
        this.apartmentType = this.selected;
        this.step++;
    },

    continueFromStep2() {
        if (this.apartmentType === 'one') {
            window.location.href = '{{ route('partner.homes.single') }}';
        } else if (this.apartmentType === 'multiple') {
            window.location.href = '{{ route('partner.homes.multiple') }}';
        }
    }
}" class="container mx-auto  px-4 sm:px-6 lg:px-8 py-10">

    <!-- Step 1 -->
    <div x-show="step === 1" x-cloak class="max-w-2xl lg:ml-16 mt-12 mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-6">How many guest houses are you listing?</h2>

        <div class="space-y-4">
            <!-- One Guest House -->
            <label :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                   class="block rounded p-4 cursor-pointer transition bg-white" @click="selected = 'one'">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/aprt-b.png') }}" alt="One Guest House" class="w-14 h-10" />
                        <span class="text-base text-gray-800">One guest house with one or multiple rooms that guests can book</span>
                    </div>
                    <template x-if="selected === 'one'">
                        <div class="text-blue-600 text-xl font-bold">✔</div>
                    </template>
                </div>
                <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
            </label>

            <!-- Multiple Apartments -->
            <label :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                   class="block rounded p-4 cursor-pointer transition bg-white" @click="selected = 'multiple'">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/aprt-a.png') }}" alt="Multiple Apartments" class="w-14 h-10" />
                        <span class="text-base text-gray-800">Multiple guest houses with one or multiple rooms that guests can book</span>
                    </div>
                    <template x-if="selected === 'multiple'">
                        <div class="text-blue-600 text-xl font-bold">✔</div>
                    </template>
                </div>
                <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
            </label>
        </div>

        <!-- Extra fields for "Multiple" -->
        <div x-show="selected === 'multiple'" x-transition class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
            

            <!-- Property count -->
            <div>
                <label class="block font-medium mb-1">Number of properties</label>
                <input type="number" min="2" x-model="propertyCount" name="property_count"
                       class="border rounded w-full sm:w-32 p-2" />
            </div>
        </div>

        <!-- Step 1 Buttons -->
        <div class="flex items-center justify-between pt-6">
            <button type="button" @click="step--"
                      class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
                ← 
            </button>
            <button type="button" @click="continueFromStep1"
                 class="py-3 px-8   rounded transition-all duration-200 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold">
                Continue 
            </button>
        </div>
    </div>

    <!-- Step 2 -->
    <div x-show="step === 2" x-cloak >
       

        <div class="text-center text-gray-700 mb-6">
            <template x-if="apartmentType === 'one'">
                 <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        One guest house where guests can book a room
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <template x-if="step === 2">
                        <div class="space-y-2">
                            <button @click="continueFromStep2"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button>
                            <button @click="step--"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </template>

                </div>
            </template>
            <template x-if="apartmentType === 'multiple'">
                  <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                     Multiple guest houses where guests can book a room
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <template x-if="step === 2">
                        <div class="space-y-2">
                            <button @click="continueFromStep2"
                                class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                Continue
                            </button>
                            <button @click="step--"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </template>

                </div>
            </template>
        </div>

       
    </div>
</div>

@endsection
