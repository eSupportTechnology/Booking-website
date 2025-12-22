@extends('car_rentals.master')

@section('content')
<!-- Notification Toast -->
<div id="notification" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
        <i class="fas fa-check-circle"></i>
        <span id="notification-text"></span>
        <button onclick="hideNotification()" class="ml-2 text-white hover:text-gray-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-700 to-gray-800 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Account Settings</h1>
                <p class="text-gray-300 text-lg">Manage your account preferences and security</p>
            </div>
            <div class="bg-white/20 px-4 py-2 rounded-xl">
                <span class="text-sm font-medium">Last updated: Today</span>
            </div>
        </div>
    </div>

    <!-- Settings Navigation -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100" x-data="{ activeTab: 'profile' }">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-user mr-2"></i>Profile
                </button>
                <button @click="activeTab = 'notifications'" :class="activeTab === 'notifications' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-bell mr-2"></i>Notifications
                </button>
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-shield-alt mr-2"></i>Security
                </button>
                <button @click="activeTab = 'payout'" :class="activeTab === 'payout' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-credit-card mr-2"></i>Payout
                </button>
                <button @click="activeTab = 'preferences'" :class="activeTab === 'preferences' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <i class="fas fa-cog mr-2"></i>Preferences
                </button>
            </nav>
        </div>

        <!-- Profile Tab -->
        <div x-show="activeTab === 'profile'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Profile Information</h3>
                <form action="{{ route('car_rentals.settings.profile.update') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div class="flex items-center space-x-6">
                            <div class="h-24 w-24 bg-gradient-to-r from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <div>
                                <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-camera mr-2"></i>Change Photo
                                </button>
                                <p class="text-sm text-gray-500 mt-2">JPG, GIF or PNG. Max size 2MB.</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="full_name" value="{{ $profile['name'] }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ $profile['email'] }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" value="{{ $profile['phone'] }}" placeholder="+1 234 567 8900" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                                <select name="language" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="en" {{ $profile['language'] == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="es" {{ $profile['language'] == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="fr" {{ $profile['language'] == 'French' ? 'selected' : '' }}>French</option>
                                    <option value="de" {{ $profile['language'] == 'German' ? 'selected' : '' }}>German</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Timezone</label>
                                <select name="timezone" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="UTC" {{ $profile['timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ $profile['timezone'] == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                    <option value="America/Chicago" {{ $profile['timezone'] == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                    <option value="America/Los_Angeles" {{ $profile['timezone'] == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Currency</label>
                                <select name="currency" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="USD" {{ $profile['currency'] == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="EUR" {{ $profile['currency'] == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                    <option value="GBP" {{ $profile['currency'] == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                    <option value="CAD" {{ $profile['currency'] == 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                            <textarea name="bio" rows="4" placeholder="Tell guests about yourself..." class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">{{ $profile['bio'] }}</textarea>
                        </div>
                        
                        <button type="submit" onclick="showNotification('Profile updated successfully!')" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div x-show="activeTab === 'notifications'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Notification Preferences</h3>
                <form action="{{ route('car_rentals.settings.notifications.update') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-4">Email Notifications</h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-check text-green-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">New Bookings</span>
                                            <p class="text-sm text-gray-600">Get notified when you receive a new booking</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_bookings" value="1" {{ $notifications['email_bookings'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gray-500 rounded-full peer peer-checked:bg-gray-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-purple-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Messages</span>
                                            <p class="text-sm text-gray-600">Get notified when guests send you messages</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_messages" value="1" {{ $notifications['email_messages'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gray-500 rounded-full peer peer-checked:bg-gray-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Reviews</span>
                                            <p class="text-sm text-gray-600">Get notified when guests leave reviews</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_reviews" value="1" {{ $notifications['email_reviews'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gray-500 rounded-full peer peer-checked:bg-gray-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-dollar-sign text-green-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Payments</span>
                                            <p class="text-sm text-gray-600">Get notified about payment updates</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_payments" value="1" {{ $notifications['email_payments'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-gray-500 rounded-full peer peer-checked:bg-gray-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 p-6 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-4">SMS Notifications</h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-mobile-alt text-blue-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Urgent Messages</span>
                                            <p class="text-sm text-gray-600">Receive SMS for urgent guest messages</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="sms_urgent" value="1" {{ $notifications['sms_urgent'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Booking Issues</span>
                                            <p class="text-sm text-gray-600">Get SMS alerts for booking problems</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="sms_issues" value="1" {{ $notifications['sms_issues'] ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all peer-checked:translate-x-full"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" onclick="showNotification('Notification preferences saved!')" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tab -->
        <div x-show="activeTab === 'security'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Security Settings</h3>
                <div class="space-y-8">
                    <div class="bg-red-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Change Password</h4>
                        <form action="{{ route('car_rentals.settings.password.update') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                    <div class="relative">
                                        <input type="password" name="current_password" id="partner_current_password" class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200" required>
                                        <button type="button" onclick="togglePartnerPassword('partner_current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i id="partner_current_password_icon" class="fas fa-eye text-gray-400"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="partner_new_password" class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200" required>
                                        <button type="button" onclick="togglePartnerPassword('partner_new_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i id="partner_new_password_icon" class="fas fa-eye text-gray-400"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="partner_confirm_password" class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200" required>
                                        <button type="button" onclick="togglePartnerPassword('partner_confirm_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i id="partner_confirm_password_icon" class="fas fa-eye text-gray-400"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" onclick="showNotification('Password changed successfully!')" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                                    <i class="fas fa-key mr-2"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="bg-green-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Two-Factor Authentication</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-700">Add an extra layer of security to your account</p>
                                <p class="text-sm text-gray-600 mt-1">Currently {{ $security['two_factor_enabled'] ? 'enabled' : 'disabled' }}</p>
                            </div>
                            <form action="{{ route('car_rentals.settings.two-factor.toggle') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="enabled" value="{{ $security['two_factor_enabled'] ? '0' : '1' }}">
                                <button type="submit" onclick="showNotification('Two-factor authentication {{ $security['two_factor_enabled'] ? 'disabled' : 'enabled' }}!')" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                                    <i class="fas fa-shield-alt mr-2"></i>{{ $security['two_factor_enabled'] ? 'Disable' : 'Enable' }} 2FA
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Login Sessions</h4>
                        <div class="space-y-3">
                            @foreach($security['active_sessions'] as $session)
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas {{ $session['device'] == 'Windows PC - Chrome' ? 'fa-desktop' : 'fa-mobile-alt' }} text-blue-600 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $session['device'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $session['last_active'] }} • {{ $session['location'] }}</p>
                                    </div>
                                </div>
                                @if($session['status'] == 'current')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Active</span>
                                @else
                                    <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Revoke
                                    </button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payout Tab -->
        <div x-show="activeTab === 'payout'" class="p-8">
            <div class="max-w-4xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Payout Settings</h3>
                <form action="{{ route('car_rentals.settings.payout.update') }}" method="POST">
                    @csrf
                    <div class="space-y-8">
                        <div class="bg-blue-50 p-6 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-4">Bank Account Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ $payout['bank_name'] }}" placeholder="Enter bank name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Account Number</label>
                                    <input type="text" name="account_number" value="{{ $payout['account_number'] }}" placeholder="Enter account number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Account Holder Name</label>
                                    <input type="text" name="account_holder" value="{{ $payout['account_holder'] }}" placeholder="Enter account holder name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Swift/Routing Code</label>
                                    <input type="text" name="swift_code" value="{{ $payout['swift_code'] }}" placeholder="Enter swift code" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-6 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-4">Payout Schedule</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payout Frequency</label>
                                    <select name="payout_frequency" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                                        <option value="weekly" {{ $payout['payout_frequency'] == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="bi-weekly" {{ $payout['payout_frequency'] == 'bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                        <option value="monthly" {{ $payout['payout_frequency'] == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Payout Amount</label>
                                    <input type="number" name="minimum_payout" value="{{ $payout['minimum_payout'] }}" min="50" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" onclick="showNotification('Payout settings saved!')" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Save Payout Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preferences Tab -->
        <div x-show="activeTab === 'preferences'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Account Preferences</h3>
                <div class="space-y-8">
                    <div class="bg-purple-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Display Settings</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Time Zone</label>
                                <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option>Eastern Time (ET)</option>
                                    <option>Central Time (CT)</option>
                                    <option>Mountain Time (MT)</option>
                                    <option>Pacific Time (PT)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Currency</label>
                                <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                    <option>USD ($)</option>
                                    <option>EUR (€)</option>
                                    <option>GBP (£)</option>
                                    <option>CAD (C$)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Danger Zone</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Deactivate Account</p>
                                    <p class="text-sm text-gray-600">Temporarily disable your account</p>
                                </div>
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    Deactivate
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Delete Account</p>
                                    <p class="text-sm text-gray-600">Permanently delete your account and all data</p>
                                </div>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function togglePartnerPassword(fieldId) {
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

function showNotification(message) {
    const notification = document.getElementById('notification');
    const text = document.getElementById('notification-text');
    text.textContent = message;
    notification.classList.remove('hidden');
    setTimeout(() => {
        hideNotification();
    }, 3000);
}

function hideNotification() {
    document.getElementById('notification').classList.add('hidden');
}
</script>
@endsection