<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AppleAuthAction;
use App\Actions\Auth\FacebookAuthAction;
use App\Actions\Auth\GoogleAuthAction;
use App\Actions\Auth\SendCustomerOtpAction;
use App\Actions\Auth\VerifyOtpAction;
use App\DTOs\Auth\AppleAuthDTO;
use App\DTOs\Auth\CustomerEmailRequestDTO;
use App\DTOs\Auth\FacebookAuthDTO;
use App\DTOs\Auth\GoogleAuthDTO;
use App\DTOs\Auth\VerifyOtpDTO;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Customer.auth.login');
    }

    public function requestOtp(Request $request)
{
    Log::info('Received email input: ' . $request->email);

    try {
        $dto = CustomerEmailRequestDTO::fromRequest($request);

        $action = new SendCustomerOtpAction();
        $action->execute($dto);

        Session::put('customer_email', $dto->email);

        // Handle AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent to your email'
            ]);
        }

        return redirect()->route('customer.email.verify')->with('success', 'OTP sent to your email');
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->expectsJson()) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        return back()->withErrors($e->errors());
    } catch (\Throwable $e) {
        Log::error('OTP request failed: ' . $e->getMessage());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }

        return back()->with('error', 'Something went wrong, please try again.');
    }
}

    public function showEmailVerifyForm()
    {
        if (!Session::has('customer_email')) {
            return redirect()->route('customer.login')->with('error', 'Please enter your email first');
        }

        return view('Customer.auth.verify-email');
    }

    public function verifyOtp(Request $request, VerifyOtpAction $action)
    {
        try {
            $email = Session::get('customer_email');

            if (!$email) {
                return $request->expectsJson()
                    ? response()->json(['errors' => ['email' => ['Session expired. Please start again.']]], 422)
                    : redirect()->route('customer.login')->with('error', 'Session expired. Please start again.');
            }

            // Validate input
            $dto = VerifyOtpDTO::fromRequest($request);

            // Allow multi-input fallback
            $otpInputs = [];
            for ($i = 0; $i < 6; $i++) {
                $otpInputs[] = $request->input("otp_$i", '');
            }

            $otp = implode('', $otpInputs);
            if (empty($otp)) {
                $otp = $dto->otp;
            }

            // Execute the OTP check
            if ($action->execute($otp, $email)) {

                $user = User::where('email', $email)->first();
                if ($user) {
                    Auth::guard('customer')->login($user);
                }
                return $request->expectsJson()
                    ? response()->json(['message' => 'Verification successful', 'redirect' => '/'])
                    : redirect('/')->with('success', 'Email verified successfully');
            }

            $error = ['otp' => ['Invalid or expired OTP']];
            return $request->expectsJson()
                ? response()->json(['errors' => $error], 422)
                : back()->withErrors($error);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->expectsJson()
                ? response()->json(['errors' => $e->errors()], 422)
                : back()->withErrors($e->errors());
        } catch (\Throwable $e) {
            Log::error('OTP verification failed: ' . $e->getMessage());
            return $request->expectsJson()
                ? response()->json(['message' => 'Something went wrong'], 500)
                : back()->with('error', 'Something went wrong, please try again.');
        }
    }

    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['email', 'profile'])
                ->redirect();
        } catch (\Throwable $e) {
            Log::error('Google redirect failed: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->with('error', 'Unable to connect to Google. Please try again.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('error')) {
                Log::warning('Google OAuth error: ' . $request->get('error'));
                return redirect()->route('customer.login')
                    ->with('error', 'Google authentication was cancelled or failed.');
            }

            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser || !$googleUser->getEmail()) {
                Log::error('Invalid Google user data received');
                return redirect()->route('customer.login')
                    ->with('error', 'Unable to retrieve user information from Google.');
            }

            $dto = GoogleAuthDTO::fromGoogleUser($googleUser);

            $action = new GoogleAuthAction();
            $result = $action->execute($dto);

            if ($result['success']) {

                if (isset($result['user_data']) && $result['user_data'] instanceof User) {
                    auth()->guard('customer')->login($result['user_data']);
                } elseif (isset($result['user_data']['id'])) {
                    $user = User::find($result['user_data']['id']);
                    if ($user) {
                        auth()->guard('customer')->login($user);
                    }
                }
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $result['message'],
                        'user' => $result['user_data'],
                        'redirect' => '/'
                    ]);
                }
                return redirect('/')->with('success', 'Successfully authenticated with Google!');
            } else {
                if ($request->expectsJson()) {
                    return response()->json(['message' => $result['message']], 500);
                }
                return redirect()->route('customer.login')
                    ->with('error', $result['message']);
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Google OAuth state error: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->with('error', 'Authentication session expired. Please try again.');
        } catch (\Throwable $e) {
            Log::error('Google callback failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Authentication failed'], 500);
            }
            return redirect()->route('customer.login')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }

    public function redirectToFacebook()
    {
        try {
            return Socialite::driver('facebook')
                ->scopes(['email', 'public_profile'])
                ->redirect();
        } catch (\Throwable $e) {
            Log::error('Facebook redirect failed: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->with('error', 'Unable to connect to Facebook. Please try again.');
        }
    }

    public function handleFacebookCallback(Request $request)
    {
        return $this->handleSocialCallback(
            $request,
            'facebook',
            FacebookAuthDTO::class,
            FacebookAuthAction::class
        );
    }

    // Apple authentication methods
    public function redirectToApple()
    {
        try {
            return Socialite::driver('apple')
                ->scopes(['email', 'name'])
                ->redirect();
        } catch (\Throwable $e) {
            Log::error('Apple redirect failed: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->with('error', 'Unable to connect to Apple. Please try again.');
        }
    }

    public function handleAppleCallback(Request $request)
    {
        return $this->handleSocialCallback(
            $request,
            'apple',
            AppleAuthDTO::class,
            AppleAuthAction::class
        );
    }

    private function handleSocialCallback(Request $request, string $provider, string $dtoClass, string $actionClass)
    {
        try {
            if ($request->has('error')) {
                Log::warning("{$provider} OAuth error: " . $request->get('error'));
                return redirect()->route('customer.login')
                    ->with('error', ucfirst($provider) . ' authentication was cancelled or failed.');
            }

            $socialUser = Socialite::driver($provider)->user();

            if (!$socialUser || !$socialUser->getEmail()) {
                Log::error("Invalid {$provider} user data received");
                return redirect()->route('customer.login')
                    ->with('error', "Unable to retrieve user information from " . ucfirst($provider) . ".");
            }

            $dto = $dtoClass::fromSocialUser($socialUser);

            $action = new $actionClass();
            $result = $action->execute($dto);

            if ($result['success']) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $result['message'],
                        'user' => $result['user_data'],
                        'redirect' => '/'
                    ]);
                }
                return redirect('/')->with('success', 'Successfully authenticated with ' . ucfirst($provider) . '!');
            } else {
                if ($request->expectsJson()) {
                    return response()->json(['message' => $result['message']], 500);
                }
                return redirect()->route('customer.login')
                    ->with('error', $result['message']);
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error("{$provider} OAuth state error: " . $e->getMessage());
            return redirect()->route('customer.login')
                ->with('error', 'Authentication session expired. Please try again.');
        } catch (\Throwable $e) {
            Log::error("{$provider} callback failed: " . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Authentication failed'], 500);
            }
            return redirect()->route('customer.login')
                ->with('error', ucfirst($provider) . ' authentication failed. Please try again.');
        }
    }
}
