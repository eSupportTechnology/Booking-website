@extends('frontend.master')

@section('title', 'Verify Your Account | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            Verify Your Account
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Check your email to complete registration
        </p>
    </div>
</section>

<!-- Verification Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                    Verify your account
                </h2>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-sm text-gray-600 mb-2" style="font-family: 'Noto Sans', sans-serif;">
                    We sent you an email with a verification link to
                </p>
                <p class="font-semibold text-gray-900 break-words" id="userEmail" style="font-family: 'Noto Sans', sans-serif;">
                    @if (isset($email) && $email)
                        {{ $email }}
                    @endif
                </p>
                <p class="mt-4 text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                    To confirm your account please follow the link in the email we just sent.
                </p>
            </div>

            <div class="text-center">
                <button id="resendButton" class="text-[#1F8FB2] hover:underline font-medium text-sm"
                    style="font-family: 'Noto Sans', sans-serif;">
                    Resend verification email
                </button>
                <p id="resendMessage" class="text-sm text-green-600 mt-2 hidden"></p>
            </div>

            <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
                By signing in or creating an account, you agree with our
                <a href="#" class="text-[#1F8FB2] hover:underline">Terms & conditions</a> and
                <a href="#" class="text-[#1F8FB2] hover:underline">Privacy statement</a>.
            </p>

            <p class="text-[11px] text-gray-400 text-center mt-2" style="font-family: 'Noto Sans', sans-serif;">
                {{ config('domains.domain') }}
            </p>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-16 0H3"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">List your property</h2>
                    <p class="text-sm text-gray-600">Reach millions of travelers worldwide</p>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#3CC0E9] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">Earn more revenue</h2>
                    <p class="text-sm text-gray-600">Competitive rates and low commission</p>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">24/7 Partner support</h2>
                    <p class="text-sm text-gray-600">We're always here to help you succeed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Display email from session storage if not rendered by backend
    const userEmail = sessionStorage.getItem('partner_email');
    const userEmailElem = document.getElementById('userEmail');
    if (userEmail && userEmailElem && !userEmailElem.textContent.trim()) {
        userEmailElem.textContent = userEmail;
    }

    // Resend verification email functionality
    const resendButton = document.getElementById('resendButton');
    const resendMessage = document.getElementById('resendMessage');

    resendButton.addEventListener('click', function() {
        const email = userEmailElem.textContent.trim();
        if (!email) return;

        resendButton.disabled = true;
        resendButton.textContent = 'Sending...';

        fetch('{{ route('partner.register.resend') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                email: email
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                resendMessage.textContent = 'Verification email has been resent!';
                resendMessage.classList.remove('hidden');
                setTimeout(() => {
                    resendMessage.classList.add('hidden');
                }, 5000);
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while resending the verification email');
        })
        .finally(() => {
            resendButton.disabled = false;
            resendButton.textContent = 'Resend verification email';
        });
    });
});
</script>

@endsection
