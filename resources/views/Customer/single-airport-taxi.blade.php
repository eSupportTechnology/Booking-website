@extends('frontend.master')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
 <!-- Top Bar: Back + Favorite -->
<div class="flex justify-between items-center mb-6">
  <!-- Back Button -->
  <a href="#"
   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium">
   <i class="fa-solid fa-arrow-left mr-2"></i> <strong>Back to Taxis</strong>
</a>


  <!-- Favorite Button -->
  <button class="p-2 rounded-full border border-gray-300 hover:bg-red-50 shadow-sm transition">
    <!-- Outline Heart -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" 
         viewBox="0 0 24 24" class="w-6 h-6 text-gray-600">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 
               4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 
               4.5 0 010-6.364z"/>
    </svg>
  </button>
</div>
<div class="flex items-center justify-between mb-4">
  <!-- Left side: Title + Reviews -->
  <div>
    <h1 class="text-xl font-bold">{{ $taxi->brand_model ?? 'Unnamed Taxi' }}</h1>
    <div class="flex items-center space-x-2">
      <!-- Stars -->
      <div class="flex text-yellow-400">
        ★★★★☆
      </div>
      <!-- Total Reviews -->
      <p class="text-gray-600 text-sm">(124 reviews)</p>
    </div>
  </div>

  <!-- Right side: Book Now Button -->
  <div>
    <button class="px-6 py-2 bg-[#3CC0E9]  text-white text-base font-semibold rounded-lg shadow hover:bg-blue-700">
      Book Now
    </button>
  </div>
</div>



  <div class="flex flex-col lg:flex-row gap-8">

<div class="flex-1 space-y-2"> <!-- vertical spacing only 0.5rem -->

  <!-- Row 1: Front Image -->
  @if($taxi->front_image)
  <div class="w-full h-72">
    <img src="{{ asset('storage/'.$taxi->front_image) }}" 
         alt="Front View"
         class="w-full h-full rounded-lg object-cover cursor-pointer border border-gray-300 shadow-sm"
         onclick="openModal('{{ asset('storage/'.$taxi->front_image) }}')">
  </div>
  @endif

  <!-- Row 2: Inside & Back Images -->
  <div class="grid grid-cols-2 gap-2"> <!-- tiny horizontal gap -->
    @if($taxi->inside_image)
    <div class="h-50">
      <img src="{{ asset('storage/'.$taxi->inside_image) }}" 
           alt="Inside View"
           class="w-full h-full rounded-lg object-cover cursor-pointer border border-gray-300 shadow-sm"
           onclick="openModal('{{ asset('storage/'.$taxi->inside_image) }}')">
    </div>
    @endif

    @if($taxi->back_image)
    <div class="h-50">
      <img src="{{ asset('storage/'.$taxi->back_image) }}" 
           alt="Back View"
           class="w-full h-full rounded-lg object-cover cursor-pointer border border-gray-300 shadow-sm"
           onclick="openModal('{{ asset('storage/'.$taxi->back_image) }}')">
    </div>
    @endif
  </div>

  <!-- Fallback if no images -->
  @if(!$taxi->front_image && !$taxi->inside_image && !$taxi->back_image)
  <div class="w-full h-50">
    <img src="{{ asset('images/placeholder-car.jpg') }}" 
         alt="No Image"
         class="w-full h-full rounded-lg object-cover cursor-pointer border border-gray-300 shadow-sm"
         onclick="openModal('{{ asset('images/placeholder-car.jpg') }}')">
  </div>
  @endif

</div>



  

    

    <!-- Right Column: Vehicle & Driver Details -->
    <div class="flex-1">
       <div class="bg-white p-6 rounded-lg shadow-md border border-gray-400 mb-6">
        <h2 class="text-lg font-semibold mb-4">Pricing Details</h2>
       
           <div><strong class="text-sm text-gray-500">Price per day:</strong>{{ $taxi->taxiType->name ?? 'Taxi' }}</div>
          <div><strong class="text-sm text-gray-500">Price per km:</strong>{{ $taxi->number_plate ?? 'N/A' }}</div>
           <div><strong class="text-sm text-gray-500">Base fare:</strong>{{ $taxi->number_plate ?? 'N/A' }}</div>
      </div>
      <!-- Vehicle Details -->
      <div class="bg-white p-6 rounded-lg shadow-md border border-gray-400 mb-6">
        <h2 class="text-lg font-semibold mb-4">Vehicle Details</h2>
        <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
          <div><strong class="text-sm text-gray-500">Brand and Model:</strong><br>{{ $taxi->taxiType->name ?? 'Taxi' }}</div>
          <div><strong class="text-sm text-gray-500">Number Plate:</strong><br>{{ $taxi->number_plate ?? 'N/A' }}</div>
          <div><strong class="text-sm text-gray-500">Vehicle Color:</strong><br>{{ $taxi->color ?? 'N/A' }}</div>
          <div><strong class="text-sm text-gray-500">Passenger Capacity:</strong><br>{{ $taxi->passenger_capacity ?? 0 }}</div>
          <div><strong class="text-sm text-gray-500">Luggage Capacity:</strong><br>{{ $taxi->luggage_capacity ?? 0 }}</div>
        </div>
              @foreach($taxi->drivers as $driver)
         <h2 class="text-lg font-semibold mb-4 mt-6">Driver Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
          @php
            $photoFile = $driver->photo ? \App\Models\File::find($driver->photo) : null;
          @endphp

          <div class="flex items-center justify-center">
            @if($photoFile?->path)
              <img src="{{ asset('storage/' . $photoFile->path) }}"
                   alt="{{ $driver->name }}"
                   class="w-24 h-24 rounded-full object-cover shadow border border-gray-300">
            @else
              <img src="{{ asset('images/user.jpeg') }}"
                   alt="Default Profile"
                   class="w-24 h-24 rounded-full object-cover shadow border border-gray-300">
            @endif
          </div>

          <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
              <p class="text-sm text-gray-500 font-semibold">Name</p>
              <p class="text-sm text-gray-800">{{ $driver->name ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 font-semibold">Contact Number</p>
              <p class="text-sm text-gray-800">{{ $driver->contact_number ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 font-semibold">Email</p>
              <p class="text-sm text-gray-800">{{ $driver->email ?? 'N/A' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 font-semibold">License Number</p>
              <p class="text-sm text-gray-800">{{ $driver->license_number ?? 'N/A' }}</p>
            </div>
      </div>
  @endforeach
      <!-- Driver Details -->

      
        </div>
        
      </div>
    
    </div>

  </div>
  
<!-- Reviews Section -->
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="bg-white border border-gray-300 rounded-lg shadow-sm p-6 mt-8 relative">
  <!-- Your Feedback Button (top-right) -->
  <a href="#"
     class="absolute top-4 right-4 px-4 py-2 bg-[#3CC0E9] hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md transition">
    Your Feedback
  </a>

  <h2 class="text-lg font-semibold mb-4">Reviews</h2>

  <!-- Single Review -->
  <div class="mb-4 border-b border-gray-200 pb-4 flex items-start gap-4">
    <img src="https://via.placeholder.com/40" alt="John Doe" class="w-10 h-10 rounded-full object-cover shadow-sm">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <span class="font-semibold text-gray-600">John Doe</span>
        <span class="text-gray-500 text-xs">(USA)</span>
        <div class="flex text-yellow-400 ml-4">★★★★☆</div>
      </div>
      <p class="text-gray-600 text-sm">Great car and smooth ride. Highly recommend!Very clean and comfortable taxi. Excellent driver</p>
    </div>
  </div>

  <!-- Single Review -->
  <div class="mb-4 border-b border-gray-200 pb-4 flex items-start gap-4">
    <img src="https://via.placeholder.com/40" alt="Jane Smith" class="w-10 h-10 rounded-full object-cover shadow-sm">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <span class="font-semibold text-gray-600">Jane Smith</span>
        <span class="text-gray-500 text-xs">(Canada)</span>
        <div class="flex text-yellow-400 ml-4">★★★★★</div>
      </div>
      <p class="text-gray-600 text-sm">Very clean and comfortable taxi. Excellent driver.Very clean and comfortable taxi. Excellent driver</p>
    </div>
  </div>

  <!-- Single Review -->
  <div class="flex items-start gap-4">
    <img src="https://via.placeholder.com/40" alt="Alex Johnson" class="w-10 h-10 rounded-full object-cover shadow-sm">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <span class="font-semibold text-gray-600">Alex Johnson</span>
        <span class="text-gray-500 text-xs">(UK)</span>
        <div class="flex text-yellow-400 ml-4">★★★★☆</div>
      </div>
      <p class="text-gray-600 text-sm">Good experience overall, would book again.Very clean and comfortable taxi. Excellent driver</p>
    </div>
  </div>

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
