@extends('partner.partner-layout')

@section('title', 'Hotels Weekly Rate | ' . config('domains.app_name'))

@section('content')
 
<div x-data="{ showMoreBeds: false }" class="max-w-2xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  <h2 class="text-3xl font-bold text-gray-900 mt-8">Other spaces</h2>

  <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
    <p class="text-lg font-medium text-gray-800 mb-4">Which beds are available in this room?</p>

    <!-- Main Bed Options -->
  <div class="space-y-4">
  @foreach([
      ['label' => 'Single bed', 'size' => '90 - 130 cm wide', 'icon' => 'mdi_bed-single (1)'],
      ['label' => 'Double bed', 'size' => '131 - 150 cm wide', 'icon' => 'famicons_bed'],
      ['label' => 'Large bed (King size)', 'size' => '151 - 180 cm wide', 'icon' => 'famicons_bed'],
      ['label' => 'Extra-large double bed (Super-king size)', 'size' => '181 - 210 cm wide', 'icon' => 'famicons_bed'],
  ] as $index => $bed)
    <div x-data="{ count: 0 }" class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <!-- Icon container to align all icons horizontally -->
        <div class="w-12 h-12 flex items-center justify-center">
          <img 
            src="{{ asset('assets/' . $bed['icon'] . '.svg') }}" 
            alt="Bed Icon"
            class="{{ $bed['label'] === 'Single bed' ? 'w-9 h-9 md:w-9 md:h-9' : 'w-6 h-6 md:w-7 md:h-7' }}"
          />
        </div>

        <div>
          
            <p class="font-medium text-gray-800">{{ $bed['label'] }}</p>
            <p class="text-sm text-gray-500">{{ $bed['size'] }}</p>
          </div>
        </div>

        <!-- Quantity selector -->
        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            @click="if (count > 0) count--"
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
     @endforeach
    </div>

    <!-- Toggle button -->
    <div class="mt-4">
      <button @click="showMoreBeds = !showMoreBeds"
              class="text-blue-600 text-sm font-medium hover:underline focus:outline-none">
        <span x-show="!showMoreBeds">More bed options</span>
        <span x-show="showMoreBeds">Hide extra options</span>
      </button>
    </div>

    <!-- More Bed Options -->
    <div x-show="showMoreBeds" x-transition class="space-y-4 mt-4">
     @foreach([
        ['label' => 'Bunk bed', 'size' => 'Variable size', 'icon' => 'mdi_bunk-bed'],
        ['label' => 'Sofa bed', 'size' => 'Variable size', 'icon' => 'mdi_sofa'],
        ['label' => 'Futon bed', 'size' => 'Variable size', 'icon' => 'famicons_bed'],
     ] as $index => $bed)
      <div x-data="{ count: 0 }" class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
           <div class="w-12 h-12 flex items-center justify-center">
           <img src="{{ asset('assets/' . $bed['icon'] . '.svg') }}" alt="Bed Icon" class="w-6 h-6 md:w-7 md:h-7" />
        </div>

          <div>
            <p class="font-medium text-gray-800">{{ $bed['label'] }}</p>
            <p class="text-sm text-gray-500">{{ $bed['size'] }}</p>
          </div>
        </div>

        <!-- Quantity selector -->
        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            @click="if (count > 0) count--"
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
     @endforeach
    </div>
  </div>

  <!-- Action buttons -->
  <div class="flex justify-between pt-4">
    <button class="border border-[#3CC0E9] text-blue-600 font-medium px-6 py-2 rounded hover:bg-gray-50">
       ←
    </button>
    <button class="bg-[#3CC0E9] text-white font-semibold px-8 py-2 rounded  hover:bg-blue-700">
      Save
    </button>
  </div>
</div>


@endsection