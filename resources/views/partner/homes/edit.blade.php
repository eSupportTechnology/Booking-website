<x-partner-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6" x-data="{ 
                    currentSection: window.location.hash ? window.location.hash.substring(1) : 'basic-info',
                    sections: ['basic-info', 'rooms', 'images', 'payments'],
                    scrollToSection(section) {
                        this.currentSection = section;
                        window.location.hash = section;
                        document.getElementById(section).scrollIntoView({ behavior: 'smooth' });
                    }
                }">
                    <!-- Navigation Menu -->
                    <div class="fixed right-8 top-1/4 bg-white p-4 rounded-lg shadow-lg">
                        <nav class="space-y-2">
                            <template x-for="section in sections" :key="section">
                                <button 
                                    @click="scrollToSection(section)"
                                    :class="{'bg-primary-600 text-white': currentSection === section,
                                            'hover:bg-gray-100': currentSection !== section}"
                                    class="block w-full px-4 py-2 text-left rounded-md transition-colors"
                                    x-text="section.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())">
                                </button>
                            </template>
                        </nav>
                    </div>

                    <form id="partner-home-form" method="POST" action="{{ route('partner.homes.update', $home) }}" 
                          enctype="multipart/form-data" class="space-y-12" x-data="partnerHomeForm()">
                        @csrf
                        @method('PUT')

                        <!-- Basic Info Section -->
                        <section id="basic-info" class="scroll-mt-16">
                            <h2 class="text-2xl font-semibold mb-6">Basic Information</h2>
                            <!-- Basic info fields will go here -->
                        </section>

                        <!-- Rooms Section -->
                        <section id="rooms" class="scroll-mt-16">
                            <h2 class="text-2xl font-semibold mb-6">Rooms</h2>
                            <!-- Rooms management will go here -->
                        </section>

                        <!-- Images Section -->
                        <section id="images" class="scroll-mt-16">
                            <h2 class="text-2xl font-semibold mb-6">Images</h2>
                            <!-- Image upload and management will go here -->
                        </section>

                        <!-- Payments Section -->
                        <section id="payments" class="scroll-mt-16">
                            <h2 class="text-2xl font-semibold mb-6">Payments</h2>
                            <!-- Payment settings will go here -->
                        </section>

                        <!-- Save Button -->
                        <div class="sticky bottom-0 bg-white p-4 border-t shadow-lg">
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function partnerHomeForm() {
            return {
                init() {
                    // Form initialization logic will go here
                },
                // Additional form methods will be added here
            }
        }
    </script>
    @endpush
</x-partner-layout>