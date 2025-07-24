@extends('frontend.partner-layout')

@section('title', 'Pricing Non-Refundable Rate')

@section('content')
<div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">
    <h2 class="text-2xl font-bold text-left mb-6">What can guests book?</h2>
    <div class="bg-white max-w-xl w-full p-6 rounded-lg shadow" x-data="{ selected: '', step: 1 }">
        <!-- Option 1 -->
        <label :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="relative block rounded p-4 cursor-pointer transition bg-white mb-4"
            @click="selected = 'one'">
            <!-- ✔ Tick -->
            <template x-if="selected === 'one'">
                <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
            </template>

            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="One Apartment"
                    class="w-10 h-8" />
                <div>
                    <span class="text-base font-bold text-gray-800">Entire place</span>
                    <p class="text-xs text-gray-800">
                        Guests are able to use the entire place and do not have to share this with the host or other guests.
                    </p>
                </div>
            </div>
            <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
        </label>

        <!-- Option 2 -->
        <label :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="relative block rounded p-4 cursor-pointer transition bg-white"
            @click="selected = 'multiple'">
            <!-- ✔ Tick -->
            <template x-if="selected === 'multiple'">
                <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
            </template>

            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/alternative-places.png') }}" alt="Multiple Apartments"
                    class="w-10 h-8" />
                <div>
                    <span class="text-base font-bold text-gray-800">A private room</span>
                    <p class="text-xs text-gray-800">
                        Guests rent a room within the property. There are common areas that are either shared with the host or other guests.
                    </p>
                </div>
            </div>
            <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
        </label>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between pt-4">
            <button type="button"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded opacity-50 cursor-not-allowed"
                disabled>
                ←
            </button>
            <button type="button"
                @click="
                    if (selected === 'one') {
                        window.location.href = '{{ route('partner.alternative.entireplace') }}';
                    } else if (selected === 'multiple') {
                        window.location.href = '{{ route('partner.alternative.privateroom') }}';
                    }
                "
                class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"
                :disabled="selected === ''"
                :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''">
                Continue
            </button>
        </div>
    </div>
</div>
@endsection
