@php
    use Illuminate\Support\Str;
    use App\Helpers\CurrencyHelper;
@endphp


@forelse ($properties as $property)

    @php
        // Determine nightly price
        $price = null;

        if ($property->pricing && $property->pricing->price_per_night) {
            $price = $property->pricing->price_per_night;
        } elseif ($property->rooms && $property->rooms->count()) {
            $price = $property->rooms->min('price_per_night');
        }

        $price = $price ?? 0; // fallback
    @endphp


<div class="bg-white rounded-xl shadow mb-5 flex flex-col md:flex-row overflow-hidden transition hover:shadow-lg border border-gray-100">

  {{-- IMAGE SECTION --}}
  <div class="md:w-1/3 relative">
    @php
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

    <img src="{{ $imgPath ?? asset('assets/default-property.jpg') }}"
         alt="{{ $property->title }}"
         loading="lazy"
         class="h-48 w-full object-cover md:h-full transition-transform duration-300 hover:scale-105">
  </div>

  {{-- PROPERTY DETAILS SECTION --}}
  <div class="md:w-2/3 p-4 flex flex-col justify-between">

    <div>
      <h3 class="text-xl font-semibold text-[#3CC0E9] mb-1 hover:underline cursor-pointer">
        {{ $property->title }}
      </h3>

      <p class="text-sm text-gray-600 mb-2 flex items-center gap-1">
        <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 4.42 4 10 6 10s6-5.58 6-10a6 6 0 00-6-6z" clip-rule="evenodd"/>
        </svg>
        {{ $property->city }}, {{ $property->country }}
      </p>

      <p class="text-gray-500 text-sm leading-relaxed">
        {{ Str::limit($property->description, 100) }}
      </p>

      @if($property->facilities && $property->facilities->count())
      <ul class="mt-2 text-sm text-gray-700 list-disc list-inside">
        @foreach($property->facilities->take(4) as $f)
          <li>{{ $f->facility_name }}</li>
        @endforeach
      </ul>
      @endif
    </div>

    {{-- PRICE AND ACTION --}}
    <div class="mt-4 flex items-center justify-between">
      <div>
        <div class="text-gray-500 text-xs">From</div>
        <div class="text-lg font-bold text-[#0071C2]">
          {{ CurrencyHelper::formatPrice($price, 'USD') }}
        </div>
      </div>

      <a href="{{ route('customer.properties.details', ['id' => $property->id]) }}"
         class="bg-[#3CC0E9] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#2AA9CD] transition">
        View Details
      </a>
    </div>

  </div>
</div>

@empty
  <div class="bg-white rounded-xl p-6 text-center shadow">
    <p class="text-gray-600">No properties match your filters.</p>
  </div>
@endforelse


@if(method_exists($properties, 'links'))
  <div class="mt-6">{{ $properties->links('pagination::tailwind') }}</div>
@endif
