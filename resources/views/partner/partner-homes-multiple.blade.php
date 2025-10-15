@extends('frontend.partner-layout')

@section('title', 'Homes - Private Rooms')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function stepForm() {
        return {
            step: 1,
            channelManager: 'yes',
            propertyName: '',
            selectedAmenities: [],
            servesBreakfast: false,
            breakfastIncluded: '',
            selectedBreakfasts: [],
            breakfastPrice: '',
            breakfastOptions: [],
            parkingReservation: '',
            parkingLocation: '',
            parkingType: '',
            parkingCost: '',
            showProperty: false,
            showHost: false,
            showNeighborhood: false,
            showNone: false,
            hostName: '',
            aboutProperty: '',
            aboutHost: '',
            aboutNeighborhood: '',

            toggleBreakfastOption(option) {
                if (this.selectedBreakfasts.includes(option)) {
                    this.selectedBreakfasts = this.selectedBreakfasts.filter(o => o !== option);
                } else {
                    this.selectedBreakfasts.push(option);
                }
            },

            saveStep1() {
                const propertyId = document.getElementById("propertyId").value;
                const subtypeId = document.getElementById("subtypeId").value;

                const payload = {
                    property_id: propertyId,
                    subtype_id: parseInt(subtypeId),
                    address: document.getElementById("address").value,
                    apartment: document.getElementById("apartment").value,
                    city: document.getElementById("city").value,
                    zipcode: document.getElementById("postcode").value,
                    country: document.getElementById("country").value,
                };
                console.log(payload);

                fetch(`/partner/property/${propertyId}/step2/${propertyId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Saved successfully!");
                            this.step++;
                        } else {
                            alert("Failed to save: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error saving data:", error);
                        alert("An error occurred while saving.");
                    });
            },

            saveStep3() {
                const propertyId = document.getElementById("propertyId").value;
                if (this.propertyName.trim() === '') {
                    alert("Property name is required.");
                    return;
                }
                const payload = {
                    property_id: propertyId,
                    title: this.propertyName,
                };

                fetch(`/partner/property/${propertyId}/step2/${propertyId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Step 3 saved successfully!");
                            this.step++;
                        } else {
                            alert("Failed to save: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error saving step 3 data:", error);
                        alert("An error occurred while saving step 3.");
                    });
            },

            saveStep4() {
                const propertyId = document.getElementById("propertyId").value;

                const payload = {
                    amenities: this.selectedAmenities, // This will be an array of IDs
                };

                fetch(`/partner/property/save-amenities/${propertyId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Amenities saved successfully!");
                            this.step++;
                        } else {
                            alert("Failed to save amenities");
                        }
                    })
                    .catch(error => {
                        console.error("Error saving amenities:", error);
                        alert("An error occurred while saving amenities.");
                    });
            },

            async saveStep5() {
                const propertyId = document.getElementById('propertyId').value;
                const payload = {
                    property_id: parseInt(document.getElementById('propertyId').value),
                    serve_breakfast: this.servesBreakfast === 'yes' ? true : false, // send as string
                    breakfast_included: this.breakfastIncluded || null, // should be 'included', 'extra', or null
                    breakfast_type: this.selectedBreakfasts.length > 0 ? this.selectedBreakfasts : null, // array of strings or null
                    breakfast_price: document.getElementById('breakfast_price')?.value || null,
                    parking_available: document.querySelector('input[name="parking"]:checked')?.value || null, // 'free', 'paid', 'no'
                    parking_cost: document.querySelector('input[name="parking"]:checked')?.value === 'paid'
                        ? document.getElementById('parking_cost')?.value : '0',                        
                    parking_reservation: document.querySelector('input[name="reservation_needed"]:checked')?.value || null, // 'yes' / 'no'
                    parking_location: document.querySelector('input[name="location"]:checked')?.value || null, // 'on_site' / 'off_site'
                    parking_type: document.querySelector('input[name="type"]:checked')?.value || null // 'private' / 'public'
                };


                try {
                    const response = await fetch(`/partner/property/save-services/${propertyId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();
                    if (result.success) {
                        console.log("✅ Services saved");
                        this.step++;
                    } else {
                        console.error("❌ Failed to save services:", result.message);
                    }
                } catch (error) {
                    console.error("❌ Error saving services:", error);
                }
            },

            saveStep6() {
                const selectedLanguages = [];
                const propertyId = document.getElementById('propertyId').value;
                document.querySelectorAll('.language-checkbox:checked').forEach((checkbox) => {
                    selectedLanguages.push(checkbox.value);
                });

                fetch(`/partner/property/save-languages/${propertyId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            property_id: propertyId,
                            languages: selectedLanguages
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Languages saved:", data.selected_languages);
                            this.step++;
                        } else {
                            console.error("Error saving languages:", data.message);
                            alert("Error saving languages.");
                        }
                    })
                    .catch(error => {
                        console.error("AJAX error:", error);
                        alert("Request failed.");
                    });
            },

            async saveStep7() {
                const propertyId = document.getElementById('propertyId').value;

                
                const smokingAllowed = document.getElementById('smokingAllowed').checked;
                const childrenAllowed = document.getElementById('childrenAllowed').checked;
                const partiesAllowed = document.getElementById('partiesAllowed').checked;

                const petOptions = document.querySelectorAll('input[name="pets"]');
                let petsAllowed = 'no';
                petOptions.forEach(option => {
                    if (option.checked) petsAllowed = option.value;
                });

                let petsFees = "0";
                if (petsAllowed !== 'no') {
                    const feeOptions = document.querySelectorAll('input[name="pet_charges"]');
                    feeOptions.forEach(option => {
                        if (option.checked) petsFees = option.value;
                    });
                }

                const checkInFrom = document.getElementById('checkInFrom').value;
                const checkInUntil = document.getElementById('checkInUntil').value;
                const checkOutFrom = document.getElementById('checkOutFrom').value;
                const checkOutUntil = document.getElementById('checkOutUntil').value;

                const payload = {
                    smoking_allowed: smokingAllowed,
                    children_allowed: childrenAllowed,
                    parties_allowed: partiesAllowed,
                    pets_allowed: petsAllowed,
                    pets_fees: petsFees,
                    check_in_from: checkInFrom,
                    check_in_until: checkInUntil,
                    check_out_from: checkOutFrom,
                    check_out_until: checkOutUntil,
                    cancellation_policy: "flexible" // You can wire this to a select/dropdown later
                };

                try {
                    const response = await fetch(`/partner/property/save-policy/${propertyId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();
                    if (data.success) {
                        console.log('Policy saved:', data);
                        this.step++;
                    } else {
                        console.error('Error:', data.message);
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                }
            },

            async saveStep8() {
                const propertyId = document.getElementById('propertyId').value;

                const payload = {
                    property_id: propertyId,
                    show_property: this.showProperty,
                    show_host: this.showHost,
                    show_neighborhood: this.showNeighborhood,
                    none_selected: this.showNone,
                    about_property: this.aboutProperty || '',
                    host_name: this.hostName || '',
                    about_host: this.aboutHost || '',
                    about_neighborhood: this.aboutNeighborhood || '',
                };

                try {
                    const response = await fetch(`/partner/property/${propertyId}/host-profile`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify(payload),
                    });

                    const result = await response.json();

                    if (result.success) {
                        console.log('✅ Host profile saved:', result.message);
                        // Optionally move to next step
                        window.location.href = "{{ url('/partner-homes-edit/' . $propertyId) }}?details=true&propertyType=multiple";                    
                    } else {
                        console.error('❌ Save failed:', result.message);
                    }
                } catch (error) {
                    console.error('❌ Error submitting host profile:', error);
                }
            }


        }
    }
</script>
<div>
    <input type="hidden" id="propertyId" value="{{ $propertyId }}">
    <input type="hidden" id="subtypeId" value="{{ $subtypeId }}">
</div>
<!-- Alpine Data Scope -->
<div x-data="stepForm()">

    <!-- Full-width Progress Bar (just under header) -->
    <div class="w-full bg-gray-200 h-2 ">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 9) + '%'">
        </div>
    </div>
    <!-- Step 1 -->
    <template x-if="step === 1">
        <div class="relative w-full max-w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-6 sm:my-10">
            <!-- Google Maps iframe full background -->
            <iframe
                class="absolute inset-0 w-full h-full"
                loading="lazy"
                src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                allowfullscreen>
            </iframe>

            <!-- Optional overlay for readability -->
            <div class="absolute inset-0"></div>

            <!-- Form content centered on map -->
            <div class="relative z-10 flex items-center justify-center md:justify-start h-auto p-4 sm:p-6 mt-[80px] sm:mt-[110px]">
                <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-4 sm:p-6 md:p-8 mb-4">
                    <h2 class="text-xl sm:text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>

                    <form action="#" method="POST">
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Find your address</label>
                            <input
                                type="text"
                                id="address"
                                name="address"
                                value="Sri Lanka"
                                class="mt-1 p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment or floor number (optional)</label>
                            <input
                                type="text"
                                id="apartment"
                                name="apartment"
                                value="aaa"
                                class="mt-1 p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div class="mb-4">
                            <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                            <select
                                id="country"
                                name="country"
                                class="mt-1 p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                                <option selected>Sri Lanka</option>
                            </select>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    value="a"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                            <div class="flex-1">
                                <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                                <input
                                    type="text"
                                    id="postcode"
                                    name="postcode"
                                    value="80400"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                        <div class="flex items-center mt-4">
                            <input
                                id="update_address"
                                type="checkbox"
                                name="update_address"
                                checked
                                class="mr-2 w-4 h-4 accent-blue-500">
                            <label for="update_address" class="text-sm text-gray-700">Update the address when moving the pin on the map.</label>
                        </div>

                        <!-- Dismissible message box -->
                        <div x-data="{ showMessage: true }" x-show="showMessage"
                            class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative text-sm sm:text-base"
                            role="alert">
                            <strong class="font-bold">Note:</strong>
                            <span class="block sm:inline">Make sure the pin location is accurate before continuing.</span>
                            <span @click="showMessage = false"
                                class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                                <svg class="fill-current h-5 w-5 sm:h-6 sm:w-6 text-yellow-800" role="button"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path
                                        d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                                </svg>
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mt-2">
                            Is the red pin location incorrect? Uncheck the option above and click or press on the map to move the pin.
                        </p>

                        <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
                            <!-- Back Button -->
                            <button
                                type="button"
                                @click="step > 1 ? step-- : step"
                                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded transition duration-200 text-sm sm:text-base">
                                ←
                            </button>

                            <!-- Continue Button -->
                            <button
                                type="button"
                                @click="saveStep1()"
                                :class="step === 8 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                :disabled="step === 8"
                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 transition duration-200 text-sm sm:text-base">
                                Continue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <template x-if="step === 2">
        <div>
            <section class="mb-12" x-data="{ channelManager: 'yes' }">
                <div class="max-w-5xl mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

                    <!-- Question Section -->
                    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                        <h2 class="text-lg font-semibold mb-2">
                            Do you want to connect this listing to your channel manager?
                        </h2>
                        <p class="text-gray-700 mb-6">
                            A channel manager is a third-party tool that lets you manage rates and availability across
                            different sites you might list your place on, including {{ config('domains.subdomain') }}. If you're already using
                            a channel manager, you can select 'Yes' to connect it to your listing.
                        </p>


                        <!-- Radio Buttons -->
                        <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                            <!-- Yes Option -->
                            <div>
                                <input type="radio" id="yes" name="channel_manager" value="yes"
                                    class="mr-2" x-model="channelManager">
                                <label for="yes" class="text-gray-700">
                                    Yes, I will connect this listing to my channel manager
                                </label>
                            </div>

                            <!-- Tooltip only if Yes is selected -->
                            <div x-show="channelManager === 'yes'" x-transition>
                                <div class="bg-red-100 border border-red-300 rounded p-2">
                                    <div class="flex items-start text-sm text-red-700 space-x-2">
                                        <!-- Inline icon -->
                                        <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                            alt="Help" class="w-5 h-5 md:w-6 md:h-6 mt-1" />

                                        <!-- Text block -->
                                        <p>
                                            Select 'Yes' only if you are already using a channel manager.
                                            You'll be able to connect your channel manager after your registration is
                                            complete – please continue to the next step.
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <!-- No Option -->
                            <div>
                                <input type="radio" id="no" name="channel_manager" value="no"
                                    class="mr-2" x-model="channelManager">
                                <label for="no" class="text-gray-700">
                                    No, I won't be using a channel manager at this time
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-between mt-6">
                            <!-- Back Button (Left) -->

                            <button type="button" @click="step = Math.max(step - 1, 1)"
                                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                ←
                            </button>


                            <!-- Continue Button (Right) -->
                            <button type="submit" @click="step = Math.min(step + 1, 13)"
                                :class="step === 9 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                :disabled="step === 9"
                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                                Continue
                            </button>
                        </div>
                    </div>
            </section>
        </div>
    </template>


    <template x-if="step === 3">
        <div class="max-w-4xl  lg:ml-24 mx-auto px-4 py-10">
            <!-- Heading -->
            <h1 class="text-3xl font-bold text-gray-900 mb-6">
                What's the name of your property?
            </h1>

            <!-- Input Container (taller white box) -->
            <div class="bg-white p-8 rounded shadow-md w-full max-w-2xl min-h-[220px] flex flex-col justify-between">
                <div>
                    <label for="property_name" class="block text-gray-700 text-base font-medium mb-3">
                        Property name
                    </label>
                    <input
                        
                        type="text"
                        id="property_name"
                        name="property_name"
                        x-model="propertyName"
                        class="w-full border border-gray-300 rounded-md px-4 py-4 text-lg focus:outline-none focus:border-blue-500"
                        placeholder="e.g., Sunset Villa"
                        required>
                    <p class="text-sm text-gray-500 mt-3">
                        This name will be seen by guests when they search for a place to stay.
                    </p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-10 flex justify-between items-center max-w-2xl">
                <!-- Back Button -->
                <button
                    type="button"
                    @click="step = Math.max(step - 1, 1)"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-6 h-12 flex items-center justify-center rounded">
                    ←
                </button>

                <!-- Continue Button -->
                <button
                    type="button"
                    @click="saveStep3()"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 h-12 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    Continue
                </button>
            </div>
        </div>
    </template>




    <template x-if="step === 4">
        <div class="max-w-4xl mx-auto lg:ml-24 px-4 py-10">
            <section class="mb-8">
                <h1 class="text-xl text-gray-700 font-bold mb-4">What can guests use at your place?</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Property Name Input + Checkboxes (2/3 Width) -->
                    <div class="md:col-span-2 flex">
                        <div
                            class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">


                            <!-- 9 Checkboxes Section -->

                            <div class="mt-2">
                                <h3
                                    class="text-gray-700 font-semibold mb-2">
                                    Select property type(s)</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
                                    @foreach($amenities as $amenity)
                                    <label class="flex items-center space-x-2">
                                        <input
                                            type="checkbox"
                                            name="property_types[]"
                                            value="{{ $amenity['id'] }}"
                                            class="text-blue-500"
                                            x-model="selectedAmenities" />
                                        <span>{{ $amenity['name'] }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips and Information (1/3 Width) -->
                    <div class="flex flex-col gap-4">

                        <!-- Tip Box 1 -->
                        <div x-data="{ show: true }" x-show="show"
                            class="bg-white p-4 border border-gray-200 rounded w-full md:w-[350px] lg:w-[400px]">

                            <div
                                class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                        alt="Help"
                                        class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                    <h3
                                        class="text-gray-700 text-sm text-bold">
                                        What if I don’t see a facility I
                                        offer?</h3>
                                </div>
                                <button @click="show = false"
                                    class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-700">
                                The facilities listed here are the ones most
                                searched for by guests. After you complete
                                your registration, you can add more
                                facilities from a larger list in the
                                extranet, the platform you'll use to manage
                                your property.
                                <br>
                                The ones selected here will apply to all of
                                your holiday homes.
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-10 flex justify-between items-center max-w-2xl">
                    <!-- Back Button -->
                    <button
                        type="button"
                        @click="step = Math.max(step - 1, 1)"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-6 h-12 flex items-center justify-center rounded">
                        ←
                    </button>

                    <!-- Continue Button -->
                    <button
                        type="button"
                        @click="saveStep4()"
                        class="bg-[#3CC0E9] text-white font-semibold px-6 h-12 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                        Continue
                    </button>
                </div>
        </div>
    </template>

    <template x-if="step === 5">
        <div 
            class="container mx-auto px-4 py-4 max-w-6xl mb-8">

            <!-- Header -->
            <h2 class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
                Services at your property
            </h2>

            <!-- Sections stacked vertically -->
            <div class="max-w-xl ml-6 flex flex-col space-y-8">

                <!-- Breakfast Section -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg mb-4 font-bold">Breakfast</h3>
                    <hr class="border-gray-300 mb-4" />

                    <!-- Serve breakfast -->
                    <p class="text-gray-700 mb-2 font-bold text-base">
                        Do you serve guests breakfast?
                    </p>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="breakfast" x-model="servesBreakfast" value="yes" class="mr-2"
                                @click="servesBreakfast = true" />
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="breakfast" x-model="servesBreakfast" value="no" class="mr-2"
                                checked @click="servesBreakfast = false; breakfastIncluded=''; selectedBreakfasts=[]; breakfastPrice=''" />
                            <span>No</span>
                        </label>
                    </div>

                    <!-- Include in price -->
                    <div x-show="servesBreakfast" x-transition class="mt-6">
                        <p class="text-gray-700 mb-2 font-bold text-base">
                            Is breakfast included in the price guests pay?
                        </p>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="breakfast_included" x-model="breakfastIncluded" value="included" class="mr-2"
                                    @click="breakfastIncluded = 'included'" />
                                <span>Yes, it's included</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="breakfast_included" x-model="breakfastIncluded" value="extra" class="mr-2"
                                    @click="breakfastIncluded = 'extra'" />
                                <span>No, it costs extra</span>
                            </label>
                        </div>
                    </div>

                    <!-- Breakfast price -->
                    <div x-show="servesBreakfast && breakfastIncluded === 'extra'" x-transition class="mt-6">
                        <p class="text-gray-700 mb-2 font-bold text-base">
                            Breakfast price per person, per day
                        </p>
                        <input type="text" x-model="breakfastPrice"
                            class="border border-gray-300 px-3 py-2 rounded w-full mb-1" placeholder="US$" />
                        <p class="text-sm text-gray-500">Including all fees and taxes</p>
                    </div>

                    <!-- Type of breakfast -->
                    <div x-show="servesBreakfast" x-transition class="mt-6">
                        <p class="text-gray-700 mb-2 font-bold text-base">
                            What type of breakfast do you offer?
                        </p>
                        <p class="text-sm text-gray-500 mb-2">Select all that apply</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="option in breakfastOptions" :key="option">
                                <button type="button"
                                    @click="toggleBreakfastOption(option)"
                                    :class="selectedBreakfasts.includes(option) ? 'bg-blue-100 border-blue-500 text-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="border px-3 py-1 rounded-full text-sm flex items-center space-x-1 transition">
                                    <span x-text="option"></span>
                                    <template x-if="selectedBreakfasts.includes(option)">
                                        <span class="ml-1 font-bold text-lg leading-none">×</span>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Parking Section -->
                <div x-data="{ parking: 'no' }" class="container bg-white shadow rounded-lg mx-auto p-6 max-w-6xl mb-8">
                    <h3 class="text-lg mb-4 font-bold">Parking</h3>
                    <hr class="border-gray-300 mb-4" />

                    <!-- Main Question -->
                    <p class="text-gray-700 mb-2 font-bold">
                        Is parking available to guests?
                    </p>
                    <div class="space-y-2 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="parking" id="free-parking" value="free" x-model="parking" class="mr-2" />
                            <span>Yes, free</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="parking" id="paid-parking" value="paid" x-model="parking" class="mr-2" />
                            <span>Yes, paid</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="parking" id="no-parking" value="no" x-model="parking" class="mr-2" />
                            <span>No</span>
                        </label>
                    </div>

                    <!-- Extra Fields for Free or Paid Parking -->
                    <div x-show="parking === 'free' || parking === 'paid'" x-transition class="space-y-4">
                        <!-- Reservation Needed -->
                        <div>
                            <p class="text-gray-700 font-semibold mb-1">Do they need to reserve a parking spot?</p>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="reservation_needed" value="yes" class="mr-2" />
                                    <span>Reservation needed</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="reservation_needed" value="no" class="mr-2" />
                                    <span>No reservation needed</span>
                                </label>
                            </div>
                        </div>

                        <!-- Parking Location -->
                        <div>
                            <p class="text-gray-700 font-semibold mb-1">Where is the parking located?</p>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="location" value="on_site" class="mr-2" />
                                    <span>On site</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="location" value="off_site" class="mr-2" />
                                    <span>Off site</span>
                                </label>
                            </div>
                        </div>

                        <!-- Parking Type -->
                        <div>
                            <p class="text-gray-700 font-semibold mb-1">What type of parking is it?</p>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="private" class="mr-2" />
                                    <span>Private</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="public" class="mr-2" />
                                    <span>Public</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Paid Parking - Cost Input -->
                    <div x-show="parking === 'paid'" x-transition class="mt-4">
                        <label class="block text-gray-700 font-semibold mb-1">How much does parking cost?</label>
                        <input type="text" name="cost" id="parking_cost" x-model="parkingCost" placeholder="e.g., $10 per day" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>
                </div>

            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between max-w-xl ml-6">
                <button type="button" @click="step = Math.max(step - 1, 1)"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                    ←
                </button>
                <button type="button" @click="saveStep5()"
                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    Continue
                </button>
            </div>
        </div>
    </template>




    <template x-if="step === 6">
        <div>
            <div class="container mx-auto px-4 py-8 max-w-2xl lg:ml-24">
                <!-- Header -->
                <h2 class="text-2xl font-bold mb-8 text-left">
                    What languages do you or your staff speak?
                </h2>

                <!-- Language Selection Section -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h3 class="text-lg  mb-4 font-bold">Select languages
                    </h3>
                    <div class="space-y-2">
                        @foreach ($languages as $lang)
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox"
                                class="mr-2 language-checkbox"
                                :value="'{{ $lang['id'] }}'" />
                            <span>{{ $lang['name'] }}</span>
                        </label>
                        @endforeach

                    </div>

                    <!-- Add Additional Languages -->
                    <div id="additionalLanguagesSection"
                        class="mt-4 hidden relative">
                        <h3 class="text-lg font-medium mb-2 ">Add
                            additional languages</h3>

                        <!-- Searchable dropdown container -->
                        <div class="relative w-full max-w-md">
                            <input type="text" id="languageInput"
                                oninput="filterDropdown()"
                                onclick="toggleDropdown()"
                                placeholder="Search languages..."
                                autocomplete="off"
                                class="w-full border rounded p-2 pr-10 cursor-pointer"
                                readonly />
                            <!-- Dropdown arrow -->
                            <button type="button"
                                onclick="toggleDropdown()"
                                class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
                                tabindex="-1">
                                ▼
                            </button>

                            <!-- Dropdown list -->
                            <ul id="languageDropdown"
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg hidden">
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Arabic
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">
                                    Bulgarian</li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Catalan
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Chinese
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Croatian
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Czech
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Danish
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer"
                                    onclick="selectLanguage(this)">Dutch
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Toggle Button for Additional Languages -->
                    <a href="#"
                        onclick="event.preventDefault(); toggleAdditionalLanguages();"
                        class="text-blue-500 hover:underline mt-4 block">
                        Add additional languages
                    </a>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <!-- Back Button on the left -->
                    <button type="button" @click="step = Math.max(step - 1, 1)"
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                        ←
                    </button>

                    <!-- Continue Button on the right -->
                    <button type="button" @click="saveStep6()"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                        Continue
                    </button>
                </div>

            </div>

            <script>
                function toggleAdditionalLanguages() {
                    const section = document.getElementById("additionalLanguagesSection");
                    section.classList.toggle("hidden");
                    if (!section.classList.contains("hidden")) {
                        document.getElementById("languageInput").focus();
                        showDropdown();
                    } else {
                        hideDropdown();
                    }
                }

                function toggleDropdown() {
                    const dropdown = document.getElementById("languageDropdown");
                    dropdown.classList.toggle("hidden");
                }

                function showDropdown() {
                    document.getElementById("languageDropdown").classList.remove("hidden");
                }

                function hideDropdown() {
                    document.getElementById("languageDropdown").classList.add("hidden");
                }

                function filterDropdown() {
                    const input = document.getElementById("languageInput");
                    const filter = input.value.toLowerCase();
                    const ul = document.getElementById("languageDropdown");
                    const items = ul.getElementsByTagName("li");
                    ul.classList.remove("hidden");
                    let visibleCount = 0;
                    for (let i = 0; i < items.length; i++) {
                        const txtValue = items[i].textContent || items[i].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            items[i].style.display = "";
                            visibleCount++;
                        } else {
                            items[i].style.display = "none";
                        }
                    }
                    // Hide dropdown if no matches
                    if (visibleCount === 0) {
                        ul.classList.add("hidden");
                    }
                }

                function selectLanguage(element) {
                    const input = document.getElementById("languageInput");
                    input.value = element.textContent;
                    hideDropdown();
                }

                // Close dropdown when clicking outside
                document.addEventListener("click", function(event) {
                    const dropdown = document.getElementById("languageDropdown");
                    const input = document.getElementById("languageInput");
                    const container = document.getElementById("additionalLanguagesSection");
                    if (
                        !container.contains(event.target)
                    ) {
                        hideDropdown();
                    }
                });
            </script>
        </div>
    </template>

    <template x-if="step === 7">
        <div>
            <div class="container mx-auto px-4 py-8 max-w-4xl lg:ml-24" x-data="{ petPolicy: 'no' }">
                <!-- Header -->
                <h2 class="text-2xl font-bold mb-8 text-left">House rules</h2>

                
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Left Section -->
                    <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
                        <!-- Toggle Switches -->
                        <div class="space-y-4">
                            <label class="flex items-center justify-between cursor-pointer">
                                <span>Smoking allowed</span>
                                <div class="relative">
                                    <input type="checkbox" id="smokingAllowed" class="sr-only peer" />
                                    <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                                    <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                            </label>

                            <label class="flex items-center justify-between cursor-pointer">
                                <span>Children allowed</span>
                                <div class="relative">
                                    <input type="checkbox" id="childrenAllowed" class="sr-only peer" checked />
                                    <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                                    <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                            </label>

                            <label class="flex items-center justify-between cursor-pointer">
                                <span>Parties/events allowed</span>
                                <div class="relative">
                                    <input type="checkbox" id="partiesAllowed" class="sr-only peer" />
                                    <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                                    <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                            </label>
                        </div>

                        <hr class="my-6 border-t border-gray-300">

                        <!-- Pet Policy -->
                        <div class="mt-6">
                            <h3 class="text-base font-semibold mb-2">Do you allow pets?</h3>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="pets" value="yes" x-model="petPolicy" class="mr-2">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="pets" value="upon_request" x-model="petPolicy" class="mr-2">
                                    <span>Upon request</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="pets" value="no" x-model="petPolicy" class="mr-2">
                                    <span>No</span>
                                </label>
                            </div>

                            <!-- Conditional Field -->
                            <div x-show="petPolicy === 'yes' || petPolicy === 'upon_request'" x-transition class="mt-4 space-y-2">
                                <label class="block text-base font-semibold mb-1">Are there additional charges for pets?</label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="pet_charges" value="free" class="mr-2">
                                    <span>Pets can stay for free</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="pet_charges" value="charges_apply" class="mr-2">
                                    <span>Charges may apply</span>
                                </label>
                            </div>
                        </div>

                        <hr class="my-6 border-t border-gray-300">

                        <!-- Check-in -->
                        <div class="mt-6">
                            <h3 class="text-base font-semibold mb-2">Check in</h3>
                            <div class="flex space-x-4">
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">From</label>
                                    <input type="time" id="checkInFrom" value="15:00" class="w-full border rounded p-2" />
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Until</label>
                                    <input type="time" id="checkInUntil" value="18:00" class="w-full border rounded p-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Check-out -->
                        <div class="mt-6">
                            <h3 class="text-base font-semibold mb-2">Check out</h3>
                            <div class="flex space-x-4">
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">From</label>
                                    <input type="time" id="checkOutFrom" value="08:00" class="w-full border rounded p-2" />
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-medium mb-1">Until</label>
                                    <input type="time" id="checkOutUntil" value="11:00" class="w-full border rounded p-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section: Tip Box -->
                    <div x-data="{ show: true }" x-show="show"
                        class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                    alt="Help"
                                    class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                <h3 class="text-gray-800 font-semibold text-base">
                                    What if my house rules change?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-700 mt-3">
                            You can easily customise these house rules later and additional house rules can be set on the
                            Policies page of the extranet after you complete registration.
                        </p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
               <div class="mt-8 flex justify-between">
                    <button type="button" @click="step = Math.max(step - 1, 1)"
                         class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                        ←
                    </button>
                    <button type="button" @click="saveStep7()"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                        Continue
                    </button>
                </div>
            </div>
        </div>

    </template>

    <template x-if="step === 8">
        <div 
            class="max-w-2xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8 lg:ml-32 py-6">

            <h2 class="text-2xl font-bold mb-8 text-left">Host Profile</h2>

            <div class="bg-white shadow-md rounded-lg p-4 space-y-6">
                <h2 class="text-base text-gray-800">
                    Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood. This info will appear on your property page.
                </h2>

                <!-- The Property Section -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" x-model="showProperty">
                        <span class="text-gray-800 font-sm">The property</span>
                    </label>

                    <div x-show="showProperty" x-transition class="mt-2">
                        <label class="block text-sm font-semibold text-gray-700">About the property</label>
                        <textarea rows="4" maxlength="1200" x-model="aboutProperty" placeholder="What makes your place unique? What can guests expect?"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>

                <!-- The Host Section -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" x-model="showHost">
                        <span class="text-gray-800 font-medium">The host</span>
                    </label>

                    <div x-show="showHost" x-transition class="mt-2 space-y-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Host name</label>
                            <input type="text" maxlength="80"  x-model="hostName" 
                                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                            <p class="text-right text-xs text-gray-500">0/80</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">About the host</label>
                            <textarea rows="4" maxlength="1200" x-model="aboutHost" placeholder="What are your interests? What do you like about hosting?" x-ref="about_host"
                                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                            <p class="text-right text-xs text-gray-500">0/1200</p>
                        </div>
                    </div>
                </div>

                <!-- The Neighborhood Section -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" x-model="showNeighborhood">
                        <span class="text-gray-800 font-medium">The neighborhood</span>
                    </label>

                    <div x-show="showNeighborhood" x-transition class="mt-2">
                        <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
                        <textarea rows="4" x-model="aboutNeighborhood" maxlength="1200" placeholder="What's the area like? Are there any attractions nearby?" x-ref="about_neighborhood"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>

                <!-- None of the Above Option -->
                <div>
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" x-model="showNone">
                        <span class="text-gray-800 font-medium">None of the above / I'll add these later</span>
                    </label>
                </div>
            </div>


            <!-- Navigation Buttons -->
            <div class="mt-12 flex justify-between">
                <button type="button" @click="step = Math.max(step - 1, 1)"
                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                    ←
                </button>

                <button type="button" @click="saveStep8()"
                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    Continue
                </button>
            </div>
        </div>

    </template>

    <template x-if="step === 9">
        <div class="mt-16">
            <div class="max-w-3xl mx-auto p-4 space-y-4 ">

                <!-- Step 1 - Completed -->
                <div class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 1</p>
                            <h2 class="text-base font-semibold">Property details</h2>
                            <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities
                                and more</p>
                        </div>
                    </div>
                    <a href="{{ route('partner.homes.multiple') }}" class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
                </div>

                <!-- Step 2 -->
                <div class="border border-gray-300  rounded-lg p-4 flex justify-between items-center ">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>
                    <a href="{{ url('/partner-homes-rooms/' . $propertyId) }}"
                        class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add room
                    </a>
                </div>

                <!-- Step 3 - Photos -->
                <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                            class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                        <div>
                            <p class="text-sm text-gray-500">Step 3</p>
                            <h2 class="text-base font-semibold">Photos</h2>
                            <p class="text-xs text-gray-600">Share some photos of your property so guests know what to
                                expect.</p>
                        </div>
                    </div>
                    <a href="{{ url('/partner-homes-images/' . $propertyId) }}"
                        class="border border-sky-400 text-sky-400 text-sm font-semibold px-4 py-2 rounded hover:bg-sky-50">
                        Add Photos
                    </a>

                </div>

                <!-- Step 4 - Final -->
                <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                            class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                        <div>
                            <p class="text-sm text-gray-500">Step 4</p>
                            <h2 class="text-base font-semibold">Final steps</h2>
                            <p class="text-xs text-gray-600">Set up payments and invoicing before you open for
                                bookings.</p>
                        </div>
                    </div>
                    <a href="{{ url('/partner-homes-payments/' . $propertyId) }}"
                        class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add final details
                    </a>
                </div>

            </div>
        </div>
    </template>





</div>

@endsection