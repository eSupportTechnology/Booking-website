<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\DTOs\CarRenters\CarRenterLoginEmailDTO;
use App\DTOs\CarRenters\CarRenterLoginPasswordDTO;
use App\Actions\CarRenters\LoginAction;

class CarRenterLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:car_renter')->except('logout');
    }

    // Step 1: Show Email Form
    public function showEmailForm()
    {
        if (Auth::guard('car_renter')->check()) {
            return redirect()->route('car_renter.dashboard');
        }
        return view('car_rentals.carrental-signin');
    }

    // Step 1: Store Email in Session
    public function storeEmail(Request $request)
    {
        // Try using DTO if available; fallback to manual validation
        try {
            $dto = CarRenterLoginEmailDTO::fromRequest($request);
            $email = $dto->email;
        } catch (\Throwable $e) {
            $validated = $request->validate([
                'email' => ['required', 'email', 'exists:car_renters,email'],
            ]);
            $email = $validated['email'];
        }

        session(['car_renter_login_email' => $email]);

        return redirect()->route('carrentals.login.password');
    }

    // Step 2: Show Password Form
    public function showPasswordForm()
    {
        $email = session('car_renter_login_email');

        if (!$email) {
            return redirect()->route('carrentals.login.email')
                ->withErrors(['email' => 'Please enter your email first.']);
        }

        return view('car_rentals.carrental-enter-password', compact('email'));
    }

    // Step 2: Process Login with Password
    public function loginWithPassword(Request $request, LoginAction $loginAction)
    {
        $email = session('car_renter_login_email');

        if (!$email) {
            return redirect()->route('carrentals.login.email')
                ->withErrors(['email' => 'Session expired. Please re-enter your email.']);
        }

        // DTO or fallback validation
        try {
            $dto = CarRenterLoginPasswordDTO::fromRequest($request);
            $password = $dto->password;
        } catch (\Throwable $e) {
            $validated = $request->validate([
                'password' => ['required', 'string'],
            ]);
            $password = $validated['password'];
        }

        // Attempt login using the dedicated action
        if ($loginAction->execute($email, $password)) {
            // Regenerate session for session fixation protection
            $request->session()->forget('car_renter_login_email');
            $request->session()->regenerate();

            $user = Auth::guard('car_renter')->user();

            return redirect()->route('car_renter.dashboard')
                ->with('success', 'Welcome back, ' . ($user->full_name ?? 'Car Renter') . '!');
        }

        // failed
        return back()->withErrors(['password' => 'Invalid password. Please try again.'])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('car_renter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('carrentals.login.email')
            ->with('success', 'Logged out successfully.');
    }
}
