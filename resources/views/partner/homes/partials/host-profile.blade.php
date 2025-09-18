<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Host Profile</h3>
        <p class="text-gray-600">Help your listing stand out by telling potential guests about yourself, your property and your neighborhood</p>
    </div>

    <form id="profile-form" action="{{ route('partner.homes.update.profile', $property) }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- The Property -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">The Property</h4>
                    <p class="text-gray-600 text-sm">Tell guests what makes your place unique</p>
                </div>
            </div>

            <div class="space-y-4">
                <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-blue-300 cursor-pointer transition-all duration-200">
                    <input type="checkbox" name="show_property" value="1" {{ $property->hostProfile?->show_property ? 'checked' : '' }} class="sr-only">
                    <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                    </div>
                    <span class="font-semibold text-gray-900">Show property description on listing</span>
                </label>

                <div id="property-description" style="display: {{ $property->hostProfile?->show_property ? 'block' : 'none' }};">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">About the property</label>
                    <textarea name="about_property" rows="4" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 resize-none" placeholder="What makes your place unique? What can guests expect?" maxlength="1200">{{ $property->hostProfile?->about_property }}</textarea>
                    <div class="text-right text-sm text-gray-500 mt-1">
                        <span id="property-count">{{ strlen($property->hostProfile?->about_property ?? '') }}</span>/1200
                    </div>
                </div>
            </div>
        </div>

        <!-- The Host -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-user-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">The Host</h4>
                    <p class="text-gray-600 text-sm">Share information about yourself</p>
                </div>
            </div>

            <div class="space-y-4">
                <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                    <input type="checkbox" name="show_host" value="1" {{ $property->hostProfile?->show_host ? 'checked' : '' }} class="sr-only">
                    <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                    </div>
                    <span class="font-semibold text-gray-900">Show host information on listing</span>
                </label>

                <div id="host-details" style="display: {{ $property->hostProfile?->show_host ? 'block' : 'none' }};">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Host name</label>
                            <input type="text" name="host_name" value="{{ $property->hostProfile?->host_name ?? Auth::user()->name }}" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200" placeholder="Your name" maxlength="80">
                            <div class="text-right text-sm text-gray-500 mt-1">
                                <span id="name-count">{{ strlen($property->hostProfile?->host_name ?? Auth::user()->name ?? '') }}</span>/80
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">About the host</label>
                            <textarea name="about_host" rows="4" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 resize-none" placeholder="What are your interests? What do you like about hosting?" maxlength="1200">{{ $property->hostProfile?->about_host }}</textarea>
                            <div class="text-right text-sm text-gray-500 mt-1">
                                <span id="host-count">{{ strlen($property->hostProfile?->about_host ?? '') }}</span>/1200
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Neighborhood -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-map-marker-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">The Neighborhood</h4>
                    <p class="text-gray-600 text-sm">Describe the local area and attractions</p>
                </div>
            </div>

            <div class="space-y-4">
                <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-200">
                    <input type="checkbox" name="show_neighborhood" value="1" {{ $property->hostProfile?->show_neighborhood ? 'checked' : '' }} class="sr-only">
                    <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm opacity-0"></i>
                    </div>
                    <span class="font-semibold text-gray-900">Show neighborhood information on listing</span>
                </label>

                <div id="neighborhood-description" style="display: {{ $property->hostProfile?->show_neighborhood ? 'block' : 'none' }};">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">About the neighborhood</label>
                    <textarea name="about_neighborhood" rows="4" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 resize-none" placeholder="What's the area like? Are there any attractions nearby?" maxlength="1200">{{ $property->hostProfile?->about_neighborhood }}</textarea>
                    <div class="text-right text-sm text-gray-500 mt-1">
                        <span id="neighborhood-count">{{ strlen($property->hostProfile?->about_neighborhood ?? '') }}</span>/1200
                    </div>
                </div>
            </div>
        </div>

        <!-- Skip Option -->
        <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-2xl p-6 border border-gray-200">
            <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-gray-300 cursor-pointer transition-all duration-200">
                <input type="checkbox" name="none_selected" value="1" {{ $property->hostProfile?->none_selected ? 'checked' : '' }} class="sr-only">
                <div class="w-6 h-6 border-2 border-gray-300 rounded-lg mr-4 flex items-center justify-center">
                    <i class="fas fa-check text-white text-sm opacity-0"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900">None of the above / I'll add these later</span>
                    <p class="text-gray-600 text-sm">Skip this section for now and complete it later</p>
                </div>
            </label>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Host Profile
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    function updateCounter(textarea, counterId) {
        const counter = document.getElementById(counterId);
        if (counter) {
            counter.textContent = textarea.value.length;
        }
    }

    // Set up character counters
    const textareas = [
        { element: document.querySelector('textarea[name="about_property"]'), counter: 'property-count' },
        { element: document.querySelector('textarea[name="about_host"]'), counter: 'host-count' },
        { element: document.querySelector('textarea[name="about_neighborhood"]'), counter: 'neighborhood-count' },
        { element: document.querySelector('input[name="host_name"]'), counter: 'name-count' }
    ];

    textareas.forEach(({ element, counter }) => {
        if (element) {
            element.addEventListener('input', () => updateCounter(element, counter));
        }
    });

    // Handle checkbox selections
    document.addEventListener('click', function(e) {
        const target = e.target.closest('label');
        if (!target) return;
        
        const input = target.querySelector('input[type="checkbox"]');
        if (!input) return;
        
        input.checked = !input.checked;
        const indicator = target.querySelector('div[class*="border-"]');
        const icon = target.querySelector('i');
        
        if (input.checked) {
            indicator.classList.add('bg-blue-500', 'border-blue-500');
            indicator.classList.remove('border-gray-300');
            icon.classList.remove('opacity-0');
            icon.classList.add('opacity-100');
            target.classList.add('border-blue-500', 'bg-blue-50');
        } else {
            indicator.classList.remove('bg-blue-500', 'border-blue-500');
            indicator.classList.add('border-gray-300');
            icon.classList.add('opacity-0');
            icon.classList.remove('opacity-100');
            target.classList.remove('border-blue-500', 'bg-blue-50');
        }
        
        // Handle visibility toggles
        if (input.name === 'show_property') {
            document.getElementById('property-description').style.display = input.checked ? 'block' : 'none';
        } else if (input.name === 'show_host') {
            document.getElementById('host-details').style.display = input.checked ? 'block' : 'none';
        } else if (input.name === 'show_neighborhood') {
            document.getElementById('neighborhood-description').style.display = input.checked ? 'block' : 'none';
        }
    });
    
    // Initialize selected states on page load
    document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
        const label = checkbox.closest('label');
        const indicator = label.querySelector('div[class*="border-"]');
        const icon = label.querySelector('i');
        
        indicator.classList.add('bg-blue-500', 'border-blue-500');
        indicator.classList.remove('border-gray-300');
        icon.classList.remove('opacity-0');
        icon.classList.add('opacity-100');
        label.classList.add('border-blue-500', 'bg-blue-50');
    });
});
</script>