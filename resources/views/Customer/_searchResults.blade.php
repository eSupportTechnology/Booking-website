@php
    use Illuminate\Support\Str;
    use App\Helpers\CurrencyHelper;
@endphp

@forelse ($properties as $property)
    @php
        // Determine nightly price safely
        $price = null;
        if ($property->pricing && $property->pricing->price_per_night) {
            $price = $property->pricing->price_per_night;
        } elseif ($property->rooms && $property->rooms->count()) {
            $price = $property->rooms->min('price_per_night');
        }
        $price = $price ?? 0; // fallback

        // Determine property image path
        $photo = $property->files->first();
        $imgPath = null;
        if ($photo && $photo->path) {
            $path = $photo->path;
            if (Str::startsWith($path, ['http://', 'https://'])) {
                $imgPath = $path;
            } elseif (Str::startsWith($path, ['storage/', 'uploads/'])) {
                $imgPath = asset($path);
            } elseif (Str::startsWith($path, 'public/')) {
                $imgPath = asset(Str::replaceFirst('public/', 'storage/', $path));
            } else {
                $imgPath = asset('storage/' . ltrim($path, '/'));
            }
        }
    @endphp

    <div class="bg-white rounded-xl shadow mb-5 flex flex-col md:flex-row overflow-hidden 
                transition hover:shadow-lg border border-gray-100">

        {{-- IMAGE SECTION --}}
        <div class="md:w-1/3 relative">
            <img src="{{ $imgPath ?? asset('assets/default-property.jpg') }}"
                 alt="{{ $property->title }}"
                 loading="lazy"
                 onerror="this.src='{{ asset('assets/default-property.jpg') }}'"
                 class="w-full h-48 md:h-full object-cover transition-transform duration-300 hover:scale-105 rounded-t-xl md:rounded-none md:rounded-l-xl">
        </div>

        {{-- PROPERTY DETAILS SECTION --}}
        <div class="md:w-2/3 p-4 flex flex-col justify-between">

            <div>
                <h3 class="text-xl font-semibold text-[#3CC0E9] mb-1 hover:underline cursor-pointer"
                    title="{{ $property->title }}">
                    {{ $property->title }}
                </h3>

                <p class="text-sm text-gray-600 mb-2 flex items-center gap-1">
                    <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                              d="M10 2a6 6 0 00-6 6c0 4.42 4 10 6 10s6-5.58 6-10a6 6 0 00-6-6z" 
                              clip-rule="evenodd" />
                    </svg>
                    {{ $property->city }}, {{ $property->country }}
                </p>

                <p class="text-gray-500 text-sm leading-relaxed">
                    {{ Str::limit(strip_tags($property->description), 100) }}
                </p>

                @if($property->facilities && $property->facilities->count())
                    <ul class="mt-2 text-sm text-gray-700 list-disc list-inside">
                        @foreach($property->facilities->take(4) as $f)
                            <li>{{ $f->facility_name }}</li>
                        @endforeach
                    </ul>
                @endif

                {{-- Optional Rating Display --}}
                @if(!empty($property->rating))
                    <div class="mt-2 flex items-center gap-2">
                        <span class="bg-[#003580] text-white text-xs px-2 py-1 rounded">
                            {{ number_format($property->rating, 1) }}
                        </span>
                        <span class="text-gray-600 text-sm">Excellent</span>
                    </div>
                @endif
            </div>

            {{-- PRICE + ACTION --}}
            <div class="mt-4 flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-xs">From</div>
                    <div class="text-lg font-bold text-[#0071C2]">
                        {{ CurrencyHelper::formatPrice($price, 'USD') }}
                    </div>
                </div>

                <a href="{{ route('customer.properties.details', ['id' => $property->id]) }}"
                   class="bg-[#3CC0E9] text-white text-sm px-5 py-2 rounded-lg 
                          hover:bg-[#2AA9CD] transition font-medium">
                    View Details
                </a>
            </div>
        </div>
    </div>

@empty
    <div class="bg-white rounded-xl p-10 shadow-lg text-center">
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No properties found.</h3>
        <p class="text-gray-500">Try adjusting your filters or search again.</p>
    </div>
@endforelse

@if(method_exists($properties, 'links'))
    <div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        {{ $properties->links('pagination::tailwind') }}
    </div>
@endif


