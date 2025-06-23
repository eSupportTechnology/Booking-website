<?php

use App\Http\Controllers\Auth\TravelerLoginController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelerDetailsController;
use App\Models\Traveler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;




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

Route::get('/register', function () {
    return view('frontend.register');
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


require __DIR__ . '/auth.php';
