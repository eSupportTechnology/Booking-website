@extends('partner.master')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $property->title }}</h1>
                        <p class="text-blue-100 text-lg">Edit your property setup</p>
                    </div>
                    {{-- <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                        <span class="text-white font-semibold" id="progress-text">0% Complete</span>
                    </div> --}}
                </div>
                {{-- <div class="mt-6 bg-white/20 rounded-full h-3">
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-400 h-3 rounded-full transition-all duration-500 shadow-lg" style="width: 0%" id="progress-bar"></div>
                </div> --}}
            </div>
        </div>

        <div x-data="{ activeTab: 'basic' }" class="space-y-8">
            <!-- Modern Tab Navigation -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-2">
                <div class="grid grid-cols-5 lg:grid-cols-10 gap-2">
                    <button @click="activeTab = 'basic'" :class="activeTab === 'basic' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-home text-lg mb-1"></i>
                        <span class="text-xs font-medium">Basic</span>
                    </button>
                    <button @click="activeTab = 'rooms'" :class="activeTab === 'rooms' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-bed text-lg mb-1"></i>
                        <span class="text-xs font-medium">Rooms</span>
                    </button>
                    <button @click="activeTab = 'photos'" :class="activeTab === 'photos' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-camera text-lg mb-1"></i>
                        <span class="text-xs font-medium">Photos</span>
                    </button>
                    <button @click="activeTab = 'amenities'" :class="activeTab === 'amenities' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-swimming-pool text-lg mb-1"></i>
                        <span class="text-xs font-medium">Amenities</span>
                    </button>
                    <button @click="activeTab = 'services'" :class="activeTab === 'services' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-concierge-bell text-lg mb-1"></i>
                        <span class="text-xs font-medium">Services</span>
                    </button>
                    <button @click="activeTab = 'languages'" :class="activeTab === 'languages' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-language text-lg mb-1"></i>
                        <span class="text-xs font-medium">Languages</span>
                    </button>
                    <button @click="activeTab = 'rules'" :class="activeTab === 'rules' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-gavel text-lg mb-1"></i>
                        <span class="text-xs font-medium">Rules</span>
                    </button>
                    <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-user-circle text-lg mb-1"></i>
                        <span class="text-xs font-medium">Profile</span>
                    </button>
                    <button @click="activeTab = 'payments'" :class="activeTab === 'payments' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-credit-card text-lg mb-1"></i>
                        <span class="text-xs font-medium">Payments</span>
                    </button>
                    <button @click="activeTab = 'verification'" :class="activeTab === 'verification' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg scale-105' : 'text-gray-600 hover:bg-gray-50'" class="flex flex-col items-center p-3 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-shield-alt text-lg mb-1"></i>
                        <span class="text-xs font-medium">Verify</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div x-show="activeTab === 'basic'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.basic-details')</div>
                <div x-show="activeTab === 'rooms'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.rooms')</div>
                <div x-show="activeTab === 'photos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.photos')</div>
                <div x-show="activeTab === 'amenities'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.amenities')</div>
                <div x-show="activeTab === 'services'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.services')</div>
                <div x-show="activeTab === 'languages'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.languages')</div>
                <div x-show="activeTab === 'rules'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.house-rules')</div>
                <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.host-profile')</div>
                <div x-show="activeTab === 'payments'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.payments')</div>
                <div x-show="activeTab === 'verification'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">@include('partner.homes.partials.verification')</div>
            </div>

            <!-- Finalize Button -->
            {{-- <div class="text-center">
                <button type="button" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-12 rounded-2xl shadow-xl transform transition-all duration-200 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" id="finalize-btn" disabled>
                    <i class="fas fa-check-circle mr-2"></i>
                    Complete Property Setup
                </button>
            </div> --}}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let completedTabs = new Set();

    function updateProgress() {
        const totalTabs = 10;
        const progress = (completedTabs.size / totalTabs) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-text').textContent = Math.round(progress) + '% Complete';

        if (completedTabs.size === totalTabs) {
            document.getElementById('finalize-btn').disabled = false;
        }
    }

    function markTabComplete(tabId) {
        completedTabs.add(tabId);
        updateProgress();
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Make functions globally available
    window.markTabComplete = markTabComplete;
    window.showNotification = showNotification;

    // Handle form submissions with event delegation
    document.addEventListener('submit', async function(e) {
        if (!e.target.id || !e.target.id.endsWith('-form')) return;

        e.preventDefault();
        e.stopPropagation();

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (result.success) {
                showNotification(result.message);
            } else {
                showNotification(result.message || 'An error occurred', 'error');
            }
        } catch (error) {
            showNotification('Network error occurred', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    updateProgress();
});
</script>
@endsection
