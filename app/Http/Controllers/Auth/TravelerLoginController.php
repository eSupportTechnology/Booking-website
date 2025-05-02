<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Traveler;
use App\Models\EmailVerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\TravelerVerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class TravelerLoginController extends Controller
{
    public function showLoginForm()
{
    return view('auth.traveler-login');
}

public function sendCode(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $code = Str::upper(Str::random(6));

    EmailVerificationCode::create([
        'email' => $request->email,
        'code' => $code,
        'expires_at' => now()->addMinutes(10),
    ]);

    Mail::to($request->email)->send(new TravelerVerificationCodeMail($request->email, $code));

    return redirect()->route('verify.code.form')->with('email', $request->email);
}

public function showCodeForm()
{
    return view('auth.verify-code');
}

public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required|string|size:6'
    ]);

    $record = EmailVerificationCode::where('email', $request->email)
        ->where('code', $request->code)
        ->where('expires_at', '>=', now())
        ->first();

    if (!$record) {
        return back()->withErrors(['code' => 'Invalid or expired code']);
    }

    // Create or get traveler
    $traveler = Traveler::firstOrCreate(['email' => $request->email]);

    // Log in the traveler
    Auth::guard('traveler')->login($traveler);

    return redirect()->route('traveler.dashboard');
}

public function redirectToGoogle()
    {
        $redirectUrl = env('TRAVELER_GOOGLE_REDIRECT_URI'); // Get the redirect URL from the .env file

        return Socialite::driver('google')
            ->redirectUrl($redirectUrl) // Explicitly set the redirect URI
            ->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $redirectUri = env('TRAVELER_GOOGLE_REDIRECT_URI');
            $googleUser = Socialite::driver('google')->setHttpClient(new \GuzzleHttp\Client([
                'verify' => false, // Disable SSL verification
            ]))->stateless()->redirectUrl($redirectUri)->user();

            // Check if traveler already exists
            $traveler = Traveler::where('email', $googleUser->getEmail())->first();

            if (!$traveler) {
                // Register new traveler
                $traveler = Traveler::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()), // Generate a random password
                ]);
            }

            // Log in the traveler
            Auth::guard('traveler')->login($traveler);

            return redirect()->route('traveler.dashboard')->with('success', 'Logged in with Google');
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage()); // Log the error
            return redirect()->route('traveler.login')->withErrors(['error' => 'Google login failed. Please try again. Error: ' . $e->getMessage()]);
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        // Find or create the traveler
        $user = Traveler::firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            ['name' => $facebookUser->getName()]
        );

        Auth::guard('traveler')->login($user);

        return redirect()->route('traveler.dashboard'); // or wherever you want
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('traveler.login')->with('success', 'You have been logged out.');
    }
}
