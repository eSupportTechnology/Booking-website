@extends('partner.master')
@section('title', 'Homes - Edit')
@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-4">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('partner.dashboard') }}" class="hover:text-blue-600 transition-colors">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400"></i>
                <a href="{{ route('partner.properties.homes') }}" class="hover:text-blue-600 transition-colors">
                    Homes
                </a>
                <i class="fas fa-chevron-right text-gray-400"></i>
                <span class="text-gray-900 font-medium">Edit Property</span>
            </div>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $property->title ?? 'Property Setup' }}</h1>
                        <p class="text-blue-100">Complete your property configuration</p>
                    </div>
                    <a href="{{ route('partner.properties.homes') }}" 
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Homes
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div x-data="{ activeTab: 'basic' }" class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border p-1">
                <nav class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-11 gap-1 overflow-x-auto">
                    @php
                        $tabs = [
                            'basic' => ['icon' => 'home', 'label' => 'Basic'],
                            'rooms' => ['icon' => 'bed', 'label' => 'Rooms'],
                            'photos' => ['icon' => 'camera', 'label' => 'Photos'],
                            'amenities' => ['icon' => 'star', 'label' => 'Amenities'],
                            'services' => ['icon' => 'concierge-bell', 'label' => 'Services'],
                            'languages' => ['icon' => 'language', 'label' => 'Languages'],
                            'rules' => ['icon' => 'gavel', 'label' => 'Rules'],
                            'profile' => ['icon' => 'user-circle', 'label' => 'Profile'],
                            'pricing' => ['icon' => 'dollar-sign', 'label' => 'Pricing'],
                            'payments' => ['icon' => 'credit-card', 'label' => 'Payments'],
                            'verification' => ['icon' => 'shield-alt', 'label' => 'Verify']
                        ];
                    @endphp

                    @foreach($tabs as $key => $tab)
                        <button @click="activeTab = '{{ $key }}'"
                                onclick="showTab('{{ $key }}')"
                                :class="activeTab === '{{ $key }}' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-50'"
                                class="flex flex-col items-center p-3 rounded-lg transition-colors tab-button"
                                data-tab="{{ $key }}">
                            <i class="fas fa-{{ $tab['icon'] }} text-lg mb-1"></i>
                            <span class="text-xs font-medium">{{ $tab['label'] }}</span>
                        </button>
                    @endforeach
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-xl shadow-sm border">
                @foreach($tabs as $key => $tab)
                    <div x-show="activeTab === '{{ $key }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         data-tab-content="{{ $key }}"
                         style="{{ $key === 'basic' ? '' : 'display: none;' }}">
                        @if($key === 'basic')
                            @include('partner.homes.partials.basic-details')
                        @elseif($key === 'rules')
                            @include('partner.homes.partials.house-rules')
                        @elseif($key === 'profile')
                            @include('partner.homes.partials.host-profile')
                        @elseif($key === 'pricing')
                            @include('partner.homes.partials.pricing')
                        @else
                            @include("partner.homes.partials.{$key}")
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
// Debug Alpine.js
console.log('Alpine.js loaded:', typeof Alpine !== 'undefined');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing homes edit page');
    // Notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;

        // Sanitize message to prevent XSS
        const sanitizedMessage = document.createTextNode(message);
        const messageContainer = document.createElement('span');
        messageContainer.appendChild(sanitizedMessage);

        const icon = document.createElement('i');
        icon.className = `fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2`;

        notification.appendChild(icon);
        notification.appendChild(messageContainer);
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Form submission handler
    document.addEventListener('submit', async function(e) {
        if (!e.target.matches('form[id$="-form"]')) return;

        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!submitBtn) return;

        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            const result = await response.json();
            showNotification(result.message || 'Operation completed', result.success ? 'success' : 'error');
        } catch (error) {
            showNotification('Network error occurred', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // Make notification function globally available
    window.showNotification = showNotification;
    
    // Fallback tab navigation if Alpine.js fails
    window.showTab = function(tabName) {
        console.log('Showing tab:', tabName);
        
        // Hide all tab contents
        document.querySelectorAll('[data-tab-content]').forEach(content => {
            content.style.display = 'none';
        });
        
        // Show selected tab content
        const targetContent = document.querySelector(`[data-tab-content="${tabName}"]`);
        if (targetContent) {
            targetContent.style.display = 'block';
        }
        
        // Update button styles
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600');
        });
        
        const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-600');
            activeBtn.classList.add('bg-blue-600', 'text-white');
        }
    };
    
    // Initialize first tab
    setTimeout(() => {
        if (typeof Alpine === 'undefined') {
            console.log('Alpine.js not found, using fallback navigation');
            showTab('basic');
        }
    }, 100);
});
</script>
@endsection
