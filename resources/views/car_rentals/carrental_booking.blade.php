@extends('Customer.master')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}" class="text-blue-600 mb-4 inline-block">← Back</a>

    {{-- Car Header --}}
    <div class="flex gap-6 bg-white shadow-md p-5 rounded-lg mb-6">
        <img src="{{ asset('storage/' . $car->car_front) }}" 
             class="w-48 h-32 object-cover rounded-lg" 
             onerror="this.src='https://placehold.co/400x250'">

        <div>
            <h1 class="text-2xl font-bold">{{ $car->model->model_name }}</h1>
            <p class="text-gray-500">{{ $car->carType->name }}</p>
            <p class="text-sm mt-2">Supplier: <strong>{{ $car->company->name }}</strong></p>
        </div>
    </div>

    {{-- Booking Form --}}
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-xl font-bold mb-4">Complete your booking</h2>

        <form action="{{ route('customer.car.book.store', $car->id) }}" method="POST">
            @csrf

            {{-- Pickup --}}
            <div class="mb-4">
                <label class="font-semibold">Pickup Location</label>
                <input type="text" name="pickup_location" class="w-full p-2 border rounded" required>
            </div>

            {{-- Dropoff --}}
            <div class="mb-4">
                <label class="font-semibold">Dropoff Location</label>
                <input type="text" name="dropoff_location" class="w-full p-2 border rounded" required>
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Pickup Date & Time</label>
                    <input type="datetime-local" name="pickup_datetime" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="font-semibold">Dropoff Date & Time</label>
                    <input type="datetime-local" name="dropoff_datetime" class="w-full p-2 border rounded" required>
                </div>
            </div>

            {{-- Submit --}}
            <button class="w-full bg-blue-600 text-white p-3 rounded-lg font-semibold hover:bg-blue-700">
                Confirm Booking
            </button>
        </form>
    </div>

</div>
@endsection
