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
<body class="bg-gray-50 ">
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Self-Drive Car Booking Form
    </h2>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Pickup & Return Date in One Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pickup Date & Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Pickup Date & Time</label>
                <input type="datetime-local" id="pickup_datetime" name="pickup_datetime" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Return Date & Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Return Date & Time</label>
                <input type="datetime-local" id="return_datetime" name="return_datetime" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <!-- Auto Calculated Number of Days -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Number of Days</label>
            <input type="text" id="total_days" name="total_days" readonly
                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-sm sm:text-sm">
        </div>

        <!-- Full Name & Email in One Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="full_name" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <!-- Phone & License Number in One Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" name="phone" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Driving License Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Driving License Number</label>
                <input type="text" name="license_number" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Address (Optional)</label>
            <textarea name="address" rows="3"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        </div>

        <!-- Upload License Front & Back -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- License Front -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload License Front</label>
                <input type="file" name="license_front" accept="image/*,.pdf" required
                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <!-- License Back -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload License Back</label>
                <input type="file" name="license_back" accept="image/*,.pdf" required
                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                Book Now
            </button>
        </div>
    </form>
</div>
</body>
</html>

<!-- Script to Auto Calculate Days -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const pickup = document.getElementById("pickup_datetime");
        const ret = document.getElementById("return_datetime");
        const totalDays = document.getElementById("total_days");

        function calculateDays() {
            if (pickup.value && ret.value) {
                const pickupDate = new Date(pickup.value);
                const returnDate = new Date(ret.value);

                if (returnDate > pickupDate) {
                    const diffTime = returnDate - pickupDate;
                    const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    totalDays.value = days + " Day(s)";
                } else {
                    totalDays.value = "Invalid range";
                }
            }
        }

        pickup.addEventListener("change", calculateDays);
        ret.addEventListener("change", calculateDays);
    });
</script>

