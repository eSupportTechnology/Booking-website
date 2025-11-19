<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Pricing Settings</h3>
        <p class="text-gray-600">Set your property pricing and commission rates</p>
    </div>

    <form id="pricing-form" action="{{ route('partner.homes.update.pricing', $property) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Enhanced Pricing Section -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Property Pricing</h4>
                    <p class="text-gray-600 text-sm">Set your base pricing structure</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adult Price (per night)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number"
                               name="adult_price"
                               value="{{ $property->adult_price ?? '' }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                               placeholder="0.00"
                               required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Child Price (per night)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number"
                               name="child_price"
                               value="{{ $property->child_price ?? '' }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-8 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                               placeholder="0.00">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Commission Rate (Set by Admin)</label>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-percentage text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-blue-900">
                                        {{ number_format(\App\Models\AdminSettings::getGlobalCommissionRate(), 2) }}%
                                    </p>
                                    <p class="text-sm text-blue-700">Current Commission Rate</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-blue-600 font-medium">Applied to all bookings</p>
                                <p class="text-xs text-blue-500">Set by administrator</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="commission_rate" value="{{ \App\Models\AdminSettings::getGlobalCommissionRate() }}">
                </div>


            </div>
        </div>
        
        <!-- Commission Breakdown Section -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-calculator text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Final Prices (Including Commission)</h4>
                    <p class="text-gray-600 text-sm">These are the prices customers will see</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-xl border border-green-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adult Price (per night) with Commission</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number"
                               id="adult_price_with_commission"
                               class="w-full pl-8 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-not-allowed text-lg font-semibold text-green-700"
                               placeholder="0.00"
                               readonly>
                    </div>
                    <div class="mt-2 text-xs text-gray-600">
                        <span id="adult_base_price_display">Base: $0.00</span> + 
                        <span id="adult_commission_display">Commission: $0.00</span>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-green-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Child Price (per night) with Commission</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number"
                               id="child_price_with_commission"
                               class="w-full pl-8 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-not-allowed text-lg font-semibold text-green-700"
                               placeholder="0.00"
                               readonly>
                    </div>
                    <div class="mt-2 text-xs text-gray-600">
                        <span id="child_base_price_display">Base: $0.00</span> + 
                        <span id="child_commission_display">Commission: $0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Currency Selection -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-coins text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Currency</h4>
                    <p class="text-gray-600 text-sm">Select your preferred currency</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Currency</label>
                    <select name="currency" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200">
                        <option value="USD" {{ ($property->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ ($property->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="GBP" {{ ($property->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                        <option value="LKR" {{ ($property->currency ?? 'USD') == 'LKR' ? 'selected' : '' }}>LKR - Sri Lankan Rupee</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Pricing Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adultPriceInput = document.querySelector('input[name="adult_price"]');
    const childPriceInput = document.querySelector('input[name="child_price"]');

    function calculateTotalPrice() {
        const adultPrice = parseFloat(adultPriceInput.value) || 0;
        const childPrice = parseFloat(childPriceInput.value) || 0;
        const commissionRate = {{ \App\Models\AdminSettings::getGlobalCommissionRate() }};

        const adultCommission = adultPrice * (commissionRate / 100);
        const childCommission = childPrice * (commissionRate / 100);
        
        const adultPriceWithCommission = adultPrice + adultCommission;
        const childPriceWithCommission = childPrice + childCommission;

        // Update final prices
        document.getElementById('adult_price_with_commission').value = adultPriceWithCommission.toFixed(2);
        document.getElementById('child_price_with_commission').value = childPriceWithCommission.toFixed(2);
        
        // Update breakdown displays
        document.getElementById('adult_base_price_display').textContent = `Base: $${adultPrice.toFixed(2)}`;
        document.getElementById('adult_commission_display').textContent = `Commission: $${adultCommission.toFixed(2)}`;
        document.getElementById('child_base_price_display').textContent = `Base: $${childPrice.toFixed(2)}`;
        document.getElementById('child_commission_display').textContent = `Commission: $${childCommission.toFixed(2)}`;
    }

    // Calculate on input change
    [adultPriceInput, childPriceInput].forEach(input => {
        if (input) {
            input.addEventListener('input', calculateTotalPrice);
        }
    });

    // Calculate on page load
    calculateTotalPrice();

    // Handle form submission
    document.getElementById('pricing-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the calculated prices with the response data
                if (data.data) {
                    document.getElementById('adult_price_with_commission').value = data.data.adult_price_with_commission.toFixed(2);
                    document.getElementById('child_price_with_commission').value = data.data.child_price_with_commission.toFixed(2);
                    
                    // Update breakdown displays
                    document.getElementById('adult_base_price_display').textContent = `Base: $${data.data.adult_price.toFixed(2)}`;
                    document.getElementById('adult_commission_display').textContent = `Commission: $${data.data.adult_commission.toFixed(2)}`;
                    document.getElementById('child_base_price_display').textContent = `Base: $${data.data.child_price.toFixed(2)}`;
                    document.getElementById('child_commission_display').textContent = `Commission: $${data.data.child_commission.toFixed(2)}`;
                }
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                successDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <div>
                            <div class="font-semibold">Pricing Updated Successfully!</div>
                            <div class="text-sm opacity-90">Using admin commission rate</div>
                        </div>
                    </div>
                `;
                document.body.appendChild(successDiv);

                setTimeout(() => {
                    successDiv.remove();
                }, 4000);
            } else {
                throw new Error(data.message || 'Failed to save pricing settings');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <div>Failed to save pricing settings. Please try again.</div>
                </div>
            `;
            document.body.appendChild(errorDiv);

            setTimeout(() => {
                errorDiv.remove();
            }, 3000);
        });
    });
});
</script>
