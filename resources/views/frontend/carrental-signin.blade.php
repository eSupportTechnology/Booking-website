@extends('frontend.carrental-layout')

@section('title', ' Company Signin | ' . config('domains.app_name'))

@section('content')

<!-- Form Section -->
    <section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
        <div class="w-full max-w-md space-y-6">


            <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">

                <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Sign in to manage
                    your car</h2>


                <form method="POST" action="#">
                    @csrf
                    <label for="email" class="block text-sm font-medium text-gray-700 mt-6 mb-2"
                        style="font-family: 'Noto Sans', sans-serif;">Username</label>
                    <input type="email" id="email" name="email" required
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" />

                    <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                        style=" background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
                        Next
                    </button>

                    <button type="submit"
                        class="w-full text-blue-600 font-semibold text-sm py-2 rounded mt-4 bg-white hover:bg-blue-100 transition-colors duration-200"
                        style="font-family: 'Noto Sans', sans-serif;">
                        Having trouble signing in?
                    </button>


                </form>

                <div class="border-t border-gray-200 my-6"></div>

                <p class="text-xs text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
                    Do you have questions about your property or the extranet?
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Partner Help</a> or
                    ask another question on the <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Partner Community</a>
                </p>

                <div class="mt-4">
                    <a href="/carrentals/account/create"
                        class="block text-center border border-blue-600 text-blue-600 hover:bg-blue-50 rounded py-2 text-sm font-semibold"
                        style="font-family: 'Noto Sans', sans-serif;">
                        Create your partner account
                    </a>
                </div>

                <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
                    By signing in or creating an account, you agree with our
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>.
                </p>

                <p class="text-[11px] text-gray-400 text-center mt-1" style="font-family: 'Noto Sans', sans-serif;">©
                    2006 – 2025 {{ config('domains.domain') }}™</p>
            </div>
        </div>
    </section>

@endsection
