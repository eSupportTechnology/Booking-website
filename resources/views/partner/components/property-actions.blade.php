@props(['property'])

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