@extends('frontend.carrental-layout')

@section('title', 'Enter Password | ' . config('app.name'))

@section('content')
<section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
    <div class="w-full max-w-md space-y-6">
        <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">
            <h2 class="text-xl font-semibold mb-2">Enter your password</h2>
            <p class="text-gray-600 text-sm">Please enter your password for</p>
            <p class="text-gray-600 text-sm mb-6 font-bold">{{ $email }}</p>

            <form method="POST" action="{{ route('carrentals.login.password.submit') }}">
                @csrf

                <div class="mb-4 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter your password"/>
                    @error('password')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                        style="background-color:#3CC0E9;">
                    Sign in
                </button>
                <a href="{{ route('partner.password.request') }}"
                        class="block text-center text-blue-600 hover:underline mt-4">
                        Forgotten your password?
                    </a>
            </form>
             <div class="border-t border-gray-200 my-6"></div>

                <p class="text-xs text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
                    By signing in or creating an account, you agree with our
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>
                </p>

                <p class="text-[11px] text-gray-400 text-center mt-4" style="font-family: 'Noto Sans', sans-serif;">
                    All rights reserved.</p>

                <p class="text-[11px] text-gray-400 text-center mt-1" style="font-family: 'Noto Sans', sans-serif;">
                    Copyright (2006 – 2025){{ config('domains.domain') }}™</p>
            </div>
        </div>
    </div>
</section>
@endsection
