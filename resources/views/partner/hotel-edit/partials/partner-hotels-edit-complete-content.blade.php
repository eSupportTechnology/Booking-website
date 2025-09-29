@extends('partner.partner-layout')

@section('title', ' Hotels Complete Registration | ' . config('domains.app_name'))

@section('content')
<section class="w-full px-4 py-8 max-w-2xl mx-auto lg:ml-32">
    <div class="max-w-3xl mx-auto mt-10 p-4 md:p-6 bg-white rounded-md shadow-sm border">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            You're almost there
        </h2>

        <p class="font-medium text-sm mb-6">To help you start earning, we'll make your property available for bookings for the next <span class="font-semibold">18 months</span>. This availability can also be adjusted after you open for bookings.</p>

        <!-- Heading above the list -->
        <p class="text-sm font-medium text-gray-800 mb-4">
            After you finish your registration you'll be able to:
        </p>
        <hr class="border-t border-gray-300 mb-4" />
        <ul class="space-y-6 text-sm text-gray-700">
            <li>
                <div class="flex items-start gap-4">
                    <div class="pt-1">
                        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
                    </div>
                    <div>
                        <p class="text-sm">Manage your property from your dashboard</p>
                    </div>
                </div>
            </li>

            <li>
                <div class="flex items-start gap-4">
                    <div class="pt-1">
                        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
                    </div>
                    <div>
                        <p class="text-sm">Receive bookings and make money from guests browsing our site</p>
                    </div>
                </div>
            </li>

            <li>
                <div class="flex items-start gap-4">
                    <div class="pt-1">
                        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
                    </div>
                    <div>
                        <p class="text-sm">
                            Stay on top of bookings from all the sites you use by syncing your calendar
                        </p>
                    </div>
                </div>
            </li>
        </ul>

        <div class="mt-6 space-y-4 text-sm text-gray-700">
            <hr class="border-t border-gray-300 mb-4" />
            <label class="flex items-start gap-2">
                <input type="checkbox" class="mt-1 accent-blue-600">
                <span>
                    I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. {{ config('domains.domain') }} B.V. reserves the right to verify and investigate any details provided in this registration.
                </span>
            </label>

            <label class="flex items-start gap-2">
                <input type="checkbox" class="mt-1 accent-blue-600">
                <span>
                    I have read, accepted, and agreed to the <a href="#" class="text-blue-600 hover:underline">General Delivery Terms</a>.
                </span>
            </label>
        </div>
    </div>

    <!-- Button Row -->
    <div class="mt-6">
        <div class="flex gap-4">
            <!-- Back Button -->
            <a href="{{ route('partner.hotels.edit.overview', $property->id) }}" 
               class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded">
                ←
            </a>

            <!-- Open for bookings Button (take remaining space) -->
            <a href="{{ route('open.booking', $property->id) }}"
               class="flex-1 px-6 py-3 bg-[#3CC0E9] text-white text-center font-semibold rounded-md hover:bg-[#29ACD5] transition">
                Open for bookings
            </a>
        </div>

        <!-- I'm not ready link -->
        <div class="mt-3 text-center">
            <a href="#" class="text-sky-500 hover:underline text-sm">I'm not ready</a>
        </div>
    </div>
</section>
@endsection