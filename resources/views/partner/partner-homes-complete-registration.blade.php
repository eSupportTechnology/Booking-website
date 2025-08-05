@extends('frontend.partner-layout')

@section('title', 'List Your Property')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section x-data="{ businessType: '{{ $accommodation_type === 'individual' ? 'individual' : 'business_entity' }}' }" x-init="window.businessType = businessType" class="w-full px-4 py-8 max-w-2xl mx-auto lg:ml-32">

  <input type="hidden" id="propertyId" value="{{ $propertyId }}">
  <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
    <div>
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
          <input type="radio" name="type" value="business_entity" x-model="businessType" class="mt-1">
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
    </div>

    <!-- Business Form -->
    <template x-if="businessType === 'business_entity'">
      <div>
        <p class="text-lg font-semibold text-gray-700 ">
          Legal business name
        </p>
        <hr class="mt-4 border-t border-gray-300 mb-4">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1" for="legal_name">Legal business name <span class="text-red-500">*</span></label>
            <input type="text" id="legal_name" name="legal_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
          </div>


          <p class="text-lg font-semibold text-gray-700 mb-2">
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
            <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1 <span class="text-red-500">*</span></label>
            <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2 <span class="text-red-500">*</span></label>
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
          </div>

          <!-- Phone Number with Country Flag -->
          <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
            <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
              <!-- Flag Image -->
              <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag">

              <!-- Country Code Select -->
              <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
                <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
                <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
                <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
              </select>


              <!-- Phone Number Input -->
              <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
            </div>
          </div>
        </div>
    </template>

    <!-- Individual Form -->
    <template x-if="businessType === 'individual'">
      <div>
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
          </div>

          <!-- Phone Number with Country Flag -->
          <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
            <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
              <!-- Flag Image -->
              <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag">

              <!-- Country Code Select -->
              <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
                <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
                <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
                <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
              </select>


              <!-- Phone Number Input -->
              <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
            </div>
          </div>
          <p class="text-lg font-semibold text-gray-700 mb-2">
            Primary residence of the contracting party
          </p>
          <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
            <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
              <option selected>Sri Lanka</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1 <span class="text-red-500">*</span></label>
            <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2 <span class="text-red-500">*</span></label>
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
      </div>
    </template>



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
        <input type="checkbox" class="mt-1 accent-blue-600" id="generalDeliveryTerms1">
        <span>
          I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. {{ config('domains.domain') }} B.V. reserves the right to verify and investigate any details provided in this registration.
        </span>
      </label>

      <label class="flex items-start gap-2">
        <input type="checkbox" class="mt-1 accent-blue-600" id="generalDeliveryTerms2">
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
      <button class="border border-[#3CC0E9]  text-blue-600  font-semibold py-2 px-4 rounded">
        ←
      </button>

      <!-- Open for bookings Button (take remaining space) -->
      <button id="completeRegistrationBtn" disabled class="flex-1 px-6 py-3 bg-[#939393] text-white text-center font-semibold rounded-md hover:cursor-not-allowed transition">
        Open for bookings
      </button>

    </div>

    <!-- I'm not ready link -->
    <div class="mt-3 text-center">
      <a href="#" class="text-sky-500 hover:underline text-sm">I'm not ready</a>
    </div>
  </div>


</section>
<script>
  const generalDeliveryTerms1 = document.getElementById('generalDeliveryTerms1');
  const generalDeliveryTerms2 = document.getElementById('generalDeliveryTerms2');
  const completeRegistrationBtn = document.getElementById('completeRegistrationBtn');

  function toggleButton() {
    if (generalDeliveryTerms1.checked && generalDeliveryTerms2.checked) {
      completeRegistrationBtn.disabled = false;
      completeRegistrationBtn.classList.remove('hover:cursor-not-allowed', 'bg-[#939393]');
      completeRegistrationBtn.classList.add('bg-[#3CC0E9]');
    } else {
      completeRegistrationBtn.disabled = true;
      completeRegistrationBtn.classList.remove('bg-[#3CC0E9]');
      completeRegistrationBtn.classList.add('hover:cursor-not-allowed', 'bg-[#939393]');
    }
  }

  generalDeliveryTerms1.addEventListener('change', toggleButton);
  generalDeliveryTerms2.addEventListener('change', toggleButton);

  const observeFlagDropdowns = () => {
    document.querySelectorAll('.country-select').forEach(select => {
      if (select.dataset.flagAttached) return;

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

  const observer = new MutationObserver(() => {
    observeFlagDropdowns();
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });


  async function submitForm() {
    const businessType = window.businessType;
    const propertyId = parseInt(document.getElementById('propertyId').value);

    if (!propertyId || isNaN(propertyId)) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Property ID'
      });
      return;
    }

    const payload = {
      property_id: propertyId,
      ownership_type: businessType,
    };

    // Validation helpers
    const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const isValidPhone = (phone) => /^[0-9\-\+]{7,15}$/.test(phone);

    if (businessType === 'individual') {
      const first_name = document.querySelector('[name="full_name"]')?.value.trim();
      const middle_name = document.querySelector('[name="middle_name"]')?.value.trim();
      const last_name = document.querySelector('[name="last_name"]')?.value.trim();
      const email = document.querySelector('[name="email"]')?.value.trim();
      const phone = document.querySelector('[name="phone"]')?.value.trim();
      const country = document.querySelector('[name="country"]')?.value.trim();
      const address_line_1 = document.querySelectorAll('[name="middle_name"]')[1]?.value.trim();
      const address_line_2 = document.querySelectorAll('[name="middle_name"]')[2]?.value.trim();
      const city = document.querySelector('[name="city"]')?.value.trim();
      const zip_code = document.querySelector('[name="postcode"]')?.value.trim();

      // Required field validation
      if (!first_name || !last_name || !email || !phone || !country || !address_line_1 || !city || !zip_code) {
        Swal.fire({
          icon: 'error',
          title: 'Please fill all required fields.'
        });
        return;
      }

      if (!isValidEmail(email)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid email address.'
        });
        return;
      }

      if (!isValidPhone(phone)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid phone number.'
        });
        return;
      }

      const individual = {
        first_name,
        middle_name,
        last_name,
        email,
        phone,
        country,
        address_line_1,
        address_line_2,
        city,
        zip_code,
        date_of_birth: '1990-01-01',
        alt_names: []
      };

      payload.individuals = [individual];

    } else if (businessType === 'business_entity') {
      const business_name = document.querySelector('[name="legal_name"]')?.value.trim();
      const address = document.querySelectorAll('[name="middle_name"]')[1]?.value.trim();
      const city = document.querySelector('[name="city"]')?.value.trim();
      const country = document.querySelector('[name="country"]')?.value.trim();
      const zip_code = document.querySelector('[name="postcode"]')?.value.trim();

      if (!business_name || !address || !city || !country || !zip_code) {
        Swal.fire({
          icon: 'error',
          title: 'Please fill all business fields.'
        });
        return;
      }

      const business = {
        business_name,
        address,
        city,
        country,
        zip_code
      };
      payload.business_entity = business;

      const rep_first_name = document.querySelector('[name="full_name"]')?.value.trim();
      const rep_middle_name = document.querySelector('[name="middle_name"]')?.value.trim();
      const rep_last_name = document.querySelector('[name="last_name"]')?.value.trim();
      const rep_email = document.querySelector('[name="email"]')?.value.trim();
      const rep_phone = document.querySelector('[name="phone"]')?.value.trim();

      if (!rep_first_name || !rep_last_name || !rep_email || !rep_phone) {
        Swal.fire({
          icon: 'error',
          title: 'Please fill all representative fields.'
        });
        return;
      }

      if (!isValidEmail(rep_email)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid representative email.'
        });
        return;
      }

      if (!isValidPhone(rep_phone)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid representative phone number.'
        });
        return;
      }

      payload.individuals = [{
        first_name: rep_first_name,
        middle_name: rep_middle_name,
        last_name: rep_last_name,
        email: rep_email,
        phone: rep_phone,
        date_of_birth: '1990-01-01',
        alt_names: []
      }];
    }

    try {
      const response = await fetch('/partner/accommodation/store', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
      });

      const result = await response.json();

      if (response.ok) {
        Swal.fire({
          icon: 'success',
          title: 'Registration completed successfully',
          showConfirmButton: false,
          timer: 3000
        });
        console.log(result);
        setTimeout(() => {
          // window.location.href = `/open-booking/${payload.property_id}`;
    window.location.href = `/partner/list-your-property?property_id=${propertyId}`;

        }, 3000);
      } else {
        console.error('Validation error:', result.errors);
        Swal.fire({
          icon: 'error',
          title: 'Server validation failed.',
          text: JSON.stringify(result.errors)
        });
      }
    } catch (error) {
      console.error('Request failed', error);
      Swal.fire({
        icon: 'error',
        title: 'Network error',
        text: error.message
      });
    }
  }


  document.getElementById('completeRegistrationBtn').addEventListener('click', function() {
    const propertyId = parseInt(document.getElementById('propertyId').value);

    submitForm();
      // fetch(`/properties/${propertyId}/open-for-bookings`, {
      //   method: 'POST',
      //   headers: {
      //     'Content-Type': 'application/json',
      //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // if using Laravel
      //   },
      //   body: JSON.stringify({
      //     open_for_bookings: true
      //   })
      // })
      // .then(response => response.json())
      // .then(data => {
      //   console.log('Booking status updated:', data);

      // })
      // .catch(error => {
      //   console.error('Error updating booking status:', error);
      // });
  });
</script>
@endsection