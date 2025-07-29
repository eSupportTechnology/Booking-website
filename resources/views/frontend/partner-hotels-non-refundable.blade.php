@extends('partner.partner-layout')

@section('title', 'List Your Property')

@section('content')

<div x-data="{ enabled: true, showTip: true }" class="max-w-4xl mx-auto px-4 py-6 lg:ml-32 mt-6">
    <div class="lg:flex lg:items-start gap-8">
        <!-- Left/Main Content -->
        <div class="w-full lg:w-2/3 space-y-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Set up a non-refundable rate plan</h1>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-sm text-gray-700 mb-4">
                    In addition to the standard rate plan you've created for your property, you can add a weekly rate plan.
                </p>
              <p class="text-sm text-gray-700 mb-4">
  With this, you set a discounted price but <span class="font-semibold">your revenue for these bookings is guaranteed</span> as guests will not receive a refund if they cancel or don’t show up.
</p>


                <!-- Toggle -->
                <div class="flex items-center gap-2 mb-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="enabled" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <span class="text-sm text-gray-700 font-medium">Set up a non-refundable rate plan</span>
                </div>

                <!-- Discount Input and Price Summary -->
                <div x-show="enabled" x-transition class="overflow-x-auto">
                    <hr class="border-t border-gray-200 mt-4">
                    <p class="text-sm font-semibold text-gray-700 mt-4 mb-4">
                        How much cheaper than the standard rate would you like to make this rate plan?
                    </p>
                    <input type="number" value="10" class="w-[90%] border rounded px-2 py-2 text-left" /> %

                    <div class="mx-auto p-4 space-y-1">
                        <!-- Row 1 -->
                        <div class="flex items-start  text-sm text-gray-700 gap-x-4">
                            <span class="text-sm text-right font-semibold w-28">US$ 20.00</span>
                            <span class="flex-1">Best price</span>
                        </div>

                        <!-- Row 2 -->
                        <div class="flex items-start  text-sm text-gray-700 gap-x-4">
                            <span class="text-sm text-right font-semibold w-28">10%</span>
                            <span class="flex-1">Discount when guests book the non-refundable option</span>
                        </div>

                        <!-- Row 3 -->
                      <div class="flex items-start text-sm text-gray-700 gap-x-4 bg-blue-50 rounded px-3 py-2">
    <span class="text-sm text-right font-semibold w-28">US$ 18</span>
    <span class="flex-1">Non-refundable price</span>
</div>

                    </div>

                    <div class="flex items-start gap-2 mt-4 mb-4 text-gray-700">
                        <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Info" class="w-5 h-5 mt-1" />
                        <p class="text-sm">
                            Guests who select non-refundable rates are usually looking for competitive prices. A discount of at least 10% will attract more guests by improving your visibility.
                        </p>
                    </div>
                </div>
            </div>
             <div class="flex items-center justify-between pt-4">
                <button type="button" @click="step--"
                        class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-100 font-semibold py-2 px-4 rounded">
                    ←
                </button>
                <button type="button" @click="step = step + 1"
                        class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"> 
                    Save
                </button>
            </div>
        </div>

        <!-- Tip Box -->
        <template x-if="showTip">
    <div class="w-full lg:w-1/3 lg:mt-16">
                <div class="bg-white rounded-lg shadow-md p-4 relative">
                    <!-- Close Button -->
                    <button @click="showTip = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-sm">
                        ✕
                    </button>

                    <div class="flex flex-col space-y-2">
                        <!-- Row with icon and heading -->
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7" />
                            <h3 class="font-semibold text-sm text-gray-800">Why should I add a non-refundable rate plan?</h3>
                        </div>

                        <p class="text-sm text-gray-600">
                            A non-refundable rate plan can help attract guests who are sure of their dates and prefer to not pay extra for flexibility they don’t need.
                        </p>
                       <p class="text-sm text-gray-600">
  Properties with non-refundable rates receive on average:
</p>
<ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
  <li>11% more views</li>
  <li>5% more bookings</li>
  <li>9% fewer cancellations</li>
</ul>

                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

@endsection
