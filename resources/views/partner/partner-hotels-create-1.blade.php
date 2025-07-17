<!DOCTYPE html>
<html lang="en" x-data="{ step: 1, selectedBox: null, unitType: null, showMore: false }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Homes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <!-- Logo -->
                    <div class="w-full md:w-auto md:ml-6">
                        <a href="/" class="text-2xl font-bold font-poppins">Bookintour.com</a>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
                        <!-- Help Icon -->
                        <a href="/help" title="Help">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>

                        <!-- Language Button -->
                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
                            title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                                class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Language Modal -->
                        <div id="language-modal"
                            class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)"
                                                class="h-5 w-5" />
                                            <span>English (UK)</span>
                                        </button>
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="h-5 w-5" />
                                            <span>Deutsch</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>

    <div class="max-w-6xl p-4 ml-14 bg-gray-100" x-data="{ propertyId: null, selected: '', }">

        <!-- Step 1: Main Form Step -->
        <form class="p-6 rounded-lg space-y-6" @submit.prevent>
            <div class="flex justify-between mb-6 text-sm font-medium hidden">
                <template x-for="n in 10" :key="n">
                    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
                        Step <span x-text="n"></span>
                    </div>
                </template>
            </div>

            <!-- STEP 1 -->
            <div x-show="step === 1" x-cloak x-data="{
                selectedBox: '',
                propertyId: null,
                subtypes: [],
                subcategories: {{ Js::from($subcategories) }},
                async submitStep1() {
                    if (this.selectedBox === '') return;

                    try {
                        const response = await fetch('{{ route('partner.property.step1.store_new') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                apartment_type: this.selectedBox,
                                subcategory_id: this.selectedBox,
                                category_id: '{{ $categoryId }}'
                            })
                        });

                        const contentType = response.headers.get('content-type');
                        if (!response.ok || !contentType.includes('application/json')) {
                            const text = await response.text();
                            console.error('Server did not return JSON:', text);
                            alert('Unexpected server response:\n' + text);
                            return;
                        }

                        const data = await response.json();
                        this.propertyId = data.property_id;
                        this.step = 2;
                        await this.fetchSubtypes(this.selectedBox);
                        alert(data.message || 'Property created successfully');

                    } catch (error) {
                        console.error('Request failed:', error);
                        alert('Request failed: ' + error.message);
                    }
                },
                async fetchSubtypes(subcategoryId) {
                    try {
                        const response = await fetch(`/partner/property_subtype/${subcategoryId}`);
                        const data = await response.json();
                        console.log('Fetched subtypes:', data);
                        this.subtypes = data;
                    } catch (err) {
                        console.error('Failed to fetch subtypes:', err);
                    }
                }
            }">
                <div x-show="step === 1" x-cloak class="container mx-auto px-4 py-8 max-w-6xl">
                    <h2 class="text-2xl font-bold mb-6 mt-8">
                        Which property category is most similar to your place?
                    </h2>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                            <!-- Main cards dynamically from DB -->
                            <template x-for="subcategory in subcategories" :key="subcategory.id">
                                <div @click="selectedBox = subcategory.id"
                                    :class="selectedBox === subcategory.id ? 'border-2 border-blue-500 bg-blue-50' :
                                        'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white relative">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-2" x-text="subcategory.name"></h3>
                                        <p class="text-sm text-gray-700">Choose this type</p>
                                    </div>
                                    <div class="absolute top-2 right-2" x-show="selectedBox === subcategory.id">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <input type="hidden" name="category_id" value="{{ $categoryId }}">
                                    <input type="radio" name="subcategory_id" :value="subcategory.id"
                                        x-model="selectedBox" class="hidden" />
                                </div>
                            </template>

                            <!-- Toggle Button for extra options if needed -->
                            <div @click="showMore = !showMore"
                                class="border border-gray-300 rounded p-4 cursor-pointer text-blue-600 hover:bg-gray-50 flex items-center justify-center font-medium transition">
                                <span x-text="showMore ? '– Show less' : '+ More options'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Help Link -->
                    <div class="mt-8 text-left">
                        <a href="#" class="flex items-center space-x-2 text-sm text-blue-500 hover:underline">
                            <img src="{{ asset('assets/iconoir_question-mark-circle.svg') }}" class="w-5 h-5" />
                            <span class="text-base">I don't see my property type on the list</span>
                        </a>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <button type="button" @click="step = 1"
                            class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded">
                            ←
                        </button>
                        <button @click="submitStep1()" :disabled="!selectedBox"
                            :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                            class="py-3 px-8 rounded transition-all duration-200 text-white font-semibold"
                            type="button">
                            Continue
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div x-show="step === 2" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
                <div id="selection-container" x-show="step === 2" x-cloak
                    class="container mx-auto px-4 py-8 max-w-6xl" x-data="{
                        async submitStep2() {
                            if (!this.selectedBox || !this.propertyId) return;

                            const response = await fetch(`/partner/property/${this.selectedBox}/step2/${this.propertyId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    subtype_id: this.selectedBox,
                                    property_id: this.propertyId
                                })
                            });

                            if (response.ok) {
                                const data = await response.json();
                                this.step = 3;
                                console.log('Step 2 selectedBox:', this.selectedBox);
                                alert(data.message || 'Step 2 saved successfully');
                            } else {
                                const error = await response.json();
                                alert(error.message || 'Error in Step 2');
                            }
                        }
                    }">
                    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow space-y-6 ">
                        <h2 class="text-xl font-bold text-left">How many hotels are you listing?</h2>

                        <div class="space-y-4">
                            <!-- One -->
                            <label :class="unitType === 'one' ? 'border-blue-500 border-2' : 'border-gray-300'"
                                class="block border rounded p-4 bg-white cursor-pointer" @click="unitType = 'one'">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/aprt-b.png') }}" class="w-14 h-10" />
                                        <span class="text-base">One hotel with one or multiple rooms that guests can
                                            book</span>
                                    </div>
                                    <template x-if="unitType === 'one'">
                                        <span class="text-blue-500 font-bold text-xl">✔</span>
                                    </template>
                                </div>
                            </label>

                            <!-- Multiple -->
                            <label :class="unitType === 'multiple' ? 'border-blue-500 border-2' : 'border-gray-300'"
                                class="block border rounded p-4 bg-white cursor-pointer"
                                @click="unitType = 'multiple'">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/aprt-a.png') }}" class="w-14 h-10" />
                                        <span class="text-base">Multiple hotels with one or multiple rooms that guests
                                            can
                                            book</span>
                                    </div>
                                    <template x-if="unitType === 'multiple'">
                                        <span class="text-blue-500 font-bold text-xl">✔</span>
                                    </template>
                                </div>
                            </label>
                        </div>

                        <div x-show="unitType === 'multiple'" x-transition
                            class="mt-6 space-y-4 bg-gray-50 p-4 rounded">


                            <div>
                                <label class="block mb-1">Number of properties</label>
                                <input type="number" min="2" value="2"
                                    class="border rounded w-24 p-2" />
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button @click="step = 1"
                                class="border border-[#3CC0E9] text-[#3CC0E9] px-4 py-2 rounded font-semibold">←
                            </button>
                            <button @click="if(unitType) step = 3" :disabled="!unitType"
                                :class="!unitType ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-[#29ACD5]'"
                                class="text-white px-6 py-2 rounded font-semibold">
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div x-show="step === 3" x-cloak class="container mx-auto px-2 py-8 max-w-6xl mt-8">
                <template x-if="unitType === 'one'">
                    <div>
                        <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                            <p class="text-base text-gray-600 mb-8">You're listing:</p>

                            <!-- Icon -->
                            <div class="flex justify-center mb-8">
                                <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                                    class="w-16 h-16" />
                            </div>

                            <!-- Heading -->
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                                One hotel where guests can book a room
                            </h2>

                            <!-- Description -->
                            <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                            <!-- Buttons -->

                            <div class="space-y-2">
                                <a href="{{ route('partner.hotels.create.2') }}">
                                    <button type="button"
                                        class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                        Continue
                                    </button></a>
                                <button type="button" @click="step = 2"
                                    class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                    No, I need to make a change
                                </button>
                            </div>
                </template>

                <template x-if="unitType === 'multiple'">
                    <div>
                        <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                            <p class="text-base text-gray-600 mb-8">You're listing:</p>

                            <!-- Icon -->
                            <div class="flex justify-center mb-8">
                                <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                                    class="w-16 h-16" />
                            </div>

                            <!-- Heading -->
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                                Multiple hotels where guests can book a room
                            </h2>

                            <!-- Description -->
                            <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                            <!-- Buttons -->

                            <div class="space-y-2">
                                <a href="{{ route('partner.hotels.create.2') }}">
                                    <button type="button"
                                        class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                                        Continue
                                    </button></a>
                                <button type="button" @click="step = 2"
                                    class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                    No, I need to make a change
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </form>

    </div>

</body>

</html>
