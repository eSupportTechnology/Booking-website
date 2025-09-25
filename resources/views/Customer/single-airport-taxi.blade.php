@extends('frontend.master')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex flex-col lg:flex-row gap-8">

    <!-- Left Column: Image Grid -->
    <div class="flex-1 grid gap-4">
      
      <!-- Row 1: Front Image -->
      @if($taxi->front_image)
      <div class="w-full">
        <img src="{{ asset('storage/'.$taxi->front_image) }}" 
             alt="Front View"
             class="w-full h-auto rounded-lg object-cover cursor-pointer"
             onclick="openModal('{{ asset('storage/'.$taxi->front_image) }}')">
      </div>
      @endif

      <!-- Row 2: Inside & Back Images -->
      <div class="grid grid-cols-2 gap-4">
        @if($taxi->inside_image)
        <img src="{{ asset('storage/'.$taxi->inside_image) }}" 
             alt="Inside View"
             class="w-full h-auto rounded-lg object-cover cursor-pointer"
             onclick="openModal('{{ asset('storage/'.$taxi->inside_image) }}')">
        @endif

        @if($taxi->back_image)
        <img src="{{ asset('storage/'.$taxi->back_image) }}" 
             alt="Back View"
             class="w-full h-auto rounded-lg object-cover cursor-pointer"
             onclick="openModal('{{ asset('storage/'.$taxi->back_image) }}')">
        @endif
      </div>

      <!-- Fallback if no images -->
      @if(!$taxi->front_image && !$taxi->inside_image && !$taxi->back_image)
      <div class="w-full">
        <img src="{{ asset('images/placeholder-car.jpg') }}" 
             alt="No Image"
             class="w-full h-auto rounded-lg object-cover cursor-pointer"
             onclick="openModal('{{ asset('images/placeholder-car.jpg') }}')">
      </div>
      @endif

    </div>

    <!-- Right Column: Vehicle & Driver Details -->
    <div class="flex-1">
      <!-- Vehicle Details -->
      <div class="bg-white p-6 rounded-lg shadow-md border border-gray-400 mb-6">
        <h2 class="text-lg font-semibold mb-4">Vehicle Details</h2>
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
          <div><strong class="text-sm text-gray-500">Brand and Model:</strong><br>{{ $taxi->taxiType->name ?? 'Taxi' }}</div>
          <div><strong class="text-sm text-gray-500">Number Plate:</strong><br>{{ $taxi->number_plate ?? 'N/A' }}</div>
          <div><strong class="text-sm text-gray-500">Vehicle Color:</strong><br>{{ $taxi->color ?? 'N/A' }}</div>
          <div><strong class="text-sm text-gray-500">Passenger Capacity:</strong><br>{{ $taxi->passenger_capacity ?? 0 }}</div>
          <div><strong class="text-sm text-gray-500">Luggage Capacity:</strong><br>{{ $taxi->luggage_capacity ?? 0 }}</div>
        </div>
      </div>

      <!-- Driver Details -->
      @foreach($taxi->drivers as $driver)
      <div class="bg-white p-6 rounded-lg shadow-md border border-gray-400 mb-6">
        <h2 class="text-lg font-semibold mb-4">Driver Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
          @php
            $photoFile = $driver->photo ? \App\Models\File::find($driver->photo) : null;
          @endphp

          <div class="flex items-center justify-center">
            @if($photoFile?->path)
              <img src="{{ asset('storage/' . $photoFile->path) }}"
                   alt="{{ $driver->name }}"
                   class="w-32 h-32 rounded-full object-cover shadow">
            @else
              <img src="{{ asset('images/user.jpeg') }}"
                   alt="Default Profile"
                   class="w-32 h-32 rounded-full object-cover shadow">
            @endif
          </div>

          <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Name</p>
              <p class="font-medium text-gray-800">{{ $driver->name ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Contact Number</p>
              <p class="font-medium text-gray-800">{{ $driver->contact_number ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Email</p>
              <p class="font-medium text-gray-800">{{ $driver->email ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">License Number</p>
              <p class="font-medium text-gray-800">{{ $driver->license_number ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</div>

<!-- Modal for Image Preview -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
  <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
  <img id="modalImage" src="" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
</div>

@endsection

<script>
  function openModal(src) {
    document.getElementById("imageModal").classList.remove("hidden");
    document.getElementById("modalImage").src = src;
  }
  function closeModal() {
    document.getElementById("imageModal").classList.add("hidden");
  }
</script>
