@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')

<div x-data="
    {
        step: 1,
        selected: '',
        sameAddress: 'yes',
        propertyCount: 2,
        apartmentType: '',
        propertyId: '{{ $property->id }}',
        subtypeName: '{{ $property_subtype->name }}',
        subtypeId: '{{ $property_subtype->id }}',

        continueFromStep1() {
            if (!this.selected) {
                alert('Please select an option.');
                return;
            }

            const addressTypeId = this.selected === 'one' ? 1 : 2;

            fetch(`/partner/property/{{ $property->category_id }}/step2/{{ $property->id }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    address_type_id: addressTypeId,
                    property_id: {{ $property->id }},
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to save address type');
                }
                return response.json();
            })
            .then(data => {
                console.log('Saved address_type:', data);
                this.apartmentType = this.selected;
                this.step++;
            })
            .catch(error => {
                console.error(error);
                alert('Something went wrong while saving address type');
            });
        }
        ,

        continueFromStep2() {
            console.log('Continuing from step 2 with apartment type:', this.apartmentType);
            console.log('Property ID:', this.propertyId);
            console.log('Subtype ID:', this.subtypeId);
            
            this.$refs.form.action = this.apartmentType === 'one'
                ? '{{ route('partner.homes.single') }}'
                : '{{ route('partner.homes.multiple') }}';
            this.$refs.form.submit();
        }

    }"
    class="container mx-auto  px-4 sm:px-6 lg:px-8 py-10">
    <form id="homesForm" method="POST" action="" x-ref="form">
        @csrf
        <input type="hidden" name="propertyId" :value="propertyId">
        <input type="hidden" name="subtypeId" :value="subtypeId">
    </form>

    <!-- Step 1 -->
    <div x-show="step === 1" x-cloak class="max-w-2xl lg:ml-16 mt-12 mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-6">How many <span x-text="subtypeName.toLowerCase()"></span>s are you listing?</h2>

        <div class="space-y-4">
            <!-- One Guest House -->
            <label :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                class="block rounded p-4 cursor-pointer transition bg-white" @click="selected = 'one'">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/aprt-b.png') }}" alt="One Guest House" class="w-14 h-10" />
                        <span class="text-base text-gray-800">One <span x-text="subtypeName.toLowerCase()"></span> with one or multiple rooms that guests can book</span>
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
                        <span class="text-base text-gray-800">Multiple <span x-text="subtypeName.toLowerCase()"></span> with one or multiple rooms that guests can book</span>
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
    <div x-show="step === 2" x-cloak>


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
                        One <span x-text="subtypeName.toLowerCase()"></span> where guests can book a room
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
                        Multiple <span x-text="subtypeName.toLowerCase()"></span> where guests can book a room
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