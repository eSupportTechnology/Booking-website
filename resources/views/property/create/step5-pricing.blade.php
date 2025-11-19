@extends('partner.partner-layout')

@section('title', 'Create Property - Pricing | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 5])
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Set your pricing</h2>
        
        <form id="step5Form" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Adult Earnings (per night) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                        <input type="number" name="adult_price" required step="0.01" min="0"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00"
                               value="{{ $property->adult_price ?? '' }}">
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Amount you want to earn per adult guest</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Children Earnings (per night) *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                        <input type="number" name="children_price" required step="0.01" min="0"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00"
                               value="{{ $property->children_price ?? '' }}">
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Amount you want to earn per child guest</p>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%)</label>
                <div class="relative">
                    <input type="number" name="commission_rate" readonly
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                           value="{{ config('app.default_commission_rate', 15) }}">
                    <span class="absolute right-3 top-3 text-gray-500">%</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">Commission rate is set by platform administration</p>
            </div>
            
            <!-- Pricing Preview -->
            <div class="bg-gray-50 rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Pricing Preview</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Your adult price per night:</span>
                        <span id="adultPreview">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Your children price per night:</span>
                        <span id="childrenPreview">$0.00</span>
                    </div>
                    <div class="flex justify-between text-red-600 font-medium">
                        <span>Commission rate:</span>
                        <span id="commissionPreview">{{ config('app.default_commission_rate', 15) }}%</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-semibold text-blue-600">
                        <span>Total adult price (including commission):</span>
                        <span id="adultTotalPrice">$0.00</span>
                    </div>
                    <div class="flex justify-between font-semibold text-blue-600">
                        <span>Total children price (including commission):</span>
                        <span id="childrenTotalPrice">$0.00</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-semibold text-green-600">
                        <span>Your earnings per adult:</span>
                        <span id="adultEarnings">$0.00</span>
                    </div>
                    <div class="flex justify-between font-semibold text-green-600">
                        <span>Your earnings per child:</span>
                        <span id="childrenEarnings">$0.00</span>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between mt-8">
                <a href="/property/create/step/4" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adultPriceInput = document.querySelector('input[name="adult_price"]');
    const childrenPriceInput = document.querySelector('input[name="children_price"]');
    const commissionInput = document.querySelector('input[name="commission_rate"]');
    
    function updatePreview() {
        const adultPrice = parseFloat(adultPriceInput.value) || 0;
        const childrenPrice = parseFloat(childrenPriceInput.value) || 0;
        const commission = {{ config('app.default_commission_rate', 15) }};
        
        // Calculate total prices (partner price + commission)
        const adultTotalPrice = adultPrice / (1 - commission / 100);
        const childrenTotalPrice = childrenPrice / (1 - commission / 100);
        
        // Partner earnings (what they entered)
        const adultEarnings = adultPrice;
        const childrenEarnings = childrenPrice;
        
        document.getElementById('adultPreview').textContent = '$' + adultPrice.toFixed(2);
        document.getElementById('childrenPreview').textContent = '$' + childrenPrice.toFixed(2);
        document.getElementById('adultTotalPrice').textContent = '$' + adultTotalPrice.toFixed(2);
        document.getElementById('childrenTotalPrice').textContent = '$' + childrenTotalPrice.toFixed(2);
        document.getElementById('adultEarnings').textContent = '$' + adultEarnings.toFixed(2);
        document.getElementById('childrenEarnings').textContent = '$' + childrenEarnings.toFixed(2);
    }
    
    adultPriceInput.addEventListener('input', updatePreview);
    childrenPriceInput.addEventListener('input', updatePreview);
    // Commission input is read-only, no need for event listener
    
    // Initial preview update
    updatePreview();
    
    document.getElementById('step5Form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/property/create/step/5', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/property/create/step/6';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>
@endsection