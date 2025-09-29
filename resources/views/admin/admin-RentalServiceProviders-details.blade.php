@extends('admin.master')
@section('title', 'Rental Service Provider Details')
@section('content')

<section class="min-h-screen p-4 bg-white rounded-lg shadow-lg">
    <div class="space-y-6 p-2 sm:p-4">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap mb-3 sm:mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center flex-wrap space-x-1 md:space-x-3 text-xs sm:text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <a href="{{ route('admin.rental-providers') }}" class="text-gray-700 hover:text-blue-600">Rental Service Providers</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs sm:text-sm"></i>
                        <span class="text-gray-500">Provider Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-6 leading-tight">
            Rental Service Provider Details - #{{ $provider->id }}
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Provider Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                @if($provider->isCompany()) bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($provider->account_type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-sm text-gray-900">{{ $provider->email }}</p>
                        </div>
                        @if($provider->isCompany())
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <p class="text-sm text-gray-900">{{ $provider->company_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Registration No</label>
                            <p class="text-sm text-gray-900">{{ $provider->business_reg_no ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">TIN Number</label>
                            <p class="text-sm text-gray-900">{{ $provider->tin_number ?? 'N/A' }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <p class="text-sm text-gray-900">{{ $provider->full_name }}</p>
                        </div>
                        @if($provider->nic_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIC Number</label>
                            <p class="text-sm text-gray-900">{{ $provider->nic_number }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <p class="text-sm text-gray-900">{{ $provider->phone }}</p>
                        </div>
                        @if($provider->phone2)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone 2</label>
                            <p class="text-sm text-gray-900">{{ $provider->phone2 }}</p>
                        </div>
                        @endif
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <p class="text-sm text-gray-900">{{ $provider->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cars Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Cars ({{ $provider->cars->count() }})</h2>
                    @if($provider->cars->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Brand</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Price/Day</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($provider->cars as $car)
                                <tr>
                                    <td class="px-4 py-2">#{{ $car->id }}</td>
                                    <td class="px-4 py-2">{{ $car->carType->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $car->brand->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            @if($car->status === 'Active') bg-green-100 text-green-800 
                                            @elseif($car->status === 'Inactive') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">${{ number_format($car->price_per_day, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No cars registered</p>
                    @endif
                </div>

                <!-- Taxis Section -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Taxis ({{ $provider->taxis->count() }})</h2>
                    @if($provider->taxis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Number Plate</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Capacity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($provider->taxis as $taxi)
                                <tr>
                                    <td class="px-4 py-2">#{{ $taxi->id }}</td>
                                    <td class="px-4 py-2">{{ $taxi->type->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $taxi->number_plate ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            @if($taxi->status === 'Active') bg-green-100 text-green-800 
                                            @elseif($taxi->status === 'Inactive') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $taxi->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $taxi->passenger_capacity ?? 'N/A' }} passengers</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No taxis registered</p>
                    @endif
                </div>
            </div>

            <!-- Summary Card -->
            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Cars</span>
                            <span class="font-semibold">{{ $provider->cars->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Taxis</span>
                            <span class="font-semibold">{{ $provider->taxis->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Cars</span>
                            <span class="font-semibold">{{ $provider->cars->where('status', 'Active')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Active Taxis</span>
                            <span class="font-semibold">{{ $provider->taxis->where('status', 'Active')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Member Since</span>
                            <span class="font-semibold">{{ $provider->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($provider->isCompany() && $provider->company_logo)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Company Logo</h2>
                    <img src="{{ asset('storage/' . $provider->company_logo) }}" alt="Company Logo" class="w-full h-32 object-contain">
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection