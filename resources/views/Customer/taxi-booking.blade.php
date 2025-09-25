
    <!-- Right Column: Car Details & Booking -->
    <div class="flex-1 space-y-6">

      <!-- Car Info -->
     
      <div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h1 class="text-2xl font-bold mb-4">{{ $taxi->brand }} {{ $taxi->model }}</h1>

    <form id="bookingForm" class="space-y-4">
        <!-- Pickup Date -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Pickup Date</label>
            <input type="date" name="pickup_date"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Pickup Location -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Pickup Location</label>
            <input type="text" id="pickup" name="pickup"
                   placeholder="Enter pickup location"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Dropoff Location -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Dropoff Location</label>
            <input type="text" id="dropoff" name="dropoff"
                   placeholder="Enter dropoff location"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Trip Type -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">Trip Type</label>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="trip_type" value="one_way" checked
                           class="text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700">One Way</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="trip_type" value="return"
                           class="text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700">Return</span>
                </label>
            </div>
        </div>

        <!-- Distance Result -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Estimated Distance</label>
            <p id="distanceResult" class="text-gray-800 font-medium">N/A</p>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
            Book Now
        </button>
    </form>
</div>
<!-- Google Maps API (replace YOUR_API_KEY with your key) -->
<script src="<!-- Load Google Maps API (call initAutocomplete after load) -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>

<script>
let pickupAutocomplete, dropoffAutocomplete;

function initAutocomplete() {
    // Initialize autocomplete for pickup
    pickupAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById("pickup"),
        { types: ["geocode"] }
    );

    // Initialize autocomplete for dropoff
    dropoffAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById("dropoff"),
        { types: ["geocode"] }
    );

    // Optional: Auto-calculate distance when dropoff selected
    dropoffAutocomplete.addListener("place_changed", () => {
        calculateDistance();
    });
}

function calculateDistance() {
    const pickup = document.getElementById("pickup").value;
    const dropoff = document.getElementById("dropoff").value;
    const distanceElem = document.getElementById("distanceResult");

    if (!pickup || !dropoff) {
        distanceElem.textContent = "Please enter both locations";
        return;
    }

    const service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
        {
            origins: [pickup],
            destinations: [dropoff],
            travelMode: "DRIVING",
            unitSystem: google.maps.UnitSystem.METRIC,
        },
        (response, status) => {
            if (status === "OK") {
                const distance = response.rows[0].elements[0].distance.text;
                const duration = response.rows[0].elements[0].duration.text;
                distanceElem.textContent = `${distance} (${duration})`;
            } else {
                distanceElem.textContent = "Could not calculate distance";
            }
        }
    );
}

// Handle form submit
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("bookingForm").addEventListener("submit", function (e) {
        e.preventDefault();
        calculateDistance();
    });
});
</script>

      <!-- Booking Form -->
      <div class="bg-white p-6 rounded-lg shadow-md ">
        <h2 class="text-lg font-semibold mb-4">Book This Car</h2>
        <form class="space-y-4 border border-gray-200">
          <input type="text" placeholder="Your Name" class="w-full border rounded p-2">
          <input type="email" placeholder="Email" class="w-full border rounded p-2">
          <input type="tel" placeholder="Phone" class="w-full border rounded p-2">
          <input type="date" class="w-full border rounded p-2">
          <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Book Now
          </button>
        </form>
      </div>

  
      

    </div>
  </div>
</div>