@extends('partner.partner-layout')

@section('title', ' Hotels Price Per Group | ' . config('domains.app_name'))

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
 

<div x-data="{ enabled: true }" class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
       <h1 class="text-2xl font-bold text-gray-800 mb-4">Price per group size</h1>
  <!-- Header -->
  <div class="bg-white p-6 rounded-lg shadow-md">
  

    <p class="text-sm text-gray-700 mb-1">
      Offering lower rates for groups of less than 2 makes your property more attractive to potential guests.
    </p>
    <p class="text-sm text-gray-700 mb-4">
      The recommended discounts are based on data from properties like yours. These can be updated at any time.
    </p>

    <!-- Toggle -->
    <div class="flex items-center gap-2 mb-4">
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" x-model="enabled" class="sr-only peer">
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
      </label>
      <span class="text-sm text-gray-700 font-medium">Enabled</span>
    </div>

    <!-- Table -->
    <div x-show="enabled" x-transition class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-700 border">
        <thead class="bg-white text-gray-900  text-sm font-semibold">
          <tr>
            <th class="px-4 py-2">Occupancy</th>
            <th class="px-4 py-2">Discount</th>
            <th class="px-4 py-2">Guests pay</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-t">
            <td class="px-4 py-2">2 guests</td>
            <td class="px-4 py-2">0%</td>
            <td class="px-4 py-2">US$ 120.00</td>
          </tr>
          <tr class="bg-white border-t">
            <td class="px-4 py-2">1 guest</td>
            <td class="px-4 py-2">
              <input type="number" value="10" class="w-16 border rounded px-2 py-1 text-center" /> %
            </td>
            <td class="px-4 py-2">US$ 108.00</td>
          </tr>
        </tbody>
      </table>
    </div>

   
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
@endsection