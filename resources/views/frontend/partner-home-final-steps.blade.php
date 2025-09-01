@extends('frontend.partner-layout')

@section('title', 'Homes Complete Registration')

@section('content')
<!-- Alpine.js for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css" />

<div x-data="{ listingType: 'individual' }" class="max-w-2xl lg:ml-24 p-8 bg-white mt-10 rounded shadow space-y-10">


    <h2 class="text-xl font-semibold text-gray-700">Are you listing the property as a business or an individual?</h2>

    <p class="text-sm text-gray-600 mt-1">
      Your answer to this question will help us make sure we include all the necessary information in your contract.
    </p>

    <!-- Business or Individual Selection -->
    <div class="flex flex-col gap-4">
        <label class="flex items-start gap-3">
            <input type="radio" name="type" value="individual" class="form-radio text-blue-600" x-model="listingType" checked>
            <div>
                <span class="font-semibold">Individual</span>
                <p class="text-sm text-gray-600">An individual or sole proprietor is a person who owns and operates an unincorporated business on their own.</p>
            </div>
        </label>
        <label class="flex items-start gap-3">
            <input type="radio" name="type" value="business" class="form-radio text-blue-600" x-model="listingType">
            <div>
                <span class="font-semibold">Business</span>
                <p class="text-sm text-gray-600">A business entity can be owned by several individuals (e.g. as a partnership, public or private corporation, non-profit organization, etc.)</p>
            </div>
        </label>
    </div>

    <!-- Business Fields -->
    <div x-show="listingType === 'business'" x-cloak class="space-y-4">
        <h3 class="text-lg font-semibold">Legal business name</h3>
        <input type="text" class="w-full border p-2 rounded" placeholder="Legal business name*">

        <h3 class="text-lg font-semibold">Registered business address</h3>
        <select class="w-full border p-2 rounded">
            <option disabled selected>Select your country</option>
            @foreach ([
                'Afghanistan','Albania','Algeria','Australia','Austria','Bangladesh','Belgium','Brazil','Canada',
                'China','Denmark','Egypt','Finland','France','Germany','India','Indonesia','Italy','Japan',
                'Malaysia','Maldives','Nepal','Netherlands','New Zealand','Norway','Pakistan','Philippines',
                'Portugal','Qatar','Russia','Saudi Arabia','Singapore','South Africa','Spain','Sri Lanka','Sweden',
                'Switzerland','Thailand','UAE','UK','USA','Vietnam'
            ] as $country)
                <option>{{ $country }}</option>
            @endforeach
        </select>
        <input type="text" class="w-full border p-2 rounded" placeholder="Registered business address line 1">
        <input type="text" class="w-full border p-2 rounded" placeholder="Registered business address line 2">
        <input type="text" class="w-full border p-2 rounded" placeholder="City*">
        <input type="text" class="w-full border p-2 rounded" placeholder="Zip code">
    </div>

    <!-- Legal Representative (Business Only) -->
    <div x-show="listingType === 'business'" x-cloak class="space-y-4">
        <h3 class="text-lg font-semibold">Legal representative’s personal information</h3>
        <input type="text" class="w-full border p-2 rounded" placeholder="First name as stated on ID">
        <input type="text" class="w-full border p-2 rounded" placeholder="Middle name(s) as stated on ID">
        <input type="text" class="w-full border p-2 rounded" placeholder="Last name as stated on ID">
        <input type="email" class="w-full border p-2 rounded" placeholder="Email*">
        <input id="phone" type="tel" class="w-full border p-2 rounded" placeholder="Phone number*">
    </div>

    <!-- Individual Info -->
    <div x-show="listingType === 'individual'" x-cloak class="space-y-4">
        <h3 class="text-lg font-semibold">Personal information of the contracting party</h3>
        <input type="text" class="w-full border p-2 rounded" placeholder="First name as stated on ID">
        <input type="text" class="w-full border p-2 rounded" placeholder="Middle name(s) as stated on ID">
        <input type="text" class="w-full border p-2 rounded" placeholder="Last name as stated on ID">
        <input type="email" class="w-full border p-2 rounded" placeholder="Email*">
        <input type="tel" id="phoneIndividual" class="w-full border p-2 rounded" placeholder="Phone number*">
    </div>

    <!-- Residence -->
    <!-- Residence (Visible only when 'Individual' is selected) -->
    <div x-show="listingType === 'individual'" x-cloak class="space-y-4">
        <h3 class="text-lg font-semibold">Primary residence of the contracting party</h3>
        <select class="w-full border p-2 rounded">
            <option disabled selected>Select your country</option>
            @foreach ([
                'Afghanistan','Albania','Algeria','Australia','Austria','Bangladesh','Belgium','Brazil','Canada',
                'China','Denmark','Egypt','Finland','France','Germany','India','Indonesia','Italy','Japan',
                'Malaysia','Maldives','Nepal','Netherlands','New Zealand','Norway','Pakistan','Philippines',
                'Portugal','Qatar','Russia','Saudi Arabia','Singapore','South Africa','Spain','Sri Lanka','Sweden',
                'Switzerland','Thailand','UAE','UK','USA','Vietnam'
            ] as $country)
                <option>{{ $country }}</option>
            @endforeach
        </select>
        <input type="text" class="w-full border p-2 rounded" placeholder="Address line 1*">
        <input type="text" class="w-full border p-2 rounded" placeholder="Address line 2">
        <input type="text" class="w-full border p-2 rounded" placeholder="City*">
        <input type="text" class="w-full border p-2 rounded" placeholder="Zip code">
    </div>


    <!-- Host Type -->
    <div class="space-y-4">
        <h3 class="font-semibold text-lg">Are you a professional or private host?</h3>

        <p class="text-sm text-gray-600">
            To comply with consumer authority commitments, we have to collect the following information from partners. This information will allow us to communicate to guests whether the property they're staying at is run by a professional or private host. This label has no relevance in terms of taxes, including VAT and other "indirect taxes," but it's required under EU consumer law.
        </p>

        <p class="text-sm text-gray-600">
            For more information, read this
            <a href="#" class="text-blue-600 underline" target="_blank" rel="noopener noreferrer">article</a>
            in Partner Help.
        </p>

        <h3 class="font-semibold text-lg">Select private or professional.</h3>
        <div class="flex flex-col gap-4">
            <label class="flex items-start gap-3">
                <input type="radio" name="host_type" class="form-radio text-blue-600" checked>
                <div>
                    <span class="font-semibold">Private host</span>
                    <p class="text-sm text-gray-600">
                        A private host is typically a party renting out a property or properties for purposes outside their primary trade, business, or profession (e.g. property rentals are a side activity or only listed occasionally).
                    </p>
                </div>
            </label>
            <label class="flex items-start gap-3">
                <input type="radio" name="host_type" class="form-radio text-blue-600">
                <div>
                    <span class="font-semibold">Professional host</span>
                    <p class="text-sm text-gray-600">
                        A professional host is typically a party renting out a property or properties for purposes relating to their primary trade, business, or profession, or as a significant source of income (e.g. property rentals are your main business activity, you represent a property management company, you have a business name, or you regularly rent out the property over a longer period of time in order to make profit). This list isn't exhaustive, and other factors may be taken into account to determine if you're a professional host.
                    </p>
                </div>
            </label>
        </div>


        <p class="text-sm mt-2 text-blue-600 underline">
            <a href="#" target="_blank" rel="noopener noreferrer">Read more in Partner Help</a>
        </p>
    </div>


        <!-- You’re almost done -->
        <div class="bg-blue-50 p-4 rounded border border-blue-200">
            <h4 class="font-semibold text-blue-700 mb-2">You’re almost done</h4>
            <p class="text-sm text-gray-700">
                To help you start earning, we’ll open your property for bookings for the next <strong>18 months</strong>.
                You can adjust availability after you open for bookings.
            </p>
            <ul class="list-disc list-inside text-sm mt-2 text-gray-700">
                <li>Manage your property from your dashboard</li>
                <li>Get bookings and make money from guests browsing our site</li>
                <li>Sync your calendar with other sites</li>
            </ul>
        </div>


    <!-- Agreements -->
    <div class="space-y-4">
        <label class="flex items-start gap-2">
            <input type="checkbox" class="form-checkbox text-blue-600 mt-1" checked>
            <span>I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. Booking.com B.V. reserves the right to verify and investigate any details provided in this registration.</span>
        </label>
        <label class="flex items-start gap-2">
            <input type="checkbox" class="form-checkbox text-blue-600 mt-1" checked>
            <span>I have read, accepted, and agreed to the <a href="#" class="text-blue-600 underline">General Delivery Terms</a>.</span>
        </label>
    </div>

    <!-- Submit Buttons -->
    <div class="flex flex-col md:flex-row gap-4 mt-6">
        <button class="bg-[#1F8FB2] hover:bg-[#166f8b] text-white px-6 py-3 rounded w-full">
            Complete registration and open for bookings
        </button>
        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded w-full">
            Complete registration and open later
        </button>
    </div>
</div>

<!-- intl-tel-input JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputs = [document.querySelector("#phone"), document.querySelector("#phoneIndividual")];
        inputs.forEach(input => {
            if (input) {
                window.intlTelInput(input, {
                    initialCountry: "lk", // Default Sri Lanka
                    separateDialCode: true,
                    preferredCountries: ["lk", "us", "gb", "in"],
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
                });
            }
        });
    });
</script>
@endsection
