@extends('partner.partner-layout')

@section('title', ' Hotels Edit | ' . config('domains.app_name'))

@section('content')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  

<div x-data="{ step: 1 }">
    <div class="mt-16">
        <div class="max-w-3xl mx-auto p-4 space-y-4 ">

            <!-- Step 1 - Completed -->
            <div class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                        class="w-6 h-6 md:w-7 md:h-7" />
                    <div>
                        <p class="text-sm text-gray-500">Step 1</p>
                        <h2 class="text-base font-semibold">Property details</h2>
                        <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities and
                            more</p>
                    </div>
                </div>
                <a href="{{ route('partner.alternative.multiple.boats.sameaddress') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
            </div>

            <div class="border border-gray-300 rounded-lg p-4 flex flex-col gap-6">

                <!-- Step 2 Header -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="assets/Group 3926.svg" alt="Icon" class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>

                </div>

                <!-- Room Card -->
                <div class="space-y-4 ">

                    <!-- Room Card 1 -->
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-100 ">
                        <!-- Room Image -->
                        <img src="{{ asset('images/room.jpg') }}" alt="Room Image"
                            class="w-24 h-24 object-cover rounded-md" />

                        <!-- Horizontal Info Table -->
                        <div class="flex-1 overflow-x-auto">
                            <p class="text-sm text-gray-600 font-semibold mb-2">Double Room</p>
                            <table class="w-full text-xs b">
                                <thead>
                                    <tr class="text-gray-500 text-left whitespace-nowrap">
                                        <th class="pr-6 border-r border-gray-300">Guests</th>
                                        <th class="pr-6 border-r border-gray-300">Beds</th>
                                        <th class="pr-6 border-r border-gray-300">Bathroom</th>
                                        <th class="pr-6 border-r border-gray-300">Price</th>
                                        <th class="pr-6 ">Rooms of this type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-gray-800 text-xs">
                                        <td class="pr-6 border-r border-gray-300">3</td>
                                        <td class="pr-6 border-r border-gray-300">1</td>
                                        <td class="pr-6 border-r border-gray-300">private</td>
                                        <td class="pr-6 border-r border-gray-300">$20</td>
                                        <td class="pr-6 border-gray-300">2</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 mt-4 sm:mt-0">
                            <button class="text-sky-600 text-sm hover:underline">Edit</button>
                            <button class="text-red-600 text-sm hover:underline">Delete</button>
                        </div>
                    </div>

                </div>

                <!-- Add Another Room -->
                <div class="text-right">

                    <a href="{{ route('partner.alternative.multiple.boat.room') }}">
                        <button
                            class="mt-4  text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">
                            + Add another room
                        </button></a>
                </div>
            </div>





            <!-- Step 3 - Photos -->
            <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                    <div>
                        <p class="text-sm text-gray-500">Step 3</p>
                        <h2 class="text-base font-semibold">Photos</h2>
                        <p class="text-xs text-gray-600">Share some photos of your property so guests know what to
                            expect.</p>
                    </div>
                </div>
                <a href="{{ route('partner.boat.photos') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>

            </div>

            <!-- Step 4 - Final -->
            <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                    <div>
                        <p class="text-sm text-gray-500">Step 4</p>
                        <h2 class="text-base font-semibold">Final steps</h2>
                        <p class="text-xs text-gray-600">Set up payments and invoicing before you open for bookings.
                        </p>
                    </div>
                </div>

                <a href="{{ route('partner.boat.payment') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
            </div>


            <div class="flex justify-center">
                <a href="{{ route('partner.boat.complete.registration') }}"
                  
                        class="mt-4 w-full  bg-[#3CC0E9] font-semibold text-white text-center rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                        Complete Registration
                  
                </a>
            </div>
        </div>
</div>
@endsection