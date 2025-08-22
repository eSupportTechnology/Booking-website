<!-- Search Box: Overlapping both sections -->
<div class="relative z-10 -mt-8 px-4">

<form action="{{ route('customer.search') }}" method="GET"
    class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">

    <!-- Destination Selector (Styled Like Guests) -->
    <div x-data="{ open: false, destination: '' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
            <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6"
                style="filter: brightness(0) saturate(100%);" />
            <span x-text="destination || '{{ __("messages.Where are you going?") }}'" style="font-family: 'Noto Sans', sans-serif;"
                class="text-gray-800 truncate text-base"></span>
        </button>

        <!-- Dropdown Box -->
        <div x-show="open" @click.away="open = false"
            class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
            <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']"
                :key="city">
                <button type="button" @click="destination = city; open = false"
                    class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                    <span x-text="city"></span>
                </button>
            </template>
        </div>

        <!-- Hidden field to submit the selected destination -->
        <input type="hidden" name="destination" :value="destination">
    </div>

    <!-- Dates Selector -->
    <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }"
        class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">

        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
            <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
            <span class="text-gray-800 truncate">
                <template x-if="activeTab === 'check'">
                    <span><span x-text="checkIn ? checkIn : '{{ __("messages.Check-in") }}'"
                            style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span> — <span
                            x-text="checkOut ? checkOut : '{{ __("messages.Check-out") }}'" style="font-family: 'Noto Sans', sans-serif;"
                            class="text-base"></span></span>
                </template>
                <template x-if="activeTab === 'flexible'">
                    <span x-text="flexibleOption ? flexibleOption : 'Flexible dates'"></span>
                </template>
            </span>
        </button>

        <!-- Dropdown Content -->
        <div x-show="open" @click.away="open = false"
            class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm"
            x-transition>
            <!-- Tabs -->
            <nav class="flex border-b border-gray-200 mb-4">
                <button @click.prevent="activeTab = 'check'"
                    :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                    class="px-4 py-2 border-b-2 font-semibold focus:outline-none">
                    {{ __('messages.Check-in / Check-out') }}
                </button>
                <button @click.prevent="activeTab = 'flexible'"
                    :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                    class="px-4 py-2 border-b-2 font-semibold focus:outline-none">
                    {{ __('messages.Flexible dates') }}
                </button>
            </nav>

            <!-- Check-in / Check-out Section -->
            <div x-show="activeTab === 'check'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Check-in Date') }}</label>
                        <input type="date" name="checkIn" x-model="checkIn"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
                            placeholder="Check-in" />
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Check-out Date') }}</label>
                        <input type="date" name="checkOut" x-model="checkOut"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
                            placeholder="Check-out" />
                    </div>
                </div>
            </div>

            <!-- Flexible Dates Section -->
            <div x-show="activeTab === 'flexible'" x-transition>
                <input type="hidden" name="flexibleOption" :value="flexibleOption">
                <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Select Flexible Dates') }}</label>
                <select x-model="flexibleOption"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none">
                    <option value="" disabled>{{ __('messages.Select option')}}</option>
                    <option value="Weekend Getaway">Weekend Getaway</option>
                    <option value="Next Month">Next Month</option>
                    <option value="Anytime">Anytime</option>
                    <option value="Custom Range">Custom Range</option>
                </select>
            </div>

            <!-- Done Button -->
            <div class="mt-4 text-right">
                <button @click="open = false"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    {{ __('messages.Done') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Guests Selector -->
    <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }"
        class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
            <img src="{{ asset('assets/user.svg') }}" alt="Calendar" class="w-5 h-5" />
            <span x-text="`${adults} {{ __('messages.adults') }} · ${children} {{ __('messages.children') }} · ${rooms} {{ __('messages.room') }} ${rooms > 1 ? 's' : ''}`"
                class="text-gray-800 text-base truncate" style="font-family: 'Noto Sans', sans-serif;"></span>
        </button>

        <!-- Guest Dropdown -->
        <div x-show="open" @click.away="open = false"
            class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
            <!-- Hidden inputs for form submission -->
            <input type="hidden" name="adults" :value="adults">
            <input type="hidden" name="children" :value="children">
            <input type="hidden" name="rooms" :value="rooms">
            <input type="hidden" name="pets" :value="pets">

            <!-- Adults -->
            <div class="flex items-center justify-between">
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.adults') }}</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded"
                        style="font-family: 'Noto Sans', sans-serif;">−</button>
                    <span x-text="adults"></span>
                    <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded"
                        style="font-family: 'Noto Sans', sans-serif;">+</button>
                </div>
            </div>

            <!-- Children -->
            <div class="flex items-center justify-between">
                <span>{{ __('messages.children')}}</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(children > 0) children--"
                        class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="children"></span>
                    <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Rooms -->
            <div class="flex items-center justify-between">
                <span>{{ __('messages.room')}}</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(rooms > 1) rooms--"
                        class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="rooms"></span>
                    <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Pets Toggle -->
            <div class="flex items-center justify-between">
                <span>{{ __('messages.Travelling with pets?') }}</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="pets" class="sr-only peer">
                    <div
                        class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                        <div
                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4">
                        </div>
                    </div>
                </label>
            </div>

            <p class="text-xs text-gray-500">
                {{ __("messages.Assistance animals aren't considered pets.") }}<br>
                <a href="#" class="text-blue-600 underline">{{ __('messages.Read more about travelling with assistance animals') }}</a>
            </p>

            <!-- Done Button -->
            <button type="button" @click="open = false"
                class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                {{ __('messages.Done')}}
            </button>
        </div>
    </div>

    <!-- Search Button -->
    <div class="px-2 py-1">
        <button type="submit"
            class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm"
            style="background-color:#3CC0E9;">
            {{ __('messages.Search') }}
        </button>
    </div>
</form>

</div>
