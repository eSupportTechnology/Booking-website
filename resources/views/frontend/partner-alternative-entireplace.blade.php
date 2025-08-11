@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')
<div x-data="wizardForm()" class="container mx-auto mt-16 px-4 md:px-6 lg:px-8 lg:ml-32">

    <!-- Step 0: Category Selection -->
    <template x-if="step === 0">
        <div class="max-w-6xl mx-auto mt-8">
            <h2 class="text-2xl md:text-3xl font-bold text-left mb-6">
                From the list below, which property category is most similar to your place?
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
                <template x-for="option in categoryOptions" :key="option.value">
                    <div
                        @click="selectCategory(option.value)"
                        :class="category === option.value ? 'border-[#3CC0E9] border-2 bg-blue-50' : 'border border-gray-300'"
                        class="relative cursor-pointer p-6 rounded-xl shadow-sm transition duration-200 hover:border-blue-400"
                    >
                        <h3 class="text-lg font-semibold mb-2 capitalize" x-text="option.label"></h3>
                        <p class="text-sm text-gray-600" x-text="option.description"></p>

                        <template x-if="category === option.value">
                            <span class="absolute top-2 right-2 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        </template>
                    </div>
                </template>
            </div>

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
                <span></span>
                <button  
                    @click="continueWizard"
                    :disabled="!category"
                    class="py-3 px-8 rounded transition-all duration-200 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                    type="button">
                    Continue
                </button>
            </div>
        </div>
    </template>

    <!-- Steps 1 & 2 -->
    <template x-if="step > 0">
        <div class="max-w-3xl mx-auto">

            <!-- Step 1 -->
            <template x-if="step === 1">
                <div class="space-y-4">
                    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow mx-auto mt-16 px-4 md:px-6 lg:px-8 lg:ml-32">
                        <div class="max-w-xl mx-auto p-4 space-y-6">

                            <h2 class="text-2xl font-bold text-center">How many <span x-text="categoryLabelPlural"></span> are you listing?</h2>

                            <div class="space-y-4">
                                <label
                                    :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white"
                                    @click="selected = 'one'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('images/aprt-b.png') }}" alt="One" class="w-14 h-10" />
                                            <span class="text-lg text-gray-800">One <span x-text="categoryLabel"></span></span>
                                        </div>
                                        <template x-if="selected === 'one'">
                                            <div class="text-blue-600 text-xl font-bold">✔</div>
                                        </template>
                                    </div>
                                    <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
                                </label>

                                <label
                                    :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white"
                                    @click="selected = 'multiple'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('images/aprt-a.png') }}" alt="Multiple" class="w-14 h-10" />
                                            <span class="text-lg text-gray-800">Multiple <span x-text="categoryLabelPlural"></span></span>
                                        </div>
                                        <template x-if="selected === 'multiple'">
                                            <div class="text-blue-600 text-xl font-bold">✔</div>
                                        </template>
                                    </div>
                                    <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
                                </label>
                            </div>

                            <div x-show="selected === 'multiple'" x-transition class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
                                <h3 class="text-lg font-semibold">Are these <span x-text="categoryLabelPlural"></span> in the same address or building?</h3>

                                <label
                                    :class="sameAddress === 'yes' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer bg-white" @click="sameAddress = 'yes'">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/accomm_single_address@2x.png') }}" class="w-10 h-10" />
                                        <span>Yes, these <span x-text="categoryLabelPlural"></span> are at the same address or building</span>
                                    </div>
                                </label>

                                <label
                                    :class="sameAddress === 'no' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer bg-white" @click="sameAddress = 'no'">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ asset('images/accomm_multiple_address@2x.png') }}" class="w-14 h-10" />
                                        <span>No, these <span x-text="categoryLabelPlural"></span> are at different addresses or buildings</span>
                                    </div>
                                </label>

                                <div>
                                    <label class="block font-medium mb-1">Number of <span x-text="categoryLabelPlural"></span></label>
                                    <input type="number" min="2" x-model="propertyCount" name="property_count"
                                        class="border rounded w-24 p-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <button type="button" @click="step--"
                                    class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
                                    ←
                                </button>
                                <template x-if="step < 2">
                                    <button type="button" @click="nextStep"
                                        class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
                                        Continue
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Step 2 -->
            <template x-if="step === 2">
                <div class="space-y-4">
                    <template x-if="selected === 'one'">
<!-- -->
                         <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/tent-big@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8" x-text="categoryHeadingDescription"></h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <template x-if="step === 2">
                        <div class="space-y-2">
                            <button @click="finalContinue"
    class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
    Continue
</button>

                            <button @click="step--"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </template>

                </div>





                
                    </template>

                    <template x-if="selected === 'multiple'">
                         <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/tent-big@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                     <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8" x-text="categoryHeadingDescriptionMultiple"></h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <template x-if="step === 2">
                        <div class="space-y-2">
                           <button @click="finalContinue"
    class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
    Continue
</button>

                            <button @click="step--"
                                class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                                No, I need to make a change
                            </button>
                        </div>
                    </template>

                </div>

                       
                    </template>


                </div>
            </template>

        </div>
    </template>
</div>

<script>
    function wizardForm() {
        return {
            step: 0,
            category: '',
            selected: '',
            sameAddress: 'yes',
            propertyCount: 2,
            categoryOptions: [
                {
                    value: 'campsite',
                    label: 'campsite',
                    description: 'Accommodation offering cabins or bungalows alongside areas for camping or caravans with shared facilities or recreational activities',
                    plural: 'campsites'
                },
                {
                    value: 'boat',
                    label: 'boat',
                    description: 'Commercial travel accommodation located on a boat',
                    plural: 'boats'
                },
                {
                    value: 'luxury_tent',
                    label: 'luxury tent',
                    description: 'Tents with fixed bedding and some services, located in natural surroundings',
                    plural: 'luxury tents'
                }
            ],
            get categoryLabel() {
                const selected = this.categoryOptions.find(opt => opt.value === this.category);
                return selected ? selected.label : '';
            },
            get categoryLabelPlural() {
                const selected = this.categoryOptions.find(opt => opt.value === this.category);
                return selected ? selected.plural : '';
            },
            get categoryHeadingDescription() {
              switch (this.category) {
                case 'campsite':
                    return 'One campsite where guests can book an entire place';
                case 'boat':
                    return 'One boat where guests can book the entire place';
                case 'luxury_tent':
                    return 'One luxury tent where guests can book the entire place';
                default:
                    return 'One property in the same location where guests can book an entire apartment';
              }
            },
           get categoryHeadingDescriptionMultiple() {
    if (this.sameAddress === 'no') {
        switch (this.category) {
            case 'campsite':
                return 'Multiple campsites at different locations where guests can book an entire place';
            case 'boat':
                return 'Multiple boats at different locations where guests can book the entire place';
            case 'luxury_tent':
                return 'Multiple luxury tents at different locations where guests can book the entire place';
            default:
                return 'Multiple properties at different locations available for guests';
        }
    } else {
        switch (this.category) {
            case 'campsite':
                return 'Multiple campsites in the same location where guests can book an entire place';
            case 'boat':
                return 'Multiple boats in the same location where guests can book the entire place';
            case 'luxury_tent':
                return 'Multiple luxury tents at the same location where guests can book the entire place';
            default:
                return 'Multiple properties available for guests';
        }
    }
},


          finalContinue() {
    let route = '';

    if (this.category === 'boat') {
        if (this.selected === 'one') {
            route = '/partner/alternative/form';
        } else if (this.sameAddress === 'yes') {
            route = '/partner/alternative/multiple/boats/sameaddress';
        } else {
            route = '/partner/alternative/single/boat';
        }
    } else if (this.category === 'campsite') {
        if (this.selected === 'one') {
            route = '/partner/alternative/Single/Campsite';
        } else if (this.sameAddress === 'yes') {
            route = '/partner/alternative/Single/Campsite';
        } else {
            route = '/partner/alternative/Single/Campsite';
        }
    } else if (this.category === 'luxury_tent') {
        if (this.selected === 'one') {
            route = '/partner/tent/single';
        } else if (this.sameAddress === 'yes') {
            route = '/partner/tent/multiple/sameaddress';
        } else {
            route = '/partner/tent/single';
        }
    }

    if (route) {
        window.location.href = route;
    }
},


 
            selectCategory(value) {
                this.category = value;
            },
            continueWizard() {
                if (this.category !== '') {
                    this.step = 1;
                }
            },
            nextStep() {
                if (this.step < 2) this.step++;
            },
            previousStep() {
                if (this.step > 1) this.step--;
            },
        };
    }
</script>
@endsection
