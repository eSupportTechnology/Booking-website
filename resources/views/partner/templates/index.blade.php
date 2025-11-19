@extends('partner.partner-layout')

@section('title', 'Property Templates | ' . config('domains.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Property Templates</h1>
        <button onclick="showSaveTemplateModal()" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            Save Current Property as Template
        </button>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($templates as $template)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ $template['title'] }}</h3>
                    <span class="text-sm text-gray-500">{{ $template['category'] }}</span>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex justify-between">
                        <span>Adult Price:</span>
                        <span class="font-medium">${{ number_format($template['adult_price'], 2) }}</span>
                    </div>
                    @if($template['child_price'] > 0)
                    <div class="flex justify-between">
                        <span>Child Price:</span>
                        <span class="font-medium">${{ number_format($template['child_price'], 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Commission:</span>
                        <span class="font-medium">{{ $template['commission_rate'] }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Amenities:</span>
                        <span class="font-medium">{{ $template['amenities_count'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Photos:</span>
                        <span class="font-medium">{{ $template['photos_count'] }}</span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button onclick="createFromTemplate({{ $template['id'] }})" 
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                        Use Template
                    </button>
                    <button onclick="deleteTemplate({{ $template['id'] }})" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        
        @if($templates->isEmpty())
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No templates</h3>
            <p class="mt-1 text-sm text-gray-500">Save your first property as a template to get started.</p>
        </div>
        @endif
    </div>
</div>

<!-- Save Template Modal -->
<div id="saveTemplateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Save as Template</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Property</label>
                    <select id="propertySelect" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select a property...</option>
                        <!-- Will be populated by JavaScript -->
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Name</label>
                    <input type="text" id="templateName" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2"
                           placeholder="Enter template name...">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button onclick="closeSaveTemplateModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button onclick="saveTemplate()" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md">
                        Save Template
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function createFromTemplate(templateId) {
    try {
        const response = await fetch(`/partner/templates/${templateId}/create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        if (result.success) {
            window.showSuccess('Property created from template successfully');
            window.location.href = `/partner/properties/${result.property_id}/edit`;
        }
    } catch (error) {
        window.showError('Failed to create property from template');
    }
}

async function deleteTemplate(templateId) {
    if (!confirm('Are you sure you want to delete this template?')) return;
    
    try {
        await fetch(`/partner/templates/${templateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        window.showSuccess('Template deleted successfully');
        window.location.reload();
    } catch (error) {
        window.showError('Failed to delete template');
    }
}

function showSaveTemplateModal() {
    loadUserProperties();
    document.getElementById('saveTemplateModal').classList.remove('hidden');
}

function closeSaveTemplateModal() {
    document.getElementById('saveTemplateModal').classList.add('hidden');
    document.getElementById('templateName').value = '';
    document.getElementById('propertySelect').value = '';
}

async function loadUserProperties() {
    try {
        const response = await fetch('/partner/properties/list');
        const properties = await response.json();
        
        const select = document.getElementById('propertySelect');
        select.innerHTML = '<option value="">Select a property...</option>';
        
        properties.forEach(property => {
            const option = document.createElement('option');
            option.value = property.id;
            option.textContent = property.title;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Failed to load properties:', error);
    }
}

async function saveTemplate() {
    const propertyId = document.getElementById('propertySelect').value;
    const templateName = document.getElementById('templateName').value;
    
    if (!propertyId || !templateName) {
        window.showError('Please select a property and enter a template name');
        return;
    }
    
    try {
        const response = await fetch(`/partner/properties/${propertyId}/save-template`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ template_name: templateName })
        });
        
        const result = await response.json();
        if (result.success) {
            window.showSuccess('Template saved successfully');
            closeSaveTemplateModal();
            window.location.reload();
        }
    } catch (error) {
        window.showError('Failed to save template');
    }
}
</script>
@endsection