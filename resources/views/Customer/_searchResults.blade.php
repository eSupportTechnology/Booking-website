@forelse ($properties as $property)
<div class="bg-white rounded-xl shadow mb-5 flex flex-col md:flex-row overflow-hidden transition hover:shadow-lg">
  <div class="md:w-1/3">
    @php $photo = $property->files->first(); @endphp
    <img src="{{ $photo ? asset($photo->path) : asset('images/no-image.jpg') }}"
         alt="{{ $property->title }}"
         class="h-48 w-full object-cover md:h-full">
  </div>

  <div class="md:w-2/3 p-4 flex flex-col justify-between">
    <div>
      <h3 class="text-xl font-semibold text-[#0071C2] mb-1">{{ $property->title }}</h3>
      <p class="text-sm text-gray-600 mb-2">
        {{ $property->city }}, {{ $property->country }}
      </p>
      <p class="text-gray-500 text-sm">{{ Str::limit($property->description, 100) }}</p>
    </div>

    <div class="mt-3 flex items-center justify-between">
      <div>
        <div class="text-gray-500 text-xs">From</div>
        <div class="text-lg font-bold text-green-600">
          LKR {{ number_format($property->rooms_min_price_per_night ?? 0, 2) }}
        </div>
      </div>
      <a href="{{ route('customer.properties.details', ['id' => $property->id]) }}"
         class="bg-[#0071C2] text-white text-sm px-4 py-2 rounded-md hover:bg-[#005A9C]">
        View
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
