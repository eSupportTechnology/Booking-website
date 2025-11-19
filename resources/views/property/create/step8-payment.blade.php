@extends('partner.partner-layout')

@section('title', 'Create Property - Payment Setup | ' . config('domains.app_name'))

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 8])

    <div x-data="{
        step: 1,
        propertyId: {{ $property->id ?? 'null' }},
        formData: {
            payment_method: 'online',
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
        init() {
            this.loadFormData();
        },
        saveFormData() {
            if (this.propertyId) {
                localStorage.setItem(`payment_form_${this.propertyId}`, JSON.stringify({
                    step: this.step,
                    formData: this.formData
                }));
            }
        },
        loadFormData() {
            if (this.propertyId) {
                const saved = localStorage.getItem(`payment_form_${this.propertyId}`);
                if (saved) {
                    try {
                        const parsedData = JSON.parse(saved);
                        this.step = parsedData.step || 1;
                        this.formData = { ...this.formData, ...parsedData.formData };
                    } catch (e) {
                        console.log('Error loading saved form data:', e);
                    }
                }
            }
        },
        goToStep(stepNumber) {
            this.saveFormData();
            this.step = stepNumber;
        },
        goBack() {
            this.saveFormData();
            this.step--;
        },
        submitStep1() {
            if (!this.propertyId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Property ID is required. Please go back and complete the previous steps first.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            this.saveFormData();

            fetch('/property/create/step/8', {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Payment method saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        this.step++;
                        this.saveFormData();
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving payment method',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving payment method',
                    confirmButtonText: 'OK'
                });
            });
        },
        submitStep2() {
            if (!this.propertyId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Property ID is required.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            this.saveFormData();

            fetch('/property/create/step/8', {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Invoicing information saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        this.step++;
                        this.saveFormData();
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving invoicing data',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving invoicing data',
                    confirmButtonText: 'OK'
                });
            });
        },
        submitStep3() {
            if (!this.propertyId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Property ID is required.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!this.formData.ownership_type) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please select ownership type',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!this.formData.owners || this.formData.owners.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required',
                    text: 'Please add at least one owner',
                    confirmButtonText: 'OK'
                });
                return;
            }

            for (let owner of this.formData.owners) {
                if (!owner.firstName || !owner.lastName || !owner.dob) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required',
                        text: 'Please fill in all owner details',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            this.saveFormData();

            let requestData = {
                property_id: this.propertyId,
                ownership_type: this.formData.ownership_type
            };

            if (this.formData.ownership_type === 'individual') {
                requestData.individuals = this.formData.owners.map(owner => ({
                    first_name: owner.firstName,
                    last_name: owner.lastName,
                    date_of_birth: owner.dob
                }));
            } else if (this.formData.ownership_type === 'business') {
                requestData.ownership_type = 'business_entity';
                requestData.business_entity = {
                    business_name: this.formData.legal_company_name || '',
                    address: this.formData.business_address || '',
                    zip_code: this.formData.business_zip_code || '',
                    city: this.formData.business_city || '',
                    country: this.formData.business_country || ''
                };
                requestData.individuals = this.formData.owners.map(owner => ({
                    first_name: owner.firstName,
                    last_name: owner.lastName,
                    date_of_birth: owner.dob
                }));
            }

            fetch('/property/create/step/8', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Verification information saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.href = '/property/create/step/7';
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error saving verification data',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving verification data',
                    confirmButtonText: 'OK'
                });
            });
        }
    }">
        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 h-2 mb-6">
            <div class="bg-blue-600 h-2 transition-all duration-500" :style="'width:' + (step * 100 / 3) + '%'"></div>
        </div>

        <!-- Step 1: Payment Method -->
        <template x-if="step === 1">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Payments</h2>

                <div class="bg-white p-6 rounded-lg shadow-sm border space-y-3 mb-6">
                    <h3 class="font-semibold text-lg text-gray-900">How can your guests pay for their stay?</h3>

                    <div class="flex flex-col space-y-2 pt-2">
                        <label class="flex items-start space-x-2">
                            <input type="radio" name="payment_method" value="online" x-model="formData.payment_method" @change="saveFormData()" class="form-radio text-blue-600 w-4 h-4 mt-1">
                            <span class="text-sm text-gray-700">
                                Online, when they make a reservation, {{ config('domains.domain') }} will facilitate your guests' payments with the payments by {{ config('domains.app_name') }} service.
                            </span>
                        </label>

                        <div x-show="formData.payment_method === 'online'" class="bg-blue-50 p-4 rounded-lg border border-blue-300 space-y-2 text-sm text-gray-800 ml-4">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Fewer cancellations</li>
                                <li>Fraud and card protection</li>
                                <li>More payment options for your guests</li>
                            </ul>
                        </div>

                        <label class="flex items-start space-x-2">
                            <input type="radio" name="payment_method" value="credit" x-model="formData.payment_method" @change="saveFormData()" class="form-radio text-blue-600 w-4 h-4 mt-1">
                            <span class="text-sm text-gray-700">By credit, at my property</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 mb-6">
                    <h3 class="font-semibold text-lg text-gray-900">How payment by {{ config('domains.domain') }} works</h3>
                    <ul class="list-decimal list-inside text-sm text-gray-700 space-y-2">
                        <li><span class="font-semibold">Your guest pays</span> through {{ config('domains.domain') }} with more options like PayPal, WeChat Pay and AliPay.</li>
                        <li><span class="font-semibold">We facilitate your guest's payment</span> You don't have to deal with fraud, chargebacks or invalid cards.</li>
                        <li><span class="font-semibold">{{ config('domains.domain') }} sends payouts to you.</span> You'll receive a bank transfer by the 15th of each month that covers all bookings with a check-out in the previous month.</li>
                    </ul>
                </div>

                <div class="flex justify-between">
                    <a href="/property/create/step/6" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</a>
                    <button @click="submitStep1()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Continue</button>
                </div>
            </div>
        </template>

        <!-- Step 2: Invoicing -->
        <template x-if="step === 2">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Invoicing</h2>

                <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 mb-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">What name should be on the Invoice?</h3>
                        <div class="space-y-4">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="invoice_name" value="user" x-model="formData.invoice_name" @change="saveFormData()" class="form-radio text-blue-600">
                                <span>{{ auth()->user()->name }}</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="invoice_name" value="property" x-model="formData.invoice_name" @change="saveFormData()" class="form-radio text-blue-600">
                                <span>My Property</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="invoice_name" value="other" x-model="formData.invoice_name" @change="saveFormData()" class="form-radio text-blue-600">
                                <span>Legal company name (please specify)</span>
                            </label>

                            <div x-show="formData.invoice_name === 'other'" class="mt-4 space-y-2">
                                <label class="block font-semibold text-gray-800">Legal company name</label>
                                <input type="text" x-model="formData.legal_company_name" @input="saveFormData()" class="w-full border px-4 py-2 rounded">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button @click="goBack()" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</button>
                    <button @click="submitStep2()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Continue</button>
                </div>
            </div>
        </template>

        <!-- Step 3: Partner Verification -->
        <template x-if="step === 3">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">Partner Verification</h2>

                <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 mb-6">
                    <p class="text-sm text-gray-800">
                        In order to comply with various legal and regulatory requirements, we need to collect and verify some information about you and your property.
                    </p>

                    <div>
                        <label class="block font-semibold text-gray-900 mb-2">
                            Is the accommodation owned by an individual or business entity?
                        </label>
                        <select x-model="formData.ownership_type" @change="saveFormData()" class="w-full p-2 border rounded text-sm focus:ring focus:ring-blue-200">
                            <option value="">Select an option</option>
                            <option value="individual">I am an individual running a business</option>
                            <option value="business">I represent a business entity</option>
                        </select>
                    </div>
                </div>

                <!-- Individual Form -->
                <div x-show="formData.ownership_type === 'individual'" x-transition class="bg-white p-6 rounded-lg border space-y-4 mb-6">
                    <p class="text-sm text-gray-800">
                        Please provide the full names and dates of birth of all individuals who own 25% or more of the accommodation.
                    </p>

                    <template x-for="(owner, index) in formData.owners" :key="index">
                        <div class="border p-4 rounded-lg space-y-4 bg-white">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">First Name</label>
                                <input type="text" x-model="owner.firstName" @input="saveFormData()" placeholder="First Name" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">Last Name</label>
                                <input type="text" x-model="owner.lastName" @input="saveFormData()" placeholder="Last Name" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
                                <input type="date" x-model="owner.dob" @change="saveFormData()" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div x-show="formData.owners.length > 1" class="text-right">
                                <button @click="formData.owners.splice(index, 1); saveFormData()" class="text-red-600 text-sm hover:underline">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div>
                        <button @click="formData.owners.push({ firstName: '', lastName: '', dob: '' }); saveFormData()" type="button" class="text-blue-600 text-sm font-medium hover:underline">
                            + Add another
                        </button>
                    </div>
                </div>

                <!-- Business Form -->
                <div x-show="formData.ownership_type === 'business'" x-transition class="bg-white p-6 rounded-lg border space-y-4 mb-6">
                    <div class="border p-4 rounded-lg space-y-4 bg-white">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600">Full name of business entity</label>
                            <input type="text" x-model="formData.legal_company_name" @input="saveFormData()" placeholder="Business Entity Name" class="w-full p-2 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600">Address of business entity</label>
                            <input type="text" x-model="formData.business_address" @input="saveFormData()" placeholder="Address" class="w-full p-2 border rounded text-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">Zip Code</label>
                                <input type="text" x-model="formData.business_zip_code" @input="saveFormData()" placeholder="Zip Code" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">City</label>
                                <input type="text" x-model="formData.business_city" @input="saveFormData()" placeholder="City" class="w-full p-2 border rounded text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600">Country</label>
                            <select x-model="formData.business_country" @change="saveFormData()" class="w-full p-2 border rounded text-sm">
                                <option value="">Select a country</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Australia">Australia</option>
                            </select>
                        </div>
                    </div>

                    <template x-for="(owner, index) in formData.owners" :key="index">
                        <div class="border p-4 rounded-lg space-y-4 bg-white">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">First Name</label>
                                <input type="text" x-model="owner.firstName" @input="saveFormData()" placeholder="First Name" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600">Last Name</label>
                                <input type="text" x-model="owner.lastName" @input="saveFormData()" placeholder="Last Name" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
                                <input type="date" x-model="owner.dob" @change="saveFormData()" class="w-full p-2 border rounded text-sm">
                            </div>
                            <div x-show="formData.owners.length > 1" class="text-right">
                                <button @click="formData.owners.splice(index, 1); saveFormData()" class="text-red-600 text-sm hover:underline">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div>
                        <button @click="formData.owners.push({ firstName: '', lastName: '', dob: '' }); saveFormData()" type="button" class="text-blue-600 text-sm font-medium hover:underline">
                            + Add another
                        </button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button @click="goBack()" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Back</button>
                    <button @click="submitStep3()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Complete</button>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

