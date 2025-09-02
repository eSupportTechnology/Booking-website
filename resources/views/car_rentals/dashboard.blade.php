@extends('frontend.carrental-layout')

@section('title', 'Car Renter Dashboard')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-4">Welcome to Car Renter Dashboard</h1>

        <p class="mb-4">You are successfully logged in as 
            <strong>{{ Auth::guard('car_renter')->user()->email }}</strong>
        </p>

        <form method="POST" action="{{ route('car_renter.logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Logout</button>
        </form>
    </div>
@endsection
