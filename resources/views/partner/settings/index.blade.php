@extends('partner.master')

@section('content')
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
                <div class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <div class="h-24 w-24 bg-gradient-to-r from-gray-400 to-gray-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <div>
                            <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-camera mr-2"></i>Change Photo
                            </button>
                            <p class="text-sm text-gray-500 mt-2">JPG, GIF or PNG. Max size 2MB.</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" value="{{ $profile['name'] }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="{{ $profile['email'] }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" value="{{ $profile['phone'] }}" placeholder="+1 234 567 8900" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                            <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                        <textarea rows="4" placeholder="Tell guests about yourself..." class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200">{{ $profile['bio'] }}</textarea>
                    </div>
                    
                    <button class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                        <i class="fas fa-save mr-2"></i>Update Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div x-show="activeTab === 'notifications'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Notification Preferences</h3>
                <div class="space-y-6">
                    <div class="bg-gray-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Email Notifications</h4>
                        <div class="space-y-4">
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-green-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">New Bookings</span>
                                        <p class="text-sm text-gray-600">Get notified when you receive a new booking</p>
                                    </div>
                                </div>
                                <input type="checkbox" {{ $notifications['email_bookings'] ? 'checked' : '' }} class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-purple-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">Messages</span>
                                        <p class="text-sm text-gray-600">Get notified when guests send you messages</p>
                                    </div>
                                </div>
                                <input type="checkbox" {{ $notifications['email_messages'] ? 'checked' : '' }} class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">Reviews</span>
                                        <p class="text-sm text-gray-600">Get notified when guests leave reviews</p>
                                    </div>
                                </div>
                                <input type="checkbox" class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-dollar-sign text-green-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">Payments</span>
                                        <p class="text-sm text-gray-600">Get notified about payment updates</p>
                                    </div>
                                </div>
                                <input type="checkbox" checked class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">SMS Notifications</h4>
                        <div class="space-y-4">
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-mobile-alt text-blue-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">Urgent Messages</span>
                                        <p class="text-sm text-gray-600">Receive SMS for urgent guest messages</p>
                                    </div>
                                </div>
                                <input type="checkbox" class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                                    <div>
                                        <span class="font-medium text-gray-900">Booking Issues</span>
                                        <p class="text-sm text-gray-600">Get SMS alerts for booking problems</p>
                                    </div>
                                </div>
                                <input type="checkbox" checked class="h-5 w-5 text-gray-600 rounded focus:ring-gray-500">
                            </label>
                        </div>
                    </div>
                    
                    <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                        <i class="fas fa-save mr-2"></i>Save Preferences
                    </button>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div x-show="activeTab === 'security'" class="p-8">
            <div class="max-w-2xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Security Settings</h3>
                <div class="space-y-8">
                    <div class="bg-red-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Change Password</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Two-Factor Authentication</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-700">Add an extra layer of security to your account</p>
                                <p class="text-sm text-gray-600 mt-1">Currently disabled</p>
                            </div>
                            <button class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                                <i class="fas fa-shield-alt mr-2"></i>Enable 2FA
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Login Sessions</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-desktop text-blue-600 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Windows PC - Chrome</p>
                                        <p class="text-sm text-gray-600">Current session • New York, US</p>
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Active</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-mobile-alt text-green-600 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">iPhone - Safari</p>
                                        <p class="text-sm text-gray-600">2 hours ago • New York, US</p>
                                    </div>
                                </div>
                                <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    Revoke
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payout Tab -->
        <div x-show="activeTab === 'payout'" class="p-8">
            <div class="max-w-4xl">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Payout Settings</h3>
                <div class="space-y-8">
                    <div class="bg-blue-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Bank Account Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bank Name</label>
                                <input type="text" placeholder="Enter bank name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Account Number</label>
                                <input type="text" placeholder="Enter account number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Account Holder Name</label>
                                <input type="text" placeholder="Enter account holder name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Swift/Routing Code</label>
                                <input type="text" placeholder="Enter swift code" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        <button class="mt-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Save Bank Details
                        </button>
                    </div>
                    
                    <div class="bg-green-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Payout Schedule</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Payout Frequency</label>
                                <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <option>Weekly</option>
                                    <option>Bi-weekly</option>
                                    <option>Monthly</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Payout Amount</label>
                                <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                    <option>$50</option>
                                    <option>$100</option>
                                    <option>$250</option>
                                    <option>$500</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-6 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-4">Tax Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tax ID / SSN</label>
                                <input type="text" placeholder="Enter tax ID" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tax Country</label>
                                <select class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>United Kingdom</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
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
@endsection