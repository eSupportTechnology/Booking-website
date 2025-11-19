@extends('partner.partner-layout')

@section('title', 'Create Property - Photos | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 4])
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Add Photos</h2>
        <p class="text-gray-600 mb-6">Upload at least 3 high-quality photos of your property</p>
        
        <!-- Existing Photos -->
        @if(isset($existingPhotos) && $existingPhotos->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Existing Photos ({{ $existingPhotos->count() }})</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($existingPhotos as $photo)
                <div class="relative">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-32 object-cover rounded-lg">
                    <button type="button" onclick="removeExistingPhoto({{ $photo->id }})" 
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                        ×
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <form id="photoForm" enctype="multipart/form-data">
            @csrf
            
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" style="display: none;">
                <button type="button" id="uploadBtn" class="w-full">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-700 mb-2">Click to Select Photos</p>
                    <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 5MB each</p>
                </button>
            </div>
            
            <div id="preview" class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4" style="display: none;"></div>
            
            <div class="flex justify-between mt-8">
                <a href="/property/create/step/3" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <button type="button" id="continueBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let selectedFiles = [];
const existingCount = {{ isset($existingPhotos) ? $existingPhotos->count() : 0 }};

document.getElementById('uploadBtn').onclick = function() {
    document.getElementById('fileInput').click();
};

document.getElementById('fileInput').onchange = function(e) {
    selectedFiles = Array.from(e.target.files);
    showPreview();
};

function showPreview() {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    
    if (selectedFiles.length > 0) {
        preview.style.display = 'grid';
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                    <button type="button" onclick="removeFile(${index})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">×</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        preview.style.display = 'none';
    }
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    showPreview();
}

function removeExistingPhoto(photoId) {
    fetch(`/property/photos/${photoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => location.reload());
}

document.getElementById('continueBtn').onclick = function() {
    const totalPhotos = selectedFiles.length + existingCount;
    
    if (totalPhotos < 3) {
        alert('Please upload at least 3 photos total');
        return;
    }
    
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    selectedFiles.forEach(file => {
        formData.append('photos[]', file);
    });
    
    fetch('/property/create/step/4', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/property/create/step/5';
        } else {
            alert(data.message || 'Upload failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Upload failed');
    });
};
</script>
@endsection