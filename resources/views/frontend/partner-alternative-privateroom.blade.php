<div x-data="wizardForm()" class=" mt-16 px-4 ">

    <!-- Step 0: Category Selection -->
    <template x-if="step === 0">
        <div>
            <h2 class="text-2xl font-bold mb-4">From the list below, which property category is most similar to your place?</h2>
 <div class="max-w-4x   sm:px-6 lg:ml-32">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-4xl">
                <template x-for="option in ['campsite', 'hotel', 'homestay']" :key="option">
                    <div
                        @click="selectCategory(option)"
                        :class="category === option ? 'border-blue-600 border-2 bg-blue-50' : 'border border-gray-300'"
                        class="relative cursor-pointer p-4 rounded-lg text-center transition duration-200 hover:border-blue-400"
                    >
                        <span class="capitalize text-lg font-semibold" x-text="option"></span>
                        <template x-if="category === option">
                            <span class="absolute top-2 right-2 text-green-600">
                                <i data-feather="check-circle"></i>
                            </span>
                        </template>
                    </div>
                </template>
            </div>

            <div class="mt-6">
                <button
                    @click="continueWizard"
                    :disabled="!category"
                    class="w-full py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 disabled:bg-gray-400"
                >
                    Continue
                </button>
            </div>
        </div>
    </template>

    <!-- Steps 1 & 2 -->
    <template x-if="step > 0">
        <div>
            <p class="capitalize text-gray-600 font-medium mb-2" x-text="category.charAt(0).toUpperCase() + category.slice(1) + ' - Step ' + step + '/2'"></p>

            <!-- Step 1 content -->
            <template x-if="step === 1">
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-gray-700">Name</span>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter name">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Email</span>
                        <input type="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter email">
                    </label>
                </div>
            </template>

            <!-- Step 2 content -->
            <template x-if="step === 2">
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-gray-700">Location</span>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Enter location">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">Description</span>
                        <textarea class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4" placeholder="Describe..."></textarea>
                    </label>
                </div>
            </template>

            <!-- Navigation buttons -->
            <div class="mt-6 flex justify-between">
                <button
                    @click="previousStep"
                    :disabled="step === 1"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 disabled:opacity-50"
                >
                    Back
                </button>

                <template x-if="step < 2">
                    <button
                        @click="nextStep"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    >
                        Next
                    </button>
                </template>

                <template x-if="step === 2">
                    <button
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                    >
                        Submit
                    </button>
                </template>
            </div>
        </div>
    </template>
</div>