<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Partner Verification</h3>
        <p class="text-gray-600">Complete verification to comply with legal and regulatory requirements</p>
    </div>

    <form id="verification-form" action="{{ route('partner.homes.update.verification', $property) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Business Type Selection -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Business Type</h4>
                    <p class="text-gray-600 text-sm">Are you listing as an individual or business entity?</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex flex-col p-6 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 cursor-pointer transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                    <input type="radio" name="type" value="individual" {{ $property->partnerVerification?->type == 'individual' ? 'checked' : '' }} class="sr-only peer">
                    <div class="flex items-center mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-user text-blue-600 text-xl mr-2"></i>
                            <span class="font-bold text-gray-900">Individual</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">An individual or sole proprietor who owns and operates an unincorporated business on their own.</p>
                </label>

                <label class="flex flex-col p-6 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 cursor-pointer transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                    <input type="radio" name="type" value="business" {{ $property->partnerVerification?->type == 'business' ? 'checked' : '' }} class="sr-only peer">
                    <div class="flex items-center mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-building text-blue-600 text-xl mr-2"></i>
                            <span class="font-bold text-gray-900">Business</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">A business entity owned by several individuals, such as a partnership, corporation, or organization.</p>
                </label>
            </div>
        </div>

        <!-- Individual Details -->
        <div id="individual-details" class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 {{ $property->partnerVerification?->type == 'individual' ? '' : 'hidden' }}">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-user-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Individual Details</h4>
                    <p class="text-gray-600 text-sm">Provide your personal information</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="full_name" value="{{ $property->partnerVerification?->full_name ?? Auth::user()->name }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200" placeholder="Enter your full name">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">National ID or Passport</label>
                    <input type="text" name="national_id" value="{{ $property->partnerVerification?->national_id }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200" placeholder="Enter ID number">
                </div>
            </div>
        </div>

        <!-- Business Details -->
        <div id="business-details" class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 {{ $property->partnerVerification?->type == 'business' ? '' : 'hidden' }}">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-building text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Business Entity Details</h4>
                    <p class="text-gray-600 text-sm">Provide your business information</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                        <input type="text" name="company_name" value="{{ $property->partnerVerification?->company_name }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Enter company name">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Business Registration Number</label>
                        <input type="text" name="registration_number" value="{{ $property->partnerVerification?->registration_number }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Enter registration number">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Trading Name (optional)</label>
                        <input type="text" name="trading_name" value="{{ $property->partnerVerification?->trading_name }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Trading name if different">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Business Address</label>
                        <input type="text" name="address" value="{{ $property->partnerVerification?->address }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Business address">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Zip Code</label>
                        <input type="text" name="zip_code" value="{{ $property->partnerVerification?->zip_code }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Zip code">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                        <input type="text" name="city" value="{{ $property->partnerVerification?->city }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="City">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                        <input type="text" name="country" value="{{ $property->partnerVerification?->country }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200" placeholder="Country">
                    </div>
                </div>
            </div>
        </div>

        <!-- Legal Compliance -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-100">
            <div class="flex items-start">
                <div class="bg-yellow-100 p-3 rounded-xl mr-4 mt-1">
                    <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Legal Compliance</h4>

                    <div class="space-y-4">
                        <label class="flex items-start p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-yellow-300 cursor-pointer transition-all duration-200 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                            <input type="checkbox" name="legitimate_business" value="1" class="sr-only" required>
                            <div>
                                <span class="font-semibold text-gray-900">I certify that this is a legitimate accommodation business</span>
                                <p class="text-gray-600 text-sm mt-1">I confirm this business has all necessary licenses and permits, which can be shown upon request. The platform reserves the right to verify and investigate any details provided.</p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-yellow-300 cursor-pointer transition-all duration-200 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                            <input type="checkbox" name="terms_accepted" value="1" class="sr-only" required>
                            <div>
                                <span class="font-semibold text-gray-900">I have read and accepted the General Delivery Terms</span>
                                <p class="text-gray-600 text-sm mt-1">I agree to the platform's terms and conditions for property listing and management.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Complete Verification
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle visibility on page load
    const typeInputs = document.querySelectorAll('input[name="type"]');
    const individualEl = document.getElementById('individual-details');
    const businessEl = document.getElementById('business-details');

    typeInputs.forEach(input => {
        if (input.checked) {
            if (individualEl) individualEl.classList.toggle('hidden', input.value !== 'individual');
            if (businessEl) businessEl.classList.toggle('hidden', input.value !== 'business');
        }
    });

    // Handle radio button changes for visibility toggles and styling
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            // Clear all radio buttons in the same group
            document.querySelectorAll(`input[name="${e.target.name}"]`).forEach(radio => {
                const label = radio.closest('label');
                if (label) {
                    label.classList.remove('border-blue-500', 'bg-blue-50');
                    label.classList.add('border-gray-200');
                }
            });

            // Style the selected radio
            const selectedLabel = e.target.closest('label');
            if (selectedLabel) {
                selectedLabel.classList.remove('border-gray-200');
                selectedLabel.classList.add('border-blue-500', 'bg-blue-50');
            }
        }

        if (e.target.name === 'type') {
            if (individualEl) individualEl.classList.toggle('hidden', e.target.value !== 'individual');
            if (businessEl) businessEl.classList.toggle('hidden', e.target.value !== 'business');
        }
    });

    // Initialize radio button styles
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        input.dispatchEvent(new Event('change'));
    });
});
</script>
