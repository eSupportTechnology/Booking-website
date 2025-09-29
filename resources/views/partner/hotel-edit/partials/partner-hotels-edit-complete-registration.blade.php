@extends('partner.partner-layout')

@section('title', ' Hotels Complete Registration | ' . config('domains.app_name'))

@section('content')
<section x-data="{ businessType: 'individual' }"  class="w-full px-4 py-8 max-w-2xl mx-auto lg:ml-32">


    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        <!-- <div>
            <h3 class="text-xl font-semibold mb-2">Are you listing property as a business or individual?</h3>
            <p class="text-sm text-gray-600 mb-4">
                Your answer to this question will help us ensure that we include all of the necessary information in your contract.
            </p>

            <div class="space-y-2">
                <label class="flex items-start space-x-2 mb-4 mt-4">
                    <input type="radio" name="type" value="individual" x-model="businessType" class="mt-1">
                    <div>
                        <span class="font-semibold text-sm">Individual</span>
                        <p class="text-sm text-gray-600">
                            An individual or sole proprietor is a person who owns and operates an unincorporated business on their own.
                        </p>
                    </div>
                </label>

                <label class="flex items-start space-x-2 mb-4">
                    <input type="radio" name="type" value="business" x-model="businessType" class="mt-1">
                    <div>
                        <span class="font-semibold text-sm">Business</span>
                        <p class="text-sm text-gray-600">
                            A business entity can be owned by several individuals, such as a partnership, public or private corporation, non-profit organisation, etc.
                        </p>
                    </div>
                </label>
                <hr class="my-6 border-t border-gray-300 mb-4">

                <p class="text-sm text-gray-700 mb-2 mt-4">
                    In case you choose to list more properties in the future, we will use the information below so that you only need to fill it once.
                </p>
            </div>
        </div> -->

        <!-- Business Form -->
        <!-- <template x-if="businessType === 'business'">
            <div>
               <p class="text-lg font-semibold text-gray-700 ">
                    Legal business name
                </p>
                <hr class="mt-4 border-t border-gray-300 mb-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="legal_name">Legal business name <span class="text-red-500">*</span></label>
                        <input type="text" id="legal_name" name="legal_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div> -->


 <!-- <p class="text-lg font-semibold text-gray-700 mb-2">
                 Registered business address
                </p>
                <hr class="mt-2 border-t border-gray-300 mb-4">
                  <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option selected>Sri Lanka</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div><div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City<span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                        <div class="flex-1">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                            <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                    </div>
                </div>

                 <p class="text-lg font-semibold text-gray-700 mb-2 mt-6">
                    Legal representative's personal information
                </p>
     <hr class="mt-2 border-t border-gray-300 mb-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="full_name">First name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle name(s) as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div> -->

                    <!-- Phone Number with Country Flag -->
                    <!-- <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2"> -->
                            <!-- Flag Image -->
                          <!-- <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag"> -->

                            <!-- Country Code Select -->
                         <!-- <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
    <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
    <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
    <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
    <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
</select> -->


                            <!-- Phone Number Input -->
                            <!-- <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
                        </div>
                    </div>
            </div>
        </template> -->

        <!-- Individual Form -->
        <!-- <template x-if="businessType === 'individual'">
            <div >
                <p class="text-lg font-semibold text-gray-700 mb-2">
                    Personal information of the contracting party
                </p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="full_name">First name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle name(s) as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div> -->

                    <!-- Phone Number with Country Flag -->
                    <!-- <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2"> -->
                            <!-- Flag Image -->
                            <!-- <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag"> -->

                            <!-- Country Code Select -->
                            <!-- <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
    <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
    <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
    <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
    <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
</select> -->


                            <!-- Phone Number Input -->
                            <!-- <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
                        </div>
                    </div>
                    <p class="text-lg font-semibold text-gray-700 mb-2">
                  Primary residence of the contracting party
                </p> -->
                  <!-- <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option selected>Sri Lanka</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div><div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City<span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                        <div class="flex-1">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                            <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div> -->
                    <!-- </div>
                </div>
            </div>
        </template> -->



    </div>
    <div class="max-w-3xl mx-auto mt-10 p-4 md:p-6 bg-white rounded-md shadow-sm border">
  <h2 class="text-xl font-semibold text-gray-800 mb-4">
   You’re almost there
  </h2>

   <p class="font-medium text-sm mb-6">To help you start earning, we’ll make your property available for bookings for the next <span class="font-semibold">18 months</span>. This availability can also be adjusted after you open for bookings.</p>

<!-- Heading above the list -->
<p class="text-sm font-medium text-gray-800 mb-4">
  After you finish your registration you’ll be able to:
</p>
<hr class="border-t border-gray-300 mb-4" />
<ul class="space-y-6 text-sm text-gray-700">
  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="text-sm">Manage your property from your dashboard</p>
      </div>
    </div>
  </li>

  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="text-sm">Receive bookings and make money from guests browsing our site</p>
      </div>
    </div>
  </li>

  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="text-sm">
          Stay on top of bookings from all the sites you use by syncing your calendar
        </p>
      </div>
    </div>
  </li>
</ul>




  <div class="mt-6 space-y-4 text-sm text-gray-700">
    <hr class="border-t border-gray-300 mb-4" />
    <label class="flex items-start gap-2">
      <input type="checkbox" class="mt-1 accent-blue-600">
      <span>
        I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. {{ config('domains.domain') }} B.V. reserves the right to verify and investigate any details provided in this registration.
      </span>
    </label>

    <label class="flex items-start gap-2">
      <input type="checkbox" class="mt-1 accent-blue-600">
      <span>
        I have read, accepted, and agreed to the <a href="#" class="text-blue-600 hover:underline">General Delivery Terms</a>.
      </span>
    </label>
  </div>


</div>
<!-- Button Row -->
<div class="mt-6">
  <div class="flex gap-4">
    <!-- Back Button -->
    <button  class="border border-[#3CC0E9]  text-blue-600  font-semibold py-2 px-4 rounded">
        ←
    </button>

    <!-- Open for bookings Button (take remaining space) -->
   <a href="{{ route('open.booking', $property->id) }}"
   class="flex-1 px-6 py-3 bg-[#3CC0E9] text-white text-center font-semibold rounded-md hover:bg-[#29ACD5] transition">
   Open for bookings
</a>

  </div>

  <!-- I'm not ready link -->
  <div class="mt-3 text-center">
    <a href="#" class="text-sky-500 hover:underline text-sm">I'm not ready</a>
  </div>
</div>


</section>
<script>
    const observeFlagDropdowns = () => {
        document.querySelectorAll('.country-select').forEach(select => {
            if (select.dataset.flagAttached) return; // Avoid duplicate listeners

            const wrapper = select.closest('.flex');
            const flag = wrapper?.querySelector('.selected-flag');

            select.addEventListener('change', () => {
                const selectedOption = select.options[select.selectedIndex];
                const newFlag = selectedOption.getAttribute('data-flag');
                if (newFlag && flag) {
                    flag.src = newFlag;
                }
            });

            select.dataset.flagAttached = "true";
        });
    };

    // Initial run
    document.addEventListener('DOMContentLoaded', observeFlagDropdowns);

    // Watch for dynamic DOM changes (e.g., from Alpine x-if)
    const observer = new MutationObserver(() => {
        observeFlagDropdowns();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
</script>
@endsection
