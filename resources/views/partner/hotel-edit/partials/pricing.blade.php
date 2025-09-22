<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-6">Pricing Settings</h3>
    
    <form id="pricing-form" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">Base Price per Night *</label>
                <input type="number" id="base_price" name="base_price" step="0.01" min="0" 
                       value="{{ $property->pricing->base_price ?? '' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency *</label>
                <select id="currency" name="currency" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required>
                    <option value="">Select Currency</option>
                    <option value="USD" {{ ($property->pricing->currency ?? '') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                    <option value="EUR" {{ ($property->pricing->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                    <option value="GBP" {{ ($property->pricing->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                    <option value="LKR" {{ ($property->pricing->currency ?? '') == 'LKR' ? 'selected' : '' }}>LKR - Sri Lankan Rupee</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                <input type="number" id="tax_rate" name="tax_rate" step="0.01" min="0" max="100" 
                       value="{{ $property->pricing->tax_rate ?? '' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="cleaning_fee" class="block text-sm font-medium text-gray-700 mb-2">Cleaning Fee</label>
                <input type="number" id="cleaning_fee" name="cleaning_fee" step="0.01" min="0" 
                       value="{{ $property->pricing->cleaning_fee ?? '' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="service_fee" class="block text-sm font-medium text-gray-700 mb-2">Service Fee</label>
                <input type="number" id="service_fee" name="service_fee" step="0.01" min="0" 
                       value="{{ $property->pricing->service_fee ?? '' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <!-- Pricing Preview -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-3">Pricing Preview</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Base Price per Night:</span>
                    <span id="preview-base-price">-</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax (<span id="preview-tax-rate">0</span>%):</span>
                    <span id="preview-tax">-</span>
                </div>
                <div class="flex justify-between">
                    <span>Cleaning Fee:</span>
                    <span id="preview-cleaning">-</span>
                </div>
                <div class="flex justify-between">
                    <span>Service Fee:</span>
                    <span id="preview-service">-</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between font-medium">
                    <span>Total per Night:</span>
                    <span id="preview-total">-</span>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update Pricing
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pricing-form');
    const basePriceInput = document.getElementById('base_price');
    const currencySelect = document.getElementById('currency');
    const taxRateInput = document.getElementById('tax_rate');
    const cleaningFeeInput = document.getElementById('cleaning_fee');
    const serviceFeeInput = document.getElementById('service_fee');
    
    // Update pricing preview
    function updatePreview() {
        const basePrice = parseFloat(basePriceInput.value) || 0;
        const currency = currencySelect.value || '';
        const taxRate = parseFloat(taxRateInput.value) || 0;
        const cleaningFee = parseFloat(cleaningFeeInput.value) || 0;
        const serviceFee = parseFloat(serviceFeeInput.value) || 0;
        
        const tax = (basePrice * taxRate) / 100;
        const total = basePrice + tax + cleaningFee + serviceFee;
        
        document.getElementById('preview-base-price').textContent = currency ? `${currency} ${basePrice.toFixed(2)}` : '-';
        document.getElementById('preview-tax-rate').textContent = taxRate.toFixed(1);
        document.getElementById('preview-tax').textContent = currency ? `${currency} ${tax.toFixed(2)}` : '-';
        document.getElementById('preview-cleaning').textContent = currency ? `${currency} ${cleaningFee.toFixed(2)}` : '-';
        document.getElementById('preview-service').textContent = currency ? `${currency} ${serviceFee.toFixed(2)}` : '-';
        document.getElementById('preview-total').textContent = currency ? `${currency} ${total.toFixed(2)}` : '-';
    }
    
    // Add event listeners for real-time preview updates
    [basePriceInput, currencySelect, taxRateInput, cleaningFeeInput, serviceFeeInput].forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });
    
    // Initial preview update
    updatePreview();
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        fetch(`/partner/hotels/{{ $property->id }}/pricing`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showMessage(data.message, 'success');
            } else {
                window.showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showMessage('An error occurred while updating pricing', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
});
</script>