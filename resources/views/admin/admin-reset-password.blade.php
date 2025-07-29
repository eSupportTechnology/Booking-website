@extends('admin.auth-layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Reset Admin Password
            </h2>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div>
                <label for="email" class="sr-only">Email address</label>
                <input id="email" name="email" type="email" value="{{ $email }}" readonly
                       class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm bg-gray-100">
            </div>
            
            <div>
                <label for="password" class="sr-only">New Password</label>
                <input id="password" name="password" type="password" required
                       class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                       placeholder="New Password">
            </div>
            
            <div>
                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                       placeholder="Confirm Password">
            </div>

            @if (session('error'))
                <div class="text-red-600 text-sm">{{ session('error') }}</div>
            @endif

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection