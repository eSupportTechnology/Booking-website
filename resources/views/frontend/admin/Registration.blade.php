@extends('frontend.admin.auth-layout')

@section('title', 'Admin Registration')

@section('content')
<div class="bg-white/70 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-darkText mb-6">Registration</h2>
    <form onsubmit="return validateRegister()">
        <div class="relative w-full mb-4">
            <input type="text" id="Username" name="Username"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Username" required />
            <label for="regName"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Username
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="email" id="regEmail" name="email"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Email" required />
            <label for="regEmail"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Email
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="password" id="regPassword" name="password"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Password" required />
            <label for="regPassword"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Password
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="password" id="regConfirm" name="password_confirmation"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Confirm Password" required />
            <label for="regConfirm"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Confirm Password
            </label>
        </div>
        <p id="regError" class="text-sm text-red-600 mb-2 hidden"></p>
        <button type="submit"
            class="w-full bg-primary hover:bg-hoverPrimary text-white py-3 rounded-lg font-semibold transition duration-200">
            Register
        </button>
        <p class="text-center text-gray-600 mt-6">
            Already have an account?
            <a href="{{ route('admin.login') }}" class="text-primary hover:underline">Log In</a>
        </p>
    </form>
</div>

<script>
    function validateRegister() {
        const name = document.getElementById("Username").value.trim();
        const email = document.getElementById("regEmail").value.trim();
        const password = document.getElementById("regPassword").value.trim();
        const confirm = document.getElementById("regConfirm").value.trim();
        const error = document.getElementById("regError");

        if (name.length < 3 || !email.includes('@') || password.length < 6) {
            error.textContent = "Please fill all fields correctly.";
            error.classList.remove("hidden");
            return false;
        }
        if (password !== confirm) {
            error.textContent = "Passwords do not match.";
            error.classList.remove("hidden");
            return false;
        }
        error.classList.add("hidden");
        return true;
    }
</script>
@endsection
