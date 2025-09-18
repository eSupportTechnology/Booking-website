<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Payment Settings</h3>
        <p class="text-gray-600">Configure how guests can pay for their bookings</p>
    </div>

    <form id="payments-form" action="{{ route('partner.homes.update.payments', $property) }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Payment Methods -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-credit-card text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Payment Methods</h4>
                    <p class="text-gray-600 text-sm">Choose how guests can pay for their stay</p>
                </div>
            </div>

            <div class="space-y-4">
                <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                    <input type="radio" name="payment_method" value="online" {{ $property->payment_method == 'online' ? 'checked' : '' }} class="sr-only">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center">
                        <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-globe text-green-600 mr-2"></i>
                            <span class="font-semibold text-gray-900">Online Payment</span>
                            <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Recommended</span>
                        </div>
                        <p class="text-gray-600 text-sm">Guests pay online when booking. Secure and convenient for both parties.</p>
                        <div class="flex items-center mt-2 space-x-2">
                            <i class="fab fa-cc-visa text-blue-600"></i>
                            <i class="fab fa-cc-mastercard text-red-600"></i>
                            <i class="fab fa-cc-amex text-blue-600"></i>
                            <i class="fab fa-paypal text-blue-600"></i>
                        </div>
                    </div>
                </label>

                <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                    <input type="radio" name="payment_method" value="credit" {{ $property->payment_method == 'credit' ? 'checked' : '' }} class="sr-only">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center">
                        <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-credit-card text-green-600 mr-2"></i>
                            <span class="font-semibold text-gray-900">Credit Card on Arrival</span>
                        </div>
                        <p class="text-gray-600 text-sm">Guests provide credit card details for guarantee, pay on arrival.</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Invoicing Information -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Invoicing Information</h4>
                    <p class="text-gray-600 text-sm">Set up your billing details for invoices</p>
                </div>
            </div>

            @php
                $invoicingInfo = $property->invoicing_info ? json_decode($property->invoicing_info, true) : [];
            @endphp

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Invoice Name</label>
                    <input type="text" name="invoice_name" value="{{ $invoicingInfo['invoice_name'] ?? Auth::user()->name }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Name for invoices" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Legal Company Name (optional)</label>
                    <input type="text" name="legal_company_name" value="{{ $invoicingInfo['legal_company_name'] ?? '' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Company name if applicable">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Billing Address</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="same_address" value="yes" {{ ($invoicingInfo['same_address'] ?? 'yes') == 'yes' ? 'checked' : '' }} class="sr-only">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-blue-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">Same as property address</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="same_address" value="no" {{ ($invoicingInfo['same_address'] ?? 'yes') == 'no' ? 'checked' : '' }} class="sr-only">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-blue-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">Different address</span>
                        </label>
                    </div>
                </div>

                <div id="billing-address" style="display: {{ ($invoicingInfo['same_address'] ?? 'yes') == 'no' ? 'block' : 'none' }};">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                            <input type="text" name="street" value="{{ $invoicingInfo['street'] ?? '' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Street address">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" name="city" value="{{ $invoicingInfo['city'] ?? '' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="City">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Address Line 1</label>
                            <input type="text" name="line1" value="{{ $invoicingInfo['line1'] ?? '' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Address line 1">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Postcode</label>
                            <input type="text" name="postcode" value="{{ $invoicingInfo['postcode'] ?? '' }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Postcode">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Benefits -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-100">
            <div class="flex items-start">
                <div class="bg-yellow-100 p-3 rounded-xl mr-4 mt-1">
                    <i class="fas fa-lightbulb text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Payment Benefits</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-yellow-700">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span>Secure payment processing</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Faster booking confirmations</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span>Improved conversion rates</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            <span>Guaranteed payments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Payment Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle radio button selections
    document.addEventListener('click', function(e) {
        const target = e.target.closest('label');
        if (!target) return;
        
        const input = target.querySelector('input[type="radio"]');
        if (!input) return;
        
        // Clear all radio buttons in the same group
        document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
            const radioLabel = radio.closest('label');
            const radioIndicator = radioLabel.querySelector('div[class*="border-"]');
            const radioDot = radioIndicator.querySelector('div');
            
            radioDot.classList.add('opacity-0');
            radioLabel.classList.remove('border-green-500', 'bg-green-50', 'border-blue-500', 'bg-blue-50');
        });
        
        // Select current radio
        input.checked = true;
        const indicator = target.querySelector('div[class*="border-"]');
        const dot = indicator.querySelector('div');
        
        dot.classList.remove('opacity-0');
        dot.classList.add('opacity-100');
        
        if (input.name === 'payment_method') {
            target.classList.add('border-green-500', 'bg-green-50');
        } else {
            target.classList.add('border-blue-500', 'bg-blue-50');
        }
        
        // Handle billing address visibility
        if (input.name === 'same_address') {
            document.getElementById('billing-address').style.display = 
                input.value === 'no' ? 'block' : 'none';
        }
    });
    
    // Initialize selected states on page load
    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        const label = radio.closest('label');
        const indicator = label.querySelector('div[class*="border-"]');
        const dot = indicator.querySelector('div');
        
        dot.classList.remove('opacity-0');
        dot.classList.add('opacity-100');
        
        if (radio.name === 'payment_method') {
            label.classList.add('border-green-500', 'bg-green-50');
        } else {
            label.classList.add('border-blue-500', 'bg-blue-50');
        }
    });
});
</script>