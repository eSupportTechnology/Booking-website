@extends('frontend.partner-layout')

@section('title', 'Partner Apartment Final')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-2">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow space-y-8">

    <!-- Header -->
    <div class="space-y-1">
      <h2 class="text-xl font-semibold">
        zara
        <span class="inline-block bg-gray-200 text-sm px-2 py-0.5 rounded-full">1</span>
      </h2>
      <p class="text-sm text-gray-600">
        Sri Lanka Foundation Institute, Colombo, WP, 00700, Sri Lanka
      </p>
    </div>

    <!-- General details button -->
    <button
      id="generalDetailsBtn"
      class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#3CC0E9] border border-[#3CC0E9] rounded hover:bg-blue-50 text-sm"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      General details
    </button>

    <!-- Apartment Cards Container -->
    <div id="apartmentCardsContainer" class="space-y-8 mt-6">
      <!-- Apartment Card -->
      <div class="border rounded overflow-hidden apartment-card" data-apartment='{
        "sleepingArrangements": "1 bedroom, sleeps 2 guest",
        "amenities": "WiFi, Air conditioning",
        "photosCount": 5,
        "basePrice": 123,
        "nonRefundablePrice": 110.7,
        "layoutCount": 1
      }'>
        <div class="grid grid-cols-1 sm:grid-cols-12">

          <!-- Image -->
          <div class="sm:col-span-3">
            <div class="relative w-full h-48 sm:h-full overflow-hidden rounded-t sm:rounded-l sm:rounded-t-none">
              <div class="relative w-full h-48 bg-red-200">
                <img src="https://via.placeholder.com/300x200" alt="Apartment" />
              </div>
              <div class="absolute bottom-2 right-2 bg-green-600 text-white text-xs sm:text-sm px-3 py-1 rounded shadow z-10 whitespace-nowrap">
                Complete
              </div>
            </div>
          </div>

          <!-- Info -->
          <div class="sm:col-span-6 p-4 space-y-2">
            <h3 class="font-semibold text-base sm:text-lg">One-Bedroom Apartment</h3>
            <p class="text-sm text-gray-600 mb-6">1 apartment with this layout</p>
            <div class="flex flex-col sm:flex-row text-sm divide-y sm:divide-y-0 sm:divide-x divide-gray-300">
              <div class="sm:pr-6 pb-2 sm:pb-0">
                <p class="text-gray-500">Bedroom</p>
                <p class="font-medium">1</p>
              </div>
              <div class="sm:px-6 pb-2 sm:pb-0">
                <p class="text-gray-500">Guests</p>
                <p class="font-medium">2</p>
              </div>
              <div class="sm:pl-6">
                <p class="text-gray-500">Price</p>
                <p class="font-medium">US$123</p>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="col-span-3 p-4 flex justify-end items-center text-sm text-blue-600 space-x-6">
            <button class="duplicateBtn hover:underline">Duplicate</button>
            <button class="editBtn hover:underline">Edit</button>
            <button class="deleteBtn hover:underline text-red-600 hidden">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add apartment -->
    <div>
      <button class="px-4 py-2 text-[#3CC0E9] border border-[#3CC0E9] rounded hover:bg-blue-50 text-sm">
        Add apartment
      </button>
    </div>

    <!-- Complete registration -->
    <div class="bg-[#1F8FB2] text-white text-center py-2 text-base font-semibold rounded shadow-inner select-none cursor-default mt-6">
      Complete registration
    </div>
  </div>
</div>

<!-- Apartment Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative space-y-4">
    <button id="editCancelBtn" class="absolute top-3 right-4 text-gray-500 hover:text-black text-xl font-bold">&times;</button>
    <h2 class="text-xl font-semibold mb-4">Which details would you like to edit?</h2>

    <!-- Each detail as one line with label, value, and small Edit button -->
    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Sleeping arrangements</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="sleepingArrangementsDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Amenities</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="amenitiesDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Photos (count)</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="photosCountDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Base price</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="basePriceDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Non-refundable price</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="nonRefundablePriceDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>

    <div class="flex justify-between items-center border-b border-gray-200 py-2">
      <div class="text-sm font-medium text-gray-700">Layout count</div>
      <div class="flex items-center space-x-3">
        <div class="text-sm text-gray-900" id="layoutCountDisplay">N/A</div>
        <button type="button" class="text-xs text-blue-600 hover:underline">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- General Details Modal -->
<div id="generalDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
    <!-- Close button -->
    <button id="generalCancelBtn" class="absolute top-3 right-4 text-gray-500 hover:text-black text-xl font-bold">&times;</button>

    <h2 class="text-xl font-semibold mb-6">Which details would you like to edit?</h2>

    <div class="divide-y divide-gray-200">
      @php
        $items = [
          ['label' => 'Address', 'value' => 'Sri Lanka aaa, Matale, CP, 80400, Sri Lanka'],
          ['label' => 'Facilities', 'value' => ''],
          ['label' => 'Breakfast details', 'value' => 'Breakfast is optional and costs US$33'],
          ['label' => 'Languages spoken', 'value' => 'French'],
          ['label' => 'Property name', 'value' => 'ccc'],
          ['label' => 'House rules', 'value' => "Children allowed\nNo smoking allowed\nNo pets allowed\nNo parties/events allowed"],
          ['label' => 'Availability', 'value' => 'Channel manager to be connected'],
          ['label' => 'Cancellation policy', 'value' => 'Guests can cancel up to 1 day before arrival'],
          ['label' => 'How you receive bookings', 'value' => 'All guests will need to request to book'],
        ];
      @endphp

      @foreach($items as $item)
      <div class="flex justify-between items-start py-4 gap-4">
        <div class="w-1/3 text-sm font-semibold text-gray-900">{{ $item['label'] }}</div>
        <div class="flex-1 text-sm text-gray-700 whitespace-pre-line">{{ $item['value'] }}</div>
        <a href="#" class="text-sm text-blue-600 hover:underline whitespace-nowrap">Edit</a>
      </div>
      @endforeach
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('apartmentCardsContainer');
    const editModal = document.getElementById('editModal');
    const generalDetailsModal = document.getElementById('generalDetailsModal');

    // Modal cancel buttons
    document.getElementById('editCancelBtn').addEventListener('click', () => {
      editModal.classList.add('hidden');
    });

    document.getElementById('generalCancelBtn').addEventListener('click', () => {
      generalDetailsModal.classList.add('hidden');
    });

    // Open General Details Modal
    document.getElementById('generalDetailsBtn').addEventListener('click', () => {
      generalDetailsModal.classList.remove('hidden');
    });

    // Update Delete buttons visibility based on number of cards
    function updateDeleteButtonsVisibility() {
      const cards = container.querySelectorAll('.apartment-card');
      const deleteButtons = container.querySelectorAll('.deleteBtn');
      if (cards.length > 1) {
        deleteButtons.forEach(btn => btn.classList.remove('hidden'));
      } else {
        deleteButtons.forEach(btn => btn.classList.add('hidden'));
      }
    }
    updateDeleteButtonsVisibility();

    // Event delegation on container for buttons inside apartment cards
    container.addEventListener('click', function (e) {
      if (e.target.classList.contains('duplicateBtn')) {
        const card = e.target.closest('.apartment-card');
        if (card) {
          const clone = card.cloneNode(true);
          container.appendChild(clone);
          updateDeleteButtonsVisibility();
        }
      }

      if (e.target.classList.contains('deleteBtn')) {
        const card = e.target.closest('.apartment-card');
        if (card) {
          card.remove();
          updateDeleteButtonsVisibility();
        }
      }

      if (e.target.classList.contains('editBtn')) {
        const card = e.target.closest('.apartment-card');
        if (!card) return;

        // Get data from data-apartment attribute (JSON)
        const data = JSON.parse(card.getAttribute('data-apartment') || '{}');

        // Populate modal display elements
        document.getElementById('sleepingArrangementsDisplay').textContent = data.sleepingArrangements || 'N/A';
        document.getElementById('amenitiesDisplay').textContent = data.amenities || 'N/A';
        document.getElementById('photosCountDisplay').textContent = data.photosCount !== undefined ? data.photosCount : 'N/A';
        document.getElementById('basePriceDisplay').textContent = data.basePrice !== undefined ? 'US$' + data.basePrice : 'N/A';
        document.getElementById('nonRefundablePriceDisplay').textContent = data.nonRefundablePrice !== undefined ? 'US$' + data.nonRefundablePrice : 'N/A';
        document.getElementById('layoutCountDisplay').textContent = data.layoutCount !== undefined ? data.layoutCount : 'N/A';

        // Show the edit modal
        editModal.classList.remove('hidden');
      }
    });
  });
</script>

@endsection
