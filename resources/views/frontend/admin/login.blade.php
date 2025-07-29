@extends('frontend.admin.auth-layout')

@section('title', 'Admin Login')

@section('content')
<div class="bg-white/70 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-darkText mb-6">Log In</h2>
    <form onsubmit="return validateLogin()">
        <div class="relative w-full mb-4">
            <input type="Username" id="loginUsername" name="Username"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                placeholder="Username" required />
            <label for="loginUsername"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-darkBlueStart">
                Username
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="password" id="loginPassword" name="password"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                placeholder="Password" required />
            <label for="loginPassword"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-darkBlueStart">
                Password
            </label>
        </div>
        <p id="loginError" class="text-sm text-red-600 mb-2 hidden"></p>
        <button type="submit"
            class="w-full bg-primary hover:bg-hoverPrimary text-white py-3 rounded-lg font-semibold transition duration-200">
            Log In
        </button>
        <p class="text-center text-gray-600 mt-6">
            <a href="{{ route('admin.ForgotPassword') }}" class="text-primary hover:underline">Forgot Password?</a>
        </p>
        <p class="text-center text-gray-600 mt-4">
            Don’t have an account?
            <a href="{{ route('admin.Registration') }}" class="text-primary hover:underline">Register</a>
        </p>
    </form>
</div>

<script>
    function validateLogin() {
        const Username = document.getElementById("loginUsername").value.trim();
        const password = document.getElementById("loginPassword").value.trim();
        const error = document.getElementById("loginError");

        if (password.length < 6) {
            error.textContent = "Invalid Username or password must be at least 6 characters.";
            error.classList.remove("hidden");
            return false;
        }
        error.classList.add("hidden");
        return true;
    }
</script>
@endsection
