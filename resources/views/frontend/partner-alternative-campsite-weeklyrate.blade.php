@extends('partner.partner-layout')

@section('title', 'Hotels Weekly Rate | ' . config('domains.app_name'))

@section('content')

<div x-data="{ enabled: true, showTip: true }" class="max-w-6xl mx-auto px-4 py-6 lg:ml-32 mt-6">
    <div class="lg:flex lg:items-start gap-8">
        
        <!-- Left/Main Content -->
        <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <!-- Header -->
            <h1 class="text-2xl font-bold text-gray-800 mb-4 mt-2">Set up a weekly rate</h1>
            
            <p class="text-sm text-gray-700 mb-4">
                In addition to the standard rate plan you've created for your property, you can add a weekly rate plan.
            </p>
            <p class="text-sm text-gray-700 mb-4">
                With this, you set a discounted price and use the same cancellation policy as the standard rate plan. 
                Guests who stay for at least a week are interested in discounts since they’ll be spending more on their overall booking.
            </p>

            <!-- Toggle -->
            <div class="flex items-center gap-2 mb-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="enabled" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full 
                        peer peer-checked:after:translate-x-full peer-checked:after:border-white 
                        after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white 
                        after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                        peer-checked:bg-blue-600">
                    </div>
                </label>
                <span class="text-sm text-gray-700 font-medium">Set up a weekly rate plan</span>
            </div>

            <!-- Input -->
            <div x-show="enabled" x-transition>
                <hr class="border-t border-gray-200 mt-4">
                <p class="text-sm font-semibold text-gray-700 mt-4 mb-4">
                    How much cheaper than the standard rate would you like to make this rate plan?
                </p>
                <div class="flex items-center gap-2">
                    <input type="number" value="15" class="w-24 border rounded px-2 py-2 text-left" /> %
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between pt-6">
                <button type="button"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-100 font-semibold py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="button"
                        class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
                    Save
                </button>
            </div>
        </div>

        <!-- Tip Box -->
        <template x-if="showTip">
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-4 relative">
                    <!-- Close Button -->
                    <button @click="showTip = false"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-sm">
                        ✕
                    </button>

                    <div class="flex flex-col space-y-2">
                        <!-- Row with icon and heading -->
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7" />
                            <h3 class="font-semibold text-sm text-gray-800">Why should I add a weekly rate plan?</h3>
                        </div>

                        <p class="text-sm text-gray-600">
                            A weekly rate plan can help you stand out to a range of guests, from business people to families, looking for competitive prices.
                        </p>
                        <p class="text-sm text-gray-600">
                            Properties with weekly rates receive on average:
                        </p>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                            <li>5% more views</li>
                            <li>15% more bookings</li>
                            <li>37% more guests booking for a week or longer</li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

@endsection
