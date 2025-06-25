<?php

use App\Http\Controllers\Auth\TravelerLoginController;
use App\Http\Controllers\Customer\Auth\CustomerAuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelerDetailsController;
use App\Models\Traveler;
use App\Http\Controllers\Partner\PartnerRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Mail\PartnerVerificationMail;
use App\Http\Controllers\Partner\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Customer\CustomerPersonalDetailsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/login/email', [LoginController::class, 'showEmailForm'])->name('login.email');
Route::post('/login/email', [LoginController::class, 'storeEmail']);

Route::get('/login/password', [LoginController::class, 'showPasswordForm'])->name('login.password');
Route::post('/login/password', [LoginController::class, 'loginWithPassword']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route::get('/login', function () {
//     return view('frontend.login');
// });

Route::get('change', [LanguageController::class, 'change'])->name('lang.change');

Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/request-otp', [CustomerAuthController::class, 'requestOtp'])->name('customer.request.otp');
    Route::post('/customer/verify-otp', [CustomerAuthController::class, 'verifyOtp'])->name('customer.verify.otp');
    Route::get('/email-verify', [CustomerAuthController::class, 'showEmailVerifyForm'])->name('customer.email.verify');

    //google routes
    Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('customer.google.auth');
    Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback'])->name('customer.google.callback');

    // Facebook routes
    Route::get('/facebook', [CustomerAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/facebook/callback', [CustomerAuthController::class, 'handleFacebookCallback'])->name('customer.facebook.callback');

    // Apple routes
    Route::get('/apple', [CustomerAuthController::class, 'redirectToApple'])->name('auth.apple');
    Route::get('/apple/callback', [CustomerAuthController::class, 'handleAppleCallback'])->name('customer.apple.callback');

    Route::get('/customer-details/create', [CustomerPersonalDetailsController::class, 'edit'])->name('customer.details.create');
    Route::post('/customer-details', [CustomerPersonalDetailsController::class, 'update'])->name('customer.details.store');

    // Route::middleware(['auth:traveler'])->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('dashboard');
    //     })->name('traveler.dashboard');

    Route::post('/customer/logout', function () {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'You have been logged out.');
    })->name('customer.logout');
});

Route::get('/list-your-property', function () {
    return view('frontend.list-your-property');
});


Route::get('/', function () {
    return view('frontend.home');
});
Route::get('/property', function () {
    return view('frontend.property');
});
Route::get('/single-hotel', function () {
    return view('frontend.single-hotel');
});
Route::get('/welcome', function () {
    return view('frontend.welcomebox');
});

Route::get('/stays', function () {
    return view('frontend.home');
})->name('stays');

Route::get('/car-rentals', function () {
    return view('frontend.car-rentals');
})->name('car.rentals');

Route::get('/airport-tours', function () {
    return view('frontend.tour-packages');
})->name('airport.tours');

Route::get('/partner-register', function () {
    return view('frontend.partner-account-create');
})->name('partner.register');

Route::get('/partner-create-password', function () {
    return view('frontend.partner-create-password');
})->name('partner.create.password');

Route::get('/partner-contact-details', function () {
    return view('frontend.partner-contact-details');
})->name('partner.contact.details');

Route::get('/partner-verification', function () {
    return view('frontend.partner-verify-message');
})->name('partner.verify.message');

Route::get('/partner-signin', function () {
    return view('frontend.partner-signin');
})->name('partner.signin');

Route::get('/partner-recovery-account', function () {
    return view('frontend.partner-recovery-account');
})->name('partner.recovery.account');

Route::get('/partner-enter-password', function () {
    return view('frontend.partner-enter-password');
})->name('partner.enter.password');

Route::get('/partner-forgot-password', function () {
    return view('frontend.partner-forgot-password');
})->name('partner.forgot.password');

// Route::get('/partner-password-recover', function () {
//     return view('frontend.partner-forgotpassword-success');
// })->name('partner.forgot.password');

Route::get('/partner-profile-create', function () {
    return view('frontend.partner-profile-create');
})->name('partner.profile.create');


Route::get('/airport-taxis', function () {
    return view('frontend.home');
})->name('airport.taxis');

// Route::get('/email-verify', function () {
//     return view('frontend.verify-email');
// })->name('email.verify');


Route::get('/airport-taxis', function () {
    return view('frontend.airport-taxi');
})->name('airport.taxis');

// routes/web.php
Route::prefix('traveler')->group(function () {
    Route::get('/login', [TravelerLoginController::class, 'showLoginForm'])->name('traveler.login');
    Route::post('/send-code', [TravelerLoginController::class, 'sendCode'])->name('send.code');
    Route::get('/verify-code', [TravelerLoginController::class, 'showCodeForm'])->name('verify.code.form');
    Route::post('/verify-code', [TravelerLoginController::class, 'verifyCode'])->name('verify.code');
    Route::post('/logout', [TravelerLoginController::class, 'logout'])->name('traveler.logout');
    Route::get('/auth/google', [TravelerLoginController::class, 'redirectToGoogle'])->name('traveler.google.login');
    Route::get('/auth/google/callback', [TravelerLoginController::class, 'handleGoogleCallback']);
    Route::get('auth/facebook', [TravelerLoginController::class, 'redirectToFacebook'])->name('traveler.facebook.login');
    Route::get('auth/facebook/callback', [TravelerLoginController::class, 'handleFacebookCallback']);

    Route::middleware(['auth:traveler'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('traveler.dashboard');

        Route::get('/profile', [TravelerDetailsController::class, 'showTravelerDetails'])->name('traveler.profile');
        Route::put('/profile/update', [TravelerDetailsController::class, 'updateTravelerDetails'])->name('traveler.profile.update');
    });
});

// Partner Registration (Web)
Route::prefix('partner')->group(function () {
    // Show email registration form
    Route::get('/register/email', function () {
        return view('partner.partner-account-create');
    })->name('partner.register.email.form');

    // Handle email registration POST
    Route::post('/register/email', [PartnerRegistrationController::class, 'storeEmail'])->name('partner.register.email');

    // Show contact details form
    Route::get('/register/contact', function () {
        return view('partner.partner-contact-details');
    })->name('partner.register.contact.form');

    // Handle contact details POST
    Route::post('/register/contact', [PartnerRegistrationController::class, 'storeContact'])->name('partner.register.contact');

    // Show password creation form
    Route::get('/register/password', function () {
        return view('partner.partner-create-password');
    })->name('partner.register.password');

    // Handle password creation POST
    Route::post('/register/password', [PartnerRegistrationController::class, 'storePassword'])->name('partner.register.password');

    // Show email verification page
    Route::get('/register/verify', function (\Illuminate\Http\Request $request) {
        $email = session('partner_registration.email');
        return view('partner.partner-verify-message', compact('email'));
    })->name('partner.register.verify');

    // Resend verification email (placeholder)
    Route::post('/register/resend', function () {
        return response()->json(['status' => 'success', 'message' => 'Verification email resent (placeholder).']);
    })->name('partner.register.resend');

    Route::get('/list-your-property', function () {
        return view('partner.list-your-property');
    })->name('partner.list-your-property');

    // Partner two-step login
    Route::get('/sign-in', [LoginController::class, 'showEmailForm'])->name('partner.login.email');
    Route::post('/sign-in', [LoginController::class, 'storeEmail']);
    Route::get('/password', [LoginController::class, 'showPasswordForm'])->name('partner.login.password');
    Route::post('/password', [LoginController::class, 'loginWithPassword']);

    // Show the forgot password form
    Route::get('/forgot-password', function () {
        return view('partner.partner-forgot-password');
    })->name('partner.password.request');

    // Handle the form POST to send reset link
    Route::post('/forgot-password', [\App\Http\Controllers\Partner\PartnerPasswordResetLinkController::class, 'store'])
        ->name('partner.password.email');

    // Show the reset password form (from email link)
    Route::get('/reset-password/{token}', function ($token) {
        return view('partner.partner-reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    })->name('partner.password.reset');

    // Handle the reset password POST
    Route::post('/reset-password', [\App\Http\Controllers\Partner\NewPasswordController::class, 'store'])
        ->name('partner.password.update');

    Route::get('/register/verify/{token}', [PartnerRegistrationController::class, 'verify'])->name('partner.register.verify.token');
});

Route::get('/partner/login', [LoginController::class, 'show'])->name('partner.login');
Route::post('/partner/login', [LoginController::class, 'login'])->name('partner.login.submit');

// Partner Registration Flow
Route::get('/partner/register', [PartnerRegistrationController::class, 'createEmail'])->name('partner.register.email-create');
Route::post('/partner/register/email', [PartnerRegistrationController::class, 'storeEmail'])->name('partner.register.email');

Route::get('/partner/register/contact', [PartnerRegistrationController::class, 'createContact'])->name('partner.register.contact-details');
Route::post('/partner/register/contact', [PartnerRegistrationController::class, 'storeContact'])->name('partner.register.contact');

Route::get('/partner/register/password', [PartnerRegistrationController::class, 'createPassword'])->name('partner.register.password-create');
Route::post('/partner/register/password', [PartnerRegistrationController::class, 'register'])->name('partner.register.password');

// Show the email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Handle the email verification link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('partner.login')->with('success', 'Your email has been verified. Please log in.');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend the verification email
Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__ . '/auth.php';
