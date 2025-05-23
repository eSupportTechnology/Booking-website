<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded shadow-md w-full max-w-md p-6 sm:p-8 text-center">
        <!-- Header -->
        <div class="text-left mb-6">
            <h1 class="text-2xl font-semibold">Verify your email address</h1>
            <p class="text-sm text-gray-700 mt-2">We’ve sent a verification code to<br>
                <span class="font-semibold">www.sample256@gmail.com</span>. Please enter this code to continue.
            </p>
        </div>

        <!-- Code Input Boxes -->
        <div class="flex justify-between gap-2 mb-6">
            @for ($i = 0; $i < 6; $i++)
                <input type="text" maxlength="1"
                    class="w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            @endfor
        </div>

        <!-- Verify Button -->
        <button disabled class="w-full bg-gray-300 text-white font-semibold py-2 rounded cursor-not-allowed">
            Verify email
        </button>

        <!-- Timer -->
        <p class="text-sm text-gray-600 mt-4">Didn’t receive an email? Please check your spam folder or request another code in <strong>48 seconds</strong></p>

        <!-- Back to sign in -->
        <a href="#" class="block mt-4 text-blue-600 hover:underline text-sm">Back to sign in</a>

        <!-- Footer -->
        <div class="mt-8 text-xs text-gray-500">
            <p>By signing in or creating an account, you agree with our 
                <a href="#" class="text-blue-600 underline">Terms & Conditions</a> and 
                <a href="#" class="text-blue-600 underline">Privacy Statement</a>.
            </p>
            <p class="mt-2">All rights reserved<br>Copyright (2025) – eSupport™</p>
        </div>
    </div>
</body>
</html>
