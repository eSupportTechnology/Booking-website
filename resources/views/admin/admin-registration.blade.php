@extends('admin.auth-layout')

@section('title', 'Admin Registration')

@section('content')
<div class="bg-white/70 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-darkText mb-6">Registration</h2>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <div class="relative w-full mb-4">
            <input type="text" id="username" name="username" value="{{ old('username') }}"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Username" required />
            <label for="username"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Username
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="peer w-full px-3 pt-5 pb-2 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Email" required />
            <label for="email"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Email
            </label>
        </div>
        <div class="relative w-full mb-4">
            <input type="password" id="password" name="password"
                class="peer w-full px-3 pt-5 pb-2 pr-10 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Password" required />
            <label for="password"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Password
            </label>
            <button type="button" id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.974 9.974 0 012.204-3.592m3.125-2.325A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.971 9.971 0 01-4.157 5.236M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3l18 18" />
                </svg>
            </button>
        </div>
        <div class="relative w-full mb-4">
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="peer w-full px-3 pt-5 pb-2 pr-10 placeholder-transparent border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#63CDED] text-sm"
                placeholder="Confirm Password" required />
            <label for="password_confirmation"
                class="absolute left-3 top-2.5 text-gray-500 text-xs transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:top-2.5 peer-focus:text-xs peer-focus:text-[#1F8FB2]">
                Confirm Password
            </label>
            <button type="button" id="toggleConfirmPassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIconConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <svg id="eyeSlashIconConfirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.974 9.974 0 012.204-3.592m3.125-2.325A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.971 9.971 0 01-4.157 5.236M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3l18 18" />
                </svg>
            </button>
        </div>
        @if ($errors->any())
            <div class="text-sm text-red-600 mb-2">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
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

    // Show/Hide Password functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Password field toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });

        // Confirm Password field toggle
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('regConfirm');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');
        const eyeSlashIconConfirm = document.getElementById('eyeSlashIconConfirm');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIconConfirm.classList.add('hidden');
                eyeSlashIconConfirm.classList.remove('hidden');
            } else {
                eyeIconConfirm.classList.remove('hidden');
                eyeSlashIconConfirm.classList.add('hidden');
            }
        });
    });
</script>
@endsection
