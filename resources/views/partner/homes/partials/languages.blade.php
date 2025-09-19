<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Languages Spoken</h3>
        <p class="text-gray-600">Let guests know which languages you can communicate in</p>
    </div>

    <form id="languages-form" class="space-y-8" action="{{ route('partner.homes.update.languages', $property) }}" method="POST">
        @csrf

        @php
            $selectedLanguages = $property->languages ? $property->languages->pluck('id')->toArray() : [];
            $popularLanguages = [
                ['id' => 1, 'name' => 'English', 'flag' => '🇺🇸'],
                ['id' => 2, 'name' => 'Spanish', 'flag' => '🇪🇸'],
                ['id' => 3, 'name' => 'French', 'flag' => '🇫🇷'],
                ['id' => 4, 'name' => 'German', 'flag' => '🇩🇪'],
                ['id' => 5, 'name' => 'Italian', 'flag' => '🇮🇹'],
                ['id' => 6, 'name' => 'Portuguese', 'flag' => '🇵🇹'],
                ['id' => 7, 'name' => 'Chinese', 'flag' => '🇨🇳'],
                ['id' => 8, 'name' => 'Japanese', 'flag' => '🇯🇵'],
                ['id' => 9, 'name' => 'Arabic', 'flag' => '🇸🇦'],
                ['id' => 10, 'name' => 'Russian', 'flag' => '🇷🇺'],
                ['id' => 11, 'name' => 'Korean', 'flag' => '🇰🇷'],
                ['id' => 12, 'name' => 'Dutch', 'flag' => '🇳🇱']
            ];
        @endphp

        <!-- Popular Languages -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-globe text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Popular Languages</h4>
                    <p class="text-gray-600 text-sm">Select the languages you or your staff can speak</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($popularLanguages as $language)
                    <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-200 group transform hover:scale-105 language-checkbox peer-checked:border-purple-500 peer-checked:bg-purple-50">
                        <input type="checkbox" name="languages[]" value="{{ $language['id'] }}" id="lang_{{ $language['id'] }}" {{ in_array($language['id'], $selectedLanguages) ? 'checked' : '' }} class="sr-only peer language-input">
                        <div class="flex items-center">
                            <span class="text-lg mr-2">{{ $language['flag'] }}</span>
                            <span class="font-medium text-gray-700 group-hover:text-purple-700">{{ $language['name'] }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Additional Languages -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-plus-circle text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Additional Languages</h4>
                        <p class="text-gray-600 text-sm">Add any other languages you speak</p>
                    </div>
                </div>
                <button type="button" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium py-2 px-6 rounded-xl transition-all duration-200 transform hover:scale-105" id="add-language">
                    <i class="fas fa-plus mr-2"></i>
                    Add Language
                </button>
            </div>

            <div id="additional-languages" class="space-y-3">
                @if($property->languages->count() > 12)
                    @foreach($property->languages->skip(12) as $language)
                        <div class="flex items-center space-x-3">
                            <input type="text" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" name="additional_languages[]" value="{{ $language->name }}" placeholder="Enter language name">
                            <button type="button" class="remove-language bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Language Benefits -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-start">
                <div class="bg-green-100 p-3 rounded-xl mr-4 mt-1">
                    <i class="fas fa-lightbulb text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Why Add Languages?</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-green-700">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            <span>Attract international guests</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star mr-2"></i>
                            <span>Improve guest experience</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            <span>Better search visibility</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-heart mr-2"></i>
                            <span>Build guest confidence</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Languages
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Add language button
    const addLanguageBtn = document.getElementById('add-language');
    if (addLanguageBtn) {
        addLanguageBtn.addEventListener('click', function() {
            const container = document.getElementById('additional-languages');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-3';
            div.innerHTML = `
                <input type="text" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" name="additional_languages[]" placeholder="Enter language name">
                <button type="button" class="remove-language bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl transition-colors">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            `;
            container.appendChild(div);
        });
    }

    // Remove language button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-language')) {
            e.target.closest('.flex').remove();
        }
    });
});
</script>
