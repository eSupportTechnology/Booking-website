@extends('admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-8">
    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-[#1F8FB2]">⚙️ Account Settings</h2>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Navigation -->
        <div class="space-y-2">
            <button onclick="showTab('profile')" id="profile-tab" class="w-full text-left px-4 py-2 bg-[#E6F7FC] text-[#1F8FB2] rounded hover:bg-[#d0effb] font-medium">
                👤 Profile
            </button>
            <button onclick="showTab('security')" id="security-tab" class="w-full text-left px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 font-medium">
                🔒 Security
            </button>
            <button onclick="showTab('notifications')" id="notifications-tab" class="w-full text-left px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 font-medium">
                🔔 Notifications
            </button>
            <button onclick="showTab('commission')" id="commission-tab" class="w-full text-left px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 font-medium">
                💰 Commission
            </button>
        </div>

        <!-- Settings Content -->
        <div class="md:col-span-3 space-y-8">
            <!-- Profile Settings -->
            <div id="profile-content" class="bg-gray-50 border rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">👤 Profile Information</h3>
                <form action="{{ route('admin.settings.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" name="full_name" value="{{ $settings->full_name ?? $admin->username }}" 
                                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ $admin->email }}" 
                                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ $settings->phone ?? '' }}" 
                                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Timezone</label>
                            <select name="timezone" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                                <option value="UTC" {{ ($settings->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ ($settings->timezone ?? '') == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="America/Chicago" {{ ($settings->timezone ?? '') == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                <option value="America/Los_Angeles" {{ ($settings->timezone ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Language</label>
                            <select name="language" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                                <option value="en" {{ ($settings->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ ($settings->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ ($settings->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="bg-[#1F8FB2] text-white px-6 py-2 rounded hover:bg-[#157799] transition">
                        Save Profile
                    </button>
                </form>
            </div>

            <!-- Security Settings -->
            <div id="security-content" class="bg-gray-50 border rounded-lg shadow p-6 hidden">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">🔒 Security Settings</h3>
                
                <!-- Change Password -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Change Password</h4>
                    <form action="{{ route('admin.settings.password.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Current Password</label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password"
                                           class="w-full border rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                                    <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="current_password_icon" class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="new_password"
                                           class="w-full border rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                                    <button type="button" onclick="togglePassword('new_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="new_password_icon" class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="confirm_password"
                                           class="w-full border rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                                    <button type="button" onclick="togglePassword('confirm_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="confirm_password_icon" class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                            Update Password
                        </button>
                    </form>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="border-t pt-6">
                    <h4 class="font-medium text-gray-700 mb-3">Two-Factor Authentication</h4>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">Add an extra layer of security to your account</p>
                            <p class="text-sm text-gray-500">Status: {{ ($settings->two_factor_enabled ?? false) ? 'Enabled' : 'Disabled' }}</p>
                        </div>
                        <form action="{{ route('admin.settings.two-factor.toggle') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="enabled" value="{{ ($settings->two_factor_enabled ?? false) ? '0' : '1' }}">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                {{ ($settings->two_factor_enabled ?? false) ? 'Disable' : 'Enable' }} 2FA
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div id="notifications-content" class="bg-gray-50 border rounded-lg shadow p-6 hidden">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">🔔 Notification Preferences</h3>
                <form action="{{ route('admin.settings.notifications.update') }}" method="POST">
                    @csrf
                    <div class="space-y-4 mb-6">
                        @php
                            $notifications = $settings->notification_preferences ?? [];
                        @endphp
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-medium text-gray-700">Email Alerts</span>
                                <p class="text-sm text-gray-600">Receive email notifications for important events</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_alerts" value="1" 
                                       {{ ($notifications['email_alerts'] ?? true) ? 'checked' : '' }} 
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#1F8FB2] rounded-full peer peer-checked:bg-[#1F8FB2] transition-all"></div>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-medium text-gray-700">System Notifications</span>
                                <p class="text-sm text-gray-600">Get notified about system updates and maintenance</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="system_notifications" value="1" 
                                       {{ ($notifications['system_notifications'] ?? true) ? 'checked' : '' }} 
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#1F8FB2] rounded-full peer peer-checked:bg-[#1F8FB2] transition-all"></div>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-medium text-gray-700">Security Alerts</span>
                                <p class="text-sm text-gray-600">Receive alerts for security-related events</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="security_alerts" value="1" 
                                       {{ ($notifications['security_alerts'] ?? true) ? 'checked' : '' }} 
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#1F8FB2] rounded-full peer peer-checked:bg-[#1F8FB2] transition-all"></div>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-medium text-gray-700">Report Notifications</span>
                                <p class="text-sm text-gray-600">Get notified when reports are generated</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="report_notifications" value="1" 
                                       {{ ($notifications['report_notifications'] ?? false) ? 'checked' : '' }} 
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#1F8FB2] rounded-full peer peer-checked:bg-[#1F8FB2] transition-all"></div>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="bg-[#1F8FB2] text-white px-6 py-2 rounded hover:bg-[#157799] transition">
                        Save Preferences
                    </button>
                </form>
            </div>

            <!-- Commission Settings -->
            <div id="commission-content" class="bg-gray-50 border rounded-lg shadow p-6 hidden">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">💰 Commission Settings</h3>
                
                <!-- Global Commission Rate -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Global Commission Rate</h4>
                    <form action="{{ route('admin.settings.commission.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Default Rate for All Partners</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <input type="number" 
                                           name="commission_rate" 
                                           value="{{ $settings->commission_rate ?? 0.15 }}" 
                                           step="0.0001" 
                                           min="0" 
                                           max="1" 
                                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" 
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Enter as decimal (e.g., 0.15 for 15%)</p>
                                </div>
                                <div class="text-lg font-semibold text-gray-700">
                                    <span id="commission-percentage">{{ number_format(($settings->commission_rate ?? 0.15) * 100, 1) }}%</span>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <p>Current global rate: <strong>{{ number_format(($settings->commission_rate ?? 0.15) * 100, 1) }}%</strong></p>
                                <p class="text-xs text-gray-500 mt-1">This rate applies to all partners unless they have an individual rate set.</p>
                            </div>
                        </div>
                        <button type="submit" class="bg-[#1F8FB2] text-white px-6 py-2 rounded hover:bg-[#157799] transition">
                            Update Global Rate
                        </button>
                    </form>
                </div>

                <!-- Individual Partner Commission Management -->
                <div class="border-t pt-6">
                    <h4 class="font-medium text-gray-700 mb-3">Individual Partner Rates</h4>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600">Set custom commission rates for specific partners</p>
                            <p class="text-sm text-gray-500">Individual rates override the global rate when assigned</p>
                        </div>
                        <a href="{{ route('admin.commission.index') }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Manage Partner Rates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('[id$="-content"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id$="-tab"]').forEach(el => {
        el.classList.remove('bg-[#E6F7FC]', 'text-[#1F8FB2]');
        el.classList.add('bg-gray-100', 'text-gray-700');
    });
    document.getElementById(tabName + '-content').classList.remove('hidden');
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('bg-gray-100', 'text-gray-700');
    activeTab.classList.add('bg-[#E6F7FC]', 'text-[#1F8FB2]');
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Update commission percentage display
document.addEventListener('DOMContentLoaded', function() {
    const commissionInput = document.querySelector('input[name="commission_rate"]');
    const percentageDisplay = document.getElementById('commission-percentage');
    
    if (commissionInput && percentageDisplay) {
        commissionInput.addEventListener('input', function() {
            const value = parseFloat(this.value) || 0;
            const percentage = (value * 100).toFixed(1);
            percentageDisplay.textContent = percentage + '%';
        });
    }
});
</script>
@endsection