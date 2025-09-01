@extends('partner.partner-layout')

@section('title', 'Hotels Weekly Rate | ' . config('domains.app_name'))

@section('content')


 
 <!-- Horizontal Layout Container -->
<div class="max-w-3xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
<h2 class="text-3xl font-bold text-gray-900 mt-8">Bedroom 1</h2>
  <!-- Bed Types Container (2/3 width) -->
<div x-data="{ showMoreBeds: false }" class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ">
  <label class="block font-medium text-gray-700 mb-2">Which beds are available in this room?</label>

 @php
    $mainBeds = [
        ['label' => 'Single bed', 'desc' => '90 - 130 cm wide'],
        ['label' => 'Double bed', 'desc' => '131 - 150 cm wide'],
        ['label' => 'Large bed (King size)', 'desc' => '151 - 180 cm wide'],
        ['label' => 'Extra-large double bed (Super-king size)', 'desc' => '181 - 210 cm wide'],
    ];

    $extraBeds = [
        ['label' => 'Bunk bed', 'desc' => 'Variable size'],
        ['label' => 'Sofa bed', 'desc' => 'Variable size'],
        ['label' => 'Futon bed(s)', 'desc' => 'Variable size'],
    ];
@endphp


@foreach ($mainBeds as $bed)
  @php
      $labelLower = strtolower($bed['label']);
      $icon = 'famicons_bed.svg'; // default

      if (str_contains($labelLower, 'sofa')) {
          $icon = 'famicons_sofa.svg';
      } elseif (str_contains($labelLower, 'bunk')) {
          $icon = 'famicons_bunk-bed.svg';
      }
  @endphp

  <div x-data="{ guests: 0 }" class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

      <div>
        <p class="text-sm font-medium">{{ $bed['label'] }}</p>
        <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <button type="button" @click="if (guests > 0) guests--"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
      <button type="button" @click="guests++"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
    </div>
  </div>
@endforeach






  <!-- Toggle Link -->
  <button type="button"
          @click="showMoreBeds = !showMoreBeds"
          class="text-sm text-blue-600 hover:underline focus:outline-none">
    <span x-show="!showMoreBeds">More bed options ▼</span>
    <span x-show="showMoreBeds">Fewer bed options ▲</span>
  </button>

  <!-- Extra Beds -->
  <div x-show="showMoreBeds"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 max-h-0"
       x-transition:enter-end="opacity-100 max-h-screen"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 max-h-screen"
       x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
       class="space-y-4 pt-2">
@foreach ($extraBeds as $bed)
  @php
      $labelLower = strtolower($bed['label']);
      $icon = 'famicons_bed.svg'; // default

      if (str_contains($labelLower, 'sofa')) {
          $icon = 'mdi_sofa.svg';
      } elseif (str_contains($labelLower, 'bunk')) {
          $icon = 'mdi_bunk-bed.svg';
      }
  @endphp

  <div x-data="{ guests: 0 }" class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

      <div>
        <p class="text-sm font-medium">{{ $bed['label'] }}</p>
        <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <button type="button" @click="if (guests > 0) guests--"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
      <button type="button" @click="guests++"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
    </div>
  </div>
@endforeach

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
  <div class="pr-40"> <!-- This padding pulls it slightly to the left -->
    
   <a href="{{ route('partner.apartment.create.2') }}">
    <button
      type="button"
     
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
    >
      Continue
    </button>
    </a>
  </div>
</div>

@endsection