<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CarRenter;

class CarRenterLoginController extends Controller
{
    // Show email form
    public function showEmailForm()
    {
        return view('car_rentals.carrental-signin');
    }

    // Store email and redirect to password form
    public function storeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:car_renters,email',
        ]);

        // Store email in session
        $request->session()->put('car_renter_login_email', $request->email);

        return redirect()->route('carrentals.login.password');
    }

    // Show password form
    public function showPasswordForm(Request $request)
    {
        $email = $request->session()->get('car_renter_login_email');

        if (!$email) {
            return redirect()->route('carrentals.login.email')
                ->with('error', 'Please enter your email first.');
        }

        return view('car_rentals.carrental-enter-password', compact('email'));
    }

    // Process login
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $email = $request->session()->get('car_renter_login_email');
        if (!$email) {
            return redirect()->route('carrentals.login.email')
                ->with('error', 'Please enter your email first.');
        }

        if (Auth::guard('car_renter')->attempt(['email' => $email, 'password' => $request->password], true)) {
            $request->session()->forget('car_renter_login_email');
            return redirect()->route('carrentals.dashboard');
        }

        return back()->withErrors([
            'password' => 'Invalid password. Please try again.',
        ]);
    }

    // Dashboard
    public function dashboard(CarRenterControlPanel $panel)
{
    $carBookings = $panel->getCarBookings();
    $taxiBookings = $panel->getTaxiBookings();

    return view('car_rentals.carrenters_control_panel', compact(
        'carBookings',
        'taxiBookings'
    ));
}


    // Logout
    public function logout(Request $request)
    {
        Auth::guard('car_renter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('carrentals.login.email');
    }
}
