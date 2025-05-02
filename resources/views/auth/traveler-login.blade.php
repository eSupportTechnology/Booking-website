<form method="POST" action="{{ route('send.code') }}">
    @csrf
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Code</button>
</form>
<div class="mt-6 text-center">
    <a href="{{ route('traveler.google.login') }}" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition duration-300 ease-in-out">

        Sign in with Google
    </a>
    <a href="{{ route('traveler.facebook.login') }}" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition duration-300 ease-in-out">

        Sign in with FB
    </a>
</div>
