<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-6">Property Policies</h3>
    
    <form id="policies-form" class="space-y-6">
        @csrf
        
        <!-- Check-in/Check-out Times -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="check_in_time" class="block text-sm font-medium text-gray-700 mb-2">Check-in Time *</label>
                <input type="time" id="check_in_time" name="check_in_time" 
                       value="{{ $property->policies->check_in_time ?? '15:00' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div>
                <label for="check_out_time" class="block text-sm font-medium text-gray-700 mb-2">Check-out Time *</label>
                <input type="time" id="check_out_time" name="check_out_time" 
                       value="{{ $property->policies->check_out_time ?? '11:00' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
        </div>
        
        <!-- Cancellation Policy -->
        <div>
            <label for="cancellation_policy" class="block text-sm font-medium text-gray-700 mb-2">Cancellation Policy *</label>
            <select id="cancellation_policy" name="cancellation_policy" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
                <option value="">Select Policy</option>
                <option value="flexible" {{ ($property->policies->cancellation_policy ?? '') == 'flexible' ? 'selected' : '' }}>
                    Flexible - Free cancellation up to 24 hours before check-in
                </option>
                <option value="moderate" {{ ($property->policies->cancellation_policy ?? '') == 'moderate' ? 'selected' : '' }}>
                    Moderate - Free cancellation up to 5 days before check-in
                </option>
                <option value="strict" {{ ($property->policies->cancellation_policy ?? '') == 'strict' ? 'selected' : '' }}>
                    Strict - Free cancellation up to 14 days before check-in
                </option>
                <option value="non_refundable" {{ ($property->policies->cancellation_policy ?? '') == 'non_refundable' ? 'selected' : '' }}>
                    Non-refundable - No cancellation allowed
                </option>
            </select>
        </div>
        
        <!-- Property Rules -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-900">Property Rules</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center">
                    <input type="checkbox" id="smoking_allowed" name="smoking_allowed" value="1"
                           {{ ($property->policies->smoking_allowed ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="smoking_allowed" class="ml-2 text-sm text-gray-700">
                        Smoking Allowed
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="pets_allowed" name="pets_allowed" value="1"
                           {{ ($property->policies->pets_allowed ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="pets_allowed" class="ml-2 text-sm text-gray-700">
                        Pets Allowed
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="parties_allowed" name="parties_allowed" value="1"
                           {{ ($property->policies->parties_allowed ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="parties_allowed" class="ml-2 text-sm text-gray-700">
                        Parties/Events Allowed
                    </label>
                </div>
            </div>
        </div>
        
        <!-- House Rules -->
        <div>
            <label for="house_rules" class="block text-sm font-medium text-gray-700 mb-2">Additional House Rules</label>
            <textarea id="house_rules" name="house_rules" rows="4" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                      placeholder="Enter any additional rules or guidelines for guests...">{{ $property->policies->house_rules ?? '' }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
        </div>
        
        <!-- Policy Preview -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-3">Policy Summary</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Check-in:</span>
                    <span id="preview-checkin">{{ $property->policies->check_in_time ?? '15:00' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Check-out:</span>
                    <span id="preview-checkout">{{ $property->policies->check_out_time ?? '11:00' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Cancellation:</span>
                    <span id="preview-cancellation" class="capitalize">{{ $property->policies->cancellation_policy ?? 'Not set' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Smoking:</span>
                    <span id="preview-smoking">{{ ($property->policies->smoking_allowed ?? false) ? 'Allowed' : 'Not allowed' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Pets:</span>
                    <span id="preview-pets">{{ ($property->policies->pets_allowed ?? false) ? 'Allowed' : 'Not allowed' }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Parties/Events:</span>
                    <span id="preview-parties">{{ ($property->policies->parties_allowed ?? false) ? 'Allowed' : 'Not allowed' }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update Policies
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('policies-form');
    const checkInInput = document.getElementById('check_in_time');
    const checkOutInput = document.getElementById('check_out_time');
    const cancellationSelect = document.getElementById('cancellation_policy');
    const smokingCheckbox = document.getElementById('smoking_allowed');
    const petsCheckbox = document.getElementById('pets_allowed');
    const partiesCheckbox = document.getElementById('parties_allowed');
    
    // Update policy preview
    function updatePreview() {
        document.getElementById('preview-checkin').textContent = checkInInput.value || 'Not set';
        document.getElementById('preview-checkout').textContent = checkOutInput.value || 'Not set';
        
        const cancellationText = cancellationSelect.options[cancellationSelect.selectedIndex]?.text || 'Not set';
        document.getElementById('preview-cancellation').textContent = cancellationText.split(' - ')[0] || 'Not set';
        
        document.getElementById('preview-smoking').textContent = smokingCheckbox.checked ? 'Allowed' : 'Not allowed';
        document.getElementById('preview-pets').textContent = petsCheckbox.checked ? 'Allowed' : 'Not allowed';
        document.getElementById('preview-parties').textContent = partiesCheckbox.checked ? 'Allowed' : 'Not allowed';
    }
    
    // Add event listeners for real-time preview updates
    [checkInInput, checkOutInput, cancellationSelect, smokingCheckbox, petsCheckbox, partiesCheckbox].forEach(input => {
        input.addEventListener('change', updatePreview);
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        fetch(`/partner/hotels/{{ $property->id }}/policies`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showMessage(data.message, 'success');
                updatePreview(); // Update preview with new values
            } else {
                window.showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showMessage('An error occurred while updating policies', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
    
    // Character count for house rules
    const houseRulesTextarea = document.getElementById('house_rules');
    const maxLength = 1000;
    
    houseRulesTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        const helpText = this.nextElementSibling;
        
        if (remaining < 0) {
            this.value = this.value.substring(0, maxLength);
            helpText.textContent = 'Maximum 1000 characters reached';
            helpText.classList.add('text-red-500');
        } else {
            helpText.textContent = `${remaining} characters remaining`;
            helpText.classList.remove('text-red-500');
        }
    });
});
</script>