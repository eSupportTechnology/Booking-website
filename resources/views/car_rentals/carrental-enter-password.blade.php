@extends('frontend.carrental-layout')

@section('title', 'Enter Password | ' . config('domains.app_name'))

@section('content')
<section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
    <div class="w-full max-w-md space-y-6">
        <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">
            <h2 class="text-xl font-semibold mb-2">Enter your password</h2>
            <p class="text-gray-600 text-sm">Please enter your {{ config('domains.domain') }} password for</p>
            <p class="text-gray-600 text-sm mb-6 font-bold">{{ $email }}</p>

            <form method="POST" action="{{ route('carrentals.login.password.submit') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}"/>

                <div class="mb-4 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter your password"/>
                </div>

                <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                        style="background-color:#3CC0E9;">
                    Sign in
                </button>
            </form>

            <div class="border-t border-gray-200 my-6"></div>
            <p class="text-xs text-gray-600 text-center">
                By signing in you agree with our
                <a href="#" class="text-blue-600 hover:underline">Terms & conditions</a> and
                <a href="#" class="text-blue-600 hover:underline">Privacy statement</a>
            </p>
        </div>
    </div>
</section>
@endsection
