<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">House Rules</h3>
        <p class="text-gray-600">Set clear expectations for your guests</p>
    </div>

    <form id="rules-form" action="{{ route('partner.homes.update.rules', $property) }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Basic Rules -->
        <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border border-red-100">
            <div class="flex items-center mb-6">
                <div class="bg-red-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-gavel text-red-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Property Rules</h4>
                    <p class="text-gray-600 text-sm">Set basic rules for your property</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="smoking_allowed" value="1" {{ $property->policies?->smoking_allowed ? 'checked' : '' }} class="sr-only">
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm opacity-0"></i>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">🚬 Smoking allowed</span>
                            <p class="text-gray-600 text-sm">Allow guests to smoke on the property</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="children_allowed" value="1" {{ $property->policies?->children_allowed ? 'checked' : '' }} class="sr-only">
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm opacity-0"></i>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">👶 Children allowed</span>
                            <p class="text-gray-600 text-sm">Welcome families with children</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="parties_allowed" value="1" {{ $property->policies?->parties_allowed ? 'checked' : '' }} class="sr-only">
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm opacity-0"></i>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">🎉 Parties/events allowed</span>
                            <p class="text-gray-600 text-sm">Allow guests to host events</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Do you allow pets?</label>
                    <div class="space-y-2">
                        @foreach(['yes' => '✅ Yes', 'upon_request' => '❓ Upon request', 'no' => '❌ No'] as $value => $label)
                            <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                                <input type="radio" name="pets_allowed" value="{{ $value }}" {{ $property->policies?->pets_allowed == $value ? 'checked' : '' }} class="sr-only">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                    <div class="w-2 h-2 bg-red-600 rounded-full opacity-0"></div>
                                </div>
                                <span class="font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="pet-fees" class="mt-6" style="display: {{ in_array($property->policies?->pets_allowed, ['yes', 'upon_request']) ? 'block' : 'none' }};">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Pet fees</label>
                <div class="flex space-x-4">
                    <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="radio" name="pets_fees" value="free" {{ $property->policies?->pets_fees == 'free' ? 'checked' : '' }} class="sr-only">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                            <div class="w-2 h-2 bg-red-600 rounded-full opacity-0"></div>
                        </div>
                        <span class="font-medium">🆓 Free</span>
                    </label>
                    <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="radio" name="pets_fees" value="charges" {{ $property->policies?->pets_fees == 'charges' ? 'checked' : '' }} class="sr-only">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                            <div class="w-2 h-2 bg-red-600 rounded-full opacity-0"></div>
                        </div>
                        <span class="font-medium">💰 Charges apply</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Check-in/Check-out Times -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Check-in & Check-out Times</h4>
                    <p class="text-gray-600 text-sm">Set arrival and departure times</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-sign-in-alt text-green-600 mr-2"></i>
                        Check-in
                    </h5>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">From</label>
                            <input type="time" name="check_in_from" value="{{ $property->policies?->check_in_from ?? '15:00' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Until</label>
                            <input type="time" name="check_in_until" value="{{ $property->policies?->check_in_until ?? '18:00' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                        </div>
                    </div>
                </div>

                <div>
                    <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-sign-out-alt text-red-600 mr-2"></i>
                        Check-out
                    </h5>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">From</label>
                            <input type="time" name="check_out_from" value="{{ $property->policies?->check_out_from ?? '08:00' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Until</label>
                            <input type="time" name="check_out_until" value="{{ $property->policies?->check_out_until ?? '11:00' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <p class="text-yellow-800 font-medium">What if my house rules change?</p>
                    <p class="text-yellow-700 text-sm">You can easily customize these house rules later and additional house rules can be set after you complete registration.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save House Rules
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle checkbox selections
    document.addEventListener('click', function(e) {
        const target = e.target.closest('label');
        if (!target) return;
        
        const input = target.querySelector('input');
        if (!input) return;
        
        if (input.type === 'checkbox') {
            input.checked = !input.checked;
            const indicator = target.querySelector('div[class*="border-"]');
            const icon = target.querySelector('i');
            
            if (input.checked) {
                indicator.classList.add('bg-red-500', 'border-red-500');
                indicator.classList.remove('border-gray-300');
                icon.classList.remove('opacity-0');
                icon.classList.add('opacity-100');
                target.classList.add('border-red-500', 'bg-red-50');
            } else {
                indicator.classList.remove('bg-red-500', 'border-red-500');
                indicator.classList.add('border-gray-300');
                icon.classList.add('opacity-0');
                icon.classList.remove('opacity-100');
                target.classList.remove('border-red-500', 'bg-red-50');
            }
        }
        
        if (input.type === 'radio') {
            // Clear all radio buttons in the same group
            document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                const radioLabel = radio.closest('label');
                const radioIndicator = radioLabel.querySelector('div[class*="border-"]');
                const radioDot = radioIndicator.querySelector('div');
                
                radioDot.classList.add('opacity-0');
                radioLabel.classList.remove('border-red-500', 'bg-red-50');
            });
            
            // Select current radio
            input.checked = true;
            const indicator = target.querySelector('div[class*="border-"]');
            const dot = indicator.querySelector('div');
            
            dot.classList.remove('opacity-0');
            dot.classList.add('opacity-100');
            target.classList.add('border-red-500', 'bg-red-50');
            
            // Handle pet fees visibility
            if (input.name === 'pets_allowed') {
                document.getElementById('pet-fees').style.display = 
                    ['yes', 'upon_request'].includes(input.value) ? 'block' : 'none';
            }
        }
    });
    
    // Initialize selected states on page load
    document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
        const label = checkbox.closest('label');
        const indicator = label.querySelector('div[class*="border-"]');
        const icon = label.querySelector('i');
        
        indicator.classList.add('bg-red-500', 'border-red-500');
        indicator.classList.remove('border-gray-300');
        icon.classList.remove('opacity-0');
        icon.classList.add('opacity-100');
        label.classList.add('border-red-500', 'bg-red-50');
    });
    
    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        const label = radio.closest('label');
        const indicator = label.querySelector('div[class*="border-"]');
        const dot = indicator.querySelector('div');
        
        dot.classList.remove('opacity-0');
        dot.classList.add('opacity-100');
        label.classList.add('border-red-500', 'bg-red-50');
    });
});
</script>