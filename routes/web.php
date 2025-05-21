<?php

use App\Http\Controllers\Auth\TravelerLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelerDetailsController;
use App\Models\Traveler;
use Illuminate\Support\Facades\Route;




Route::get('/login', function () {
    return view('frontend.login');
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
Route::get('/welcome', function () {
    return view('frontend.welcomebox');
});

Route::get('/stays', function () {
    return view('frontend.home');
})->name('stays');

Route::get('/car-rentals', function () {
    return view('frontend.car-rentals');
})->name('car.rentals');

Route::get('/airport-taxis', function () {
    return view('frontend.home');
})->name('airport.taxis');

Route::get('/airport-tours', function () {
    return view('frontend.home');
})->name('airport.tours');

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


require __DIR__.'/auth.php';
