
@extends('partner.partner-layout')

@section('title', 'List your apartment | ' . config('domains.app_name'))

@push('styles')
@include('partner.partials.wizard-styles')
@endpush

@section('content')
<body class="bg-gray-100 text-gray-800">
    <!-- Toast Notification System -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script>
    // Toast notification system
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        // Base classes
        let bgColor = 'bg-blue-500';
        let textColor = 'text-white';
        let icon = 'ℹ️';

        // Type-specific styling
        switch(type) {
            case 'success':
                bgColor = 'bg-green-500';
                icon = '✅';
                break;
            case 'error':
                bgColor = 'bg-red-500';
                icon = '❌';
                break;
            case 'warning':
                bgColor = 'bg-orange-500';
                textColor = 'text-white';
                icon = '⚠️';
                break;
        }

        toast.className = `${bgColor} ${textColor} px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <span class="text-lg">${icon}</span>
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
        `;

        container.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
    </script>
    <!-- Header -->

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Currency modal logic
        const currentCurrency = document.getElementById("current-currency");
        const currencyModal = document.getElementById("currency-modal");
        const currencyCloseBtn = document.getElementById("currency-close-btn");

        if (currentCurrency && currencyModal && currencyCloseBtn) {
            // Open currency modal on clicking the currency span
            currentCurrency.addEventListener("click", () => {
                currencyModal.classList.remove("hidden");
            });

            // Close currency modal on close button click
            currencyCloseBtn.addEventListener("click", () => {
                currencyModal.classList.add("hidden");
            });

            // Close currency modal on clicking outside the modal content
            window.addEventListener("click", (e) => {
                if (e.target === currencyModal) {
                    currencyModal.classList.add("hidden");
                }
            });

            // Change currency when a currency button is clicked
            currencyModal.querySelectorAll("button[data-currency]").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const selectedCurrency = btn.getAttribute("data-currency");
                    currentCurrency.textContent = selectedCurrency;
                    currencyModal.classList.add("hidden");
                });
            });
        }

        // Language modal logic
        const languageButton = document.getElementById("language-button");
        const languageModal = document.getElementById("language-modal");
        const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

        if (languageButton && languageModal && closeBtn) {
            // Open the language modal
            languageButton.addEventListener("click", () => {
                languageModal.classList.remove("hidden");
            });

            // Close language modal on close button click
            closeBtn.addEventListener("click", () => {
                languageModal.classList.add("hidden");
            });

            // Close language modal on clicking outside the modal content
            window.addEventListener("click", (event) => {
                if (event.target === languageModal) {
                    languageModal.classList.add("hidden");
                }
            });
        }
    });
</script>

    <!--Start Form-->
    <div class="max-w-6xl p-4 mx-auto sm:ml-14" x-data="{
        step: 1,
        categoryId: null,
        addressTypeId: null,
        showProgress: false,
        selected: '',
        sameAddress: 'yes',
        propertyCount: 2,
        selectedChannels: [],
        url: '',
        showImportSection() {
            return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
        }
    }">

        <!-- Add CSRF token meta tag -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form method="POST" action="{{ route('partner.property.step1.store_new') }}"
            class=" p-6 rounded-lg  space-y-6" enctype="multipart/form-data"             @submit="
                console.log('Form submit event triggered');
                // Ensure addressTypeId is set correctly before submission
                if (selected === 'One') {
                    addressTypeId = 1;
                } else if (selected === 'Multiple') {
                    if (sameAddress === 'no') {
                        addressTypeId = 3;
                    } else {
                        addressTypeId = 2;
                    }
                }
                console.log('Form submission - selected:', selected, 'sameAddress:', sameAddress, 'addressTypeId:', addressTypeId);
                console.log('Form action:', event.target.action);
                console.log('Form data being submitted:', {
                    categoryId: categoryId,
                    propertyCount: propertyCount,
                    addressTypeId: addressTypeId,
                    selectedChannels: selectedChannels
                });

                // For multiple apartments with same address, we need to handle the redirect after form submission
                console.log('Checking condition - selected:', selected, 'sameAddress:', sameAddress);
                console.log('Condition result:', selected === 'Multiple' && sameAddress === 'yes');

                if (selected === 'Multiple' && sameAddress === 'yes') {
                    console.log('AJAX submission triggered');
                    // Prevent default form submission and handle it manually
                    event.preventDefault();

                    // Submit form via AJAX
                    const formData = new FormData(event.target);
                    fetch(event.target.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Form submission response:', data);
                        if (data.success) {
                            // Show success message
                            showToast('Property created successfully!', 'success');
                            // Redirect to multiple apartment form with property ID
                            console.log('Redirecting to multiple apartment form with property ID:', data.property_id);
                            window.location.href = '/partner/partner-multiple-apartment/' + data.property_id;
                        } else {
                            showToast('Error: ' + data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while saving the property.', 'error');
                    });
                }
            ">
            @csrf

            <!-- Hidden fields for DTO data -->
            <input type="hidden" name="category_id" :value="categoryId">
            <input type="hidden" name="property_count" :value="propertyCount">
            <input type="hidden" name="address_type_id" :value="addressTypeId">
            <input type="hidden" name="selected_channels" :value="selectedChannels.join(',')">

            <!-- Progress bar -->
            <div x-show="showProgress" class="flex justify-between mb-6 text-sm font-medium">
                <template x-for="n in 10" :key="n">
                    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
                        Step <span x-text="n"></span>
                    </div>
                </template>
            </div>


            <!-- Main Step 1 (How many apartments)-->
            <div x-show="step === 1" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow ">
                    <div class="max-w-xl mx-auto p-4 space-y-6">

                        <h2 class="text-2xl font-bold text-center">How many apartments are you listing?</h2>

                        <!-- Apartment type options -->
                        <div class="space-y-4">
                            @foreach ($subcategories as $subcategory)
                                <label
                                    :class="selected === '{{ $subcategory->name }}' ? 'border-blue-600 border-2' :
                                        'border border-gray-300'"
                                    class="block rounded p-4 cursor-pointer transition bg-white"
                                    @click="selected = '{{ $subcategory->name }}'; categoryId = {{ $subcategory->category_id ?? 'null' }}; addressTypeId = {{ $subcategory->name === 'One' ? 1 : 2 }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @if ($subcategory->name === 'One')
                                                <img src="{{ asset('images/aprt-b.png') }}" alt="One Apartment"
                                                    class="w-14 h-10" />
                                                <span class="text-lg text-gray-800">One apartment</span>
                                            @elseif($subcategory->name === 'Multiple')
                                                <img src="{{ asset('images/aprt-a.png') }}" alt="Multiple Apartments"
                                                    class="w-14 h-10" />
                                                <span class="text-lg text-gray-800">Multiple apartments</span>
                                            @else
                                                <span class="text-lg text-gray-800">{{ $subcategory->name }}</span>
                                            @endif
                                        </div>
                                        <template x-if="selected === '{{ $subcategory->name }}'">
                                            <div class="text-blue-600 text-xl font-bold">✔</div>
                                        </template>
                                    </div>
                                    <input type="radio" name="apartment_type" value="{{ $subcategory->name }}"
                                        x-model="selected" class="hidden" />
                                </label>
                            @endforeach
                        </div>

                        <!-- Conditional fields for multiple apartments -->
                        <div x-show="selected === 'Multiple'" x-transition
                            class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
                            <h3 class="text-lg font-semibold">Are these properties in the same address or building?
                            </h3>

                            <!-- Same address option -->
                            <label
                                :class="sameAddress === 'yes' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                class="block rounded p-4 cursor-pointer bg-white"
                                @click="sameAddress = 'yes'; addressTypeId = 2">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/accomm_single_address@2x.png') }}"
                                        alt="Multiple Apartments" class="w-10 h-10" />
                                    <span>Yes, these apartments are at the same address or building</span>
                                </div>
                            </label>

                            <!-- Different addresses option -->
                            <label
                                :class="sameAddress === 'no' ? 'border-blue-600 border-2' : 'border border-gray-300'"
                                class="block rounded p-4 cursor-pointer bg-white"
                                @click="sameAddress = 'no'; addressTypeId = 3">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('images/accomm_multiple_address@2x.png') }}"
                                        alt="Multiple Apartments" class="w-14 h-10" />
                                    <span>No, these apartments are at different addresses or buildings</span>
                                </div>
                            </label>

                            <!-- Number of properties -->
                            <div>
                                <label class="block font-medium mb-1">Number of properties</label>
                                <input type="number" min="2" x-model="propertyCount"
                                    @input="formData.property_count = propertyCount" name="property_count"
                                    class="border rounded w-24 p-2" />
                            </div>
                        </div>
                        <!-- Navigation Buttons for Step 1 -->
                        <template x-if="step === 1">
                            <div class="flex items-center justify-between pt-4">
                                <button type="button" @click="step--"
                                    class="wiz-btn-secondary">
                                    ←
                                </button>
                                <button type="button"
                                    @click="
                                        if(selected === 'One') {
                                            step = 2;
                                        } else if(selected === 'Multiple') {
                                            step = 3;
                                        }
                                    "
                                    class="wiz-btn-primary"
                                    :class="!selected ? 'opacity-50 cursor-not-allowed' : ''">
                                    Continue
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!--Main Step 1 End-->

            <!-- Confirmation Step for ONE Apartment (Step 2) -->
            <div x-show="step === 2 && selected === 'One'" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/aprt-b.png') }}" alt="One Apartment"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        One apartment where guests can book the entire apartment
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="button" @click="step = 4"
                            class="wiz-btn-primary w-full">
                            Continue
                        </button>
                        <button type="button" @click="step = 1"
                            class="wiz-btn-secondary w-full mb-6">
                            No, I need to make a change
                        </button>
                    </div>
                </div>
            </div>

            <!-- Confirmation Step for MULTIPLE Apartments (Step 3) -->
            <div x-show="step === 3 && selected === 'Multiple'" x-cloak>
                <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
                    <p class="text-base text-gray-600 mb-8">You're listing:</p>

                    <!-- Icon -->
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments"
                            class="w-16 h-16" />
                    </div>

                    <!-- Heading -->
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
                        <span x-text="sameAddress === 'yes' ? 'Multiple apartments in the same location' : 'Multiple apartments in different locations'"></span>
                        where guests can book an entire apartment
                    </h2>

                    <!-- Description -->
                    <p class="text-gray-700 mb-8">Does this sound like your property?</p>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="submit" x-show="sameAddress === 'yes'"
                            class="wiz-btn-primary w-full">
                            Continue
                        </button>
                        <button type="button" x-show="sameAddress === 'no'"
                            @click="step = 4"
                            class="wiz-btn-primary w-full">
                            Continue
                        </button>
                        <button type="button" @click="step = 1"
                            class="wiz-btn-secondary w-full mb-6">
                            No, I need to make a change
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Step 4 (Where else is your property listed? - For ONE apartment)-->
            <div x-show="step === 4" x-cloak>
                <div x-data="{
                    selectedChannels: [],
                    get showImportSection() {
                        return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
                    }
                }" class="bg-white max-w-xl w-full p-6 rounded-lg shadow space-y-6">

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-gray-900" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Where else are your properties listed?' : 'Where else is your property listed?'"></h2>

                    <!-- Info -->
                    <p class="text-sm text-gray-700">
                        <span x-text="selected === 'Multiple' && sameAddress === 'no' ? 'If your properties are listed on Airbnb or Vrbo, you can speed up registration by importing them' : 'If your property is listed on Airbnb or Vrbo, you can speed up registration by importing it'"></span>
                        directly to {{ config('domains.subdomain') }}.
                    </p>

                    <!-- Checkboxes -->
                    <div class="space-y-4 text-left">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Airbnb" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Airbnb</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="TripAdvisor" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>TripAdvisor</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Vrbo" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Vrbo</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" value="Another" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <span>Another website</span>
                        </label>
                        <label class="flex items-center space-x-3 text-gray-400"
                            :class="{ 'text-gray-900': !selectedChannels.length }">
                            <input type="checkbox" value="None" x-model="selectedChannels"
                                class="form-checkbox h-5 w-5 text-blue-600" :disabled="selectedChannels.length > 0">
                            <span x-text="selected === 'Multiple' && sameAddress === 'no' ? 'My properties aren\'t listed on any other websites' : 'My property isn\'t listed on any other websites'"></span>
                        </label>
                    </div>

                    <!-- Conditional Airbnb/Vrbo import section -->
                    <div x-show="showImportSection" x-transition class="border-t pt-6 space-y-4">
                        <h3 class="font-semibold text-gray-800">Import property details from Airbnb or Vrbo</h3>

                        <label class="block text-sm font-medium text-gray-700" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Paste the links to your Airbnb or Vrbo listings' : 'Paste the link to your Airbnb or Vrbo listing'"></label>
                        <div x-data="{ url: '' }" class="flex gap-2">
                            <input type="url" x-model="url" :disabled="true"
                                class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                                placeholder="https://www.airbnb.com/rooms/xxxxx or https://www.vrbo.com/xxxxx">
                            <button type="button" class="px-4 py-2 rounded"
                                :class="url ? 'bg-blue-500 text-white cursor-pointer hover:bg-[#29ACD5]' :
                                    'bg-gray-300 text-gray-600 cursor-not-allowed'"
                                :disabled="!url">
                                Apply
                            </button>
                        </div>

                        <p class="text-xs text-gray-600">
                            Example links:<br>
                            https://www.airbnb.com/rooms/xxxxxxx<br>
                            https://www.vrbo.com/xxxxxx
                            <span x-show="selected === 'Multiple' && sameAddress === 'no'"><br><em>Note: You can add multiple property links during the next steps.</em></span>
                        </p>
                        <a href="#" class="text-blue-600 text-sm hover:underline" x-text="selected === 'Multiple' && sameAddress === 'no' ? 'Where can I find these links?' : 'Where can I find this link?'"></a>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between pt-4">
                        <button type="button" @click="selected === 'Multiple' && sameAddress === 'no' ? step = 3 : step = 2"
                            class="wiz-btn-secondary">
                            ←
                        </button>
                        <button type="submit" :disabled="selectedChannels.length === 0"
                            :class="selectedChannels.length === 0 ?
                                'bg-gray-300 text-gray-600 cursor-not-allowed' :
                                'bg-[#3CC0E9] hover:bg-[#29ACD5] text-white cursor-pointer'"
                            class="font-semibold py-3 px-6 rounded transition duration-200">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
            <!--Main Step 4 End-->



        </form>
    </div>
</body>
@endsection
