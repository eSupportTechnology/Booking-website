@props(['property'])

@php
    // Check if property has any active deals
    $activeDeal = null;
    if (isset($property->deals)) {
        $activeDeal = $property->deals->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }
@endphp

@if($activeDeal)
    <div class="absolute top-2 left-2 z-10">
        <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-2 py-1 rounded-md shadow-lg">
            <div class="flex items-center space-x-1">
                <span class="text-xs font-bold">🔥</span>
                <span class="text-xs font-semibold">{{ $activeDeal->discount_percentage }}% OFF</span>
            </div>
            <div class="text-xs opacity-90">{{ $activeDeal->title }}</div>
        </div>
    </div>
@endif