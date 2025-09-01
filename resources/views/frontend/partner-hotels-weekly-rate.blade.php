@extends('partner.partner-layout')

@section('title', ' Hotels Weekly Rate | ' . config('domains.app_name'))

@section('content')

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
 

<div x-data="{ enabled: true }" class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  <!-- Header -->
  
    <h1 class="text-2xl font-bold text-gray-800 mb-4 mt-6">Set up a weekly rate</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <p class="text-sm text-gray-700 mb-4">
    In addition to the standard rate plan you've created for your property, you can add a weekly rate plan.
    </p>
    <p class="text-sm text-gray-700 mb-4">
      With this, you set a discounted price and use the same cancellation policy as the standard rate plan. Guests who stay for at least a week are interested in discounts since they’ll be spending more on their overall booking.
    </p>

    <!-- Toggle -->
    <div class="flex items-center gap-2 mb-4">
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" x-model="enabled" class="sr-only peer">
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
      </label>
      <span class="text-sm text-gray-700 font-medium">Set up a weekly rate plan</span>
    </div>

   

    
    <!-- Table -->
    <div x-show="enabled" x-transition class="overflow-x-auto">
        <hr class="border-t border-gray-200 mt-4">
      <p class="text-sm font-semibold text-gray-700 mt-4 mb-4">
  How much cheaper than the standard rate would you like to make this rate 
plan?
    </p>
              <input type="number" value="10" class="w-[90%] border rounded px-2 py-2 text-left" /> %
            
      
    </div>

    <!-- Buttons -->
   
  </div>
   <div class="flex justify-between mt-6 ">
    <!-- Back Button -->
<button
  type="button"
 @click="propertyWizardStep--"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end ">
    <button
      type="submit"
    @click="propertyWizardStep++"
      class="px-12 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
      Save
    </button>
  </div>

  </div>
</div>
@endsection