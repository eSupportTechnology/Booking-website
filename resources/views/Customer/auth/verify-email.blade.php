<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" min-h-screen ">

    <!-- HEADER START -->
    <header class="text-white px-4 py-2 w-full" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-auto md:ml-6">
                        <a href="/" class="text-2xl font-bold">
                            <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto"
                        style="font-family: 'Noto Sans', sans-serif;">
                        <a href="/help" title="Help" class="ml-2">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>
                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
                            title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                                class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Modal -->
                        <div id="language-modal"
                            class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Select your language
                                    </h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button
                                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg"
                                                alt="English (UK)" class="h-5 w-5" />
                                            <span>English (UK)</span>
                                        </button>
                                        <button
                                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg"
                                                alt="Deutsch" class="h-5 w-5" />
                                            <span>Deutsch</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal End -->
                    </div>
                </div>
            </div>
        </section>
    </header>
    <!-- HEADER END -->

    <!-- Main Content -->
    <main class="min-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
        <div class="bg-white rounded shadow-md w-full max-w-md p-6 sm:p-8 text-center mt-10">
            <div class="text-left mb-6">
                <form method="POST" action="{{ route('customer.verify.otp') }}" id="otp-form">
                    @csrf
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <h1 class="text-2xl font-semibold" style="font-family: 'Noto Sans', sans-serif;">Verify your email
                        address</h1>
                    <p class="text-sm text-gray-700 mt-2" style="font-family: 'Noto Sans', sans-serif;">
                        We've sent a verification code to<br>
                        <span class="font-semibold" style="font-family: 'Noto Sans', sans-serif;">
                            {{ session('customer_email', 'your email') }}
                        </span>. Please enter this code to continue.
                    </p>

                    <!-- Hidden input to collect the full OTP -->
                    <input type="hidden" name="otp" id="full-otp">

                    <!-- Code Input Boxes -->
                    <div class="flex justify-between gap-2 mb-6" id="code-container">
                        <input type="text" maxlength="1" name="otp_0"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 0)">
                        <input type="text" maxlength="1" name="otp_1"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 1)">
                        <input type="text" maxlength="1" name="otp_2"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 2)">
                        <input type="text" maxlength="1" name="otp_3"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 3)">
                        <input type="text" maxlength="1" name="otp_4"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 4)">
                        <input type="text" maxlength="1" name="otp_5"
                            class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="handleInput(this, 5)">
                    </div>

                    <!-- Display errors -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Verify Button -->
                    <button id="verify-btn" disabled
                        class="w-full bg-gray-300 text-white font-semibold py-2 rounded cursor-not-allowed"
                        style="font-family: 'Noto Sans', sans-serif;">
                        Verify email
                    </button>
                    <!-- Resend Timer -->
                    <p class="text-sm text-gray-600 mt-4" style="font-family: 'Noto Sans', sans-serif;">
                        Didn't receive an email? Please check your spam folder or request another code in
                        <strong id="countdown">60 seconds</strong>
                    </p>
                    <a href="{{ route('customer.login') }}" class="block mt-4 text-blue-600 hover:underline text-sm"
                        style="font-family: 'Noto Sans', sans-serif;">Back to sign in</a>

                    <div class="mt-8 text-xs text-gray-500">
                        <p style="font-family: 'Noto Sans', sans-serif;">By signing in or creating an account, you
                            agree with
                            our
                            <a href="#" class="text-blue-600 underline"
                                style="font-family: 'Noto Sans', sans-serif;">Terms & Conditions</a> and
                            <a href="#"
                                class="text-blue-600 underline"style="font-family: 'Noto Sans', sans-serif;">Privacy
                                Statement</a>.
                        </p>
                        <p class="mt-2"style="font-family: 'Noto Sans', sans-serif;">All rights reserved<br>Copyright
                            (2025)
                            – Bookintour™</p>
                    </div>
            </div>
    </main>

    <!-- Language Modal Script -->
    <script>
        function handleInput(element, index) {
            const inputs = document.querySelectorAll('.code-input');
            const verifyBtn = document.getElementById('verify-btn');
            const fullOtpInput = document.getElementById('full-otp');

            // Only allow numeric input
            element.value = element.value.replace(/[^0-9]/g, '');

            // Move to next input if current is filled
            if (element.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            // Move to previous input on backspace
            if (element.value.length === 0 && index > 0) {
                inputs[index - 1].focus();
            }

            // Collect all input values
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });

            // Update hidden input
            fullOtpInput.value = otp;

            // Enable/disable verify button
            if (otp.length === 6) {
                verifyBtn.disabled = false;
                verifyBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                verifyBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                verifyBtn.style.backgroundColor = '#3CC0E9';
            } else {
                verifyBtn.disabled = true;
                verifyBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                verifyBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                verifyBtn.style.backgroundColor = '';
            }
        }

        // Handle paste event
        document.addEventListener('paste', function(e) {
            const inputs = document.querySelectorAll('.code-input');
            const paste = (e.clipboardData || window.clipboardData).getData('text');

            if (paste.length === 6 && /^\d{6}$/.test(paste)) {
                e.preventDefault();
                for (let i = 0; i < 6; i++) {
                    inputs[i].value = paste[i];
                }
                handleInput(inputs[5], 5); // Trigger the handler for the last input
            }
        });

        // Handle backspace key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                const inputs = document.querySelectorAll('.code-input');
                const currentIndex = Array.from(inputs).indexOf(document.activeElement);

                if (currentIndex > -1 && inputs[currentIndex].value === '' && currentIndex > 0) {
                    inputs[currentIndex - 1].focus();
                }
            }
        });

        // Countdown timer
        let countdown = 60;
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            if (countdown > 0) {
                countdownElement.textContent = countdown + ' seconds';
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdownElement.innerHTML =
                    '<a href="{{ route('customer.login') }}" class="text-blue-500 hover:underline">Request new code</a>';
            }
        }

        // Start countdown when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCountdown();
        });
    </script>
</body>

</html>
