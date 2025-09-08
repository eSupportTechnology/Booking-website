@extends('car_rentals.master')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4">{{ $car->brand->brand_name ?? '' }} {{ $car->model->model_name ?? '' }}</h2>
    <p><strong>Car Type:</strong> {{ $car->carType->name ?? '' }}</p>
    <p><strong>Fuel Type:</strong> {{ $car->fuel_type }}</p>
    <p><strong>Seats:</strong> {{ $car->seats }}</p>
    <p><strong>Status:</strong> {{ $car->is_active ? 'Active' : 'Inactive' }}</p>
    <p><strong>Address:</strong> {{ $car->company->address ?? 'N/A' }}</p>

    <div class="mt-6">
        <a href="#" class="bg-gray-600 text-white px-4 py-2 rounded-lg">← Back</a>
    </div>
</div>
@endsection
