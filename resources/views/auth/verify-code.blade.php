<form method="POST" action="{{ route('verify.code') }}">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">
    <input type="text" name="code" placeholder="Enter the 6-digit code" required>
    <button type="submit">Login</button>
</form>
