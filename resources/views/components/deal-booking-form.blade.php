@props(['property'])

<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold mb-4">Book with Deal</h3>
    
    <form id="deal-booking-form" action="{{ route('customer.bookings.store', $property) }}" method="POST">
        @csrf
        <input type="hidden" name="property_id" value="{{ $property->id }}">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                <input type="date" name="check_in" id="check_in" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                <input type="date" name="check_out" id="check_out" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        @if($property->rooms->count() > 0)
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Room</label>
            <select name="room_id" id="room_id" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Room</option>
                @foreach($property->rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }} - ${{ $room->price_per_night }}/night</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Guests</label>
            <input type="number" name="guest_count" min="1" max="20" value="2" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div id="deals-section" class="mb-4" style="display: none;">
            <label class="block text-sm font-medium text-gray-700 mb-2">Available Deals</label>
            <div id="deals-container" class="space-y-2">
                <!-- Deals will be loaded here -->
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition">
            Book Now
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const roomSelect = document.getElementById('room_id');
    const dealsSection = document.getElementById('deals-section');
    const dealsContainer = document.getElementById('deals-container');

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    checkInInput.min = today;
    
    checkInInput.addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        checkInDate.setDate(checkInDate.getDate() + 1);
        checkOutInput.min = checkInDate.toISOString().split('T')[0];
        loadDeals();
    });

    checkOutInput.addEventListener('change', loadDeals);
    roomSelect.addEventListener('change', loadDeals);

    function loadDeals() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        const roomId = roomSelect.value;

        if (!checkIn || !checkOut) {
            dealsSection.style.display = 'none';
            return;
        }

        const params = new URLSearchParams({
            check_in: checkIn,
            check_out: checkOut
        });
        
        if (roomId) {
            params.append('room_id', roomId);
        }

        fetch(`/properties/{{ $property->id }}/deals?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.deals && data.deals.length > 0) {
                    dealsSection.style.display = 'block';
                    dealsContainer.innerHTML = data.deals.map(deal => `
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="deal_id" value="${deal.id}" class="mr-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium">${deal.title}</span>
                                    <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">${deal.discount_display}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">${deal.description}</p>
                                ${deal.applicable_to === 'room' ? `<p class="text-xs text-blue-600 mt-1">Room: ${deal.room_name}</p>` : ''}
                                ${deal.available_dates ? `<p class="text-xs text-gray-500 mt-1">Available: ${deal.available_dates}</p>` : ''}
                            </div>
                        </label>
                    `).join('');
                } else {
                    dealsSection.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading deals:', error);
                dealsSection.style.display = 'none';
            });
    }
});
</script>