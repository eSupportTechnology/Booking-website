@extends('frontend.admin.auth-layout')

@section('title', 'Forgot Password')

@section('content')
<div class="bg-white/70 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-darkText mb-6">Reset Password</h2>
    <form onsubmit="return validateForgot()">
        <div class="relative w-full mb-4">
            <input type="Username" id="forgotUsername" name="Username"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Enter your Username" required />
            <label for="forgotUsername"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Username
            </label>
        </div>
        <p id="forgotError" class="text-sm text-red-600 mb-2 hidden"></p>
        <button type="submit"
            class="w-full bg-primary hover:bg-hoverPrimary text-white py-3 rounded-lg font-semibold transition duration-200">
            Send Reset Link
        </button>
        <p class="text-center text-gray-600 mt-6">
            Remember your password?
            <a href="{{ route('admin.login') }}" class="text-primary hover:underline">Log In</a>
        </p>
    </form>
</div>

<script>
    function validateForgot() {
        const Username = document.getElementById("forgotUsername").value.trim();
        const error = document.getElementById("forgotError");

        if (Username.length < 3) {
            error.textContent = "Username must be at least 3 characters.";
            error.classList.remove("hidden");
            return false;
        }
        error.classList.add("hidden");
        return true;
    }

@endsection
