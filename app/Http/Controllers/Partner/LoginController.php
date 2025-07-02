<?php

namespace App\Http\Controllers\Partner;

// use App\Http\Controllers\Partner\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Partner\LoginAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller

{
    public function showEmailForm()
    {
        return view('partner.partner-sign-in');
    }

    public function storeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No account found with this email. Please register first.',
        ]);

        session(['partner_login_email' => $request->email]);

        return redirect()->route('partner.login.password');
    }

    public function showPasswordForm()
    {
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
        $request->validate([
            'password' => 'required|string',
        ]);

        $email = $request->input('email') ?? session('partner_login_email');

        if (!$email) {
            return redirect()->route('partner.login.email')->withErrors([
                'email' => 'Session expired. Please re-enter your email.',
            ]);
        }

        if ($loginAction->execute($email, $request->password)) {
            session()->forget('partner_login_email');
            $user = Auth::user();
            return redirect()->route('partner.list-your-property')->with('partner_name', $user ? $user->name : null);
        }

        return back()->withErrors([
            'password' => 'Invalid password.',
        ])->withInput();
    }

    public function show()
    {
        return view('partner.partner-sign-in'); // or your custom login view
    }
}
