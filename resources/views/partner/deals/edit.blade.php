@extends('partner.master')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Deal</h1>

        <form action="{{ route('partner.deals.update', $deal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deal Title</label>
                    <input type="text" name="title" value="{{ old('title', $deal->title) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                    @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">{{ old('description', $deal->description) }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Hidden Defaults -->
                <input type="hidden" name="deal_type" value="percentage">
                <input type="hidden" name="applicable_to" value="property">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property</label>
                    <select name="property_id" id="property_id_edit"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        @foreach($properties as $property)
                        <option value="{{ $property->id }}"
                            {{ old('property_id', $deal->property_id) == $property->id ? 'selected' : '' }}>
                            {{ $property->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('property_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount Percentage (%)</label>
                    <input type="number" name="discount_percentage" value="{{ old('discount_percentage', $deal->discount_percentage) }}" min="1" max="100"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                    @error('discount_percentage')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Hidden Original Price (Required by DB but not used in new logic) -->
                <input type="hidden" name="original_price" value="0">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $deal->start_date->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        @error('start_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $deal->end_date->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        @error('end_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specific Available Dates</label>
                    <div id="date_picker_container_edit">
                        <input type="date" id="date_picker_edit" class="border border-gray-300 rounded px-3 py-2 mr-2">
                        <button type="button" onclick="addDateEdit()" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">Add Date</button>
                    </div>
                    <div id="selected_dates_edit" class="mt-2 flex flex-wrap gap-2">
                        @foreach($deal->dealDates as $dealDate)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm flex items-center">
                            {{ $dealDate->available_date->format('Y-m-d') }}
                            <button type="button" onclick="removeDateEdit('{{ $dealDate->available_date->format('Y-m-d') }}')" class="ml-2 text-red-500 hover:text-red-700">×</button>
                            <input type="hidden" name="available_dates[]" value="{{ $dealDate->available_date->format('Y-m-d') }}">
                        </span>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('partner.deals.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#3CC0E9] transition">
                        Update Deal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let selectedDatesEdit = @json($deal - > dealDates - > pluck('available_date') - > map(fn($date) => $date - > format('Y-m-d')) - > toArray());

    function addDateEdit() {
        const datePicker = document.getElementById('date_picker_edit');
        const date = datePicker.value;

        if (date && !selectedDatesEdit.includes(date)) {
            selectedDatesEdit.push(date);
            updateDateDisplayEdit();
            datePicker.value = '';
        }
    }

    function removeDateEdit(date) {
        selectedDatesEdit = selectedDatesEdit.filter(d => d !== date);
        updateDateDisplayEdit();
    }

    function updateDateDisplayEdit() {
        const container = document.getElementById('selected_dates_edit');
        container.innerHTML = selectedDatesEdit.map(date => `
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm flex items-center">
            ${date}
            <button type="button" onclick="removeDateEdit('${date}')" class="ml-2 text-red-500 hover:text-red-700">×</button>
            <input type="hidden" name="available_dates[]" value="${date}">
        </span>
    `).join('');
    }
</script>
@endsection