@extends('partner.partner-layout')

@section('title', 'Create Property - Room Configuration | ' . config('domains.app_name'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-6xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 3])

    <div x-data="roomConfig()">
        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 h-2 mb-6">
            <div class="bg-blue-600 h-2 transition-all duration-500" :style="'width:' + (step * 100 / 3) + '%'"></div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6">Room Configuration</h2>
            <p class="text-gray-600 mb-6">Configure room details, bed types, bathroom settings, prices, and amenities for your property</p>

            <!-- Existing Rooms Display -->
            <div x-show="existingRooms && existingRooms.length > 0" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <h3 class="font-semibold text-green-900 mb-2">Existing Rooms ({{ count($existingRooms ?? []) }})</h3>
                <div class="flex flex-wrap gap-2">
                    <template x-for="room in existingRooms" :key="room.id">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            <span x-text="room.name || 'Room ' + room.id"></span>
                            <span x-show="room.price" class="ml-2">—</span>
                            <span x-show="room.price" class="font-semibold" x-text="formatPrice(room.price, room.currency || priceCurrency)"></span>
                        </span>
                    </template>
                </div>
            </div>

            <!-- Step 1: Room Details -->
            <template x-if="step === 1">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Room Details</h3>

                    <div class="space-y-6">
                        <!-- Room Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Room Type *</label>
                            <select x-model="roomType" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Room Type</option>
                                <template x-for="type in roomTypes" :key="type.id">
                                    <option :value="type.id" x-text="type.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Room Count -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">How many rooms of this type? *</label>
                            <input type="number" x-model.number="roomCount" min="1" @input="calculateMaxGuests()"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   placeholder="1">
                        </div>

                        <!-- Room Size -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Room Size *</label>
                                <input type="number" x-model.number="roomSize" min="1" step="0.01"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                                <select x-model="sizeUnit" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="square meters">Square Meters</option>
                                    <option value="square feet">Square Feet</option>
                                </select>
                            </div>
                        </div>

                        <!-- Price per Room -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price per Night *</label>
                                <input type="number" x-model.number="roomPrice" min="0" step="0.01"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select x-model="priceCurrency" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="USD">USD</option>
                                    <option value="LKR">LKR</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bed Types -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Which beds are available in this room? *</label>
                            <div class="space-y-4">
                                <template x-for="bedType in bedTypes" :key="bedType.id">
                                    <div class="flex items-center justify-between p-4 border border-gray-300 rounded-lg hover:border-blue-400 transition-colors">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900" x-text="bedType.name"></p>
                                            <p class="text-xs text-gray-500 mt-1" x-text="getBedDescription(bedType.name)"></p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="updateBedCount(bedType.name, (bedCounts[bedType.name] || 0) - 1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">−</button>
                                            <span class="w-12 text-center font-semibold text-gray-900" x-text="bedCounts[bedType.name] || 0"></span>
                                            <button type="button" @click="updateBedCount(bedType.name, (bedCounts[bedType.name] || 0) + 1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-blue-100 text-blue-600 hover:text-blue-800 transition-colors">+</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Max Guests UI with Auto toggle -->
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            <strong>Max Guests per Room:</strong>
                                            <span class="font-semibold text-blue-600 text-lg" x-show="autoCalculateGuests" x-text="maxGuestsPerRoom"></span>
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <label class="flex items-center space-x-2 text-sm">
                                            <input type="checkbox" x-model="autoCalculateGuests" @change="onAutoToggle()" class="form-checkbox h-4 w-4 text-blue-600">
                                            <span>Auto-calculate from beds</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-3" x-show="!autoCalculateGuests">
                                    <label class="block text-xs text-gray-600 mb-1">Edit Max Guests per Room</label>
                                    <input type="number" x-model.number="maxGuestsPerRoom" min="0" @input="calculateMaxGuests()"
                                           class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-2" x-show="maxGuestsPerRoom === 0">Set a value greater than 0 or enable auto-calc.</p>
                                </div>

                                <p class="text-xs text-gray-600 mt-2" x-show="autoCalculateGuests && maxGuestsPerRoom === 0">Add at least one bed to calculate guest capacity</p>
                            </div>
                        </div>

                        <!-- Smoking -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Smoking Allowed?</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="smoking" value="true" x-model="smokingAllowed" class="form-radio text-blue-600">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="smoking" value="false" x-model="smokingAllowed" class="form-radio text-blue-600">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit/step/3' : '/property/create/step/3' }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</a>
                        <button @click="saveStep1()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Continue</button>
                    </div>
                </div>
            </template>

            <!-- Step 2: Bathroom Configuration -->
            <template x-if="step === 2">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Bathroom Configuration</h3>

                    <div class="space-y-6">
                        <!-- Bathroom Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bathroom Type *</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="bathroom_type" value="private" x-model="bathroomType" class="form-radio text-blue-600">
                                    <span>Private</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="bathroom_type" value="shared" x-model="bathroomType" class="form-radio text-blue-600">
                                    <span>Shared</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bathroom Amenities -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Bathroom Amenities</label>
                            <div class="space-y-4">
                                <template x-if="bathroomAmenitiesList.length > 0">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        <template x-for="amenity in bathroomAmenitiesList" :key="amenity.id">
                                            <label class="flex items-center space-x-2 cursor-pointer p-2 rounded hover:bg-gray-50">
                                                <input type="checkbox" :value="amenity.id" x-model="bathroomAmenities"
                                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm text-gray-700" x-text="amenity.name"></span>
                                            </label>
                                        </template>
                                    </div>
                                </template>
                                <div x-show="bathroomAmenitiesList.length === 0"
                                     class="text-sm text-gray-500 italic">
                                    No bathroom-specific amenities found. You can add general amenities in the next step.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step--" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</button>
                        <button @click="saveStep2()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Continue</button>
                    </div>
                </div>
            </template>

            <!-- Step 3: Room Amenities -->
            <template x-if="step === 3">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Room Amenities</h3>

                    <div class="space-y-6">
                        <p class="text-sm text-gray-600 mb-4">Select amenities available in this room</p>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <template x-for="(category, categoryName) in allAmenities" :key="categoryName">
                                <div class="col-span-full">
                                    <h4 class="font-medium text-gray-900 mb-2" x-text="categoryName"></h4>
                                    <div class="space-y-2">
                                        <template x-for="amenity in category" :key="amenity.id">
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" :value="amenity.id" x-model="roomAmenities"
                                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm text-gray-700" x-text="amenity.name"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button @click="step--" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</button>
                        <button @click="saveStep3()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Continue</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    const baseUrl = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/3.5" : "/property/create/step/3.5" }}';
    const nextStepUrl = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/4" : "/property/create/step/4" }}';

    Alpine.data('roomConfig', () => ({
        step: 1,
        propertyId: {{ $property->id ?? 'null' }},
        roomType: '',
        roomCount: 1,
        maxGuestsPerRoom: 0,
        roomSize: '',
        sizeUnit: 'square meters',
        roomPrice: 0,
        priceCurrency: 'USD',
        smokingAllowed: false,
        bedCounts: {},
        bathroomType: 'private',
        bathroomAmenities: [],
        roomAmenities: [],
        roomTypes: @json($roomTypes ?? []),
        bedTypes: @json($bedTypes ?? []),
        allAmenities: @json($groupedAmenities ?? []),
        existingRooms: @json($existingRooms ?? []),
        baseUrl: baseUrl,
        nextStepUrl: nextStepUrl,

        // New: toggle for auto-calculation
        autoCalculateGuests: true,

        get bathroomAmenitiesList() {
            const bathroomKeywords = ['bathroom', 'bath', 'toilet', 'shower', 'sink', 'tub', 'toiletries', 'washroom'];
            const bathroomAmenities = [];

            Object.values(this.allAmenities).forEach(category => {
                category.forEach(amenity => {
                    const nameLower = amenity.name.toLowerCase();
                    if (bathroomKeywords.some(keyword => nameLower.includes(keyword))) {
                        bathroomAmenities.push(amenity);
                    }
                });
            });

            return bathroomAmenities;
        },

        getBedDescription(bedName) {
            const descriptions = {
                'Twin': '35–51 inches wide',
                'Full': '52–59 inches wide',
                'Queen': '60–70 inches wide',
                'King': '71–81 inches wide',
                'Bunk': 'Varying sizes',
                'Sofa Bed': 'Varying sizes',
                'Futon': 'Varying sizes'
            };
            return descriptions[bedName] || '';
        },

        init() {
            // Normalize bedCounts values to numbers if prefilled
            Object.keys(this.bedCounts).forEach(k => {
                this.bedCounts[k] = Number(this.bedCounts[k]) || 0;
                if (this.bedCounts[k] === 0) delete this.bedCounts[k];
            });

            this.roomCount = Number(this.roomCount) || 1;
            this.roomPrice = Number(this.roomPrice) || 0;
            this.priceCurrency = this.priceCurrency || 'USD';

            // If existingRooms have price/currency, keep them; otherwise use defaults
            // If server provided a prefilled maxGuestsPerRoom, keep it; otherwise auto-calc
            if (!this.maxGuestsPerRoom) this.autoCalculateGuests = true;

            this.calculateMaxGuests();
        },

        formatPrice(amount, currency) {
            if (amount === null || amount === undefined || amount === '') return '';
            return (currency ? currency + ' ' : '') + Number(amount).toFixed(2);
        },

        // Called when user toggles auto-calc checkbox
        onAutoToggle() {
            if (this.autoCalculateGuests) {
                // switch to auto: recalc from beds
                this.calculateMaxGuests();
            } else {
                // switch to manual: ensure there's a sensible default
                if (!this.maxGuestsPerRoom || this.maxGuestsPerRoom === 0) {
                    this.maxGuestsPerRoom = Math.max(1, Math.floor(this.maxGuestsPerRoom) || 1);
                }
                this.calculateMaxGuests();
            }
        },

        calculateMaxGuests() {
            // If autoCalculateGuests is true, compute per-room from bedCounts
            if (this.autoCalculateGuests) {
                let perRoom = 0;
                Object.values(this.bedCounts).forEach(count => {
                    perRoom += Number(count) || 0;
                });
                this.maxGuestsPerRoom = perRoom;
            } else {
                // manual: ensure numeric
                this.maxGuestsPerRoom = Number(this.maxGuestsPerRoom) || 0;
            }
            // Note: we no longer maintain or send a total_max_guests field.
        },

        updateBedCount(bedType, count) {
            const newCount = Math.max(0, Number(count) || 0);
            if (newCount > 0) {
                this.bedCounts[bedType] = newCount;
            } else {
                delete this.bedCounts[bedType];
            }

            // Only recalc if auto-calc is enabled
            if (this.autoCalculateGuests) {
                this.calculateMaxGuests();
            }
        },

        async saveStep1() {
            if (!this.propertyId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Property ID is required.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Validate numeric roomCount, roomSize and price
            this.roomCount = Math.max(1, parseInt(this.roomCount) || 1);
            this.roomSize = Number(this.roomSize) || 0;
            this.roomPrice = Number(this.roomPrice) || 0;
            this.maxGuestsPerRoom = Math.max(0, parseInt(this.maxGuestsPerRoom) || 0);
            this.calculateMaxGuests();

            if (!this.roomType || !this.roomCount || this.maxGuestsPerRoom <= 0 || !this.roomSize || this.roomPrice <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required Fields',
                    text: 'Please fill in all required fields and ensure price and guest capacity are greater than 0.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const sizeInSqM = this.sizeUnit === 'square feet' ? Math.round(this.roomSize * 0.092903) : this.roomSize;
            const beds = Object.keys(this.bedCounts).filter(bedType => this.bedCounts[bedType] > 0).map(bedType => ({
                type: bedType,
                count: this.bedCounts[bedType]
            }));

            // Send only the fields your server needs: include max_guests (per-room) but omit total_max_guests
            const payload = {
                property_id: this.propertyId,
                room_type_id: this.roomType,
                room_count: this.roomCount,
                max_guests_per_room: this.maxGuestsPerRoom,
                max_guests: this.maxGuestsPerRoom, // server expects this field name
                size_sq_m: sizeInSqM,
                price_per_night: this.roomPrice,
                currency: this.priceCurrency,
                smoking_allowed: this.smokingAllowed === 'true' || this.smokingAllowed === true,
                beds: beds
            };

            try {
                const response = await fetch(this.baseUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Room details saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Update existing rooms with server response (which may include price/currency)
                    this.existingRooms = data.rooms || [];
                    // Recalculate in case server returned rooms with bed info
                    this.calculateMaxGuests();
                    this.step++;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving room details',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving room details',
                    confirmButtonText: 'OK'
                });
            }
        },

        async saveStep2() {
            if (!this.existingRooms || this.existingRooms.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Rooms',
                    text: 'Please add rooms first.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const payload = {
                rooms: this.existingRooms.map(room => ({
                    id: room.id,
                    bathroom_type: this.bathroomType,
                    bathroom_amenities: this.bathroomAmenities
                }))
            };

            try {
                const response = await fetch(this.baseUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Bathroom details saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.step++;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving bathroom details',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving bathroom details',
                    confirmButtonText: 'OK'
                });
            }
        },

        async saveStep3() {
            if (!this.existingRooms || this.existingRooms.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Rooms',
                    text: 'Please add rooms first.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const formData = new FormData();
            this.existingRooms.forEach(room => formData.append('rooms[]', room.id));
            this.roomAmenities.forEach(amenityId => formData.append('amenities[]', amenityId));

            try {
                const response = await fetch(this.baseUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Room amenities saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = this.nextStepUrl;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving room amenities',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving room amenities',
                    confirmButtonText: 'OK'
                });
            }
        }
    }));
});
</script>

@endsection
