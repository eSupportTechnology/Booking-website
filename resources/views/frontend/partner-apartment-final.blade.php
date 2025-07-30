@extends('frontend.partner-layout')

@section('title', 'Partner Apartment Final')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-2">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow space-y-8">

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
      class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 border rounded hover:bg-gray-200 text-sm"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      General details
    </button>

    <!-- Container to hold apartment cards -->
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

              <!-- Complete badge fixed bottom-right -->
              <div
                class="absolute bottom-2 right-2 bg-green-600 text-white text-xs sm:text-sm px-3 py-1 rounded shadow z-10 whitespace-nowrap"
              >
                Complete
              </div>
            </div>
          </div>

          <!-- Info -->
          <div class="sm:col-span-6 p-4 space-y-2">
            <h3 class="font-semibold text-base sm:text-lg">One-Bedroom Apartment</h3>

            <p class="text-sm text-gray-600 mb-6">1 apartment with this layout</p>

            <div
              class="flex flex-col sm:flex-row text-sm divide-y sm:divide-y-0 sm:divide-x divide-gray-300"
            >
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
          <div
            class="col-span-3 p-4 flex justify-end items-center text-sm text-blue-600 space-x-6"
          >
            <button class="duplicateBtn hover:underline">Duplicate</button>
            <button class="editBtn hover:underline">Edit</button>
            <button class="deleteBtn hover:underline text-red-600 hidden">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add apartment -->
    <div>
      <button
        class="px-4 py-2 border rounded text-blue-700 hover:bg-blue-50 text-sm"
      >
        Add apartment
      </button>
    </div>

    <!-- Complete registration -->
    <div
      class="bg-[#1F8FB2] text-white text-center py-4 text-base font-semibold rounded shadow-inner select-none cursor-default mt-6"
    >
      Complete registration
    </div>
  </div>
</div>

<!-- Modal (hidden by default) -->
<div  id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
    <h2 class="text-xl font-semibold mb-4">Edit Apartment Details</h2>
    <form id="editForm">
      <table class="w-full border-collapse">
        <tbody>
          <tr class="border-b">
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Sleeping arrangements</td>
            <td class="py-2">
              <input
                type="text"
                id="sleepingArrangements"
                name="sleepingArrangements"
                class="w-full border rounded px-3 py-2"
                placeholder="e.g. 1 bedroom, sleeps 2 guest"
              />
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Amenities</td>
            <td class="py-2">
              <textarea
                id="amenities"
                name="amenities"
                rows="2"
                class="w-full border rounded px-3 py-2"
                placeholder="WiFi, Air conditioning, etc."
              ></textarea>
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Photos (count)</td>
            <td class="py-2">
              <input
                type="number"
                id="photosCount"
                name="photosCount"
                class="w-full border rounded px-3 py-2"
                min="0"
              />
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Base price (US$ per night)</td>
            <td class="py-2">
              <input
                type="number"
                id="basePrice"
                name="basePrice"
                class="w-full border rounded px-3 py-2"
                min="0"
                step="0.01"
              />
            </td>
          </tr>
          <tr class="border-b">
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Non-refundable price (US$ per night)</td>
            <td class="py-2">
              <input
                type="number"
                id="nonRefundablePrice"
                name="nonRefundablePrice"
                class="w-full border rounded px-3 py-2"
                min="0"
                step="0.01"
              />
            </td>
          </tr>
          <tr>
            <td class="py-2 pr-4 font-medium text-gray-700 align-top">Layout (number of apartments)</td>
            <td class="py-2">
              <input
                type="number"
                id="layoutCount"
                name="layoutCount"
                class="w-full border rounded px-3 py-2"
                min="0"
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-6 text-right">
        <button
          type="button"
          id="cancelBtn"
          class="ml-2 px-4 py-2 border rounded hover:bg-gray-100"
        >
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('apartmentCardsContainer');
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    let activeCard = null;


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
    });


    container.addEventListener('click', function (e) {
      if (e.target.classList.contains('editBtn')) {
        activeCard = e.target.closest('.apartment-card');
        if (!activeCard) return;


        const data = JSON.parse(activeCard.getAttribute('data-apartment'));


        form.sleepingArrangements.value = data.sleepingArrangements || '';
        form.amenities.value = data.amenities || '';
        form.photosCount.value = data.photosCount ?? '';
        form.basePrice.value = data.basePrice ?? '';
        form.nonRefundablePrice.value = data.nonRefundablePrice ?? '';
        form.layoutCount.value = data.layoutCount ?? '';


        modal.classList.remove('hidden');
      }
    });


    document.getElementById('cancelBtn').addEventListener('click', () => {
      modal.classList.add('hidden');
    });


    document.getElementById('saveBtn').addEventListener('click', () => {
      if (!activeCard) return;


      const updatedData = {
        sleepingArrangements: form.sleepingArrangements.value,
        amenities: form.amenities.value,
        photosCount: parseInt(form.photosCount.value) || 0,
        basePrice: parseFloat(form.basePrice.value) || 0,
        nonRefundablePrice: parseFloat(form.nonRefundablePrice.value) || 0,
        layoutCount: parseInt(form.layoutCount.value) || 0,
      };

      activeCard.setAttribute('data-apartment', JSON.stringify(updatedData));


      activeCard.querySelector('h3').textContent = updatedData.sleepingArrangements;

      const layoutText = updatedData.layoutCount + ' apartment' + (updatedData.layoutCount !== 1 ? 's' : '') + ' with this layout';
      activeCard.querySelector('.text-sm.mb-6').textContent = layoutText;


      const priceContainers = activeCard.querySelectorAll('.sm\\:pl-6 .font-medium');
      if(priceContainers.length > 0){
        priceContainers[0].textContent = `US$${updatedData.basePrice.toFixed(2)}`;
      }


      modal.classList.add('hidden');
    });


    function updateDeleteButtonsVisibility() {
      const cards = container.querySelectorAll('.apartment-card');
      const deleteButtons = container.querySelectorAll('.deleteBtn');
      if (cards.length > 1) {
        deleteButtons.forEach((btn) => btn.classList.remove('hidden'));
      } else {
        deleteButtons.forEach((btn) => btn.classList.add('hidden'));
      }
    }
    updateDeleteButtonsVisibility();
  });
</script>
@endsection
