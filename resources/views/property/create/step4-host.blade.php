@extends('partner.partner-layout')

@section('title', 'Create Property - Host Profile | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 4])

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Host Profile & Languages</h2>

        <form id="step4Form" class="space-y-8">
            @csrf

            <!-- Host Profile -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Host Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Host Name *</label>
                        <input type="text" name="host_name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Your name"
                               value="{{ old('host_name', $hostProfile->host_name ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="+1 234 567 8900"
                               value="">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">About You</label>
                    <textarea name="about" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Tell guests about yourself and your property...">{{ old('about', $hostProfile->about_host ?? '') }}</textarea>
                </div>
            </div>

            <!-- Languages -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Languages You Speak</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if(isset($languages))
                        @foreach($languages as $language)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="languages[]" value="{{ $language->id }}"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($language->id, $selectedLanguages ?? []) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $language->name }}</span>
                        </label>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Response Time -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Response Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Typical Response Time</label>
                        <select name="response_time"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="within_hour">Within an hour</option>
                            <option value="within_few_hours">Within a few hours</option>
                            <option value="within_day">Within a day</option>
                            <option value="few_days">A few days or more</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Response Rate</label>
                        <select name="response_rate"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="100">100%</option>
                            <option value="90">90%</option>
                            <option value="80">80%</option>
                            <option value="70">70% or less</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit/step/3' : '/property/create/step/3' }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('step4Form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/4" : "/property/create/step/4" }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/5" : "/property/create/step/5" }}';
        } else {
            alert(data.message || 'Error saving host profile');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving host profile');
    });
});
</script>
@endsection
