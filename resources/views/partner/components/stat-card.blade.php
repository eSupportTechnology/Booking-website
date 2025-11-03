@props(['title', 'value', 'color' => '#1F8FB2'])

<div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: {{ $color }};">
    <h2 class="text-sm text-gray-500">{{ $title }}</h2>
    <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
</div>
