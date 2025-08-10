@extends('partner.partner-layout')

@section('title', ' Hotels Rooms | ' . config('domains.app_name'))

@section('content')
<div class="max-w-xl mx-auto px-4 lg:ml-32 mt-12">
<!-- Main Step 3 (Where else is your property listed?)-->
<div x-data="{
    selectedChannels: [],
    step: 3,
    get showImportSection() {
        return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
    },
    toggleChannel(channel) {
        if (channel === 'None') {
            this.selectedChannels = ['None'];
        } else {
            this.selectedChannels = this.selectedChannels.filter(c => c !== 'None');
            if (this.selectedChannels.includes(channel)) {
                this.selectedChannels = this.selectedChannels.filter(c => c !== channel);
            } else {
                this.selectedChannels.push(channel);
            }
        }
    }
}">
    <div class="bg-white max-w-xl w-full p-6 rounded-lg shadow space-y-6">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-900">Where else is your property listed?</h2>

        <!-- Info -->
        <p class="text-sm text-gray-700">
            If your property is listed on Airbnb or Vrbo, you can speed up registration by importing it
            directly to {{ config('domains.subdomain') }}.
        </p>

        <!-- Checkboxes -->
        <div class="space-y-4 text-left">
            <label class="flex items-center space-x-3">
                <input type="checkbox" value="Airbnb" :checked="selectedChannels.includes('Airbnb')"
                    @change="toggleChannel('Airbnb')"
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Airbnb</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="checkbox" value="TripAdvisor" :checked="selectedChannels.includes('TripAdvisor')"
                    @change="toggleChannel('TripAdvisor')"
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>TripAdvisor</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="checkbox" value="Vrbo" :checked="selectedChannels.includes('Vrbo')"
                    @change="toggleChannel('Vrbo')"
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Vrbo</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="checkbox" value="Another" :checked="selectedChannels.includes('Another')"
                    @change="toggleChannel('Another')"
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>Another website</span>
            </label>
            <label class="flex items-center space-x-3"
                :class="{ 'text-gray-400': selectedChannels.length > 0 && !selectedChannels.includes('None'), 'text-gray-900': selectedChannels.includes('None') }">
                <input type="checkbox" value="None" :checked="selectedChannels.includes('None')"
                    @change="toggleChannel('None')"
                    class="form-checkbox h-5 w-5 text-blue-600">
                <span>My property isn't listed on any other websites</span>
            </label>
        </div>

        <!-- Conditional Airbnb/Vrbo import section -->
        <div x-show="showImportSection" x-transition class="border-t pt-6 space-y-4">
            <h3 class="font-semibold text-gray-800">Import property details from Airbnb or Vrbo</h3>

            <label class="block text-sm font-medium text-gray-700">Paste the link to your Airbnb or Vrbo listing</label>
            <div x-data="{ url: '' }" class="flex gap-2">
                <input type="url" name="import_url" x-model="url"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                    placeholder="https://www.airbnb.com/rooms/xxxxx or https://www.vrbo.com/xxxxx"
                    required>
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
            </p>
            <a href="#" class="text-blue-600 text-sm hover:underline">Where can I find this link?</a>
        </div>

    </div>

    <!-- Navigation Buttons OUTSIDE the white container -->
    <div class="flex items-center justify-between mt-6">
        <button type="button" @click="step--"
            class="border border-[#3CC0E9] text-[#3CC0E9] hover:bg-blue-50 font-semibold py-2 px-4 rounded">
            ← 
        </button>
     
        <button type="button"
            @click="if(selectedChannels.length > 0) window.location.href='{{ route('partner.alternative.single.boat') }}'"
            :disabled="selectedChannels.length === 0"
            :class="selectedChannels.length === 0 ?
                'bg-gray-300 text-gray-400 cursor-not-allowed' :
                'bg-[#3CC0E9] hover:bg-[#29ACD5] text-white cursor-pointer'"
            class="font-semibold py-3 px-6 rounded transition duration-200">
            Continue 
        </button> 
    </div>
</div>
</div>
<!--Main Step 3 End-->
@endsection
