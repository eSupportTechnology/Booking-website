@extends('frontend.master')

@section('title', 'Car Rental Registration | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            Register Your Account
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            List your vehicles and start earning with {{ config('domains.domain') }}
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-xl mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            <h2 class="text-xl font-semibold mb-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Register Your Account
            </h2>

            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
                    <ul class="mb-0 pl-4 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Toggle -->
            <div class="flex justify-center items-center space-x-6 mb-8">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="reg_type" value="company" checked class="text-[#1F8FB2] focus:ring-[#1F8FB2]" />
                    <span class="text-gray-800 text-sm font-medium">Company Registration</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="reg_type" value="individual" class="text-[#1F8FB2] focus:ring-[#1F8FB2]" />
                    <span class="text-gray-800 text-sm font-medium">Individual Registration</span>
                </label>
            </div>

            <!-- Company Registration Form -->
            <form id="company-form" action="{{ route('car_renter.register.company.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <h3 class="text-base font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Company Registration</h3>
                <p class="text-sm text-gray-600 mb-4" style="font-family: 'Noto Sans', sans-serif;">Please provide your company details to register.</p>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-800">Company Logo <span class="text-red-500">*</span></label>
                    <input type="file" id="logo" name="logo" accept="image/png, image/jpeg" class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg px-3 py-2" />
                    <p class="text-xs text-gray-500 mt-1">Upload PNG or JPG format only.</p>
                </div>

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-800">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" id="company_name" name="company_name" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="business_reg" class="block text-sm font-medium text-gray-800">Business Registration Number <span class="text-red-500">*</span></label>
                    <input type="text" id="business_reg" name="business_reg" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="tin_no" class="block text-sm font-medium text-gray-800">Tin Number</label>
                    <input type="text" id="tin_no" name="tin_no" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="company_email" class="block text-sm font-medium text-gray-800">Company Email <span class="text-red-500">*</span></label>
                    <input type="email" id="company_email" name="company_email" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
                    <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 space-x-2">
                        <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag" class="w-6 h-4 rounded" />
                        <select id="country-select" class="bg-white border border-gray-300 rounded-md px-2 py-1">
                            <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
                            <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
                            <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
                            <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
                        </select>
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required class="flex-1 outline-none border-none py-1" />
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-800">Company Address <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" rows="2" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent"></textarea>
                </div>

                <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color:#1F8FB2;">
                    Register Company
                </button>
            </form>

            <!-- Individual Registration Form -->
            <form id="individual-form" action="{{ route('car_renter.register.individual.store') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <h3 class="text-base font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Individual Registration</h3>
                <p class="text-sm text-gray-600 mb-4" style="font-family: 'Noto Sans', sans-serif;">Please provide your details to register as an individual.</p>

                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-800">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="full_name" name="full_name" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="individual_email" class="block text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="individual_email" name="individual_email" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="individual_phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number 1 <span class="text-red-500">*</span></label>
                    <input type="tel" id="individual_phone" name="individual_phone" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="individual_phone2" class="block text-sm font-medium text-gray-800 mb-1">Phone number 2</label>
                    <input type="tel" id="individual_phone2" name="individual_phone2" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="individual_nic" class="block text-sm font-medium text-gray-800 mb-1">NIC Number <span class="text-red-500">*</span></label>
                    <input type="text" id="individual_nic" name="individual_nic" required class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent" />
                </div>

                <div>
                    <label for="individual_address" class="block text-sm font-medium text-gray-800">Address <span class="text-red-500">*</span></label>
                    <textarea id="individual_address" name="individual_address" rows="2" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-3 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent"></textarea>
                </div>

                <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color:#1F8FB2;">
                    Register Individual
                </button>
            </form>

            <div class="border-t border-gray-200 my-6"></div>

            <div class="mt-4">
                <a href="{{ route('carrentals.login.email') }}"
                   class="block text-center border-2 border-[#1F8FB2] text-[#1F8FB2] hover:bg-[#1F8FB2] hover:text-white rounded-lg py-3 text-sm font-semibold transition"
                   style="font-family: 'Noto Sans', sans-serif;">
                    Already have an account? Sign in
                </a>
            </div>

            <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
                By creating an account, you agree with our
                <a href="#" class="text-[#1F8FB2] hover:underline">Terms & conditions</a> and
                <a href="#" class="text-[#1F8FB2] hover:underline">Privacy statement</a>.
            </p>

            <p class="text-[11px] text-gray-400 text-center mt-2" style="font-family: 'Noto Sans', sans-serif;">
                {{ config('domains.domain') }}
            </p>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
            <!-- Card 1 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        List your vehicles
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        Reach travelers looking for rentals
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#3CC0E9] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        Earn more revenue
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        Competitive rates and low commission
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        24/7 Support
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        We're always here to help you succeed
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const regTypeRadios = document.querySelectorAll("input[name='reg_type']");
    const companyForm = document.getElementById("company-form");
    const individualForm = document.getElementById("individual-form");

    regTypeRadios.forEach(radio => {
        radio.addEventListener("change", () => {
            if (radio.value === "company") {
                companyForm.classList.remove("hidden");
                individualForm.classList.add("hidden");
            } else {
                individualForm.classList.remove("hidden");
                companyForm.classList.add("hidden");
            }
        });
    });

    const countrySelect = document.getElementById('country-select');
    const selectedFlag = document.getElementById('selected-flag');
    if (countrySelect && selectedFlag) {
        countrySelect.addEventListener('change', () => {
            const flagUrl = countrySelect.options[countrySelect.selectedIndex].getAttribute('data-flag');
            if (flagUrl) selectedFlag.src = flagUrl;
        });
    }
});
</script>

@endsection
