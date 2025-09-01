@props(['property'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ $property['image'] ?? asset('assets/default-property.jpg') }}" 
             alt="{{ $property['name'] }}" 
             class="w-full h-48 object-cover">
        <div class="absolute top-2 right-2">
            <span class="bg-{{ $property['status'] === 'Active' ? 'green' : ($property['status'] === 'Pending' ? 'yellow' : 'red') }}-100 text-{{ $property['status'] === 'Active' ? 'green' : ($property['status'] === 'Pending' ? 'yellow' : 'red') }}-700 text-xs font-medium px-2 py-1 rounded">
                {{ $property['status'] }}
            </span>
        </div>
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $property['name'] }}</h3>
        <p class="text-gray-600 text-sm mb-2">{{ $property['location'] }}</p>
        <p class="text-gray-500 text-xs mb-3">{{ $property['type'] }}</p>
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">{{ $property['bookings'] }} bookings</span>
            <div class="flex space-x-2">
                <a href="{{ route('partner.properties.views', $property['id']) }}" 
                   class="bg-[#1F8FB2] text-white px-3 py-1 rounded text-xs hover:opacity-90 transition">
                    View Details
                </a>
                <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition">
                    Edit
                </button>
                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>