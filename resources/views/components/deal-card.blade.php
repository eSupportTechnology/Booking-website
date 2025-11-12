@props(['deal'])

<div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg p-4 text-black shadow-lg hover:shadow-xl transition-shadow duration-300">
    <div class="flex items-center justify-between mb-2">
        <span class="bg-white bg-opacity-20 text-xs font-semibold px-2 py-1 rounded-full">
            🔥 HOT DEAL
        </span>
        <span class="text-xs font-medium">
            {{ $deal->discount_display }}
        </span>
    </div>

    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $deal->title }}</h3>

    <p class="text-sm opacity-90 mb-3 line-clamp-2">{{ $deal->description }}</p>

    <div class="flex items-center justify-between mb-3">
        <div class="text-sm">
            @if($deal->deal_type !== 'special')
                <span class="line-through opacity-75">${{ $deal->original_price }}</span>
                <span class="font-bold text-lg ml-2">${{ $deal->discounted_price }}</span>
            @else
                <span class="font-bold text-lg">{{ $deal->special_offer_text }}</span>
            @endif
        </div>
        @if($deal->property)
            <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded">
                {{ $deal->property->city }}
            </span>
        @endif
    </div>

    <div class="flex items-center justify-between text-xs mb-3">
        <span>Valid until: {{ $deal->end_date->format('M d, Y') }}</span>
        @if($deal->property)
            <span>⭐ {{ number_format($deal->property->rating ?? 4.5, 1) }}</span>
        @endif
    </div>
    
    @if($deal->applicable_to === 'room' && $deal->room)
        <div class="text-xs mb-2 bg-white bg-opacity-20 px-2 py-1 rounded">
            Room: {{ $deal->room->name }}
        </div>
    @endif
    
    @if($deal->dealDates->count() > 0)
        <div class="text-xs mb-2">
            <span class="font-semibold">Available dates:</span>
            @foreach($deal->dealDates->take(3) as $dealDate)
                <span class="bg-white bg-opacity-20 px-1 py-0.5 rounded mr-1">{{ $dealDate->available_date->format('M d') }}</span>
            @endforeach
            @if($deal->dealDates->count() > 3)
                <span>+{{ $deal->dealDates->count() - 3 }} more</span>
            @endif
        </div>
    @endif

    @if($deal->property)
        <a href="{{ route('customer.properties.details', $deal->property->id) }}"
           class="block w-full bg-white text-orange-600 font-semibold py-2 px-4 rounded text-center hover:bg-gray-100 transition-colors duration-200">
            View Deal
        </a>
    @endif
</div>
