<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>10 Step Wizard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-3xl mx-auto p-4" x-data="{ step: 1 }">
  <form method="POST" action="{{ route('your-backend-route') }}" class="bg-white p-6 rounded-lg shadow-md space-y-6">
    @csrf

    <!-- Progress bar -->
    <div class="flex justify-between mb-6 text-sm font-medium">
      <template x-for="n in 10">
        <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
          Step <span x-text="n"></span>
        </div>
      </template>
    </div>

    <!-- Step 1 -->
    <div x-show="step === 1" x-cloak>
      <label class="block mb-2">Full Name</label>
      <input type="text" name="full_name" class="w-full border p-2 rounded" placeholder="Enter your full name">
    </div>

    <!-- Step 2 -->
    <div x-show="step === 2" x-cloak>
      <label class="block mb-2">Email Address</label>
      <input type="email" name="email" class="w-full border p-2 rounded" placeholder="Enter your email">
    </div>

    <!-- Step 3 -->
    <div x-show="step === 3" x-cloak>
      <label class="block mb-2">Phone Number</label>
      <input type="text" name="phone" class="w-full border p-2 rounded" placeholder="Enter your phone number">
    </div>

    <!-- Step 4 -->
    <div x-show="step === 4" x-cloak>
      <label class="block mb-2">Address</label>
      <input type="text" name="address" class="w-full border p-2 rounded" placeholder="Enter your address">
    </div>

    <!-- Step 5 -->
    <div x-show="step === 5" x-cloak>
      <label class="block mb-2">Date of Birth</label>
      <input type="date" name="dob" class="w-full border p-2 rounded">
    </div>

    <!-- Step 6 -->
    <div x-show="step === 6" x-cloak>
      <label class="block mb-2">Gender</label>
      <select name="gender" class="w-full border p-2 rounded">
        <option value="">Select</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>
    </div>

    <!-- Step 7 -->
    <div x-show="step === 7" x-cloak>
      <label class="block mb-2">Education Level</label>
      <input type="text" name="education" class="w-full border p-2 rounded" placeholder="Enter your highest education level">
    </div>

    <!-- Step 8 -->
    <div x-show="step === 8" x-cloak>
      <label class="block mb-2">Skills</label>
      <textarea name="skills" rows="3" class="w-full border p-2 rounded" placeholder="List your skills"></textarea>
    </div>

    <!-- Step 9 -->
    <div x-show="step === 9" x-cloak>
      <label class="block mb-2">Upload Resume</label>
      <input type="file" name="resume" class="w-full border p-2 rounded">
    </div>

    <!-- Step 10 -->
    <div x-show="step === 10" x-cloak>
      <label class="block mb-2">Comments</label>
      <textarea name="comments" rows="4" class="w-full border p-2 rounded" placeholder="Additional comments..."></textarea>
    </div>

    <!-- Buttons -->
    <div class="flex justify-between pt-4">
      <button type="button"
              x-show="step > 1"
              @click="step--"
              class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
        Back
      </button>

      <template x-if="step < 10">
        <button type="button"
                @click="step++"
                class="ml-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          Next
        </button>
      </template>

      <template x-if="step === 10">
        <button type="submit"
                class="ml-auto px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          Submit
        </button>
      </template>
    </div>
  </form>
</div>

</body>
</html>
