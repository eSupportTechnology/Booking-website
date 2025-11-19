<div x-data="photoManager({{ $property->id ?? 'null' }})" x-init="initSortable()" class="photo-manager">
    <!-- Upload Area -->
    <div class="mb-6">
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
            <input type="file" multiple accept="image/*" @change="handleFileUpload" class="hidden" id="photo-upload">
            <label for="photo-upload" class="cursor-pointer">
                <div class="text-gray-600">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-medium text-blue-600">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 5MB each</p>
                </div>
            </label>
        </div>
    </div>

    <!-- Photo Grid -->
    <div id="photo-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <template x-for="(photo, index) in photos" :key="photo.id">
            <div class="photo-item relative group bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" 
                 :data-id="photo.id">
                <!-- Photo -->
                <div class="aspect-w-4 aspect-h-3 cursor-move">
                    <img :src="photo.url" :alt="photo.caption || 'Property photo'" 
                         class="w-full h-32 object-cover">
                </div>
                
                <!-- Overlay Controls -->
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <div class="flex space-x-2">
                        <button @click="setPrimary(photo.id)" 
                                :class="photo.is_primary ? 'bg-yellow-500' : 'bg-gray-600'"
                                class="text-white p-2 rounded-full hover:bg-opacity-80 transition-colors"
                                :title="photo.is_primary ? 'Primary photo' : 'Set as primary'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                        <button @click="deletePhoto(photo.id)" 
                                class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors"
                                title="Delete photo">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Caption Input -->
                <div class="p-2">
                    <input type="text" 
                           :value="photo.caption" 
                           @blur="updateCaption(photo.id, $event.target.value)"
                           placeholder="Add caption..." 
                           class="w-full text-xs border-0 bg-transparent focus:ring-1 focus:ring-blue-500 rounded px-1 py-1">
                </div>
                
                <!-- Primary Badge -->
                <div x-show="photo.is_primary" class="absolute top-2 left-2">
                    <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-medium">Primary</span>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Empty State -->
    <div x-show="photos.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No photos</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by uploading your first photo.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
function photoManager(propertyId) {
    return {
        propertyId: propertyId,
        photos: @json($property->photos->map(function($photo) {
            return [
                'id' => $photo->id,
                'url' => Storage::url($photo->path),
                'caption' => $photo->caption,
                'is_primary' => $photo->is_primary,
            ];
        }) ?? []),
        
        initSortable() {
            if (!this.propertyId) return;
            
            new Sortable(document.getElementById('photo-grid'), {
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: (evt) => this.updateOrder()
            });
        },
        
        async handleFileUpload(event) {
            const files = Array.from(event.target.files);
            if (files.length === 0) return;
            
            const formData = new FormData();
            files.forEach(file => formData.append('photos[]', file));
            
            try {
                const response = await fetch(`/partner/properties/${this.propertyId}/photos/upload`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const result = await response.json();
                if (result.success) {
                    this.photos.push(...result.photos);
                    window.showNotification('Photos uploaded successfully', 'success');
                }
            } catch (error) {
                window.showNotification('Failed to upload photos', 'error');
            }
            
            event.target.value = '';
        },
        
        async updateOrder() {
            const photoIds = Array.from(document.querySelectorAll('.photo-item')).map(el => el.dataset.id);
            
            try {
                await fetch(`/partner/properties/${this.propertyId}/photos/reorder`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ photo_ids: photoIds })
                });
            } catch (error) {
                console.error('Failed to update photo order:', error);
            }
        },
        
        async updateCaption(photoId, caption) {
            try {
                await fetch(`/partner/properties/${this.propertyId}/photos/${photoId}/caption`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ caption })
                });
                
                const photo = this.photos.find(p => p.id == photoId);
                if (photo) photo.caption = caption;
            } catch (error) {
                window.showNotification('Failed to update caption', 'error');
            }
        },
        
        async setPrimary(photoId) {
            try {
                await fetch(`/partner/properties/${this.propertyId}/photos/${photoId}/primary`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                this.photos.forEach(photo => {
                    photo.is_primary = photo.id == photoId;
                });
                
                window.showNotification('Primary photo updated', 'success');
            } catch (error) {
                window.showNotification('Failed to set primary photo', 'error');
            }
        },
        
        async deletePhoto(photoId) {
            if (!confirm('Are you sure you want to delete this photo?')) return;
            
            try {
                await fetch(`/partner/properties/${this.propertyId}/photos/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                this.photos = this.photos.filter(photo => photo.id != photoId);
                window.showNotification('Photo deleted successfully', 'success');
            } catch (error) {
                window.showNotification('Failed to delete photo', 'error');
            }
        }
    }
}
</script>