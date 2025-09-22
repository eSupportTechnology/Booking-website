<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-6">Hotel Amenities</h3>
    
    <form id="amenities-form" class="space-y-6">
        @csrf
        
        @if(isset($amenities) && $amenities->count() > 0)
            @foreach($amenities as $category => $categoryAmenities)
                <div class="mb-8">
                    <h4 class="text-md font-medium text-gray-800 mb-4 capitalize">{{ $category }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categoryAmenities as $amenity)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="amenity_{{ $amenity->id }}" 
                                       name="amenities[]" 
                                       value="{{ $amenity->id }}"
                                       {{ $property->amenities->contains($amenity->id) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="amenity_{{ $amenity->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $amenity->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No amenities available. Please contact administrator.</p>
            </div>
        @endif
        
        <div class="flex justify-end pt-6 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update Amenities
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('amenities-form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        fetch(`/partner/hotels/{{ $property->id }}/amenities`, {
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
            window.showMessage('An error occurred while updating amenities', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
});
</script>