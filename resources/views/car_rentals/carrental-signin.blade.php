@extends('frontend.carrental-layout')

@section('title', 'Car Renter Sign In | ' . config('app.name'))

@section('content')
<section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
    <div class="w-full max-w-md space-y-6">
        <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">
            <h2 class="text-xl font-semibold mb-2">Sign in to your car renter account</h2>

            <form method="POST" action="{{ route('carrentals.login.email.store') }}">
                @csrf
                <label for="email" class="block text-sm font-medium text-gray-700 mt-6 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
                       value="{{ old('email') }}"/>

                @error('email')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                        style="background-color:#3CC0E9;">
                    Next
                </button>
            </form>

            <div class="border-t border-gray-200 my-6"></div>
            <p class="text-xs text-gray-600 text-center">
                Don’t have an account?
                <a href="#" class="text-blue-600 hover:underline">Create one</a>
            </p>
        </div>
    </div>
</section>
@endsection
