@extends('car_rentals.layout')

@section('title', 'Add Car | ' . config('app.name'))

@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div x-data="taxiWizard()" @open-modal.window="showModal = true">
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] border-r border-white h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 4) + '%'"></div>
    </div>

    <!-- Step 1: Car Type Image Selection -->
    <template x-if="step === 1">
        <div class="px-6 py-8 mt-6 w-full max-w-4xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <!-- Car Images Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Example car image -->
                <!-- Add other images as in your previous code -->
            </div>

            <!-- Taxi Type Section -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Select Taxi Type</h2>
                <p class="text-gray-500 text-sm mb-4">Click on a taxi type to select it. Each type shows an example image.</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4">
                    <!-- Standard -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'standard' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='standard'">
                        <img src="{{ asset('images/3.jpg') }}" alt="Standard" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">Standard</h3>
                        <p class="text-gray-500 text-sm text-center">Regular car, 4 passengers.</p>
                    </div>

                    <!-- People Carrier -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'peopleCarrier' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='peopleCarrier'">
                        <img src="{{ asset('images/10.jpg') }}" alt="People Carrier" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">People Carrier</h3>
                        <p class="text-gray-500 text-sm text-center">Larger car for 6–8 passengers.</p>
                    </div>

                    <!-- Large People Carrier -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'largePeopleCarrier' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='largePeopleCarrier'">
                        <img src="{{ asset('images/large.jpeg') }}" alt="Large People Carrier" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">Large People Carrier</h3>
                        <p class="text-gray-500 text-sm text-center">More than 8 passengers.</p>
                    </div>

                    <!-- Minibus -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'minibus' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='minibus'">
                        <img src="{{ asset('images/mini.jpeg') }}" alt="Minibus" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">Minibus</h3>
                        <p class="text-gray-500 text-sm text-center">12–20 passengers.</p>
                    </div>

                    <!-- Executive -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'executive' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='executive'">
                        <img src="{{ asset('images/2.jpg') }}" alt="Executive" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">Executive</h3>
                        <p class="text-gray-500 text-sm text-center">Premium sedan, luxury for business passengers.</p>
                    </div>

                    <!-- Luxury -->
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedCategory === 'luxury' ? 'ring-4 ring-blue-500 bg-blue-50' : ''"
                        @click="selectedCategory='luxury'">
                        <img src="{{ asset('images/bmw.jpeg') }}" alt="Luxury" class="w-full h-32 object-cover rounded-lg mb-2">
                        <h3 class="font-semibold text-center">Luxury</h3>
                        <p class="text-gray-500 text-sm text-center">High-end luxury cars (Mercedes, BMW, etc.).</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="saveStep1" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 2: Airport Taxi Basic Information -->
    <template x-if="step === 2">
        <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold">Enter Basic Information About the Taxi</h1>
            <p class="text-gray-500 text-sm mb-4">Provide details for the airport taxi you are registering.</p>

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Number Plate <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="e.g., WP-AB 1234" class="w-full p-2 border rounded-md text-sm" x-model="number_plate">
                    <p class="text-gray-500 text-sm mt-1">Enter the taxi’s registration number plate.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Taxi Color <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="e.g., White, Black, Silver" class="w-full p-2 border rounded-md text-sm" x-model="color">
                    <p class="text-gray-500 text-sm mt-1">Enter the color of the taxi.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Number of Passengers <span class="text-red-500">*</span>
                    </label>
                    <input type="number" placeholder="e.g., 4" class="w-full p-2 border rounded-md text-sm" min="1" max="50" x-model="passenger_capacity">
                    <p class="text-gray-500 text-sm mt-1">Enter the maximum number of passengers the taxi can carry.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Luggage Capacity <span class="text-gray-500">(Optional)</span>
                    </label>
                    <input type="number" placeholder="Number of suitcases" class="w-full p-2 border rounded-md text-sm" min="0" max="20" x-model="luggage_capacity">
                    <p class="text-gray-500 text-sm mt-1">Enter the number of suitcases or luggage the taxi can hold.</p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="saveStep2" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 3: Driver Details -->
    <template x-if="step === 3">
        <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Provide Driver Details</h1>
            <p class="text-gray-500 text-sm mb-4">Enter the driver’s information for this taxi listing.</p>

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Driver Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="Enter Driver Name" class="w-full p-2 border rounded-md text-sm" x-model="driver_name">
                    <p class="text-gray-500 text-sm mt-1">Full name of the taxi driver.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Contact Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="Enter Contact Number" class="w-full p-2 border rounded-md text-sm" x-model="driver_contact">
                    <p class="text-gray-500 text-sm mt-1">Mobile or phone number of the driver.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Email <span class="text-gray-500">(Optional)</span>
                    </label>
                    <input type="email" placeholder="Enter Email Address" class="w-full p-2 border rounded-md text-sm" x-model="driver_email">
                    <p class="text-gray-500 text-sm mt-1">Driver’s email address if available.</p>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Driver License Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" placeholder="Enter License Number" class="w-full p-2 border rounded-md text-sm" x-model="driver_license">
                    <p class="text-gray-500 text-sm mt-1">Official driver’s license number.</p>
                </div>
                <!-- Driver License Front -->
<div>
    <label class="block font-semibold text-sm mb-1">
        Driver License Front
    </label>
    <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*"
           @change="driver_license_front = $event.target.files[0]">
</div>

<!-- Driver License Back -->
<div>
    <label class="block font-semibold text-sm mb-1">
        Driver License Back
    </label>
    <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*"
           @change="driver_license_back = $event.target.files[0]">
</div>

<!-- Tourism License Front -->
<div>
    <label class="block font-semibold text-sm mb-1">
        Tourism License Front
    </label>
    <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*"
           @change="tourism_license_front = $event.target.files[0]">
</div>

<!-- Tourism License Back -->
<div>
    <label class="block font-semibold text-sm mb-1">
        Tourism License Back
    </label>
    <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*"
           @change="tourism_license_back = $event.target.files[0]">
</div>


                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Upload Driver Photo
                    </label>
                    <input type="file" class="w-full p-2 border rounded-md text-sm" accept="image/*" @change="driver_photo = $event.target.files[0]">
                    <p class="text-gray-500 text-sm mt-1">Upload a clear photo of the driver.</p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="saveStep3" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 4: Taxi Payment & Submit -->
    <template x-if="step === 4">
        <div class="px-6 py-8 mt-6 w-full max-w-xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Set Taxi Fare & Complete Submission</h1>
            <p class="text-gray-500 text-sm mb-4">Specify how the taxi payment will be calculated for customers.</p>

            <div>
                <label class="block font-semibold text-sm mb-1">Select Fare Calculation Type <span class="text-red-500">*</span></label>
                <select x-model="pricingType" class="w-full p-2 border rounded-md text-sm">
                    <option selected>Select an option</option>
                    <option value="perKm">Per Kilometer</option>
                    <option value="perDay">Per Day</option>
                </select>
            </div>

            <div class="space-y-4 mt-4">
                <div>
                    <label class="block font-semibold text-sm mb-1">Base Fare (Flag Fall) <span class="text-red-500">*</span></label>
                    <input type="number" x-model="baseFare" placeholder="e.g., 300" class="w-full p-2 border rounded-lg" step="0.01">
                </div>

                <div x-show="pricingType === 'perKm'" class="transition-all">
                    <label class="block font-semibold text-sm mb-1">Price per Kilometer <span class="text-red-500">*</span></label>
                    <input type="number" x-model="pricePerKm" placeholder="e.g., 50" class="w-full p-2 border rounded-lg" step="0.01">
                </div>

                <div x-show="pricingType === 'perDay'" class="transition-all">
                    <label class="block font-semibold text-sm mb-1">Price per Day <span class="text-red-500">*</span></label>
                    <input type="number" x-model="pricePerDay" placeholder="e.g., 16000" class="w-full p-2 border rounded-lg" step="0.01">
                </div>

               <!-- <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-sm mb-1">Airport Fee (Optional)</label>
                        <input type="number" x-model="airportFee" placeholder="e.g., 200" class="w-full p-2 border rounded-lg" step="0.01">
                    </div>
                    <div>
                        <label class="block font-semibold text-sm mb-1">Luggage Fee (Optional)</label>
                        <input type="number" x-model="luggageFee" placeholder="e.g., 50" class="w-full p-2 border rounded-lg" step="0.01">
                    </div>
                </div>-->
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button type="button" @click="saveStep4"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">
                    Submit
                </button>
            </div>
        </div>
    </template>

        <!-- Step 5: Upload Taxi Images -->
    <template x-if="step === 5">
        <div class="px-6 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Upload Taxi Images</h1>
            <p class="text-gray-500 text-sm mb-4">Upload clear photos of the taxi (front, back, inside). Preview before submitting.</p>

            <div class="space-y-4">
                <!-- Front Image -->
                <div>
                    <label class="block font-semibold text-sm mb-1">Front Image <span class="text-red-500">*</span></label>
                    <input type="file" accept="image/*" class="w-full p-2 border rounded-md text-sm"
                        @change="previewImage($event, 'front')">
                    <template x-if="images.front">
                        <img :src="images.frontPreview" class="w-40 h-28 object-cover rounded mt-2 border">
                    </template>
                </div>

                <!-- Back Image -->
                <div>
                    <label class="block font-semibold text-sm mb-1">Back Image <span class="text-red-500">*</span></label>
                    <input type="file" accept="image/*" class="w-full p-2 border rounded-md text-sm"
                        @change="previewImage($event, 'back')">
                    <template x-if="images.back">
                        <img :src="images.backPreview" class="w-40 h-28 object-cover rounded mt-2 border">
                    </template>
                </div>

                <!-- Inside Image -->
                <div>
                    <label class="block font-semibold text-sm mb-1">Inside Image <span class="text-red-500">*</span></label>
                    <input type="file" accept="image/*" class="w-full p-2 border rounded-md text-sm"
                        @change="previewImage($event, 'inside')">
                    <template x-if="images.inside">
                        <img :src="images.insidePreview" class="w-40 h-28 object-cover rounded mt-2 border">
                    </template>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button @click="step--"
                    class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="saveStep5"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">
                    Submit Images
                </button>
            </div>
        </div>
    </template>


    <!-- Modal -->
    
</div>

<script>
document.addEventListener("alpine:init", () => {
    Alpine.data("taxiWizard", () => ({
        step: 1,
        selectedCategory: '',
        showModal: false,
        taxi_id: null,

        // Step 2
        number_plate: '',
        color: '',
        passenger_capacity: '',
        luggage_capacity: '',

        // Step 3
        driver_name: '',
        driver_contact: '',
        driver_email: '',
        driver_license: '',
        driver_photo: null,
        driver_license_front: null,
driver_license_back: null,
tourism_license_front: null,
tourism_license_back: null,

        // Step 4
        pricingType: '',
        baseFare: '',
        pricePerKm: '',
        pricePerDay: '',
        airportFee: 0,
        luggageFee: 0,

        // Step 5
        images: {
            front: null,
            back: null,
            inside: null,
            frontPreview: null,
            backPreview: null,
            insidePreview: null,
        },

        // ================= Step 1 =================
        async saveStep1() {
            if (!this.selectedCategory) {
                Swal.fire({
                    icon: "warning",
                    title: "Required",
                    text: "Please select a taxi type before continuing!",
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            try {
                const response = await fetch("{{ route('taxis.storeStep1') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ taxi_type: this.selectedCategory })
                });

                const data = await response.json();
                if (data.success) {
                    this.taxi_id = data.taxi_id;
                    this.step++;
                    Swal.fire({
                        icon: "success",
                        title: "Saved",
                        text: data.message || "Step 1 completed!",
                        toast: true,
                        position: "top-end",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: "error", title: "Error", text: data.message || "Failed to save step 1" });
                }
            } catch (error) {
                Swal.fire({ icon: "error", title: "Error", text: "Something went wrong while saving." });
            }
        },

        // ================= Step 2 =================
        async saveStep2() {
            if (!this.number_plate || !this.color || !this.passenger_capacity) {
                Swal.fire({
                    icon: "warning",
                    title: "Required",
                    text: "Please fill all required fields!",
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            try {
                const response = await fetch("{{ route('taxis.storeStep2') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        taxi_id: this.taxi_id,
                        number_plate: this.number_plate,
                        color: this.color,
                        passenger_capacity: this.passenger_capacity,
                        luggage_capacity: this.luggage_capacity
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        let errorMsg = Object.values(errorData.errors).flat().join("\n");
                        Swal.fire({ icon: "error", title: "Validation Error", text: errorMsg });
                    }
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    this.step++;
                    Swal.fire({
                        icon: "success",
                        title: "Saved",
                        text: data.message || "Step 2 completed!",
                        toast: true,
                        position: "top-end",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } catch (error) {
                Swal.fire({ icon: "error", title: "Error", text: "Unexpected error occurred" });
            }
        },

     // ================= Step 3 =================
async saveStep3() {
    if (!this.driver_name || !this.driver_contact || !this.driver_license) {
        Swal.fire({
            icon: "warning",
            title: "Required",
            text: "Please fill all required fields!",
            toast: true,
            position: "top-end",
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    try {
        const formData = new FormData();
        formData.append("taxi_id", this.taxi_id);
        formData.append("name", this.driver_name);
        formData.append("contact_number", this.driver_contact);
        formData.append("email", this.driver_email);
        formData.append("license_number", this.driver_license);

        // Driver photo
        if (this.driver_photo) formData.append("photo", this.driver_photo);

        // Driver license images
        if (this.driver_license_front) formData.append("driver_license_front", this.driver_license_front);
        if (this.driver_license_back) formData.append("driver_license_back", this.driver_license_back);

        // Tourism license images
        if (this.tourism_license_front) formData.append("tourism_license_front", this.tourism_license_front);
        if (this.tourism_license_back) formData.append("tourism_license_back", this.tourism_license_back);

        const response = await fetch("{{ route('taxis.storeStep3') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            this.step++;
            Swal.fire({
                icon: "success",
                title: "Saved",
                text: data.message || "Driver details saved!",
                toast: true,
                position: "top-end",
                timer: 2000,
                showConfirmButton: false
            });
        }
    } catch (error) {
        Swal.fire({ icon: "error", title: "Error", text: "Unexpected error occurred" });
        console.error(error);
    }
},


        // ================= Step 4 =================
        async saveStep4() {
            if (!this.pricingType || !this.baseFare ||
                (this.pricingType === 'perKm' && !this.pricePerKm) ||
                (this.pricingType === 'perDay' && !this.pricePerDay)) {
                Swal.fire({ icon: "warning", title: "Required", text: "Please fill all required fields!" });
                return;
            }

            const formData = new FormData();
            formData.append("taxi_id", this.taxi_id);
            formData.append("pricing_type", this.pricingType);
            formData.append("base_fare", this.baseFare);
            if (this.pricingType === 'perKm') formData.append("price_per_km", this.pricePerKm);
            if (this.pricingType === 'perDay') formData.append("price_per_day", this.pricePerDay);
            formData.append("airport_fee", this.airportFee);
            formData.append("luggage_fee", this.luggageFee);

            try {
                const response = await fetch("{{ route('taxis.storeStep4') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    this.step++; // ✅ Move to Step 5
                    Swal.fire({
                        icon: "success",
                        title: "Fare Saved",
                        text: "Now upload taxi images.",
                        toast: true,
                        position: "top-end",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: "error", title: "Error", text: data.message || "Failed to save fare" });
                }
            } catch (error) {
                Swal.fire({ icon: "error", title: "Error", text: "Unexpected error occurred" });
            }
        },

        // ================= Step 5 =================
        previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                this.images[type] = file;
                this.images[type + "Preview"] = URL.createObjectURL(file);
            }
        },

        async saveStep5() {
            if (!this.images.front || !this.images.back || !this.images.inside) {
                Swal.fire({
                    icon: "warning",
                    title: "Required",
                    text: "Please upload all required images (front, back, inside).",
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            const formData = new FormData();
            formData.append("taxi_id", this.taxi_id);
            formData.append("front", this.images.front);
            formData.append("back", this.images.back);
            formData.append("inside", this.images.inside);

            try {
                const response = await fetch("{{ route('taxis.storeStep5') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Taxi Registered!",
                        text: "Your taxi has been successfully registered.",
                        confirmButtonText: "Go to Dashboard"
                    }).then(() => {
                        window.location.href = "/my/taxi";
                    });
                } else {
                    Swal.fire({ icon: "error", title: "Error", text: data.message || "Failed to upload images" });
                }
            } catch (error) {
                Swal.fire({ icon: "error", title: "Error", text: "Unexpected error occurred" });
            }
        }
    }));
});
</script>




@endsection
