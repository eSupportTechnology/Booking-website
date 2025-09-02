<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DTOs\CarRenters\CarRenterLoginEmailDTO;
use App\DTOs\CarRenters\CarRenterLoginPasswordDTO;
use App\Actions\CarRenters\LoginAction;
use App\Models\CarRenter;

class CarRenterLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:car_renter')->except('logout');
    }

    // Show Email Form
    public function showEmailForm()
    {
        if (Auth::guard('car_renter')->check()) {
            return redirect()->route('car_renter.dashboard');
        }
        return view('car_rentals.carrental-signin');
    }

    // Store Email in Session
    public function storeEmail(Request $request)
    {
        try {
            $dto = CarRenterLoginEmailDTO::fromRequest($request);

            session(['car_renter_login_email' => $dto->email]);

            return redirect()->route('carrentals.login.password')
                ->with('success', 'Email verified. Please enter your password.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    // Show Password Form
    public function showPasswordForm()
    {
        if (Auth::guard('car_renter')->check()) {
            return redirect()->route('car_renter.dashboard');
        }

        if (!session('car_renter_login_email')) {
            return redirect()->route('carrentals.login.email')->withErrors([
                'email' => 'Please enter your email first.',
            ]);
        }

        $email = session('car_renter_login_email');
        $user = CarRenter::where('email', $email)->first();

        if ($user) {
            return view('car_rentals.carrental-enter-password', compact('email'));
        }

        abort(403, 'Unauthorized');
    }

    // Process Login
    public function loginWithPassword(Request $request, LoginAction $loginAction)
    {
        try {
            $email = $request->input('email') ?? session('car_renter_login_email');

            if (!$email) {
                return redirect()->route('carrentals.login.email')
                    ->with('error', 'Session expired. Please re-enter your email.');
            }

            $dto = CarRenterLoginPasswordDTO::fromArray([
                'password' => $request->password,
                'email' => $email
            ]);

            if ($loginAction->execute($email, $dto->password)) {
                session()->forget('car_renter_login_email');
                $user = Auth::guard('car_renter')->user();

                return redirect()->route('car_renter.dashboard')
                    ->with('success', 'Welcome back, ' . ($user ? $user->name : 'Car Renter') . '!');
            }

            return back()->with('error', 'Invalid password. Please try again.')->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
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
