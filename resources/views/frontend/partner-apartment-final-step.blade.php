<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Overview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- If using Laravel Vite setup -->

    <script src="https://cdn.tailwindcss.com"></script>
   <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <script defer>
        document.addEventListener("alpine:init", () => {
            Alpine.data("modals", () => ({
                showGeneralModal: false,
                showEditModal: false,
                openGeneralModal() {
                    this.showGeneralModal = true;
                    this.showEditModal = false;
                },
                openEditModal() {
                    this.showEditModal = true;
                },
                closeModal() {
                    this.showGeneralModal = false;
                    this.showEditModal = false;
                }
            }));
        });
    </script>
</head>
<body class="bg-gray-50 p-4" x-data="modals()">

    <!-- Header -->
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold">aaa</h1>
                <p class="text-sm text-gray-500">Sri Lanka aaa, Matale, CP, 80400, Sri Lanka</p>
            </div>
            <button @click="openGeneralModal" class="mt-2 sm:mt-0 px-4 py-2 bg-white border border-blue-600 text-blue-600 font-semibold rounded hover:bg-blue-50">
                General details
            </button>
        </div>

        <!-- Apartments List -->
        <div class="mt-6 space-y-4">
            @foreach([1,2,3] as $index)
                <div class="bg-white shadow rounded-md flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 space-y-4 sm:space-y-0">
                    <div class="flex items-start space-x-4">
                        <img src="{{ $index == 3 ? 'https://via.placeholder.com/120x100?text=Photo' : 'https://via.placeholder.com/120x100?text=Sketch' }}" alt="Room Image" class="w-28 h-24 object-cover rounded-md">
                        <div>
                            <h2 class="font-semibold text-gray-800">{{ $index == 2 ? 'Apartment' : 'Double Room' }}</h2>
                            <p class="text-sm text-gray-600">1 apartment with this layout</p>
                            <p class="text-sm text-gray-500">Bedrooms: 1 | Guests: 2 | Price: {{ $index == 3 ? 'US$20' : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs rounded font-medium {{ $index == 3 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $index == 3 ? 'Complete' : 'In progress' }}
                        </span>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Duplicate</a>
                        <a href="#" @click.prevent="openEditModal" class="text-blue-600 text-sm hover:underline">Edit</a>
                        <a href="#" class="text-blue-600 text-sm hover:underline">Delete</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add Apartment Button -->
        <div class="mt-6">
            <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50">Add apartment</button>
        </div>

        <!-- Complete Registration Button -->
        <div class="mt-6">
            <button class="w-full bg-gray-300 text-gray-600 py-3 rounded cursor-not-allowed" disabled>Complete registration</button>
        </div>
    </div>

    <!-- General Modal -->
    <div x-show="showGeneralModal" class="fixed inset-0 bg-black bg-opacity-40 z-40 flex items-center justify-center" x-cloak>
        <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
            <button @click="closeModal" class="absolute top-2 right-3 text-gray-600 text-lg font-bold">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Which details would you like to edit?</h2>
            <div class="divide-y text-sm">
                <div class="flex justify-between py-2"><span>Address</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Facilities</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Breakfast details</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Parking details</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Languages spoken</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Property name</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>House rules</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Availability</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 bg-black bg-opacity-40 z-40 flex items-center justify-center" x-cloak>
        <div class="bg-white w-full max-w-xl p-6 rounded-lg shadow-lg relative">
            <button @click="closeModal" class="absolute top-2 right-3 text-gray-600 text-lg font-bold">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Which details would you like to edit?</h2>
            <div class="divide-y text-sm">
                <div class="flex justify-between py-2"><span>Sleeping arrangements</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Amenities</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Photos</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Base price</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Non-refundable price</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
                <div class="flex justify-between py-2"><span>Layout</span><a href="#" class="text-blue-600 hover:underline">Edit</a></div>
            </div>
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
