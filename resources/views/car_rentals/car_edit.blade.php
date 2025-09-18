@extends('car_rentals.master')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
        @csrf
        @method('PUT')

        <!-- ===================== Main Container ===================== -->
        <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 space-y-6">

            <!-- ===================== Basic Information ===================== -->
            <div>
                <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Edit Car Information</h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left: Car Details -->
                    <div>
                        <!-- Car Type -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Car Type</label>
                            <select name="car_type_id" class="w-full border rounded p-2 text-sm sm:text-base">
                                @foreach($car_types as $type)
                                    <option value="{{ $type->id }}" {{ $car->car_type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Company -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Company</label>
                            <select name="company_id" class="w-full border rounded p-2 text-sm sm:text-base">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ $car->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Brand</label>
                            <select name="brand_id" class="w-full border rounded p-2 text-sm sm:text-base">
                                @foreach($car_brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Model</label>
                            <select name="model_id" class="w-full border rounded p-2 text-sm sm:text-base">
                                @foreach($car_models as $model)
                                    <option value="{{ $model->id }}" {{ $car->model_id == $model->id ? 'selected' : '' }}>
                                        {{ $model->model_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Seats -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Seats</label>
                            <input type="number" name="seats" value="{{ $car->seats }}" class="w-full border rounded p-2 text-sm sm:text-base">
                        </div>

                        <!-- Transmission -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Transmission</label>
                            <select name="transmission" class="w-full border rounded p-2 text-sm sm:text-base">
                                <option value="manual" {{ $car->transmission == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ $car->transmission == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            </select>
                        </div>

                        <!-- Fuel Type -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Fuel Type</label>
                            <select name="fuel_type" class="w-full border rounded p-2 text-sm sm:text-base">
                                <option value="petrol" {{ $car->fuel_type == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel" {{ $car->fuel_type == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ $car->fuel_type == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ $car->fuel_type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>

                        <!-- Mileage -->
                        <div class="mb-4">
                            <label class="block font-semibold mb-1 text-sm sm:text-base">Mileage Type</label>
                            <select name="mileage_type" class="w-full border rounded p-2 text-sm sm:text-base">
                                <option value="unlimited" {{ $car->mileage_type == 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                                <option value="limited" {{ $car->mileage_type == 'limited' ? 'selected' : '' }}>Limited</option>
                            </select>
                        </div>
                    </div>

                    <!-- Right: Car Images -->
                    <div class="space-y-4">
                        <h3 class="text-base sm:text-lg font-semibold mb-2">Car Images</h3>

                     <!-- Front Image -->
<div>
    <label class="block font-semibold mb-1 text-sm">Front View</label>
    <div class="mb-2">
        @if($car->car_front)
            <img src="{{ asset('storage/' . $car->car_front) }}" 
                 alt="Car Front" 
                 class="w-full h-56 object-cover rounded">
        @else
            <div class="w-full h-40 bg-gray-100 rounded border flex items-center justify-center text-gray-400">
                No Image
            </div>
        @endif
    </div>
    <input type="file" name="car_front" class="w-full text-sm">
</div>

<!-- Back Image -->
<div>
    <label class="block font-semibold mb-1 text-sm">Back View</label>
    <div class="mb-2">
        @if($car->car_back)
            <img src="{{ asset('storage/' . $car->car_back) }}" 
                 alt="Car Back" 
                 class="w-full h-56 object-cover rounded">
        @else
            <div class="w-full h-40 bg-gray-100 rounded border flex items-center justify-center text-gray-400">
                No Image
            </div>
        @endif
    </div>
    <input type="file" name="car_back" class="w-full text-sm">
</div>

<!-- Inside Image -->
<div>
    <label class="block font-semibold mb-1 text-sm">Inside View</label>
    <div class="mb-2">
        @if($car->car_inside)
            <img src="{{ asset('storage/' . $car->car_inside) }}" 
                 alt="Car Inside" 
                 class="w-full h-56 object-cover rounded">
        @else
            <div class="w-full h-40 bg-gray-100 rounded border flex items-center justify-center text-gray-400">
                No Image
            </div>
        @endif
    </div>
    <input type="file" name="car_inside" class="w-full text-sm">
</div>



                    </div>
                </div>
            </div>

            <!-- ===================== Driver Details (if with_driver) ===================== -->
            @if($car->with_driver === 'yes')
            <div>
                <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Driver Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Driver Name</label>
                        <input type="text" name="driver_name" value="{{ $car->driver_name }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Driver Phone</label>
                        <input type="text" name="driver_phone" value="{{ $car->driver_phone }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Driver Age</label>
                        <input type="number" name="driver_age" value="{{ $car->driver_age }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Driver Experience (Years)</label>
                        <input type="number" name="driver_experience" value="{{ $car->driver_experience }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Driver NIC</label>
                        <input type="text" name="driver_nic" value="{{ $car->driver_nic }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                </div>
            </div>
            @endif

            <!-- ===================== Pricing ===================== -->
            <div>
                <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Pricing</h2>

                <!-- Pricing Type -->
               <div class="mb-4 w-1/2">
    <label class="block font-semibold mb-1 text-sm sm:text-base">Pricing Type</label>
    <select name="pricingType" class="w-full border rounded p-2 text-sm sm:text-base">
        <option value="perDay" {{ $car->pricingType == 'perDay' ? 'selected' : '' }}>Per Day</option>
        <option value="perKm" {{ $car->pricingType == 'perKm' ? 'selected' : '' }}>Per Km</option>
    </select>
</div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Price Per Day</label>
                        <input type="number" name="pricePerDay" value="{{ $car->pricePerDay }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-sm sm:text-base">Price Per Km</label>
                        <input type="number" name="pricePerKm" value="{{ $car->pricePerKm }}" class="w-full border rounded p-2 text-sm sm:text-base">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
                <a href="/my/car-rentals" class="bg-gray-500 text-white px-6 py-2 rounded-lg text-center">Back</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>

        </div>
    </form>
</div>
@endsection
