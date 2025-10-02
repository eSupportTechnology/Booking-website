{{-- resources/views/taxi-booking-form.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Taxi Booking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50">
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Self-Drive Car Booking Form
    </h2>

    {{-- Replace action="#" with your booking route, e.g. route('bookings.store') --}}
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- If you passed $car from controller, use its price_per_day. If not, fallback to old() or 0 --}}
        @php
          $pricePerDayVal = isset($car) ? (float) $car->price_per_day : (float) old('price_per_day', 0);
          $currency = $car->currency ?? 'LKR';
        @endphp

        {{-- Pickup & Return Date in One Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pickup Date & Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Pickup Date & Time</label>
                <input type="datetime-local" id="pickup_datetime" name="pickup_datetime" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>

            <!-- Return Date & Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Return Date & Time</label>
                <input type="datetime-local" id="return_datetime" name="return_datetime" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>
        </div>

        {{-- Number of Days + Price (single row) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
          <!-- Number of Days -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Number of Days</label>
            {{-- show numeric value only (readonly) --}}
            <input type="number" id="total_days" name="total_days" readonly
                   class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-lg sm:text-sm h-12 px-3" />
          </div>

          <!-- Price display: Price per day (small) + Total price (big) -->
          <div>
           

            <div class="flex gap-3">
              <div class="flex-1">
           <label class="block text-sm font-medium text-gray-700">Total price (all days)</label>
                <input type="text" id="price_per_day_display" readonly
                       value="{{ $currency }} {{ number_format($pricePerDayVal, 2) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 shadow-lg sm:text-sm h-10 px-3" />
              </div>

            
            </div>


          </div>
        </div>

        <!-- Full Name & Email in One Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="full_name" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>
        </div>

        <!-- Phone & License Number in One Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" name="phone" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>

            <!-- Driving License Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Driving License Number</label>
                <input type="text" name="license_number" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-12 px-3">
            </div>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Address (Optional)</label>
            <textarea name="address" rows="3"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3"></textarea>
        </div>

        <!-- Upload License Front & Back -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- License Front -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload License Front</label>
                <input type="file" name="license_front" accept="image/*,.pdf" required
                    class="mt-1 block w-full text-sm text-gray-700 rounded-lg h-12 pt-2 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <!-- License Back -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload License Back</label>
                <input type="file" name="license_back" accept="image/*,.pdf" required
                    class="mt-1 block w-full text-sm text-gray-700 rounded-lg h-12 pt-2 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
        </div>

        <!-- Hidden inputs for form submission -->
        <input type="hidden" id="price_per_day" name="price_per_day" value="{{ $pricePerDayVal }}">
        <input type="hidden" id="total_price_raw" name="total_price_raw" value="0">
        <input type="hidden" id="currency" value="{{ $currency }}">

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end">
            <button type="submit"
                class="w-[20%]  bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                Book Now
            </button>
        </div>
    </form>
</div>

{{-- Script to Auto Calculate Days & Price --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const pickup = document.getElementById("pickup_datetime");
        const ret = document.getElementById("return_datetime");
        const totalDays = document.getElementById("total_days");
        const pricePerDay = document.getElementById("price_per_day"); // numeric value for calculations
        const pricePerDayDisplay = document.getElementById("price_per_day_display"); // formatted display
        const totalPriceDisplay = document.getElementById("total_price"); // formatted display
        const totalPriceRaw = document.getElementById("total_price_raw"); // numeric raw for submission
        const currency = document.getElementById("currency").value || '';

        function formatCurrency(value) {
            // simple formatting — change to Intl.NumberFormat if you need localized formatting
            return currency ? `${currency} ${Number(value).toFixed(2)}` : Number(value).toFixed(2);
        }

        function calculateDaysAndPrice() {
            if (!pickup.value || !ret.value) {
                totalDays.value = '';
                totalPriceDisplay.value = formatCurrency(0);
                totalPriceRaw.value = 0;
                return;
            }

            const pickupDate = new Date(pickup.value);
            const returnDate = new Date(ret.value);

            // allow equal times to count as 1 day (user probably intends same-day booking)
            if (returnDate >= pickupDate) {
                const msDay = 1000 * 60 * 60 * 24;
                const diffTime = returnDate - pickupDate;
                let days = Math.ceil(diffTime / msDay);

                // if same time or very small diff, ensure at least 1 day
                if (diffTime === 0 || days === 0) days = 1;

                totalDays.value = days;

                const ppd = parseFloat(pricePerDay.value) || 0;
                const total = ppd * days;

                totalPriceDisplay.value = formatCurrency(total);
                totalPriceRaw.value = total;
            } else {
                totalDays.value = '';
                totalPriceDisplay.value = 'Invalid range';
                totalPriceRaw.value = 0;
            }
        }

        // Recalculate when pickup/return change
        pickup.addEventListener("change", calculateDaysAndPrice);
        ret.addEventListener("change", calculateDaysAndPrice);

        // If price per day is edited (rare) recalc
        pricePerDay.addEventListener("input", function () {
            // update display
            const p = parseFloat(pricePerDay.value) || 0;
            pricePerDayDisplay.value = formatCurrency(p);
            calculateDaysAndPrice();
        });

        // initialize display from server value
        (function init() {
            const initialPpd = parseFloat(pricePerDay.value) || 0;
            pricePerDayDisplay.value = formatCurrency(initialPpd);
            totalPriceDisplay.value = formatCurrency(0);
            totalPriceRaw.value = 0;
        })();
    });
</script>
</body>
</html>
