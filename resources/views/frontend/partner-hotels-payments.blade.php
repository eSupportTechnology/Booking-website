<!DOCTYPE html>
<html lang="en" x-data="{ step: 1 }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>9-Step Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
                        @php
                            $host = config('domains.app_name');

                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if ($host == 'BookinTour')
                                <h1>Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
                        </a>
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

    <!-- ✅ Progress Bar (now works correctly) -->
    <div class="w-full bg-gray-200 h-2 ">
        <div class="bg-[#3CC0E9] border-r border-white h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 4) + '%'"></div>
    </div>



    <!-- Step 1 -->
    <template x-if="step === 1">
    <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ paymentMethod: 'credit' }">

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
                        class="form-radio text-sky-600 w-6 h-6 mt-1"
                        value="online"
                        x-model="paymentMethod"
                    />
                    <span class="text-sm text-gray-700">
                        Online, when they make a reservation, {{ config('domains.domain') }} will facilitate your
                        guests’ payments with the payments by {{ config('domains.app_name') }} service.
                    </span>
                </label>


                <!-- Show Only When "Online" is Selected -->
      <div x-show="paymentMethod === 'online'" class="bg-blue-50 p-4 rounded-lg border border-blue-300 space-y-2 text-sm text-gray-800 ml-4">
    <ul class="list-disc list-inside space-y-1">
        <li>Fewer cancellations</li>
        <li>Fraud and card protection</li>
        <li>More payment options for your guests</li>
    </ul>
</div>


                <!-- Credit at Property Option -->
                <label class="flex items-center space-x-2">
                    <input
                        type="radio"
                        name="payment_method"
                        class="form-radio text-sky-600 w-4 h-4"
                        value="credit"
                        x-model="paymentMethod"
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
            <a href="{{ route('partner.hotels.edit') }}">
                <button @click="step--"
                    class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">
                    ←
                </button>
            </a>
            <button @click="step++"
                class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                Continue
            </button>
        </div>
    </div>
</template>


    <!-- Step X - Invoicing -->
    <template x-if="step === 2">
         <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ invoiceName: 'user', sameAddress: 'yes' }">

        <!-- Heading -->
        <h2 class="text-3xl font-bold text-gray-800">Invoicing</h2>

        <!-- Invoicing Options -->
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
            
<!-- Invoice Name Section -->
<div>
    <h3 class="font-semibold text-gray-900 mb-2">What name should be on the Invoice?</h3>
    <div class="space-y-4">
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="user" x-model="invoiceName" class="form-radio text-sky-600">
            <span>Dinidu Dananjaya</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="property" x-model="invoiceName" class="form-radio text-sky-600">
            <span>My Property</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" name="invoice_name" value="other" x-model="invoiceName" class="form-radio text-sky-600">
            <span>Legal company name (please specify)</span>
        </label>

        <!-- Show input field for legal company name if 'other' is selected -->
        <div x-show="invoiceName === 'other'" class="mt-4 space-y-2">
            <label class="block font-semibold text-gray-800">Legal company name</label>
            <input type="text" x-model="legalCompanyName"  class="w-full border px-4 py-2 rounded" />
            <!-- Hidden field to include in form submission -->
            <input type="hidden" name="legal_company_name" :value="legalCompanyName">
        </div>
    </div>
</div>


            <template x-if="invoiceName === 'user' || invoiceName === 'other'">
                <!-- Same Address Section -->
                <div>
                    <hr class="my-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Does this recipient have the same address as your property?</h3>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="same_address" value="yes" x-model="sameAddress" class="form-radio text-sky-600">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="same_address" value="no" x-model="sameAddress" class="form-radio text-sky-600">
                            <span>No</span>
                        </label>
                    </div>

                    <!-- Address Fields if "No" is selected -->
                    <div class="mt-4 space-y-4" x-show="sameAddress === 'no'">
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
            <button @click="step++"
                class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                Continue
            </button>
        </div>

    </div>
    </template>


    <!-- Step X - Partner Verification -->
    <template x-if="step === 3">
        <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ ownershipType: '', owners: [{ firstName: '', lastName: '', dob: '' }] }">

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
                    <select x-model="ownershipType"
                        class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
                        <option value="">Select an option</option>
                        <option value="individual">I am an individual running a business</option>
                        <option value="business">I represent a business entity</option>
                    </select>
                </div>
            </div>

            <!-- Individual Form -->
            <div x-show="ownershipType === 'individual'" x-transition class="bg-white p-6 rounded-lg  space-y-4">

                <p class="text-sm text-gray-800">
                    Please provide the full names and dates of birth of all individuals who own 25% or more of the
                    accommodation.
                </p>

                <!-- Owner Input Blocks -->
                <template x-for="(owner, index) in owners" :key="index">
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

                        <div x-show="owners.length > 1" class="text-right">
                            <button @click="owners.splice(index, 1)" class="text-red-600 text-sm hover:underline">
                                Remove
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Add Another Owner -->
                <div>
                    <button @click="owners.push({ firstName: '', lastName: '', dob: '' })" type="button"
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
            <div x-show="ownershipType === 'business'" x-transition
                class="bg-white p-6 rounded-lg shadow border space-y-4">


                <div class="border p-4 rounded-lg space-y-4 bg-white">

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Full name of business entity</label>
                        <input type="text" x-model="owner.firstName" placeholder="First Name"
                            class="w-full p-2 border rounded text-sm" />
                    </div>

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Address of business entity</label>
                        <input type="text" x-model="owner.address" placeholder="Address"
                            class="w-full p-2 border rounded text-sm" />
                    </div>

                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">Zip Code</label>
                        <input type="text" x-model="owner.zipCode" placeholder="Zip Code"
                            class="w-full p-2 border rounded text-sm" />
                    </div>
                    <div>
                        <label class="block  text-sm font-semibold text-gray-600">City</label>
                        <input type="text" x-model="owner.city" placeholder="City"
                            class="w-full p-2 border rounded text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600">Country</label>
                        <select x-model="owner.country" class="w-full p-2 border rounded text-sm">
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
                <template x-for="(owner, index) in owners" :key="index">
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

                        <div x-show="owners.length > 1" class="text-right">
                            <button @click="owners.splice(index, 1)" class="text-red-600 text-sm hover:underline">
                                Remove
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Add Another Owner -->
                <div>
                    <button @click="owners.push({ firstName: '', lastName: '', dob: '' })" type="button"
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
                <button @click="step++"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                    Continue
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
                <a href="{{ route('partner.hotels.edit') }}">
                    <button @click="step++"
                        class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
                        Continue
                    </button></a>
            </div>

        </div>
    </template>


</body>

</html>
