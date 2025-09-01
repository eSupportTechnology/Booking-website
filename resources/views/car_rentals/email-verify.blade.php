@extends('partner.partner-layout')

@section('title', 'Verify Your Account | ' . config('domains.app_name'))

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<main class="flex-grow flex justify-center items-start px-4 py-16">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-xl text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Verify your account</h2>
        <div class="bg-gray-100 text-left p-4 rounded">
            <p class="text-gray-700 mb-2">
                We sent you an email with a verification link to
            </p>
            <p class="font-semibold text-gray-900 break-words" id="userEmail">
                @if (isset($email) && $email)
                    {{ $email }}
                @endif
            </p>
            <p class="mt-4 text-gray-700">
                To confirm your account please follow the link in the email we just sent.
            </p>
            <div class="mt-6">
                <button id="resendButton" class="text-blue-600 hover:text-blue-800 font-medium">
                    Resend verification email
                </button>
                <p id="resendMessage" class="text-sm text-green-600 mt-2 hidden"></p>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const userEmailElem = document.getElementById('userEmail');
    let userEmail = userEmailElem.textContent.trim();

    // If backend didn't pass email, check sessionStorage
    if (!userEmail) {
        userEmail = sessionStorage.getItem('car_renter_email');
        if (userEmail && userEmailElem) {
            userEmailElem.textContent = userEmail;
        }
    }

    const resendButton = document.getElementById('resendButton');
    const resendMessage = document.getElementById('resendMessage');

    resendButton.addEventListener('click', function() {
        if (!userEmail) return;

        resendButton.disabled = true;
        resendButton.textContent = 'Sending...';

        fetch('{{ route('carrentals.register.resend') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: userEmail })
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
