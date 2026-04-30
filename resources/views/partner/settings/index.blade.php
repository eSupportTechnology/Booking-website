@extends('partner.master')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <h1 class="text-xl font-semibold text-gray-800">Settings</h1>
        <p class="text-gray-500 text-sm">Manage your account preferences</p>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm" x-data="{ activeTab: 'profile' }">
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="flex px-4 gap-4 text-sm">
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'border-[#1F8FB2] text-[#1F8FB2]' : 'border-transparent text-gray-500'" class="py-3 border-b-2 font-medium whitespace-nowrap">Profile</button>
                <button @click="activeTab = 'notifications'" :class="activeTab === 'notifications' ? 'border-[#1F8FB2] text-[#1F8FB2]' : 'border-transparent text-gray-500'" class="py-3 border-b-2 font-medium whitespace-nowrap">Notifications</button>
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-[#1F8FB2] text-[#1F8FB2]' : 'border-transparent text-gray-500'" class="py-3 border-b-2 font-medium whitespace-nowrap">Security</button>
                <button @click="activeTab = 'payout'" :class="activeTab === 'payout' ? 'border-[#1F8FB2] text-[#1F8FB2]' : 'border-transparent text-gray-500'" class="py-3 border-b-2 font-medium whitespace-nowrap">Payout</button>
            </nav>
        </div>

        <!-- Profile Tab -->
        <div x-show="activeTab === 'profile'" class="p-5">
            <form action="{{ route('partner.settings.profile.update') }}" method="POST" class="max-w-xl space-y-4">
                @csrf
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center text-white text-xl font-semibold">
                        {{ strtoupper(substr($profile['name'], 0, 1)) }}
                    </div>
                    <button type="button" class="text-sm text-[#1F8FB2] hover:underline">Change photo</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Full Name</label>
                        <input type="text" name="full_name" value="{{ $profile['name'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $profile['email'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ $profile['phone'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Language</label>
                        <select name="language" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                            <option value="en" {{ $profile['language'] == 'English' ? 'selected' : '' }}>English</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Bio</label>
                    <textarea name="bio" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">{{ $profile['bio'] }}</textarea>
                </div>
                <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Save Changes</button>
            </form>
        </div>

        <!-- Notifications Tab -->
        <div x-show="activeTab === 'notifications'" class="p-5">
            <form action="{{ route('partner.settings.notifications.update') }}" method="POST" class="max-w-xl space-y-4">
                @csrf
                <div class="space-y-3">
                    @foreach(['email_bookings' => 'New Bookings', 'email_messages' => 'Messages', 'email_reviews' => 'Reviews', 'email_payments' => 'Payments'] as $key => $label)
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ $notifications[$key] ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#1F8FB2] transition"></div>
                            <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-4"></div>
                        </label>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Save Preferences</button>
            </form>
        </div>

        <!-- Security Tab -->
        <div x-show="activeTab === 'security'" class="p-5">
            <div class="max-w-xl space-y-6">
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-800 mb-3">Change Password</h3>
                    <form action="{{ route('partner.settings.password.update') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="password" name="current_password" placeholder="Current password" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                        <input type="password" name="password" placeholder="New password" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                        <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                        <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Update Password</button>
                    </form>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-800">Two-Factor Authentication</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $security['two_factor_enabled'] ? 'Enabled' : 'Disabled' }}</p>
                        </div>
                        <form action="{{ route('partner.settings.two-factor.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="enabled" value="{{ $security['two_factor_enabled'] ? '0' : '1' }}">
                            <button type="submit" class="text-sm text-[#1F8FB2] hover:underline">{{ $security['two_factor_enabled'] ? 'Disable' : 'Enable' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payout Tab -->
        <div x-show="activeTab === 'payout'" class="p-5">
            <form action="{{ route('partner.settings.payout.update') }}" method="POST" class="max-w-xl space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ $payout['bank_name'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Account Number</label>
                        <input type="text" name="account_number" value="{{ $payout['account_number'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Account Holder</label>
                        <input type="text" name="account_holder" value="{{ $payout['account_holder'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Swift Code</label>
                        <input type="text" name="swift_code" value="{{ $payout['swift_code'] }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Payout Frequency</label>
                        <select name="payout_frequency" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                            <option value="weekly" {{ $payout['payout_frequency'] == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="bi-weekly" {{ $payout['payout_frequency'] == 'bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                            <option value="monthly" {{ $payout['payout_frequency'] == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Minimum Payout ($)</label>
                        <input type="number" name="minimum_payout" value="{{ $payout['minimum_payout'] }}" min="50" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1F8FB2]">
                    </div>
                </div>
                <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Save Payout Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
