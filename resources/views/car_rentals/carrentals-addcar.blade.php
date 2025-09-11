@extends('car_rentals.layout')

@section('title', 'Add Car | ' . config('app.name'))

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="carForm()">
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500" :style="'width:' + (step * 25) + '%'"></div>
    </div>

    <!-- Step 1: Car Info -->
    <template x-if="step === 1">
        <div class="px-6 py-6 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold">Enter Basic Information About the Car</h1>

            <div class="space-y-4">
                <!-- Car Type -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Car Type <span class="text-red-500">*</span></label>
                    @foreach($car_types as $type)
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" x-model="car.car_type_id" value="{{ $type->id }}" class="form-radio text-blue-600">
                        <span class="ml-2">{{ $type->name }}</span>
                    </label>
                    @endforeach
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Company <span class="text-red-500">*</span></label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.company_id">
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Brand <span class="text-red-500">*</span></label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.brand">
                        <option value="">-- Select Brand --</option>
                        @foreach($car_brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Model -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Model <span class="text-red-500">*</span></label>
                    <select class="w-full p-2 border rounded-md text-sm" x-model="car.model_id">
                        <option value="">-- Select Model --</option>
                        <template x-for="model in filteredModels" :key="model.id">
                            <option :value="model.id" x-text="model.model_name"></option>
                        </template>
                    </select>
                </div>

                <!-- Seats -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Seats <span class="text-red-500">*</span></label>
                    <input type="number" x-model.number="car.seats" placeholder="e.g., 4" class="w-full p-2 border rounded-md" min="2" max="20">
                </div>

                <!-- With Driver -->
                <div>
                    <label class="block text-sm font-semibold mb-1">With Driver? <span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" x-model="car.with_driver" value="yes">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" x-model="car.with_driver" value="no">
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <!-- Driver Details -->
                <div x-show="car.with_driver === 'yes'" x-cloak class="space-y-4 p-4 border rounded-lg bg-gray-50">
                    <div>
                        <label>Driver Name</label>
                        <input type="text" x-model="car.driver_name" placeholder="Enter driver name" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label>Phone Number</label>
                        <input type="text" x-model="car.driver_phone" placeholder="Enter phone number" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Age</label>
                            <input type="number" x-model.number="car.driver_age" placeholder="Enter age" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>Experience (Years)</label>
                            <input type="number" x-model.number="car.driver_experience" placeholder="Enter years of experience" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label>NIC Number</label>
                        <input type="text" x-model="car.driver_nic" placeholder="Enter NIC number" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ url()->previous() }}" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</a>
                <button @click.prevent="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 2: Specifications -->
    <template x-if="step === 2">
        <div class="px-6 py-8 mt-6 w-full bg-white max-w-xl mx-auto lg:ml-24 space-y-6 rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Provide Detailed Specifications</h1>

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold text-sm mb-1">Transmission <span class="text-red-500">*</span></label>
                    <select x-model="car.transmission" class="w-full p-2 border rounded-md text-sm">
                        <option value="">Select Transmission</option>
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">Mileage Type <span class="text-red-500">*</span></label>
                    <select x-model="car.mileage_type" class="w-full p-2 border rounded-md text-sm">
                        <option value="">Select Mileage Type</option>
                        <option value="unlimited">Unlimited</option>
                        <option value="limited">Limited</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-1">Fuel Type <span class="text-red-500">*</span></label>
                    <select x-model="car.fuel_type" class="w-full p-2 border rounded-md text-sm">
                        <option value="">Select Fuel Type</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 3: Image Selection -->
    <template x-if="step === 3">
        <div class="px-6 py-8 mt-6 w-full max-w-4xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Select a Car Image</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @for($i = 1; $i <= 11; $i++)
                    <div
                        class="border rounded-lg p-2 cursor-pointer hover:ring-2 hover:ring-blue-400 relative"
                        :class="selectedImage === '{{ $i }}' ? 'ring-4 ring-blue-500' : ''"
                        @click="selectedImage='{{ $i }}'">
                        <img src="{{ asset('images/'.$i.'.jpg') }}" class="w-full h-32 object-cover rounded-lg">
                        <span x-show="selectedImage === '{{ $i }}'" class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Selected</span>
                    </div>
                @endfor
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Continue</button>
            </div>
        </div>
    </template>

    <!-- Step 4: Pricing -->
    <template x-if="step === 4">
        <div class="px-6 py-8 mt-6 w-full max-w-xl mx-auto lg:ml-24 space-y-6 bg-white rounded-lg shadow border">
            <h1 class="text-2xl font-bold mb-2">Set Rental Pricing</h1>

            <div>
                <label class="block font-semibold text-sm mb-1">Select Pricing Type <span class="text-red-500">*</span></label>
                <select x-model="car.pricingType" class="w-full p-2 border rounded-md text-sm">
                    <option value="">Select an option</option>
                    <option value="perDay">Price Per Day</option>
                    <option value="perKm">Price Per Kilometer</option>
                </select>
            </div>

            <div class="space-y-4 mt-4">
                <div x-show="car.pricingType === 'perDay'">
                    <label class="block font-semibold text-sm mb-1">Price Per Day <span class="text-red-500">*</span></label>
                    <input type="number" x-model="car.pricePerDay" class="w-full p-2 border rounded-md" step="0.01">
                </div>
                <div x-show="car.pricingType === 'perKm'">
                    <label class="block font-semibold text-sm mb-1">Price Per Kilometer <span class="text-red-500">*</span></label>
                    <input type="number" x-model="car.pricePerKm" class="w-full p-2 border rounded-md" step="0.01">
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="step--" class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">←</button>
                <button @click="submitStep()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition">Submit</button>
            </div>
        </div>
    </template>
</div>

<script>
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
            with_driver: '',
            driver_name: '',
            driver_phone: '',
            driver_age: '',
            driver_experience: '',
            driver_nic: '',
            transmission: '',
            mileage_type: '',
            fuel_type: '',
            pricingType: '',
            pricePerDay: '',
            pricePerKm: '',
        },
        selectedImage: '',
        models: @json($car_models),
        get filteredModels() {
            return this.car.brand ? this.models.filter(m => m.brand_id == this.car.brand) : [];
        },
        async submitStep() {
        if (this.step === 1 && this.car.with_driver === 'no') {
        this.car.driver_name = null;
        this.car.driver_phone = null;
        this.car.driver_age = null;
        this.car.driver_experience = null;
        this.car.driver_nic = null;
    }
            try {
                const response = await fetch("/cars/register-step", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
                    },
            body: JSON.stringify({
    step: this.step,
    car: this.car,
    car_id: this.car_id, // ✅ included
    selectedImage: this.selectedImage,
    pricingType: this.car.pricingType,
    pricePerDay: this.car.pricePerDay,
    pricePerKm: this.car.pricePerKm,
    deposit: this.car.deposit ?? 0
})


                });
                const data = await response.json();

                if(data.success){
                    if(this.step === 4){
                        Swal.fire({
                            title: "Car added successfully!",
                            text: "Do you want to add more cars?",
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonText: "Yes",
                            cancelButtonText: "No"
                        }).then((result)=>{
                            if(result.isConfirmed){
                                this.step=1;
                                this.car = {
                                    car_type_id:'', company_id:'', brand:'', model_id:'', seats:'', with_driver:'',
                                    driver_name:'', driver_phone:'', driver_age:'', driver_experience:'', driver_nic:'',
                                    transmission:'', mileage_type:'', fuel_type:'', pricingType:'', pricePerDay:'', pricePerKm:''
                                };
                                this.selectedImage='';
                            } else {
                                window.location.href="/my/car-rentals";
                            }
                        });
                    } else {
                     this.car_id = data.car_id; // correct key from backend

                        this.step++;
                        Swal.fire({
                            title: data.message || "Step submitted",
                            icon: "success",
                            toast: true,
                            position: "top-end",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                } else {
                    Swal.fire({
                        title: data.message || "Error occurred",
                        icon: "error",
                        toast:true,
                        position:"top-end",
                        timer:2000,
                        showConfirmButton:false
                    });
                }

            } catch (err) {
                console.error(err);
                Swal.fire({
                    title: "Error submitting step",
                    icon:"error",
                    toast:true,
                    position:"top-end",
                    timer:2000,
                    showConfirmButton:false
                });
            }
        }
    }
}
</script>

@endsection
