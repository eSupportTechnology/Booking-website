{{-- resources/views/taxi-booking-form.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Taxi Booking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg p-6 relative">
    <h1 class="text-2xl font-semibold mb-4">Taxi Booking</h1>

    <form id="bookingForm" class="space-y-6">
   


      <!-- Pickup -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup location</label>
        <div class="flex gap-2">
          <input type="text" id="pickupInput" required class="flex-1 rounded-lg border-gray-200 shadow-sm p-2" placeholder="Choose on map or type manually" />
          <button type="button" onclick="openMap('pickup')" class="bg-indigo-600 text-white px-3 rounded-lg">
            <i class="fa-solid fa-map-pin"></i>
          </button>
        </div>
      </div>

      <!-- Dropoff -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Dropoff location</label>
        <div class="flex gap-2">
          <input type="text" id="dropoffInput" required class="flex-1 rounded-lg border-gray-200 shadow-sm p-2" placeholder="Choose on map or type manually" />
          <button type="button" onclick="openMap('dropoff')" class="bg-indigo-600 text-white px-3 rounded-lg">
            <i class="fa-solid fa-map-pin"></i>
          </button>
        </div>
      </div>

      <!-- Date & Time -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Pickup date & time</label>
          <input type="datetime-local" name="pickup_datetime" required class="w-full rounded-lg border-gray-200 p-2 shadow-sm">
        </div>
        <div id="returnDateTimeWrapper" class="hidden">
          <label class="block text-sm font-medium text-gray-700 mb-2">Return date & time</label>
          <input type="datetime-local" name="return_datetime" class="w-full rounded-lg border-gray-200 p-2 shadow-sm">
        </div>
      </div>

      <!-- Distance -->
      <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-dashed border-gray-200">
        <div>
          <p class="text-sm text-gray-600">Distance</p>
          <p id="distanceText" class="text-lg font-medium">—</p>
        </div>
        <div class="text-right">
          <p class="text-sm text-gray-600">Estimated fare</p>
          <p id="fareText" class="text-lg font-medium">—</p>
        </div>
      </div>

      <!-- Contact info -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Full name</label>
          <input type="text" name="name" required class="w-full rounded-lg border-gray-200 p-2 shadow-sm" placeholder="John Doe" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
          <input type="text" name="address" required class="w-full rounded-lg border-gray-200 p-2 shadow-sm" placeholder="123 Main St" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input type="email" name="email" required class="w-full rounded-lg border-gray-200 p-2 shadow-sm" placeholder="you@example.com" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Phone 1</label>
          <input type="tel" name="phone1" required pattern="[0-9+\-() ]{7,20}" class="w-full rounded-lg border-gray-200 p-2 shadow-sm" placeholder="+94 77 123 4567" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Phone 2</label>
          <input type="tel" name="phone2" pattern="[0-9+\-() ]{7,20}" class="w-full rounded-lg border-gray-200 p-2 shadow-sm" placeholder="+94 77 123 4567" />
        </div>
      </div> 

      <!-- Submit -->
      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">Book Taxi</button>
      </div>
    </form>
  </div>

  <!-- Map Modal -->
  <div id="mapModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-11/12 md:w-2/3 h-3/4 relative">
      <button onclick="closeMap()" class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded">X</button>
      <div id="map" class="w-full h-full rounded-xl"></div>
    </div>
  </div>

  <script>
    let map, marker, activeField = null;

    function openMap(field) {
      activeField = field;
      document.getElementById('mapModal').classList.remove('hidden');

      if (!map) {
        map = L.map('map');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Try to get user's location
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (pos) => {
              const lat = pos.coords.latitude;
              const lon = pos.coords.longitude;
              map.setView([lat, lon], 13);
              L.circleMarker([lat, lon], {radius:6, color:"blue"}).addTo(map).bindPopup("You are here");
            },
            () => {
              map.setView([6.9271, 79.8612], 10); // fallback: Colombo
            }
          );
        } else {
          map.setView([6.9271, 79.8612], 10);
        }

        // Click to choose location
        map.on('click', async function(e) {
          if (marker) map.removeLayer(marker);
          marker = L.marker(e.latlng).addTo(map);

          const lat = e.latlng.lat;
          const lon = e.latlng.lng;

          // Reverse geocode
          const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
          const data = await res.json();
          const address = data.display_name || `${lat}, ${lon}`;

          if (activeField === 'pickup') {
            document.getElementById('pickupInput').value = address;
          } else if (activeField === 'dropoff') {
            document.getElementById('dropoffInput').value = address;
          }

          closeMap();
          refreshDistance();
        });
      }
    }

    function closeMap() {
      document.getElementById('mapModal').classList.add('hidden');
    }

    async function getCoordinates(query) {
      try {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
        const data = await res.json();
        if (data.length > 0) return { lat: parseFloat(data[0].lat), lon: parseFloat(data[0].lon) };
      } catch (e) { console.error(e); }
      return null;
    }

    async function getDrivingDistance(a, b) {
      const url = `https://router.project-osrm.org/route/v1/driving/${a.lon},${a.lat};${b.lon},${b.lat}?overview=false`;
      const res = await fetch(url);
      const data = await res.json();
      if (data.routes?.length) {
        return { distance: data.routes[0].distance/1000, duration: data.routes[0].duration/60 };
      }
      return null;
    }

    async function refreshDistance() {
      const pickup = document.getElementById('pickupInput').value;
      const dropoff = document.getElementById('dropoffInput').value;

      if (!pickup || !dropoff) return;

      const coordsA = await getCoordinates(pickup);
      const coordsB = await getCoordinates(dropoff);
      if (!coordsA || !coordsB) return;

      const result = await getDrivingDistance(coordsA, coordsB);
      if (!result) return;

      const km = Math.round(result.distance * 10) / 10;
      document.getElementById('distanceText').textContent = `${km} km (≈ ${Math.round(result.duration)} min)`;

      const base = 200, perKm = 60;
      document.getElementById('fareText').textContent = `${Math.round(base + km*perKm)} LKR`;
    }

    document.getElementById('pickupInput').addEventListener('blur', refreshDistance);
    document.getElementById('dropoffInput').addEventListener('blur', refreshDistance);
  </script>
  </body>
</html>
