@extends('admin.master')

@section('content')
<div class="p-6 bg-[#1F8FB2] rounded shadow space-y-8">

    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-white">Partner Details</h2>

        <a href="{{ url('/admin/partners') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Partners
        </a>
    </div>

    <!-- Profile Section -->
    <div class="bg-white border rounded-lg shadow p-6 flex items-center space-x-6 relative">
        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#3CC0E9] shadow">
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500 text-2xl">{{ strtoupper(substr($partner->partner->first_name, 0, 1)) }}</span>
            </div>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800">{{ $partner->partner->first_name }} {{ $partner->partner->last_name }}</h3>
            @if($partner->properties->first() && $partner->properties->first()->accommodation)
                <p class="text-sm text-gray-600">
                    {{ $partner->properties->first()->accommodation->ownership_type === 'business_entity' ? 'Business Partner' : 'Individual Partner' }}
                </p>
            @endif
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🧾 Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">First Name:</h4>
                <p class="text-gray-700">{{ $partner->partner->first_name }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Last Name:</h4>
                <p class="text-gray-700">{{ $partner->partner->last_name }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $partner->email }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Phone:</h4>
                <p class="text-gray-700">{{ $partner->partner->contact_number ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Status:</h4>
                <div class="space-x-2 mt-1">
                    @if($partner->email_verified_at)
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                    @else
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending Verification</span>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Registered On:</h4>
                <p class="text-gray-700">{{ $partner->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📞 Contact Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Phone Number:</h4>
                <p class="text-gray-700">{{ $partner->partner->contact_number }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $partner->email }}</p>
            </div>
            @if($partner->properties->isNotEmpty() && $partner->properties->first()->address)
            <div>
                <h4 class="text-gray-800 font-medium">Primary Property Address:</h4>
                <p class="text-gray-700">{{ $partner->properties->first()->address }}</p>
                <p class="text-gray-700">{{ $partner->properties->first()->city }}, {{ $partner->properties->first()->country }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Business Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏢 Business Details</h3>
        @php
            $businessProperties = $partner->properties->filter(function($property) {
                return $property->accommodation &&
                       $property->accommodation->ownership_type === 'business_entity' &&
                       $property->accommodation->businessEntities->isNotEmpty();
            });
        @endphp

        @if($businessProperties->isNotEmpty())
            @foreach($businessProperties as $property)
                @foreach($property->accommodation->businessEntities as $entity)
                <div class="mb-8 last:mb-0">
                    <div class="border-b pb-2 mb-4">
                        <h4 class="text-lg font-medium text-gray-800">{{ $entity->business_name }}</h4>
                        @if($entity->trading_name)
                            <p class="text-sm text-gray-600">Trading as: {{ $entity->trading_name }}</p>
                        @endif
                        <p class="text-sm text-gray-500">Associated with property: {{ $property->title }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-gray-800 font-medium">Business Address:</h4>
                            <p class="text-gray-700">{{ $entity->address }}</p>
                        </div>
                        <div>
                            <h4 class="text-gray-800 font-medium">Location:</h4>
                            <p class="text-gray-700">{{ $entity->city }}, {{ $entity->country }} ({{ $entity->zip_code }})</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        @endif

        @php
            $individualProperties = $partner->properties->filter(function($property) {
                return $property->accommodation &&
                       $property->accommodation->ownership_type === 'individual' &&
                       $property->accommodation->individuals->isNotEmpty();
            });
        @endphp

        @if($individualProperties->isNotEmpty())
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Individual Property Owners</h3>
                @foreach($individualProperties as $property)
                    @foreach($property->accommodation->individuals as $individual)
                    <div class="mb-4 last:mb-0">
                        <div class="border-b pb-2 mb-2">
                            <h4 class="font-medium text-gray-800">{{ $individual->first_name }} {{ $individual->last_name }}</h4>
                            <p class="text-sm text-gray-500">Associated with property: {{ $property->title }}</p>
                        </div>
                        @if($individual->date_of_birth)
                        <p class="text-sm text-gray-600">Date of Birth: {{ \Carbon\Carbon::parse($individual->date_of_birth)->format('Y-m-d') }}</p>
                        @endif
                    </div>
                    @endforeach
                @endforeach
            </div>
        @endif

        @if($businessProperties->isEmpty() && $individualProperties->isEmpty())
            <p class="text-gray-500 italic">No business entities or individual owners registered</p>
        @endif
    </div>

    <!-- Properties Section -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏠 Listed Properties</h3>
        @if($partner->properties && $partner->properties->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Listed On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($partner->properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($property->photos->first())
                                        <img src="{{ asset('storage/' . $property->photos->first()->image_path) }}"
                                             alt="{{ $property->title }}"
                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <div>{{ $property->title }}</div>
                                        @if($property->accommodation)
                                            <div class="text-xs text-gray-500">
                                                @if($property->accommodation->businessEntities->isNotEmpty())
                                                    {{ $property->accommodation->businessEntities->first()->business_name }}
                                                @else
                                                    Individual Property
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->category->name ?? 'Not Set' }}</div>
                                @if($property->propertySubcategory)
                                    <div class="text-xs text-gray-500">{{ $property->propertySubcategory->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->city }}, {{ $property->country }}</div>
                                @if($property->zipcode)
                                    <div class="text-xs text-gray-500">{{ $property->zipcode }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $property->status === 'active' ? 'bg-green-100 text-green-800' :
                                       ($property->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $property->reviews->count() }} Reviews
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>{{ $property->created_at->format('Y-m-d') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $property->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic">No properties listed yet</p>
        @endif
    </div>
</div>
@endsection
