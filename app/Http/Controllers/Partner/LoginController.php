<?php

namespace App\Http\Controllers\Partner;

// use App\Http\Controllers\Partner\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Partner\LoginAction;
use App\Models\User;
use App\DTOs\Partner\PartnerLoginEmailDTO;
use Illuminate\Support\Facades\Auth;
use App\DTOs\Partner\PartnerLoginPasswordDTO;

class LoginController extends Controller

{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showEmailForm()
    {
        if (Auth::check()) {
            return redirect()->route('partner.dashboard');
        }
        return view('partner.partner-sign-in');
    }

    public function storeEmail(Request $request)
    {
        try {
            $dto = PartnerLoginEmailDTO::fromRequest($request);
            
            session(['partner_login_email' => $dto->email]);

            return redirect()->route('partner.login.password')->with('success', 'Email verified. Please enter your password.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function showPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('partner.dashboard');
        }
        
        if (!session('partner_login_email')) {
            return redirect()->route('partner.login.email')->withErrors([
                'email' => 'Please enter your email first.',
            ]);
        }

        $email = session('partner_login_email');
        $user = User::where('email', $email)->first();
        if ($user && ($user->hasRole('partner') || $user->hasRole('customer'))) {
            return view('partner.partner-enter-pwd', [
                'email' => $email,
            ]);
        }

        // handle non-partner case or show error
        abort(403, 'Unauthorized');
    }

    public function loginWithPassword(Request $request, LoginAction $loginAction)
    {
        try {
            $email = $request->input('email') ?? session('partner_login_email');

            if (!$email) {
                return redirect()->route('partner.login.email')->with('error', 'Session expired. Please re-enter your email.');
            }

            $dto = PartnerLoginPasswordDTO::fromArray([
                'password' => $request->password,
                'email' => $email
            ]);

            if ($loginAction->execute($email, $dto->password)) {
                session()->forget('partner_login_email');
                $user = Auth::user();
                return redirect()->route('partner.dashboard')->with('success', 'Welcome back, ' . ($user ? $user->name : 'Partner') . '!');
            }

            return back()->with('error', 'Invalid password. Please try again.')->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('partner.dashboard');
        }
        return view('partner.partner-sign-in');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login')->with('success', 'Logged out successfully.');
    }
}
