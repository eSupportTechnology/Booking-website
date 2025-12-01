@extends('frontend.master')
@section('title', 'Booking Completed')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Success Header -->
    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 flex items-center gap-4 mb-8">
        <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow">
            <i class="fa-solid fa-check text-white text-3xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Booking Confirmed!</h1>
            <p class="text-gray-500 text-sm">Your airport transfer reservation has been successfully completed.</p>
        </div>
    </div>

    <!-- Booking Reference -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <p class="text-sm text-gray-500">Booking Reference</p>
        <p class="text-xl font-semibold tracking-wider text-gray-800 mt-1">
            {{ $booking->booking_id }}
        </p>
    </div>

    <!-- Trip Summary -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Trip Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Pickup Location</p>
                <p class="font-medium">{{ $booking->pickup_location }}</p>
            </div>
            <div>
                <p class="text-gray-500">Dropoff Location</p>
                <p class="font-medium">{{ $booking->dropoff_location }}</p>
            </div>
            <div>
                <p class="text-gray-500">Pickup Date & Time</p>
                <p class="font-medium">{{ $booking->pickup_datetime }}</p>
            </div>
            <div>
                <p class="text-gray-500">Distance</p>
                <p class="font-medium">{{ $booking->distance }} km</p>
            </div>
        </div>
    </div>

    <!-- Map Preview -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-3">Route Preview</h2>
        <div id="previewMap" class="w-full h-64 rounded-md border"></div>
    </div>

    <!-- Customer Details -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Passenger Information</h2>

        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            <p><span class="text-gray-500">Name:</span> {{ $booking->name }}</p>
            <p><span class="text-gray-500">Email:</span> {{ $booking->email }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $booking->phone1 }}</p>
            <p><span class="text-gray-500">Address:</span> {{ $booking->address ?: '-' }}</p>
        </div>
    </div>

    <!-- Vehicle Info -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Vehicle Information</h2>

        <div class="grid sm:grid-cols-2 gap-4 text-sm">
            <p><span class="text-gray-500">Model:</span> {{ $booking->taxi->brand_model }}</p>
            <p><span class="text-gray-500">Color:</span> {{ $booking->taxi->color }}</p>
            <p><span class="text-gray-500">Passengers:</span> {{ $booking->taxi->passenger_capacity }}</p>
            <p><span class="text-gray-500">Luggage:</span> {{ $booking->taxi->luggage_capacity }}</p>
        </div>
    </div>

    <!-- Driver Info -->
    
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Driver Details</h2>

        @php
            $driver = $booking->taxi->drivers->first();
        @endphp

        @if($driver)

            @php
                // Driver photo filename (stored in DB)
                $photoFile = $driver->photo;

                // Build correct path:
                // storage/app/public/uploads/<filename>
                $photoUrl = $photoFile
                    ? asset('storage/uploads/' . basename($photoFile))
                    : asset('images/user.jpeg');
            @endphp

            <div class="flex items-start gap-6">
                <img src="{{ $photoUrl }}"
                    class="w-20 h-20 rounded-full border shadow-md">

                <div class="text-sm">
                    <p><span class="text-gray-500">Name:</span> {{ $driver->name }}</p>
                    <p><span class="text-gray-500">Phone:</span> {{ $driver->contact_number }}</p>
                    <p><span class="text-gray-500">Email:</span> {{ $driver->email }}</p>
                    <p><span class="text-gray-500">License:</span> {{ $driver->license_number }}</p>
                </div>
            </div>

        @else        
            <p class="text-gray-500 italic">No driver assigned to this taxi yet.</p>
        @endif

    </div>


    <!-- Payment & Fare -->
    <div class="bg-white border shadow-sm rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Fare Summary</h2>

        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <p>Base Fare</p>
                <p>LKR {{ number_format($booking->base_fare) }}</p>
            </div>
            <div class="flex justify-between">
                <p>Distance Charge</p>
                <p>LKR {{ number_format($booking->distance_fare) }}</p>
            </div>
            <div class="flex justify-between">
                <p>Service Fee</p>
                <p>LKR {{ number_format($booking->service_fee) }}</p>
            </div>

            <hr class="my-3">

            <div class="flex justify-between font-semibold text-lg">
                <p>Total Amount</p>
                <p>LKR {{ number_format($booking->total_amount) }}</p>
            </div>

            <p class="mt-4 text-sm">
                <span class="text-gray-500">Payment Method:</span>
                <strong class="ml-1 text-gray-700 uppercase">{{ $booking->payment_method }}</strong>
            </p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <a href="{{ route('customer.airport-taxi.search') }}"
           class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow text-center">
            Back to Search
        </a>

        <a href="{{ route('frontend.taxi.booking.invoice', $booking->id) }}"
           class="w-full sm:w-auto px-6 py-3 bg-gray-800 hover:bg-black text-white rounded-lg shadow text-center">
            Download Invoice
        </a>
        
    </div>
</div>

@endsection

<!-- Map Script -->
<script>
document.addEventListener('DOMContentLoaded', async () => {
    let map = L.map('previewMap').setView([6.9271, 79.8612], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const pickup = @json($booking->pickup_location);
    const dropoff = @json($booking->dropoff_location);

    async function getCoords(q) {
        const r = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${q}`);
        const d = await r.json();
        return d.length ? { lat: d[0].lat, lon: d[0].lon } : null;
    }

    const A = await getCoords(pickup);
    const B = await getCoords(dropoff);

    if (A && B) {
        L.marker([A.lat, A.lon]).addTo(map).bindPopup("Pickup");
        L.marker([B.lat, B.lon]).addTo(map).bindPopup("Dropoff");

        map.fitBounds([[A.lat, A.lon], [B.lat, B.lon]], { padding: [50, 50] });

        const routeURL = `https://router.project-osrm.org/route/v1/driving/${A.lon},${A.lat};${B.lon},${B.lat}?overview=full&geometries=geojson`;

        const routeResp = await fetch(routeURL);
        const routeJSON = await routeResp.json();

        if (routeJSON.routes?.length) {
            const coords = routeJSON.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
            L.polyline(coords, { color: "#3CC0E9", weight: 5 }).addTo(map);
        }
    }
});
</script>
