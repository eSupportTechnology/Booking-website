 @extends('partner.partner-layout')

@section('title', 'Create Property - Step 1 | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.success-message')

    <!-- Progress Bar -->
    @include('property.components.progress-bar', ['currentStep' => 1])

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">What type of property do you want to list?</h2>

        <form id="step1Form" class="space-y-6">
            @csrf

            <!-- Property Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Property Category *</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($categories as $category)
                    <div class="border-2 border-gray-200 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition-colors category-option"
                         data-category="{{ $category->id }}">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $category->description ?? 'Property type description' }}</p>
                        </div>
                        <input type="radio" name="category_id" value="{{ $category->id }}" class="hidden">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Subcategory Selection -->
            <div id="subcategorySection" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-4">Property Subcategory *</label>
                <div id="subcategoryOptions" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Subcategories will be loaded here -->
                </div>
            </div>

            <!-- Subtype Selection -->
            <div id="subtypeSection" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-4">Property Subtype</label>
                <div id="subtypeOptions" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Subtypes will be loaded here -->
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryOptions = document.querySelectorAll('.category-option');
    const form = document.getElementById('step1Form');
    const subcategorySection = document.getElementById('subcategorySection');

    const subtypeSection = document.getElementById('subtypeSection');

    // Pre-select category, subcategory, and subtype if in edit mode
    @if(($mode ?? 'create') === 'edit' && $property)
        const propertyCategoryId = {{ $property->category_id ?? 'null' }};
        const propertySubcategoryId = {{ $property->subcategory_id ?? 'null' }};
        const propertySubtypeId = {{ $property->subtype_id ?? 'null' }};

        if (propertyCategoryId) {
            // Select the category
            const categoryOption = document.querySelector(`.category-option[data-category="${propertyCategoryId}"]`);
            if (categoryOption) {
                categoryOption.click();

                // Load and select subcategory if exists
                if (propertySubcategoryId) {
                    setTimeout(() => {
                        loadSubcategories(propertyCategoryId);
                        setTimeout(() => {
                            const subcatOption = document.querySelector(`.subcategory-option[data-subcategory="${propertySubcategoryId}"]`);
                            if (subcatOption) {
                                subcatOption.click();

                                // Load and select subtype if exists
                                if (propertySubtypeId) {
                                    setTimeout(() => {
                                        const subtypeOption = document.querySelector(`input[name="subtype_id"][value="${propertySubtypeId}"]`);
                                        if (subtypeOption) {
                                            subtypeOption.closest('.subtype-option').click();
                                        }
                                    }, 500);
                                }
                            }
                        }, 500);
                    }, 100);
                }
            }
        }
    @endif

    categoryOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            categoryOptions.forEach(opt => opt.classList.remove('border-blue-500', 'bg-blue-50'));

            // Add selected class to clicked option
            this.classList.add('border-blue-500', 'bg-blue-50');

            // Check the radio button
            this.querySelector('input[type="radio"]').checked = true;

            // Load subcategories
            const categoryId = this.dataset.category;
            loadSubcategories(categoryId);
        });
    });

    function loadSubcategories(categoryId) {
        fetch(`/property/subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const subcategoryOptions = document.getElementById('subcategoryOptions');
                subcategoryOptions.innerHTML = '';

                if (data.length > 0) {
                    subcategorySection.classList.remove('hidden');

                    data.forEach(subcategory => {
                        const div = document.createElement('div');
                        div.className = 'border border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors subcategory-option';
                        div.dataset.subcategory = subcategory.id;
                        div.innerHTML = `
                            <h4 class="font-medium">${subcategory.name}</h4>
                            <p class="text-sm text-gray-600">${subcategory.description || ''}</p>
                            <input type="radio" name="subcategory_id" value="${subcategory.id}" class="hidden">
                        `;

                        div.addEventListener('click', function() {
                            document.querySelectorAll('.subcategory-option').forEach(opt =>
                                opt.classList.remove('border-blue-500', 'bg-blue-50'));
                            this.classList.add('border-blue-500', 'bg-blue-50');
                            this.querySelector('input[type="radio"]').checked = true;

                            loadSubtypes(subcategory.id);
                        });

                        subcategoryOptions.appendChild(div);
                    });
                } else {
                    subcategorySection.classList.add('hidden');
                }
            });
    }

    function loadSubtypes(subcategoryId) {
        fetch(`/property/subtypes/${subcategoryId}`)
            .then(response => response.json())
            .then(data => {
                const subtypeOptions = document.getElementById('subtypeOptions');
                subtypeOptions.innerHTML = '';

                if (data.length > 0) {
                    subtypeSection.classList.remove('hidden');

                    data.forEach(subtype => {
                        const div = document.createElement('div');
                        div.className = 'border border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-500 transition-colors subtype-option';
                        div.innerHTML = `
                            <h4 class="font-medium">${subtype.name}</h4>
                            <p class="text-sm text-gray-600">${subtype.description || ''}</p>
                            <input type="radio" name="subtype_id" value="${subtype.id}" class="hidden">
                        `;

                        div.addEventListener('click', function() {
                            document.querySelectorAll('.subtype-option').forEach(opt =>
                                opt.classList.remove('border-blue-500', 'bg-blue-50'));
                            this.classList.add('border-blue-500', 'bg-blue-50');
                            this.querySelector('input[type="radio"]').checked = true;
                        });

                        subtypeOptions.appendChild(div);
                    });
                } else {
                    subtypeSection.classList.add('hidden');
                }
            });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Check if a category is selected
        const selectedCategory = document.querySelector('input[name="category_id"]:checked');
        if (!selectedCategory) {
            alert('Please select a property type');
            return;
        }

        const formData = new FormData(form);

        const saveUrl = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/1" : route("property.create.save", 1) }}';
        const nextUrl = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/2" : route("property.create.step", 2) }}';

        fetch(saveUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response:', data);
            if (data.success) {
                window.location.href = nextUrl;
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting form. Please try again.');
        });
    });
});
</script>
@endsection
