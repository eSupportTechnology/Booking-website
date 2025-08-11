@extends('partner.partner-layout')

@section('title', ' Hotels Payments | ' . config('domains.app_name'))

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
   
    <div  x-data="{ 
        step: 1,
        propertyId: {{ $propertyModel ? $propertyModel->id : 'null' }},
        showToast: false,
        toastMessage: '',
        toastType: 'success',
        formData: {
            payment_method: 'credit',
            invoice_name: 'user',
            same_address: 'yes',
            legal_company_name: '',
            ownership_type: '',
            owners: [{ firstName: '', lastName: '', dob: '' }],
            business_address: '',
            business_zip_code: '',
            business_city: '',
            business_country: ''
        },
        
        showToastMessage(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.showToast = true;
            
            // Auto-hide toast after 3 seconds
            setTimeout(() => {
                this.showToast = false;
            }, 3000);
        },
        
        submitStep1() {
            console.log('Property ID in submitStep1:', this.propertyId);
            
            if (!this.propertyId) {
                this.showToastMessage('Property ID is required. Please go back and complete the previous steps first.', 'error');
                return;
            }

            fetch('/partner/property/save-payment-step/' + this.propertyId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_method: this.formData.payment_method
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showToastMessage('Payment method saved successfully! Moving to next step...', 'success');
                    setTimeout(() => {
                        this.step++;
                    }, 1000);
                } else {
                    this.showToastMessage('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToastMessage('An error occurred while saving payment method', 'error');
            });
        },

        submitStep2() {
            if (!this.propertyId) {
                this.showToastMessage('Property ID is required. Please go back and complete the previous steps first.', 'error');
                return;
            }

            fetch('/partner/property/save-invoicing/' + this.propertyId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    invoice_name: this.formData.invoice_name,
                    same_address: this.formData.same_address,
                    legal_company_name: this.formData.legal_company_name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showToastMessage('Invoicing information saved successfully! Moving to next step...', 'success');
                    setTimeout(() => {
                        this.step++;
                    }, 1000);
                } else {
                    this.showToastMessage('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToastMessage('An error occurred while saving invoicing data', 'error');
            });
        },

        submitStep3() {
            if (!this.propertyId) {
                this.showToastMessage('Property ID is required. Please go back and complete the previous steps first.', 'error');
                return;
            }

            if (!this.formData.ownership_type) {
                this.showToastMessage('Please select ownership type', 'error');
                return;
            }

            if (!this.formData.owners || this.formData.owners.length === 0) {
                this.showToastMessage('Please add at least one owner', 'error');
                return;
            }

            for (let owner of this.formData.owners) {
                if (!owner.firstName || !owner.lastName || !owner.dob) {
                    this.showToastMessage('Please fill in all owner details (First Name, Last Name, Date of Birth)', 'error');
                    return;
                }
            }

            fetch('/partner/property/save-verification/' + this.propertyId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    ownership_type: this.formData.ownership_type,
                    owners: this.formData.owners,
                    legal_company_name: this.formData.legal_company_name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showToastMessage('Verification information saved successfully! Moving to next step...', 'success');
                    setTimeout(() => {
                        this.step++;
                    }, 1000);
                } else {
                    this.showToastMessage('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToastMessage('An error occurred while saving verification data', 'error');
            });
        },

        completePaymentProcess() {
            if (!this.propertyId) {
                this.showToastMessage('Property ID is required. Please go back and complete the previous steps first.', 'error');
                return;
            }

            // Submit final completion data via PATCH request
            fetch('/partner/property/complete-payment/' + this.propertyId, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({
                    property_id: this.propertyId,
                    status: 'completed'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.showToastMessage('Payment process completed successfully! Redirecting...', 'success');
                    // Redirect to a GET route after successful completion
                    setTimeout(() => {
                        window.location.href = '/partner/properties'; // or another appropriate GET route
                    }, 2000);
                } else {
                    this.showToastMessage('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToastMessage('An error occurred while completing the payment process', 'error');
            });
        },
    }">
    <!-- Toast Container -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-4 right-4 z-50 max-w-sm w-full">
        <div :class="{
            'bg-green-500': toastType === 'success',
            'bg-red-500': toastType === 'error',
            'bg-blue-500': toastType === 'info'
        }" class="rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg x-show="toastType === 'success'" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <svg x-show="toastType === 'error'" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <svg x-show="toastType === 'info'" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span x-text="toastMessage" class="text-sm font-medium"></span>
                </div>
                <button @click="showToast = false" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Debug info -->
    <script>
        console.log('Property ID from backend:', {{ $propertyModel ? $propertyModel->id : 'null' }});
        console.log('Property model:', @json($propertyModel));
    </script>
    <!-- ✅ Progress Bar (now works correctly) -->
    <div class="w-full bg-gray-200 h-2 ">
        <div class="bg-[#3CC0E9] border-r border-white h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 4) + '%'"></div>
    </div>

    <!-- Debug Property ID Display -->
    <div class="px-4 py-2 bg-yellow-100 border border-yellow-300 rounded mb-4" x-show="propertyId">
        <p class="text-sm text-yellow-800">
            <strong>Debug:</strong> Property ID: <span x-text="propertyId"></span>
        </p>
    </div>

    <!-- No Property ID Warning -->
    <div class="px-4 py-2 bg-red-100 border border-red-300 rounded mb-4" x-show="!propertyId">
        <p class="text-sm text-red-800">
            <strong>Warning:</strong> No Property ID found. Please go back and complete the previous steps first.
        </p>
        <a href="{{ route('partner.property.category') }}" class="text-blue-600 hover:underline text-sm">
            ← Go back to property creation
        </a>
    </div>



    <!-- Step 1 -->
<template x-if="step === 1">
    <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

        <!-- Title -->
        <h2 class="text-3xl font-bold text-gray-800">Payments</h2>

        <!-- Guest Payment Options -->
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-3">
            <h3 class="font-semibold text-lg text-gray-900">How can your guests pay for their stay?</h3>

            <div class="flex flex-col space-y-2 pt-2">
                <!-- Online Payment Option -->
                <label class="flex items-start space-x-2">
                    <input
                        type="radio"
                        name="payment_method"
                        class="form-radio text-sky-600 w-4 h-4 mt-1"
                        value="online"
                        x-model="formData.payment_method"
                    />
                    <span class="text-sm text-gray-700">
                        Online, when they make a reservation, {{ config('domains.domain') }} will facilitate your
                        guests’ payments with the payments by {{ config('domains.app_name') }} service.
                    </span>
                </label>

                <!-- Show Only When "Online" is Selected -->
                <div x-show="formData.payment_method === 'online'" class="bg-blue-50 p-4 rounded-lg border border-blue-300 space-y-2 text-sm text-gray-800 ml-4">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Fewer cancellations</li>
                        <li>Fraud and card protection</li>
                        <li>More payment options for your guests</li>
                    </ul>
                </div>

                <!-- Credit at Property Option -->
                <label class="flex items-start space-x-2">
                    <input
                        type="radio"
                        name="payment_method"
                        class="form-radio text-sky-600 w-4 h-4 mt-1"
                        value="credit"
                        x-model="formData.payment_method"
                        checked
                    />
                    <span class="text-sm text-gray-700">By credit, at my property</span>
                </label>
            </div>
        </div>

        <!-- Info on how Bookintour.com handles payment -->
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4">
            <h3 class="font-semibold text-lg text-gray-900">How payment by {{ config('domains.domain') }} works</h3>
            <ul class="list-decimal list-inside text-sm text-gray-700 space-y-2">
                <li>
                    <span class="font-sm font-semibold">Your guest pays</span> through
                    {{ config('domains.domain') }} with more options like PayPal, WeChat Pay and AliPay.
                </li>
                <li>
                    <span class="font-sm font-semibold">We facilitate your guest’s payment</span> You don’t have to
                    deal with fraud, chargebacks or invalid cards.
                </li>
                <li>
                    <span class="font-sm font-semibold">{{ config('domains.domain') }} sends payouts to you.</span>
                    You’ll receive a bank transfer by the 15th of each month that covers all bookings with a
                    check-out in the previous month.
                </li>
            </ul>
        </div>

        <!-- Continue Button -->
        <div class="flex justify-between items-center pt-4">
            <button @click="step--"
                class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">
                ←
            </button>
            <button @click="submitStep1()"
                class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                Continue
            </button>
        </div>
    </div>
</template>


    <!-- Step X - Invoicing -->
    <template x-if="step === 2">
         <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

        <!-- Heading -->
        <h2 class="text-3xl font-bold text-gray-800">Invoicing</h2>

        <!-- Invoicing Options -->
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
            
<!-- Invoice Name Section -->
<div>
    <h3 class="font-semibold text-gray-900 mb-2">What name should be on the Invoice?</h3>
    <div class="space-y-4">
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="user" x-model="formData.invoice_name" class="form-radio text-sky-600">
            <span>Dinidu Dananjaya</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="property" x-model="formData.invoice_name" class="form-radio text-sky-600">
            <span>My Property</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="other" x-model="formData.invoice_name" class="form-radio text-sky-600">
            <span>Legal company name (please specify)</span>
        </label>

        <!-- Show input field for legal company name if 'other' is selected -->
        <div x-show="formData.invoice_name === 'other'" class="mt-4 space-y-2">
            <label class="block font-semibold text-gray-800">Legal company name</label>
            <input type="text" x-model="formData.legal_company_name"  class="w-full border px-4 py-2 rounded" />
            <!-- Hidden field to include in form submission -->
            <input type="hidden" name="legal_company_name" :value="formData.legal_company_name">
        </div>
    </div>
</div>


            <template x-if="formData.invoice_name === 'user' || formData.invoice_name === 'other'">
                <!-- Same Address Section -->
                <div>
                    <hr class="my-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Does this recipient have the same address as your property?</h3>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="same_address" value="yes" x-model="formData.same_address" class="form-radio text-sky-600">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="same_address" value="no" x-model="formData.same_address" class="form-radio text-sky-600">
                            <span>No</span>
                        </label>
                    </div>

                    <!-- Address Fields if "No" is selected -->
                    <div class="mt-4 space-y-4" x-show="formData.same_address === 'no'">
                        <p class="font-medium text-gray-800 mb-1">Please provide invoice recipient’s address</p>
    <!-- Country/region (disabled, from backend later) -->
    <div>
        <label class="block font-medium text-gray-800 mb-1">Country/region</label>
        <input type="text" value="Sri Lanka" disabled
            class="w-full border px-4 py-2 rounded bg-gray-100 text-gray-500 cursor-not-allowed" />
    </div>

    <!-- Street Address -->
    <div>
        <label class="block font-medium text-gray-800 mb-1">Street Address</label>
        <input type="text" placeholder="Street Address" class="w-full border px-4 py-2 rounded" />
    </div>

    <!-- City -->
    <div>
        <label class="block font-medium text-gray-800 mb-1">City</label>
        <input type="text" placeholder="City" class="w-full border px-4 py-2 rounded" />
    </div>

    <!-- Address line 1 -->
    <div>
        <label class="block font-medium text-gray-800 mb-1">Address line 1</label>
        <input type="text" placeholder="Address line 1" class="w-full border px-4 py-2 rounded" />
    </div>

    <!-- Postcode -->
    <div>
        <label class="block font-medium text-gray-800 mb-1">Postcode</label>
        <input type="text" placeholder="Postcode" class="w-full border px-4 py-2 rounded" />
    </div>
</div>

                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-4">
            <button @click="step--"
                class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">
                ←
            </button>
            <button @click="submitStep2()"
                class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                Continue
            </button>
        </div>

    </div>
    </template>


    <!-- Step X - Partner Verification -->
    <template x-if="step === 3">
        <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

            <h2 class="text-3xl font-bold text-gray-800">Partner verification</h2>

            <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
                <p class="text-sm text-gray-800">
                    In order to comply with various legal and regulatory requirements, we need to collect and verify
                    some information about you and your property.
                </p>

                <div>
                    <label class="block font-semibold text-gray-900 mb-2">
                        Is the accommodation owned by an individual or business entity?
                    </label>
                    <select x-model="formData.ownership_type"
                        class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
                        <option value="">Select an option</option>
                        <option value="individual">I am an individual running a business</option>
                        <option value="business">I represent a business entity</option>
                    </select>
                </div>
            </div>

            <!-- Individual Form -->
            <div x-show="formData.ownership_type === 'individual'" x-transition class="bg-white p-6 rounded-lg  space-y-4">

                <p class="text-sm text-gray-800">
                    Please provide the full names and dates of birth of all individuals who own 25% or more of the
                    accommodation.
                </p>

                <!-- Owner Input Blocks -->
                <template x-for="(owner, index) in formData.owners" :key="index">
                    <div class="border p-4 rounded-lg space-y-4 bg-white">
                        <div>
                            <label class="block  text-sm font-semibold text-gray-600">First Name</label>
                            <input type="text" x-model="owner.firstName" placeholder="First Name"
                                class="w-full p-2 border rounded text-sm" />
                        </div>

                        <div>
                            <label class="block  text-sm font-semibold text-gray-600">Last Name</label>
                            <input type="text" x-model="owner.lastName" placeholder="Last Name"
                                class="w-full p-2 border rounded text-sm" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
                            <input type="date" x-model="owner.dob"
                                class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
                        </div>

                        <div x-show="formData.owners.length > 1" class="text-right">
                            <button @click="formData.owners.splice(index, 1)" class="text-red-600 text-sm hover:underline">
                                Remove
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Add Another Owner -->
                <div>
                    <button @click="formData.owners.push({ firstName: '', lastName: '', dob: '' })" type="button"
                        class="text-sky-600 text-sm font-medium hover:underline mt-2">
                        + Add another
                    </button>
                </div>
                <!-- Single Optional Field Outside Loop -->
                <div>
                    <label class="block font-semibold text-sm text-gray-600">
                        If any owners go by an alternative name or names, please provide those details.
                        <span class="text-gray-500">- (Optional)</span>
                    </label>
                    <input type="text" class="w-full p-2 border rounded text-sm" />
                </div>


            </div>

            <!-- Business Form -->
            <div x-show="formData.ownership_type === 'business'" x-transition
                class="bg-white p-6 rounded-lg shadow border space-y-4">


                <div class="border p-4 rounded-lg space-y-4 bg-white">

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Full name of business entity</label>
                        <input type="text" x-model="formData.legal_company_name" placeholder="Business Entity Name"
                            class="w-full p-2 border rounded text-sm" />
                    </div>

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Address of business entity</label>
                        <input type="text" x-model="formData.business_address" placeholder="Address"
                            class="w-full p-2 border rounded text-sm" />
                    </div>

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Zip Code</label>
                        <input type="text" x-model="formData.business_zip_code" placeholder="Zip Code"
                            class="w-full p-2 border rounded text-sm" />
                    </div>
                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">City</label>
                        <input type="text" x-model="formData.business_city" placeholder="City"
                            class="w-full p-2 border rounded text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600">Country</label>
                        <select x-model="formData.business_country" class="w-full p-2 border rounded text-sm">
                            <option value="">Select a country</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="India">India</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Australia">Australia</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>



                    <div>
                        <label class="block font-semibold text-sm text-gray-600">
                            If the company operates under a different name (e.g. "trading as" name) in relation to the
                            accommodation, please provide those details.
                            <span class="text-gray-500">- (Optional)</span>
                        </label>
                        <input type="text" class="w-full p-2 border rounded text-sm" />
                    </div>



                </div>
                <p class="text-sm text-gray-800">
                    Please provide the full names and dates of birth of all individuals who own 25% or more of the
                    accommodation.
                </p>
                <!-- Owner Input Blocks -->
                <template x-for="(owner, index) in formData.owners" :key="index">
                    <div class="border p-4 rounded-lg space-y-4 bg-white">
                        <div>
                            <label class="block  text-sm font-semibold text-gray-600">First Name</label>
                            <input type="text" x-model="owner.firstName" placeholder="First Name"
                                class="w-full p-2 border rounded text-sm" />
                        </div>

                        <div>
                            <label class="block  text-sm font-semibold text-gray-600">Last Name</label>
                            <input type="text" x-model="owner.lastName" placeholder="Last Name"
                                class="w-full p-2 border rounded text-sm" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
                            <input type="date" x-model="owner.dob"
                                class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
                        </div>

                        <div x-show="formData.owners.length > 1" class="text-right">
                            <button @click="formData.owners.splice(index, 1)" class="text-red-600 text-sm hover:underline">
                                Remove
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Add Another Owner -->
                <div>
                    <button @click="formData.owners.push({ firstName: '', lastName: '', dob: '' })" type="button"
                        class="text-sky-600 text-sm font-medium hover:underline mt-2">
                        + Add another
                    </button>
                </div>
                <!-- Single Optional Field Outside Loop -->
                <div>
                    <label class="block font-semibold text-sm text-gray-600">
                        If any owners go by an alternative name or names, please provide those details.
                        <span class="text-gray-500">- (Optional)</span>
                    </label>
                    <input type="text" class="w-full p-2 border rounded text-sm" />
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between pt-4">
                <button @click="step--"
                    class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">

                    ←
                </button>
                <button @click="completePaymentProcess()"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                    Complete
                </button>
            </div>
        </div>
    </template>


    <!-- Step 4 -->
    <template x-if="step === 4">
        <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

            <!-- Header -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 leading-relaxed">
                Some important information before <br class="hidden sm:block" />
                you list your hotel on <br>{{ config('domains.domain') }}</span>
            </h2>

            <div class="bg-white shadow-md rounded-lg border border-gray-200 p-6 space-y-4">
                <!-- Item 1 -->
                <div class="flex items-start space-x-3">
                    <!-- Your SVG Icon -->
                    <img src="{{ asset('assets/Group (14).svg') }}" alt="Tick" class="w-5 h-5 mt-1" />

                    <!-- Text Content -->
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Are bookings confirmed straight away?</h3>
                        <p class="text-sm text-gray-600">Yes. They’re confirmed as soon as a guest makes a booking.</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start space-x-3">
                    <img src="{{ asset('assets/Group (14).svg') }}" alt="Tick" class="w-5 h-5 mt-1" />

                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Can I choose who stays at my place?</h3>
                        <p class="text-sm text-gray-600">No. If a date is open in your calendar, all guests using our
                            site can book it.</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start space-x-3">
                    <img src="{{ asset('assets/Group (14).svg') }}" alt="Tick" class="w-5 h-5 mt-1" />

                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">Can I decide when I get bookings?</h3>
                        <p class="text-sm text-gray-600">
                            Yes. The best way to do this is to keep your calendar up-to-date. Close any dates you don’t
                            want a booking on. If you have bookings on other sites, close these dates as well.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center">
                <button @click="step--"
                    class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">

                    ←
                </button>
                <button @click="submitStep3()"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                    Continue
                </button>
            </div>

        </div>
    </template>


</div>



@endsection