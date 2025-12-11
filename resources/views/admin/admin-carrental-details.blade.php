@extends('admin.master')
@section('title', 'Car Rental Details')
@section('content')

<section class="min-h-screen p-4 sm:p-6 bg-gray-50">
    <div class="space-y-6 sm:space-y-8">

        <!-- Breadcrumb -->
        <nav class="flex flex-wrap text-sm sm:text-base mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 sm:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                </li>

                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <a href="{{ route('admin.rental.carrentals') }}" class="text-gray-700 hover:text-blue-600">
                            Car Rentals
                        </a>
                    </div>
                </li>

                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-gray-500">Car Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Vehicle Basic Info -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Vehicle Details</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base">
                    <p><span class="font-semibold">Vehicle ID:</span> #C{{ $car->id }}</p>
                    <p><span class="font-semibold">Brand:</span> {{ $car->brand?->brand_name }}</p>
                    <p><span class="font-semibold">Model:</span> {{ $car->model?->model_name }}</p>
                    <p><span class="font-semibold">Vehicle Type:</span> {{ $car->type?->name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Number Plate:</span> {{ $car->number_plate }}</p>
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span class="px-2 py-1 rounded-full text-white text-xs sm:text-sm
                            @if($car->status == 'Active') bg-green-500 
                            @elseif($car->status == 'Inactive') bg-yellow-500 
                            @else bg-red-500 @endif">
                            {{ $car->status }}
                        </span>
                    </p>

                    <p>
                        <span class="font-semibold">Approval Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $car->approval_status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($car->approval_status) }}
                        </span>
                    </p>
                </div>

                <div class="flex items-center justify-center">
                    <img src="{{ asset('storage/' . $car->car_front) }}"
                         alt="Car Image"
                         class="rounded-lg shadow-md w-full max-w-xs sm:max-w-sm md:max-w-md h-48 object-cover">
                </div>

            </div>
        </div>

        <!-- Owner Details -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Owner Details</h2>

            @php $owner = $car->renter; @endphp

            @if($owner)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">

                    @if($owner->account_type === 'company')
                        <p><span class="font-semibold">Company Name:</span> {{ $owner->company_name }}</p>
                        <p><span class="font-semibold">Business Reg. No:</span> {{ $owner->business_reg_no }}</p>
                        <p><span class="font-semibold">TIN Number:</span> {{ $owner->tin_number }}</p>
                        <p><span class="font-semibold">Company Phone:</span> {{ $owner->phone }}</p>
                        <p><span class="font-semibold">Address:</span> {{ $owner->address }}</p>
                    @else
                        <p><span class="font-semibold">Full Name:</span> {{ $owner->full_name }}</p>
                        <p><span class="font-semibold">NIC:</span> {{ $owner->nic_number }}</p>
                        <p><span class="font-semibold">Phone:</span> {{ $owner->phone }}</p>
                        <p><span class="font-semibold">Address:</span> {{ $owner->address }}</p>
                    @endif

                </div>
            @else
                <p class="text-gray-500">No owner information available.</p>
            @endif
        </div>

        <!-- Driver Details -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">

            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Driver Details</h2>

            @if($car->driver_name)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                    <p><span class="font-semibold">Driver Name:</span> {{ $car->driver_name }}</p>
                    <p><span class="font-semibold">Contact Number:</span> {{ $car->driver_phone }}</p>
                    <p><span class="font-semibold">NIC:</span> {{ $car->driver_nic }}</p>
                    <p><span class="font-semibold">Experience:</span> {{ $car->driver_experience }} years</p>
                </div>
            @else
                <p class="text-gray-500">No driver assigned to this vehicle.</p>
            @endif

        </div>

        <!-- Pricing Details -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Pricing Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-sm sm:text-base">
                <p><span class="font-semibold">Pricing Type:</span> {{ $car->pricing_type }}</p>
                <p><span class="font-semibold">Price per Day:</span> LKR {{ number_format($car->price_per_day) }}</p>
                <p><span class="font-semibold">Price per KM:</span> LKR {{ number_format($car->price_per_km) }}</p>
                <p><span class="font-semibold">Refundable Deposit:</span> LKR {{ number_format($car->deposit) }}</p>
            </div>
        </div>

        <!-- Vehicle Images -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Vehicle Images</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div class="text-center">
                    <p class="font-semibold mb-2">Front</p>
                    <img src="{{ $car->car_front ? asset('storage/'.$car->car_front) : asset('assets/default-car.jpg') }}"
                        class="rounded shadow-md h-40 object-cover w-full">
                </div>

                <div class="text-center">
                    <p class="font-semibold mb-2">Back</p>
                    <img src="{{ $car->car_back ? asset('storage/'.$car->car_back) : asset('assets/default-car.jpg') }}"
                        class="rounded shadow-md h-40 object-cover w-full">
                </div>

                <div class="text-center">
                    <p class="font-semibold mb-2">Inside</p>
                    <img src="{{ $car->car_inside ? asset('storage/'.$car->car_inside) : asset('assets/default-car.jpg') }}"
                        class="rounded shadow-md h-40 object-cover w-full">
                </div>

            </div>

        </div>

        <!-- Back Button -->
        <div class="mt-4 sm:mt-6">
            <a href="{{ route('admin.rental.carrentals') }}"
               class="bg-[#1F8FB2] hover:bg-[#157799] text-white px-4 py-2 rounded shadow text-sm sm:text-base">
                ← Back to Vehicle List
            </a>
        </div>

    </div>
</section>

@endsection
