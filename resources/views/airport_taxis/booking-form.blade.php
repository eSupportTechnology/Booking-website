@extends('frontend.master')
@section('title', 'Book Airport Taxi')

@section('content')
@php
    // Local uploaded file path (you asked to include the file path as-is)
    $exampleImage = '/mnt/data/7c8fc7dd-638d-4a3c-b035-4191f03e1249.png';
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
        <div class="flex items-center gap-4">
            <img src="{{ $exampleImage }}" alt="Taxi" class="w-16 h-16 rounded-lg object-cover shadow-sm">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Book an Airport Transfer</h1>
                <p class="text-sm text-gray-500">Fast — Reliable — Transparent pricing</p>
            </div>
        </div>
    </div>
    


    <form id="taxiBookingForm" action="{{ route('frontend.taxi.book')}}"  method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @csrf
        <input type="hidden" name="taxi_id" value="{{ $taxi->id }}">

        <!-- Left column: Shipment & trip -->
        <div class="space-y-6">

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-lg font-medium mb-4 text-gray-800">Trip details</h2>

                <label class="block text-sm text-gray-600">Pickup location</label>
                <input id="pickup_location" name="pickup_location" required type="text"
       value="{{ request('pickup') }}" placeholder="e.g. Bandaranaike International Airport (CMB)"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-3 focus:ring-blue-200 focus:border-blue-500 p-3">

                <label class="block text-sm text-gray-600 mt-4">Dropoff location</label>
                <input id="dropoff_location" name="dropoff_location" required type="text"
       value="{{ request('dropoff') }}" placeholder="e.g. Fort, Colombo"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-3 focus:ring-blue-200 focus:border-blue-500 p-3">

                <div class="grid grid-cols-2 gap-3 mt-4">
                    <div>
                        <label class="block text-sm text-gray-600">Pickup date & time</label>
                        <input id="pickup_datetime" name="pickup_datetime" required type="datetime-local"
                               class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Return (optional)</label>
                        <input id="return_datetime" name="return_datetime" type="datetime-local"
                               class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 mt-4 text-sm">
                    <div>
                        <label class="text-gray-600">Passengers</label>
                        <input id="passengers" name="passengers" type="number" min="1" max="30" value="1"
                               class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
                    </div>
                    <div>
                        <label class="text-gray-600">Luggage</label>
                        <input id="bags" name="bags" type="number" min="0" max="20" value="1"
                               class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
                    </div>
                    <div>
                        <label class="text-gray-600">Distance (km)</label>
                        <input id="distance" name="distance" type="number"
       value="{{ request('distance') }}" min="0" step="0.1" value=""
                               placeholder="auto or enter"
                               class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pricing_type" value="perKm" checked class="text-blue-600">
                        <span class="text-sm text-gray-600">Per km</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pricing_type" value="perDay" class="text-blue-600">
                        <span class="text-sm text-gray-600">Per day</span>
                    </label>
                </div>

            </div>

            <!-- Customer Details -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-lg font-medium mb-4 text-gray-800">Contact details</h2>

                <label class="block text-sm text-gray-600">Full name</label>
                <input id="name" name="name" required type="text" placeholder="John Doe"
                       class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">

                <label class="block text-sm text-gray-600 mt-4">Phone</label>
                <input id="phone1" name="phone1" required type="tel" placeholder="+94 77 123 4567"
                       class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">

                <label class="block text-sm text-gray-600 mt-4">Email</label>
                <input id="email" name="email" required type="email" placeholder="you@example.com"
                       class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">

                <label class="block text-sm text-gray-600 mt-4">Address (optional)</label>
                <input id="address" name="address" type="text" placeholder="Hotel or pickup gate"
                       class="mt-1 block w-full rounded-md border-gray-300 p-3 shadow-sm">
            </div>

            <!-- Price & submit -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-lg font-medium mb-4 text-gray-800">Fare & payment</h2>

                <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                    <span>Base fare</span>
                    <span id="baseFareLabel">LKR 200</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                    <span>Distance charge</span>
                    <span id="distanceFareLabel">LKR 0</span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                    <span>Service fee</span>
                    <span id="serviceFeeLabel">LKR 150</span>
                </div>

                <hr class="my-3">

                <div class="flex items-center justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span id="totalFareLabel">
                        LKR {{ request('fare') ?? 350 }}
                    </span>
                </div>
                <!-- Payment Methods -->
                <div class="bg-white shadow-md border border-gray-200 rounded-xl p-6 mb-8">
                    <h2 class="text-lg font-semibold mb-4">Payment Method</h2>

                    <div class="space-y-3 text-sm">

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="payment_method" value="card"
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                            <span>Credit / Debit Card (Visa, MasterCard, Amex)</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="payment_method" value="paypal"
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <span>PayPal</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="payment_method" value="stripe"
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <span>Stripe</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <span>Bank Transfer</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="payment_method" value="pay_to_driver"
                                class="w-5 h-5 text-green-600 focus:ring-green-500">
                            <span class="font-semibold text-green-700">Pay to Driver (Cash at Pickup)</span>
                        </label>

                    </div>
                </div>

                
                <div class="mt-3">
                    <button type="submit"
                            class="w-full inline-flex justify-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg shadow">
                        Confirm & Book
                    </button>
                </div>
            </div>

        </div>

        <!-- Right column: Visuals (map + taxi card) -->
        <div class="space-y-6">

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-md font-medium text-gray-800 mb-3">Route preview</h3>
                <div id="bookingMap" class="w-full h-64 rounded-lg border"></div>
                <p class="text-xs text-gray-500 mt-3">Map powered by OpenStreetMap & OSRM (client-side preview).</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-md font-medium text-gray-800 mb-4">Vehicle selection</h3>

                <!-- A simple vehicle card — replace with dynamic data if available -->
                <div class="flex items-start gap-4">
                    <div class="w-28 h-20 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center border">
                        <img src="{{ $exampleImage }}" alt="vehicle" class="object-cover w-full h-full">
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Standard Sedan</p>
                        <p class="text-sm text-gray-500 mt-1">Up to 3 passengers • 2 bags</p>
                        <p class="text-sm text-gray-700 mt-3 font-medium">LKR <span id="vehicleBase">200</span></p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="taxi_id" value="{{ $taxi->id }}" checked class="text-blue-600">
                        <span class="text-sm text-gray-600">Choose this vehicle</span>
                    </label>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm text-sm text-gray-600">
                <p><strong>Note:</strong> You will receive a confirmation with driver details and booking reference after submitting.</p>
            </div>

        </div>
    </form>
</div>

<!-- Leaflet and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // -------------------------------
    // MAP INITIALIZATION
    // -------------------------------
    const map = L.map('bookingMap').setView([6.9271, 79.8612], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let pickupMarker, dropMarker, routeLine;

    async function geocode(q) {
        if (!q) return null;
        const res = await fetch(
            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}`
        );
        const json = await res.json();
        if (!json.length) return null;
        return { lat: parseFloat(json[0].lat), lon: parseFloat(json[0].lon) };
    }

    async function drawRoute() {
        const pickup = document.getElementById('pickup_location').value.trim();
        const dropoff = document.getElementById('dropoff_location').value.trim();

        if (!pickup || !dropoff) return;

        const A = await geocode(pickup);
        const B = await geocode(dropoff);
        if (!A || !B) return;

        if (pickupMarker) map.removeLayer(pickupMarker);
        if (dropMarker) map.removeLayer(dropMarker);
        if (routeLine) map.removeLayer(routeLine);

        pickupMarker = L.marker([A.lat, A.lon]).addTo(map).bindPopup('Pickup');
        dropMarker = L.marker([B.lat, B.lon]).addTo(map).bindPopup('Dropoff');

        map.fitBounds([[A.lat, A.lon], [B.lat, B.lon]], { padding: [50, 50] });

        // OSRM route fetch
        try {
            const url = `https://router.project-osrm.org/route/v1/driving/${A.lon},${A.lat};${B.lon},${B.lat}?overview=full&geometries=geojson`;
            const routeReq = await fetch(url);
            const routeJson = await routeReq.json();

            if (routeJson.routes?.length) {
                const coords = routeJson.routes[0].geometry.coordinates.map(
                    c => [c[1], c[0]]
                );
                routeLine = L.polyline(coords, { color: "#1570ef", weight: 5 }).addTo(map);

                const km = (routeJson.routes[0].distance / 1000).toFixed(2);
                document.getElementById('distance').value = km;
                calculateFare();
            }

        } catch (e) {
            console.warn("Route error", e);
        }
    }

    document.getElementById('pickup_location').addEventListener('blur', drawRoute);
    document.getElementById('dropoff_location').addEventListener('blur', drawRoute);


    // -------------------------------
    // FARE CALCULATION
    // -------------------------------
    const baseFare = 200;
    const perKmRate = 60;
    const serviceFee = 150;

    function formatLKR(n) {
        return new Intl.NumberFormat('en-US').format(Math.round(n));
    }

    function calculateFare() {
        const distVal = parseFloat(document.getElementById('distance').value) || 0;

        const distanceFare = distVal * perKmRate;
        const total = baseFare + distanceFare + serviceFee;

        document.getElementById('baseFareLabel').innerText = 'LKR ' + formatLKR(baseFare);
        document.getElementById('distanceFareLabel').innerText = 'LKR ' + formatLKR(distanceFare);
        document.getElementById('serviceFeeLabel').innerText = 'LKR ' + formatLKR(serviceFee);
        document.getElementById('totalFareLabel').innerText = 'LKR ' + formatLKR(total);

        document.getElementById('vehicleBase').innerText = formatLKR(baseFare);
    }

    document.getElementById('distance').addEventListener('input', calculateFare);

    // Auto calculate initial fare
    calculateFare();


    // -------------------------------
    // FORM SUBMISSION VALIDATION
    // -------------------------------
    document.getElementById('taxiBookingForm').addEventListener('submit', function (e) {

        const required = [
            'pickup_location', 'dropoff_location', 'pickup_datetime',
            'name', 'phone1', 'email'
        ];

        for (let field of required) {
            let el = document.getElementById(field);
            if (!el || el.value.trim() === '') {
                e.preventDefault();
                alert('Please fill all required fields.');
                el.focus();
                return false;
            }
        }

        // Payment method required
        const payment = document.querySelector('input[name="payment_method"]:checked');
        if (!payment) {
            e.preventDefault();
            alert('Please select a payment method.');
            return false;
        }

        // Taxi selection required
        const taxi = document.querySelector('input[name="taxi_id"]:checked');
        if (!taxi) {
            e.preventDefault();
            alert('Please select a vehicle.');
            return false;
        }

        if (!confirm("Are you sure you want to confirm your booking?")) {
            e.preventDefault();
            return false;
        }

        // Final recalc to store correct amount
        calculateFare();
        return true;
    });

});
</script>



@endsection
