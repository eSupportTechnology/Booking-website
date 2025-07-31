@extends('partner.partner-layout')

@section('title', ' Apartment Bedrooms | ' . config('domains.app_name'))

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

 <!-- Horizontal Layout Container -->
<div x-data="{
    beds: {{ json_encode($bedTypes->map(fn($bed) => ['id' => $bed->id, 'name' => $bed->name, 'count' => 0])) }},
    showMoreBeds: false,
    isLoading: false,
    increment(bedId) {
        const bed = this.beds.find(b => b.id === bedId);
        if (bed) {
            bed.count++;
        }
    },
    decrement(bedId) {
        const bed = this.beds.find(b => b.id === bedId);
        if (bed && bed.count > 0) {
            bed.count--;
        }
    },
    async save() {
        this.isLoading = true;
        const payload = {
            room_name: 'Bedroom 1', // Or make this dynamic if needed
            beds: this.beds.filter(b => b.count > 0)
        };
        try {
            let res = await fetch('{{ route('partner.property.bedroom.store', $property) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify(payload)
            });
            let data = await res.json();
            if (res.ok && data.success) {
                window.location.href = '{{ route('partner.property.step2', ['category' => 'apartment', 'property' => $property->id]) }}';
            } else {
                alert('Error: ' + (data.message || 'Could not save bedroom.'));
            }
        } catch (err) {
            alert('AJAX error: ' + err.message);
        } finally {
            this.isLoading = false;
        }
    }
}" class="max-w-3xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
<h2 class="text-3xl font-bold text-gray-900 mt-8">Bedroom 1</h2>
  <!-- Bed Types Container (2/3 width) -->
<div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ">
  <label class="block font-medium text-gray-700 mb-2">Which beds are available in this room?</label>

 @php
    $mainBeds = $bedTypes->take(4);
    $extraBeds = $bedTypes->slice(4);
@endphp


@foreach ($mainBeds as $bed)
  <div class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/famicons_bed.svg') }}" alt="Icon" class="w-5 h-5" />
      <div>
        <p class="text-sm font-medium">{{ $bed->name }}</p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" @click="decrement({{ $bed->id }})"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="beds.find(b => b.id === {{ $bed->id }}).count"></span>
      <button type="button" @click="increment({{ $bed->id }})"
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
    <div class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
      <div class="flex items-start gap-2">
        <img src="{{ asset('assets/famicons_bed.svg') }}" alt="Icon" class="w-5 h-5" />
        <div>
          <p class="text-sm font-medium">{{ $bed->name }}</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <button type="button" @click="decrement({{ $bed->id }})"
                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
        <span class="mx-4 text-sm font-semibold" x-text="beds.find(b => b.id === {{ $bed->id }}).count"></span>
        <button type="button" @click="increment({{ $bed->id }})"
                class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
      </div>
    </div>
  @endforeach
</div>

  </div>

  
</div>
<div class="mt-8 flex justify-between items-center">
  <a href="{{ url('/partner/property/apartment/step2/' . $property->id) }}">
    <!-- Back Button -->
    <button type="button" class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
    </button>
  </a>

  <!-- Continue Button slightly aligned to the left -->
  <div class="pr-40"> <!-- This padding pulls it slightly to the left -->
    
   
    <button
      type="button"
      @click="save"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
    >
      Save and Continue
    </button>
    
  </div>
</div>



@endsection