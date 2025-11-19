<div x-data="pricingCalculator()" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Enhanced Pricing</h3>
    
    <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="form-field">
            <label class="block text-sm font-medium text-gray-700 mb-1">Adult Price (per night)</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                <input type="number" 
                       x-model="adultPrice" 
                       @input="calculateTotal" 
                       data-autosave
                       data-validate
                       name="adult_price"
                       step="0.01"
                       min="0"
                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
            </div>
        </div>
        
        <div class="form-field">
            <label class="block text-sm font-medium text-gray-700 mb-1">Child Price (per night)</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                <input type="number" 
                       x-model="childPrice" 
                       @input="calculateTotal" 
                       data-autosave
                       data-validate
                       name="child_price"
                       step="0.01"
                       min="0"
                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
            </div>
        </div>
    </div>
    
    <div class="form-field mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Commission Rate (%)</label>
        <div class="relative">
            <input type="number" 
                   x-model="commissionRate" 
                   @input="calculateTotal" 
                   data-autosave
                   data-validate
                   name="commission_rate"
                   step="0.01"
                   min="0"
                   max="100"
                   class="w-full pr-8 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">%</span>
        </div>
    </div>
    
    <!-- Pricing Summary -->
    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
        <h4 class="font-medium text-gray-900 mb-3">Pricing Summary</h4>
        
        <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Adult Price:</span>
                <span class="font-medium" x-text="'$' + parseFloat(adultPrice || 0).toFixed(2)"></span>
            </div>
            
            <div class="flex justify-between items-center" x-show="childPrice > 0">
                <span class="text-gray-600">Child Price:</span>
                <span class="font-medium" x-text="'$' + parseFloat(childPrice || 0).toFixed(2)"></span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Base Price:</span>
                <span class="font-medium" x-text="'$' + basePrice.toFixed(2)"></span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Commission (<span x-text="commissionRate"></span>%):</span>
                <span class="font-medium text-orange-600" x-text="'$' + commissionAmount.toFixed(2)"></span>
            </div>
            
            <div class="border-t border-gray-300 pt-2 mt-2">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Total Price:</span>
                    <span class="font-bold text-lg text-green-600" x-text="'$' + totalPrice.toFixed(2)"></span>
                </div>
            </div>
        </div>
        
        <!-- Price Breakdown Chart (Mobile-friendly) -->
        <div class="mt-4">
            <div class="flex items-center text-xs text-gray-600 mb-2">
                <span>Price Breakdown</span>
            </div>
            <div class="flex rounded-lg overflow-hidden h-3">
                <div class="bg-blue-500 transition-all duration-300" 
                     :style="`width: ${basePrice > 0 ? (basePrice / totalPrice) * 100 : 0}%`"
                     :title="`Base Price: $${basePrice.toFixed(2)}`"></div>
                <div class="bg-orange-500 transition-all duration-300" 
                     :style="`width: ${commissionAmount > 0 ? (commissionAmount / totalPrice) * 100 : 0}%`"
                     :title="`Commission: $${commissionAmount.toFixed(2)}`"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>Base Price</span>
                <span>Commission</span>
            </div>
        </div>
    </div>
    
    <!-- Save Button -->
    <div class="form-buttons flex flex-col md:flex-row gap-2 mt-6">
        <button type="button" 
                @click="savePricing()"
                :disabled="!adultPrice || adultPrice <= 0"
                :class="(!adultPrice || adultPrice <= 0) ? 
                    'bg-gray-300 text-gray-500 cursor-not-allowed' : 
                    'bg-blue-500 hover:bg-blue-600 text-white cursor-pointer'"
                class="w-full md:w-auto px-6 py-3 rounded-lg font-medium transition-colors">
            Save Pricing
        </button>
        
        <button type="button" 
                @click="resetPricing()"
                class="w-full md:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
            Reset
        </button>
    </div>
</div>

<script>
function pricingCalculator() {
    return {
        adultPrice: {{ $property->adult_price ?? 0 }},
        childPrice: {{ $property->child_price ?? 0 }},
        commissionRate: {{ $property->commission_rate ?? 10 }},
        basePrice: 0,
        commissionAmount: 0,
        totalPrice: 0,
        
        init() {
            this.calculateTotal();
        },
        
        calculateTotal() {
            this.basePrice = parseFloat(this.adultPrice || 0) + parseFloat(this.childPrice || 0);
            this.commissionAmount = this.basePrice * (parseFloat(this.commissionRate || 0) / 100);
            this.totalPrice = this.basePrice + this.commissionAmount;
        },
        
        async savePricing() {
            if (!this.adultPrice || this.adultPrice <= 0) {
                window.showError('Adult price is required');
                return;
            }
            
            try {
                const response = await fetch(`/partner/properties/{{ $property->id ?? 'ID' }}/pricing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        adult_price: parseFloat(this.adultPrice),
                        child_price: parseFloat(this.childPrice || 0),
                        commission_rate: parseFloat(this.commissionRate),
                        property_id: {{ $property->id ?? 'null' }}
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    window.showSuccess('Pricing saved successfully');
                } else {
                    window.showError(result.message || 'Failed to save pricing');
                }
            } catch (error) {
                window.showError('Failed to save pricing');
            }
        },
        
        resetPricing() {
            this.adultPrice = 0;
            this.childPrice = 0;
            this.commissionRate = 10;
            this.calculateTotal();
        }
    }
}
</script>