@extends('frontend.master')

@section('title', 'Profile Settings - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/customerpersonaldetails.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@section('content')
<!-- Profile Settings Container -->
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="text-gray-600 mt-1">Manage your personal information and preferences</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <aside class="w-full lg:w-72 bg-white rounded-xl shadow-sm border border-gray-200 p-4 h-fit">
                <!-- Personal (Active) -->
                <div class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg mb-1 bg-[#1F8FB2] text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Personal details</span>
                </div>

                <!-- Bookings & Trips -->
                <a href="{{ route('customer.reservations.index') }}"
                    class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg mb-1 transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Bookings & Trips</span>
                </a>

                <!-- Messages -->
                <a href="{{ route('customer.messages.index') }}"
                    class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg mb-1 transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Messages</span>
                </a>

                <!-- Rewards & Wallet -->
                <a href="{{ route('rewards.wallet') }}"
                    class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg mb-1 transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Rewards & Wallet</span>
                </a>

                <!-- Reviews -->
                <a href="{{ route('reviews') }}"
                    class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg mb-1 transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span>Reviews</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('customer.logout') }}" class="mt-4 pt-4 border-t border-gray-200">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Personal details</h2>
                        <p class="text-gray-600 mt-1">Update your information and find out how it's used</p>
                    </div>

                    <!-- Profile Picture Display -->
                    <div class="relative w-20 h-20">
                        <img id="profile-preview"
                            src="{{ $details?->profile_image ? asset('storage/' . $details->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($firstName ?? 'User') . '&background=1F8FB2&color=fff&size=80' }}"
                            alt="Profile" class="w-full h-full rounded-full object-cover border-4 border-[#1F8FB2] shadow-lg" />
                        <button type="button" onclick="document.getElementById('profile-modal').classList.remove('hidden')"
                            class="absolute bottom-0 right-0 bg-[#1F8FB2] border-2 border-white rounded-full p-2 shadow cursor-pointer hover:bg-[#29ACD5] transition-colors">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Profile Image Upload Modal -->
                    <div id="profile-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
                            <h3 class="text-lg font-semibold mb-4">Update Profile Picture</h3>
                            <div id="image-preview-container" class="mb-4 text-center">
                                <img id="modal-preview" src="{{ $details?->profile_image ? asset('storage/' . $details->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($firstName ?? 'User') . '&background=1F8FB2&color=fff&size=150' }}"
                                    class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-[#1F8FB2]" />
                            </div>
                            <input type="file" id="modal-file-input" accept="image/*" class="w-full border rounded-lg p-2 mb-4" />
                            <div id="upload-status" class="text-center mb-4 text-sm"></div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('profile-modal').classList.add('hidden')"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                <button type="button" onclick="uploadProfileImage()"
                                    class="flex-1 px-4 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5]">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Name Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Full Name</h3>
                                <p class="mt-1 text-gray-700">{{ $firstName }} {{ $lastName }}</p>
                            </div>
                            <button type="button" onclick="toggleSection('name')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="name-section" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $firstName ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2] focus:border-transparent" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $lastName ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2] focus:border-transparent" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('name')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Display Name Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Display Name</h3>
                                <p class="mt-1 {{ $details->display_name ?? false ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $details->display_name ?? 'Choose a display name for reviews' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('displayName')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="displayName-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Display name</label>
                                <input type="text" name="display_name" value="{{ old('display_name', $details->display_name ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2] focus:border-transparent" />
                                <p class="text-xs text-gray-500 mt-1">This name will be shown when you leave reviews or messages.</p>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('displayName')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Email Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Email Address</h3>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="text-gray-700">{{ $email }}</span>
                                    @if($emailVerified)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mt-1">This is the email address you use to sign in.</p>
                            </div>
                            <button type="button" onclick="toggleSection('email')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="email-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                                <input type="email" name="email" value="{{ old('email', $email ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2] focus:border-transparent" />
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('email')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Phone Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Phone Number</h3>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="{{ $details->phone_number ?? false ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                        {{ $details->phone_number ?? 'Add your phone number' }}
                                    </span>
                                    @if($details?->phone_verified)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button type="button" onclick="toggleSection('phone')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="phone-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
                                <input type="tel" name="phone_number" value="{{ old('phone_number', $details->phone_number ?? '') }}"
                                    placeholder="+49 123 456 7890"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2] focus:border-transparent" />
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('phone')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Date of Birth Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Date of Birth</h3>
                                <p class="mt-1 {{ $details?->date_of_birth ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $details?->date_of_birth ? $details->date_of_birth->format('d M Y') : 'Add your date of birth' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('dob')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="dob-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date of birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($details?->date_of_birth)->format('Y-m-d')) }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('dob')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Nationality Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Nationality</h3>
                                <p class="mt-1 {{ $details?->nationality ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $details?->nationality ?? 'Select your nationality' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('nationality')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="nationality-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                                <select name="nationality" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]">
                                    <option value="">Select your nationality</option>
                                    <option value="German" {{ old('nationality', $details?->nationality) === 'German' ? 'selected' : '' }}>German</option>
                                    <option value="Sri Lankan" {{ old('nationality', $details?->nationality) === 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                    <option value="British" {{ old('nationality', $details?->nationality) === 'British' ? 'selected' : '' }}>British</option>
                                    <option value="American" {{ old('nationality', $details?->nationality) === 'American' ? 'selected' : '' }}>American</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('nationality')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Gender Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Gender</h3>
                                <p class="mt-1 {{ $details?->gender ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $details?->gender ? ucfirst($details->gender) : 'Select your gender' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('gender')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="gender-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]">
                                    <option value="">Select your gender</option>
                                    <option value="female" {{ old('gender', strtolower($details?->gender)) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="male" {{ old('gender', strtolower($details?->gender)) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="other" {{ old('gender', strtolower($details?->gender)) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('gender')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Address Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Address</h3>
                                @php
                                    $addressParts = collect([$details?->street, $details?->city, $details?->postcode, $details?->country])->filter()->join(', ');
                                @endphp
                                <p class="mt-1 {{ $addressParts ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $addressParts ?: 'Add your address' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('address')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="address-section" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country/Region</label>
                                <select name="country" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]">
                                    <option value="">Select country</option>
                                    <option value="Germany" {{ old('country', $details?->country) === 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="Sri Lanka" {{ old('country', $details?->country) === 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                    <option value="United Kingdom" {{ old('country', $details?->country) === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="United States" {{ old('country', $details?->country) === 'United States' ? 'selected' : '' }}>United States</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                <input type="text" name="street" value="{{ old('street', $details->street ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="city" value="{{ old('city', $details->city ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postcode</label>
                                    <input type="text" name="postcode" value="{{ old('postcode', $details->postcode ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('address')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Passport Section -->
                <div class="border-t border-gray-200 py-5">
                    <form method="POST" action="{{ route('customer.details.store') }}">
                        @csrf
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Passport Details</h3>
                                @php
                                    $passportInfo = collect([$passportFirstName, $passportLastName])->filter()->join(' ');
                                    if ($details?->passportNumber) $passportInfo .= ' | ' . $details->passportNumber;
                                @endphp
                                <p class="mt-1 {{ $passportInfo ? 'text-gray-700' : 'text-gray-400 italic' }}">
                                    {{ $passportInfo ?: 'Add passport details' }}
                                </p>
                            </div>
                            <button type="button" onclick="toggleSection('passport')" class="text-[#1F8FB2] hover:text-[#29ACD5] font-medium text-sm">Edit</button>
                        </div>
                        <div id="passport-section" class="hidden space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First name(s)</label>
                                    <input type="text" name="passportFirstName" value="{{ old('passportFirstName', $passportFirstName ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last name(s)</label>
                                    <input type="text" name="passportLastName" value="{{ old('passportLastName', $passportLastName ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Enter the name exactly as written on your passport.</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Issuing country</label>
                                    <select name="issuingCountry" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]">
                                        <option value="">Select country</option>
                                        <option value="Germany" {{ old('issuingCountry', $details?->issuingCountry) === 'Germany' ? 'selected' : '' }}>Germany</option>
                                        <option value="Sri Lanka" {{ old('issuingCountry', $details?->issuingCountry) === 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                        <option value="United Kingdom" {{ old('issuingCountry', $details?->issuingCountry) === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Passport number</label>
                                    <input type="text" name="passportNumber" value="{{ old('passportNumber', $details->passportNumber ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry date</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <input type="text" name="passportExpiryDay" placeholder="DD" maxlength="2" value="{{ old('passportExpiryDay', $passportExpiryDay ?? '') }}"
                                        class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-center focus:ring-2 focus:ring-[#1F8FB2]" />
                                    <input type="text" name="passportExpiryMonth" placeholder="MM" maxlength="2" value="{{ old('passportExpiryMonth', $passportExpiryMonth ?? '') }}"
                                        class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-center focus:ring-2 focus:ring-[#1F8FB2]" />
                                    <input type="text" name="passportExpiryYear" placeholder="YYYY" maxlength="4" value="{{ old('passportExpiryYear', $passportExpiryYear ?? '') }}"
                                        class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-center focus:ring-2 focus:ring-[#1F8FB2]" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSection('passport')" class="px-4 py-2 text-gray-700 text-sm font-medium">Cancel</button>
                                <button type="submit" class="px-6 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#29ACD5] text-sm font-medium">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>
</div>

<script>
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId + '-section');
    if (section) {
        section.classList.toggle('hidden');
    }
}

// Profile image preview
document.addEventListener('DOMContentLoaded', function() {
    const modalFileInput = document.getElementById('modal-file-input');
    const modalPreview = document.getElementById('modal-preview');

    if (modalFileInput) {
        modalFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    modalPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

function uploadProfileImage() {
    const fileInput = document.getElementById('modal-file-input');
    const uploadStatus = document.getElementById('upload-status');
    const file = fileInput.files[0];

    if (!file) {
        uploadStatus.innerHTML = '<span class="text-red-600">Please select an image</span>';
        return;
    }

    if (!file.type.startsWith('image/')) {
        uploadStatus.innerHTML = '<span class="text-red-600">Invalid file type</span>';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        uploadStatus.innerHTML = '<span class="text-red-600">File too large (max 2MB)</span>';
        return;
    }

    uploadStatus.innerHTML = '<span class="text-blue-600">Uploading...</span>';

    const reader = new FileReader();
    reader.onload = function(e) {
        const base64Data = e.target.result;

        fetch('/api/profile/image', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                image: base64Data,
                filename: file.name
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadStatus.innerHTML = '<span class="text-green-600">Saved!</span>';
                document.getElementById('profile-preview').src = data.image_url;
                document.getElementById('modal-preview').src = data.image_url;
                setTimeout(() => {
                    document.getElementById('profile-modal').classList.add('hidden');
                    uploadStatus.innerHTML = '';
                }, 1500);
            } else {
                uploadStatus.innerHTML = '<span class="text-red-600">' + (data.message || 'Failed') + '</span>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            uploadStatus.innerHTML = '<span class="text-red-600">Upload failed</span>';
        });
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
