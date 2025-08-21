@extends('partner.partner-layout')

@section('title', 'Add Car | ' . config('domains.app_name'))

@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ step: 1 }">
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] border-r border-white h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 4) + '%'"></div>
    </div>



       <!-- Step 1: Car Type Image Selection -->
<template x-if="step === 1">
  <div class="px-6 py-8 mt-6 w-full max-w-4xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border" x-data="{ selectedImage: '', selectedCategory: '' }">
    
    

    <!-- Car Images Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <!-- Example car image -->
      
      <!-- Add other images as in your previous code -->
    </div>

    <!-- Taxi Type Section -->
    <div class="mt-6">
      <h2 class="text-xl font-semibold mb-2">Select Taxi Type</h2>
      <p class="text-gray-500 text-sm mb-4">Click on a taxi type to select it. Each type shows an example image.</p>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4">
        <!-- Standard -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'standard' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='standard'"
        >
          <img src="{{ asset('images/3.jpg') }}" alt="Standard" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">Standard</h3>
          <p class="text-gray-500 text-sm text-center">Regular car, 4 passengers.</p>
        </div>

        <!-- People Carrier -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'peopleCarrier' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='peopleCarrier'"
        >
          <img src="{{ asset('images/10.jpg') }}" alt="People Carrier" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">People Carrier</h3>
          <p class="text-gray-500 text-sm text-center">Larger car for 6–8 passengers.</p>
        </div>

        <!-- Large People Carrier -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'largePeopleCarrier' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='largePeopleCarrier'"
        >
          <img src="{{ asset('images/large.jpeg') }}" alt="Large People Carrier" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">Large People Carrier</h3>
          <p class="text-gray-500 text-sm text-center">More than 8 passengers.</p>
        </div>

        <!-- Minibus -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'minibus' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='minibus'"
        >
          <img src="{{ asset('images/mini.jpeg') }}" alt="Minibus" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">Minibus</h3>
          <p class="text-gray-500 text-sm text-center">12–20 passengers.</p>
        </div>

        <!-- Executive -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'executive' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='executive'"
        >
          <img src="{{ asset('images/2.jpg') }}" alt="Executive" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">Executive</h3>
          <p class="text-gray-500 text-sm text-center">Premium sedan, luxury for business passengers.</p>
        </div>

        <!-- Luxury -->
        <div 
          class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
          :class="selectedCategory === 'luxury' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
          @click="selectedCategory='luxury'"
        >
          <img src="{{ asset('images/bmw.jpeg') }}" alt="Luxury" class="w-full h-32 object-cover rounded-lg mb-2">
          <h3 class="font-semibold text-center">Luxury</h3>
          <p class="text-gray-500 text-sm text-center">High-end luxury cars (Mercedes, BMW, etc.).</p>
        </div>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between items-center mt-6">
      <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
      <button @click="step++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
    </div>
  </div>
</template>
    <!-- Step 2: Car Info -->
   <!-- Step 2: Airport Taxi Basic Information -->
<template x-if="step === 2">
    <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
        <h1 class="text-2xl font-bold">Enter Basic Information About the Taxi</h1>
        <p class="text-gray-500 text-sm mb-4">Provide details for the airport taxi you are registering.</p>

        <div class="space-y-4">
           

           

              <div>
                <label class="block font-semibold text-sm mb-1">
                    Number Plate <span class="text-red-500">*</span>
                </label>
                <input type="text" placeholder="e.g., WP-AB 1234" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Enter the taxi’s registration number plate.</p>
            </div>

               <div>
                <label class="block font-semibold text-sm mb-1">
                    Taxi Color <span class="text-red-500">*</span>
                </label>
                <input type="text" placeholder="e.g., White, Black, Silver" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Enter the color of the taxi.</p>
            </div>

            

            <!-- Seats -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Number of Passengers <span class="text-red-500">*</span>
                </label>
                <input type="number" placeholder="e.g., 4" class="w-full p-2 border rounded-md text-sm" min="1" max="50">
                <p class="text-gray-500 text-sm mt-1">Enter the maximum number of passengers the taxi can carry.</p>
            </div>

            <!-- Luggage / Suitcase Capacity -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Luggage Capacity <span class="text-gray-500">(Optional)</span>
                </label>
                <input type="number" placeholder="Number of suitcases" class="w-full p-2 border rounded-md text-sm" min="0" max="20">
                <p class="text-gray-500 text-sm mt-1">Enter the number of suitcases or luggage the taxi can hold.</p>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
            <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
            <button @click="step++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
        </div>
    </div>
</template>


  <!-- Step 3: Driver Details -->
<template x-if="step === 3">
    <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
        <h1 class="text-2xl font-bold mb-2">Provide Driver Details</h1>
        <p class="text-gray-500 text-sm mb-4">Enter the driver’s information for this taxi listing.</p>

        <div class="space-y-4">
            <!-- Driver Name -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Driver Name <span class="text-red-500">*</span>
                </label>
                <input type="text" placeholder="Enter Driver Name" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Full name of the taxi driver.</p>
            </div>

            <!-- Driver Contact Number -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Contact Number <span class="text-red-500">*</span>
                </label>
                <input type="text" placeholder="Enter Contact Number" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Mobile or phone number of the driver.</p>
            </div>

            <!-- Driver Email -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Email <span class="text-gray-500">(Optional)</span>
                </label>
                <input type="email" placeholder="Enter Email Address" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Driver’s email address if available.</p>
            </div>

            <!-- Driver License Number -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Driver License Number <span class="text-red-500">*</span>
                </label>
                <input type="text" placeholder="Enter License Number" class="w-full p-2 border rounded-md text-sm">
                <p class="text-gray-500 text-sm mt-1">Official driver’s license number.</p>
            </div>

            <!-- Driver Photo -->
            <div>
                <label class="block font-semibold text-sm mb-1">
                    Upload Driver Photo
                </label>
                <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*">
                <p class="text-gray-500 text-sm mt-1">Upload a clear photo of the driver.</p>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
            <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
            <button @click="step++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
        </div>
    </div>
</template>


   




    <!-- Step 4: Taxi Payment & Submit -->
<template x-if="step === 4">
    <div class="px-6 py-8 mt-6 w-full max-w-xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border" 
         x-data="{ pricingType: '', baseFare: '', pricePerKm: '', pricePerMinute: '', airportFee: 0, luggageFee: 0, nightSurcharge: 0 }">
        <h1 class="text-2xl font-bold mb-2">Set Taxi Fare & Complete Submission</h1>
        <p class="text-gray-500 text-sm mb-4">Specify how the taxi payment will be calculated for customers.</p>

        <!-- Pricing Type -->
        <div>
            <label class="block font-semibold text-sm mb-1">Select Fare Calculation Type <span class="text-red-500">*</span></label>
            <select x-model="pricingType" class="w-full p-2 border rounded-md text-sm">
                <option disabled selected>Select an option</option>
                <option value="perKm">Per Kilometer</option>
                <option value="perDay">Per Day</option>
            </select>
            <p class="text-gray-500 text-sm mt-1">Choose whether your taxi charges are per kilometer or per day.</p>
        </div>

        <div class="space-y-4 mt-4">

            <!-- Base Fare (Flag Fall) -->
            <div>
                <label class="block font-semibold text-sm mb-1">Base Fare (Flag Fall) <span class="text-red-500">*</span></label>
                <input type="number" x-model="baseFare" placeholder="e.g., 300" class="w-full p-2 border rounded-lg" step="0.01">
                <p class="text-gray-500 text-sm mt-1">The fixed starting price for the taxi ride.</p>
            </div>

            <!-- Price per km -->
            <div x-show="pricingType === 'perKm'" class="transition-all">
                <label class="block font-semibold text-sm mb-1">Price per Kilometer <span class="text-red-500">*</span></label>
                <input type="number" x-model="pricePerKm" placeholder="e.g., 50" class="w-full p-2 border rounded-lg" step="0.01">
                <p class="text-gray-500 text-sm mt-1">Cost for each kilometer traveled.</p>
            </div>

            <!-- Price per day -->
            <div x-show="pricingType === 'perDay'" class="transition-all">
                <label class="block font-semibold text-sm mb-1">Price per Day <span class="text-red-500">*</span></label>
                <input type="number" x-model="pricePerDay" placeholder="e.g., 16,000" class="w-full p-2 border rounded-lg" step="0.01">
                <p class="text-gray-500 text-sm mt-1">Daily rental price if taxi is booked for full day.</p>
            </div>

           
            <!-- Optional: Extra Fees -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-sm mb-1">Airport Fee (Optional)</label>
                    <input type="number" x-model="airportFee" placeholder="e.g., 200" class="w-full p-2 border rounded-lg" step="0.01">
                </div>
                <div>
                    <label class="block font-semibold text-sm mb-1">Luggage Fee (Optional)</label>
                    <input type="number" x-model="luggageFee" placeholder="e.g., 50 per suitcase" class="w-full p-2 border rounded-lg" step="0.01">
                </div>
            </div>

            

        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
            <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
            <button type="submit" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Submit</button>
        </div>
    </div>
</template>


</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
