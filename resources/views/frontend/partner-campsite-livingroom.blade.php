@extends('partner.partner-layout')

@section('title', 'Hotels Weekly Rate | ' . config('domains.app_name'))

@section('content')
 
  
 <!-- Horizontal Layout Container -->
<div class="max-w-xl  mt-16 px-4 sm:px-6 lg:ml-32">
    <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-8">Living room</h2>
  <!-- Bed Row -->
  <div x-data="{ count: 1 }" class="bg-white border border-gray-300 rounded-lg p-6 flex justify-between items-center shadow-sm">
    <!-- Icon and Label -->
    <div class="flex items-center gap-3">
        <img src="{{ asset('assets/mdi_sofa.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 " />
      <span class="font-medium text-gray-800">Sofa bed</span>
    </div>

    <!-- Counter -->
    <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
      <button
        type="button"
        @click="if(count > 0) count--"
        class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
      >−</button>
      <span class="w-10 text-center text-gray-900 font-medium" x-text="count"></span>
      <button
        type="button"
        @click="count++"
        class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
      >+</button>
    </div>
  </div>

  <div class="mt-8 flex justify-between items-center">
     <a href="{{ route('partner.apartment.create.2') }}">
  <!-- Back Button on the left -->
  <button
    type="button"
  
    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded"
  >
    ←
  </button></a>

  <!-- Continue Button slightly aligned to the left -->
  <div class="pr-30"> <!-- This padding pulls it slightly to the left -->
    
 
    <button
      type="button"
     
      class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
    >
      Save
    </button>
   
  </div>
</div>


@endsection