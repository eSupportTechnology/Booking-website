@props(['name', 'value' => '', 'placeholder' => 'Select date', 'minDate' => null])

<div class="relative">
    <input 
        type="date" 
        name="{{ $name }}" 
        value="{{ $value }}"
        min="{{ $minDate ?? date('Y-m-d') }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent']) }}
        placeholder="{{ $placeholder }}"
    >
    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <i class="fas fa-calendar-alt text-gray-400"></i>
    </div>
</div>

<script>
// Enhanced date picker with flatpickr (optional)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
        flatpickr('input[name="{{ $name }}"]', {
            dateFormat: 'Y-m-d',
            minDate: '{{ $minDate ?? "today" }}',
            theme: 'material_blue'
        });
    }
});
</script>