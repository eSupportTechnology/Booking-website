<div class="p-8 max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h3 class="text-3xl font-bold text-gray-900 mb-2">Property Services</h3>
        <p class="text-gray-600 text-lg">Enhance your guest experience with premium services</p>
    </div>

    <form id="services-form" class="space-y-8 bg-white rounded-3xl shadow-xl p-8 border border-gray-100" action="{{ route('partner.homes.update.services', $property) }}" method="POST">
        @csrf

        <!-- Breakfast Section -->
        <section class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl p-6 border border-orange-100 transition-all duration-300 hover:shadow-md">
            <header class="flex items-center mb-6">
                <div class="bg-orange-100 p-3 rounded-xl mr-4 shadow-sm">
                    <i class="fas fa-utensils text-orange-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900">Breakfast Service</h4>
                    <p class="text-gray-600 text-sm">Offer delicious meals to start your guests' day right</p>
                </div>
            </header>

            <!-- Serve Breakfast Toggle -->
            <label class="group flex items-center p-5 bg-white rounded-xl border-2 {{ $property->services?->serve_breakfast ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }} hover:border-orange-400 cursor-pointer transition-all duration-200 mb-6 shadow-sm">
                <input type="checkbox" name="serve_breakfast" value="1" id="serve_breakfast" {{ $property->services?->serve_breakfast ? 'checked' : '' }} class="sr-only peer">
                <div>
                    <span class="font-semibold text-gray-900 text-base">We serve breakfast</span>
                    <p class="text-gray-600 text-sm">Provide morning meals for your guests</p>
                </div>
            </label>

            <!-- Conditional Details -->
            <div id="breakfast-details" class="space-y-6 ml-2" style="display: {{ $property->services?->serve_breakfast ? 'block' : 'none' }};">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pricing Option -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pricing Model</label>
                        <select name="breakfast_included" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition-all duration-200">
                            <option value="included" {{ $property->services?->breakfast_included == 'included' ? 'selected' : '' }}>🆓 Included in price</option>
                            <option value="extra" {{ $property->services?->breakfast_included == 'extra' ? 'selected' : '' }}>💰 Extra charge</option>
                        </select>
                    </div>

                    <!-- Price Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (if extra)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" name="breakfast_price" value="{{ $property->services?->breakfast_price }}" step="0.01" placeholder="0.00"
                                   class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition-all duration-200">
                        </div>
                    </div>
                </div>

                <!-- Breakfast Types -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Breakfast Types Offered</label>
                    @php
                        $breakfastTypes = $property->services?->breakfast_type ?? [];
                        if (is_string($breakfastTypes)) {
                            $breakfastTypes = json_decode($breakfastTypes, true) ?? [];
                        }
                    @endphp
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['continental' => '🥐 Continental', 'american' => '🍳 American', 'buffet' => '🍽️ Buffet', 'asian' => '🍜 Asian'] as $type => $label)
                            <label class="group flex items-center p-3 bg-white rounded-xl border-2 {{ in_array($type, $breakfastTypes) ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }} hover:border-orange-300 cursor-pointer transition-all duration-200">
                                <input type="checkbox" name="breakfast_type[]" value="{{ $type }}" {{ in_array($type, $breakfastTypes) ? 'checked' : '' }} class="sr-only peer">
                                <span class="text-sm font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Parking Section -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 transition-all duration-300 hover:shadow-md">
            <header class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4 shadow-sm">
                    <i class="fas fa-car text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900">Parking Service</h4>
                    <p class="text-gray-600 text-sm">Manage parking options for your guests</p>
                </div>
            </header>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Availability</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach(['no' => '🚫 No parking', 'free' => '🆓 Free parking', 'paid' => '💰 Paid parking'] as $value => $label)
                            <label class="group flex items-center p-4 bg-white rounded-xl border-2 {{ $property->services?->parking_available == $value ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} hover:border-blue-400 cursor-pointer transition-all duration-200">
                                <input type="radio" name="parking_available" value="{{ $value }}" {{ $property->services?->parking_available == $value ? 'checked' : '' }} class="sr-only peer">
                                <span class="font-medium text-sm">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Conditional Parking Details -->
                <div id="parking-details" class="space-y-6 ml-2" style="display: {{ in_array($property->services?->parking_available, ['free', 'paid']) ? 'block' : 'none' }};">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Daily Cost ($)</label>
                            <input type="number" name="parking_cost" value="{{ $property->services?->parking_cost }}" step="0.01" placeholder="0.00"
                                   class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Reservation Required</label>
                            <select name="parking_reservation" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-200">
                                <option value="yes" {{ $property->services?->parking_reservation == 'yes' ? 'selected' : '' }}>✅ Yes, required</option>
                                <option value="no" {{ $property->services?->parking_reservation == 'no' ? 'selected' : '' }}>❌ No, not required</option>
                                <option value="not_needed" {{ $property->services?->parking_reservation == 'not_needed' ? 'selected' : '' }}>➖ Not needed</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                            <select name="parking_location" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-200">
                                <option value="on_site" {{ $property->services?->parking_location == 'on_site' ? 'selected' : '' }}>🏢 On-site</option>
                                <option value="off_site" {{ $property->services?->parking_location == 'off_site' ? 'selected' : '' }}>🚶 Off-site</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                            <select name="parking_type" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-200">
                                <option value="private" {{ $property->services?->parking_type == 'private' ? 'selected' : '' }}>🔒 Private</option>
                                <option value="public" {{ $property->services?->parking_type == 'public' ? 'selected' : '' }}>🌐 Public</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6">
            <button type="submit"
                    class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300 min-w-48">
                <i class="fas fa-save mr-2"></i>
                Save Services
            </button>
        </div>
    </form>
</div>

<script>
// Enhanced interactive logic
document.addEventListener('DOMContentLoaded', function () {
    const $ = (sel) => document.querySelector(sel);

    // Handle conditional visibility on page load
    const serveBreakfastInput = $('#serve_breakfast');
    if (serveBreakfastInput && serveBreakfastInput.checked) {
        $('#breakfast-details').style.display = 'block';
    }

    const parkingInputs = document.querySelectorAll('input[name="parking_available"]');
    parkingInputs.forEach(input => {
        if (input.checked && ['free', 'paid'].includes(input.value)) {
            $('#parking-details').style.display = 'block';
        }
    });

    // Handle checkbox and radio changes for conditional visibility and styling
    document.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') {
            const label = e.target.closest('label');
            if (e.target.checked) {
                label.classList.remove('border-gray-200');
                label.classList.add('border-orange-500', 'bg-orange-50');
            } else {
                label.classList.remove('border-orange-500', 'bg-orange-50');
                label.classList.add('border-gray-200');
            }
        }
        
        if (e.target.type === 'radio') {
            // Clear all radio buttons in the same group
            document.querySelectorAll(`input[name="${e.target.name}"]`).forEach(radio => {
                const label = radio.closest('label');
                if (label) {
                    label.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50');
                    label.classList.add('border-gray-200');
                }
            });
            
            // Style the selected radio
            const selectedLabel = e.target.closest('label');
            if (selectedLabel) {
                selectedLabel.classList.remove('border-gray-200');
                if (e.target.name === 'payment_method') {
                    selectedLabel.classList.add('border-green-500', 'bg-green-50');
                } else {
                    selectedLabel.classList.add('border-blue-500', 'bg-blue-50');
                }
            }
        }
        
        if (e.target.id === 'serve_breakfast') {
            $('#breakfast-details').style.display = e.target.checked ? 'block' : 'none';
        }

        if (e.target.name === 'parking_available') {
            $('#parking-details').style.display = ['free', 'paid'].includes(e.target.value) ? 'block' : 'none';
        }
    });
    
    // Initialize radio button styles
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        input.dispatchEvent(new Event('change'));
    });
});
</script>
