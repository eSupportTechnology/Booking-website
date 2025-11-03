@props(['search' => '', 'placeholder' => 'Search properties...', 'route'])

<div class="bg-white p-4 rounded-lg shadow">
    <form method="GET" class="flex space-x-4">
        <input type="text"
               name="search"
               value="{{ $search }}"
               placeholder="{{ $placeholder }}"
               class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
            Search
        </button>
        @if($search)
            <a href="{{ $route }}"
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                Clear
            </a>
        @endif
    </form>
</div>
