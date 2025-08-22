@extends('partner.partner-layout')

@section('title', 'Add Car | ' . config('domains.app_name'))

@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="carForm()">
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] border-r border-white h-2 transition-all duration-500"
            :style="'width:' + (step * 100 / 4) + '%'"></div>
    </div>

    <!-- Step 1: Car Info -->
    <template x-if="step === 1">

        <div class="px-6 py-6 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold">Enter Basic Information About the Car</h1>

            <div class="space-y-4">
                <!-- Car Type -->
                <div>
                    <label class="block text-sm  font-semibold mb-1">
                        Car Type <span class="text-red-500">*</span>
                    </label>
                    @foreach($car_types as $type)
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" x-model="car.car_type_id" value="{{ $type->id }}" class="form-radio text-blue-600">
                        <span class="ml-2">{{ $type->name }}</span>
                    </label>
                    @endforeach
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm  font-semibold mb-1">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.company_id">
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Select the rental company providing the car.</p>
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Brand <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.brand">
                        <option value="">-- Select Brand --</option>
                        @foreach($car_brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Select the manufacturer or brand of the car </p>
                </div>

                <!-- Model -->
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Model <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.model_id">
                        <option value="">-- Select Model --</option>
                        <template x-for="model in filteredModels" :key="model.id">
                            <option :value="model.id" x-text="model.model_name"></option>
                        </template>
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Select the specific model of the car (e.g., Corolla, Civic).</p>
                </div>

                <!-- Seats -->
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Seats <span class="text-red-500">*</span>
                    </label>
                    <input type="number" x-model="car.seats" placeholder="e.g., 4" class="w-full p-2 border rounded-md" min="2" max="20">
                    <p class="text-gray-500 text-sm mt-1">Enter the number of passengers the car can seat.</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ url()->previous() }}" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</a>
                <button @click.prevent="submitStep()"
                    class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">
                    Continue
                </button>
            </div>
        </div>
    </template>

    <!-- Step 2: Specifications -->
    <template x-if="step === 2">
        <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Provide Detailed Specifications and Features of the Car</h1>

            <div class="space-y-4">
                <!-- Transmission -->
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Transmission <span class="text-red-500">*</span>
                    </label>
                    <select x-model="car.transmission" class="w-full p-2 border rounded-md text-sm">
                        <option selected>Select Transmission</option>
                        <option>manual</option>
                        <option>automatic</option>
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Select the type of transmission (Manual or Automatic).</p>
                </div>

                <!-- Mileage Type -->
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Mileage Type <span class="text-red-500">*</span>
                    </label>
                    <select x-model="car.mileage_type" class="w-full p-2 border rounded-md text-sm">
                        <option selected>Select Mileage Type</option>
                        <option>unlimited</option>
                        <option>limited</option>
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Choose whether the mileage is unlimited or limited.</p>
                </div>

                <!-- Fuel Type -->
                <div>
                    <label class="block font-semibold text-sm mb-1">
                        Fuel Type <span class="text-red-500">*</span>
                    </label>
                    <select x-model="car.fuel_type" class="w-full p-2 border rounded-md text-sm">
                        <option selected>Select Fuel Type</option>
                        <option>petrol</option>
                        <option>diesel</option>
                        <option>electric</option>
                        <option>hybrid</option>
                    </select>
                    <p class="text-gray-500 text-sm mt-1">Choose the fuel type of the car.</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>
    
    <!-- Step 3: Car Type Image Selection -->
    <template x-if="step === 3">
        <div class="px-6 py-8 mt-6 w-full max-w-4xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Select a demo image to represent the car for the listing</h1>


            <p class="text-gray-500 text-sm mt-2">Click on a car image to select it as the demo photo for this listing.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Small Car -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '4' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='4'">
                    <img src="{{ asset('images/4.jpg') }}" alt="Small Car" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '4'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- Sedan -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '3' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='3'">
                    <img src="{{ asset('images/3.jpg') }}" alt="Sedan" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '3'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- SUV -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '2' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='2'">
                    <img src="{{ asset('images/2.jpg') }}" alt="SUV" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '2'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- Van / People Carrier -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '1' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='1'">

                    <img src="{{ asset('images/1.jpg') }}" alt="Van" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '1'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Small Car -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '6' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='6'">
                    <img src="{{ asset('images/6.jpg') }}" alt="Small Car" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '6'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- Sedan -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '5' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='5'">
                    <img src="{{ asset('images/5.jpg') }}" alt="Sedan" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '5'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- SUV -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === 'suv' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='7'">
                    <img src="{{ asset('images/7.jpg') }}" alt="SUV" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '7'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>

                <!-- Van / People Carrier -->
                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '8' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='8'">

                    <img src="{{ asset('images/8.jpg') }}" alt="Van" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '8'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '10' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='10'">
                    <img src="{{ asset('images/10.jpg') }}" alt="SUV" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '10'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>


                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '9' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='9'">

                    <img src="{{ asset('images/9.jpg') }}" alt="Van" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '9'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mt-2"> If your car is not above list, please select this.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div
                    class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                    :class="selectedImage === '11' ? 'ring-4 ring-blue-500' : ''"
                    @click="selectedImage='11'">
                    <img src="{{ asset('images/11.jpg') }}" alt="Sedan" class="w-full h-32 object-cover rounded-lg">

                    <span x-show="selectedImage === '11'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                </div>
            </div>


            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>


   <!-- Step 4: Pricing & Submit -->
    <template x-if="step === 4">
        <div class="px-6 py-8 mt-6 w-full max-w-xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Set Rental Pricing and Complete Submission</h1>

            <div>
                <label class="block font-semibold text-sm mb-1">Select Pricing Type <span class="text-red-500">*</span></label>
                <select x-model="car.pricingType" class="w-full p-2 border rounded-md text-sm ">
                    <option disabled selected>Select an option</option>
                    <option value="perDay">Price Per Day</option>
                    <option value="perKm">Price Per Kilometer</option>
                </select>
                <p class="text-gray-500 text-sm mt-1">Choose whether you want to set a daily rate or a per kilometer rate.</p>
            </div>

            <div class="space-y-4 mt-4">
                <div x-show="car.pricingType === 'perDay'" class="transition-all">
                    <label class="block font-semibold text-sm mb-1">Price Per Day <span class="text-red-500">*</span></label>
                    <input type="number" x-model="car.pricePerDay" placeholder="e.g., 16,948.72" class="w-full p-2 border rounded-lg" step="0.01">
                    <p class="text-gray-500 text-sm mt-1">Enter the daily rental price of the car.</p>
                </div>

                <div x-show="car.pricingType === 'perKm'" class="transition-all">
                    <label class="block font-semibold text-sm mb-1">Price Per Kilometer <span class="text-red-500">*</span></label>
                    <input type="number" x-model="car.pricePerKm" placeholder="e.g., 50.00" class="w-full p-2 border rounded-lg" step="0.01">
                    <p class="text-gray-500 text-sm mt-1">Enter the additional cost per kilometer.</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9]  text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Submit</button>
            </div>
        </div>
    </template>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function carForm() {
        return {
            step: 1,
            car_id: '',
            car: {
                car_type_id: '',
                company_id: '',
                brand: '',
                model_id: '',
                seats: '',
                price_per_day: '',
                deposit: 0,
                transmission: '',
                mileage_type: '',
                fuel_type: '',
                pricingType: '',
                pricePerDay: '',
                pricePerKm: '',
                deposit: 0
            },
            selectedImage: '',
            models: @json($car_models),
            get filteredModels() {
                if (!this.car.brand) {
                    return [];
                }
                return this.models.filter(m => m.brand_id == this.car.brand);
            },
            async submitStep() {
                try {
                    let response = await fetch("/cars/register-step", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            step: this.step,
                            car: this.car,
                            car_id: this.car_id ? this.car_id : '1',
                            selectedImage: this.selectedImage ? this.selectedImage : null,
                            pricingType: this.car.pricingType,
                            pricePerDay: this.car.pricePerDay,
                            pricePerKm: this.car.pricePerKm,
                            deposit: this.car.deposit
                        })
                    });
                    let data = await response.json();
                    if (data.success) {
                        if (this.step === 4) {
                            Swal.fire({
                                title: "Car added successfully!",
                                text: "Do you want to add more cars?",
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonText: "Yes, add more",
                                cancelButtonText: "No, finish"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.step = 1;
                                    this.car = {
                                        car_type_id: '',
                                        company_id: '',
                                        brand: '',
                                        model_id: '',
                                        seats: '',
                                        price_per_day: '',
                                        deposit: 0,
                                        transmission: '',
                                        mileage_type: '',
                                        fuel_type: '',
                                        pricingType: '',
                                        pricePerDay: '',
                                        pricePerKm: '',
                                        deposit: 0
                                    };
                                    this.selectedImage = '';
                                } else {
                                    window.location.href = "/carrentals/types";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: data.message || "Step submitted successfully.",
                                icon: "success",
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.car_id = data.car;
                            this.step++;
                        }
                    } else {
                        Swal.fire({
                            title: data.message || "An error occurred.",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 3000
                        });
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire({
                        title: "An error occurred while submitting the step.",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        icon: "error",
                        timer: 3000
                    });
                }
            }
        }
    }
</script>

@endsection