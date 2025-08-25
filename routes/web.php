<?php

use App\Http\Controllers\Auth\TravelerLoginController;
use App\Http\Controllers\Customer\Auth\CustomerAuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelerDetailsController;
use App\Models\Traveler;
use App\Http\Controllers\Partner\PartnerRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\PartnerVerificationMail;
use App\Http\Controllers\Partner\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Customer\CustomerPersonalDetailsController;
use App\Http\Controllers\Customer\EmailVerifyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PropertyDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AirportTaxiController;
use App\Http\Controllers\CarReservations\CarRentalController;

Route::post('/accommodation/save-verification/{propertyId}', [AccommodationController::class, 'saveVerification']);


Route::get('/login/email', [LoginController::class, 'showEmailForm'])->name('login.email');
Route::post('/login/email', [LoginController::class, 'storeEmail']);

Route::get('/login/password', [LoginController::class, 'showPasswordForm'])->name('login.password');
Route::post('/login/password', [LoginController::class, 'loginWithPassword']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route::get('/login', function () {
//     return view('frontend.login');
// });

Route::post('change-language', [LanguageController::class, 'change'])->name('lang.change');

Route::prefix('customer')->group(function () {
    // Search route
    Route::get('/search', [\App\Http\Controllers\Customer\SearchController::class, 'search'])->name('customer.search');

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

    // customer dashboard
    Route::middleware(['auth:customer'])->group(function () {
        Route::get('/', function () {
            return view('Customer.home');
        })->name('customer.dashboard');

        Route::delete('/account/request-deletion', [CustomerAuthController::class, 'requestDeletion'])
            ->name('customer.account.request-deletion');
    });
    Route::get('/account/confirm-deletion/{token}', [CustomerAuthController::class, 'confirmDeletion'])
        ->name('customer.account.confirm-deletion');


    Route::delete('/customer/account', [CustomerAuthController::class, 'destroy'])
        ->middleware('auth:customer')
        ->name('customer.account.destroy');


    Route::get('/customer-details/create', [CustomerPersonalDetailsController::class, 'edit'])->name('customer.details.create');
    Route::post('/customer-details', [CustomerPersonalDetailsController::class, 'update'])->name('customer.details.store');


    // Email verification routes
    Route::post('/email/send-otp', [EmailVerifyController::class, 'sendOtp'])->name('email.send-otp');
    Route::post('/email/verify-otp', [EmailVerifyController::class, 'verifyOtp'])->name('email.verify-otp');
    Route::post('/email/resend-otp', [EmailVerifyController::class, 'resendOtp'])->name('email.resend-otp');


    Route::post('/customer/logout', function () {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'You have been logged out.');
    })->name('customer.logout');
});

Route::get('/list-your-property', function () {
    return view('partner.list-your-property');
});


Route::get('/', function () {
    return view('Customer.home');
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

Route::get('/partner-hotels-payments', function () {
    return view('frontend.partner-hotels-payments');
})->name('partner.hotels.payments');

Route::get('/partner-hotels-photos', function () {
    return view('partner.partner-hotels-photos');
})->name('partner.hotels.photos');




Route::get('/partner-forgot-password', function () {
    return view('frontend.partner-forgot-password');
})->name('partner.forgot.password');

// Route::get('/partner-password-recover', function () {
//     return view('frontend.partner-forgotpassword-success');
// })->name('partner.forgot.password');

Route::get('/partner-property-types', function () {
    return view('frontend.partner-property-types');
})->name('partner.property.types');

Route::get('/partner-apartment-create-1', function () {
    return view('frontend.partner-apartment-create-form-1');
})->name('partner.apartment.create.1');

Route::get('/partner/apartment/otherspaces/{property}', function ($property) {
    $property = \App\Models\Property::findOrFail($property);
    return view('partner.partner-apartments-otherspaces', compact('property'));
})->name('partner.apartment.otherspaces');

Route::get('/partner/apartment/livingroom/{property}', function ($property) {
    $property = \App\Models\Property::findOrFail($property);
    return view('partner.partner-apartments-livingroom', compact('property'));
})->name('partner.apartment.livingroom');



Route::get('/partner-homes-complete', function () {
    return view('frontend.partner-homes-complete-registration');
})->name('partner.homes.complete');

// Route::get('/partner-apartment-weekly-rate', function () {
//     return view('frontend.partner-apartment-weekly-rate');
// })->name('partner.apartment.weekly.rate');

Route::get('/partner-apartment-refundable-rate', function () {
    return view('frontend.partner-apartment-non-refundable-rate');
})->name('partner.apartment.refundable.rate');

Route::get('/open-booking/{propertyId}', [PropertyController::class, 'openBooking'])->name('open.booking');

// Route::get('/partner-apartment-pricing-policies', function () {
//     return view('frontend.partner-apartment-pricing-cancel-policies');
// })->name('partner.apartment.pricing.policies');

Route::get('/customer-profile-create', function () {
    return view('frontend.customer-profile-create');
})->name('customer.profile.create');

Route::get('/partner-apartment-create-2/{propertyId?}', [PropertyController::class, 'showSingleApartmentForm2'])->name('partner.apartment.create.2');
Route::get('/partner/property/apartment/step2/{propertyId}', [PropertyController::class, 'showSingleApartmentForm2'])->name('partner.property.apartment.step2');

Route::get('/partner-homes-create-1', function () {
    return view('frontend.partner-homes-create-form-1');
})->name('partner.homes.create.1');

Route::get('/partner-hotels-rooms', function () {
    return view('frontend.partner-hotels-rooms');
})->name('partner.hotels.rooms');




Route::get('/partner-hotels-create-2', function () {
    return view('frontend.partner-hotels-create-2');
})->name('partner.hotels.create.2');

Route::get('/partner-hotels-create-1', function () {
    return view('frontend.partner-hotels-create-1');
})->name('partner.hotels.create.1');


Route::get('/partner-alternative-place-type', function () {
    return view('frontend.partner-alternative-places-types');
})->name('partner.alternative.place.type');


Route::get('/partner-alternative-entireplace', function () {
    return view('frontend.partner-alternative-entireplace');
})->name('partner.alternative.entireplace');


Route::get('/partner-alternative-privateroom', function () {
    return view('frontend.partner-alternative-privateroom');
})->name('partner.alternative.privateroom');

Route::get('/partner/alternative/entireplace/step/2', function () {
    return view('frontend.partner-alternative-entireplace-step-02');
})->name('partner.alternative.entireplace.step.2');



Route::get('/partner/alternative/Single/Campsite', function () {
    return view('frontend.partner-alternative-one-campsite');
})->name('partner.alternative.single.campsite');

Route::get('/partner/alternative/Single/Campsite/room', function () {
    return view('frontend.partner-alternative-campsite-room');
})->name('partner.alternative.single.campsite.room');

Route::get('/partner/alternative/Campsite/edit', function () {
    return view('frontend.partner-alternative-campsite-edit');
})->name('partner.alternative.single.campsite.edit');


Route::get('/partner/alternative/Single/Campsite/cancel-policies', function () {
    return view('frontend.partner-alternative-campsite-cancel-policies');
})->name('partner.alternative.single.campsite.cancel-policies');

Route::get('/partner/alternative/Single/Campsite/cancel-policies', function () {
    return view('frontend.partner-alternative-campsite-cancel-policies');
})->name('partner.alternative.single.campsite.cancel-policies');

Route::get('/partner/alternative/form', function () {
    return view('frontend.partner-alternative-form-1');
})->name('partner.alternative.form');

Route::get('/partner/alternative/single/boat', function () {
    return view('frontend.partner-alternative-single-boat');
})->name('partner.alternative.single.boat');

Route::get('/partner/alternative/multiple/boats/sameaddress', function () {
    return view('frontend.partner-alternative-boat-multiple-sameaddress');
})->name('partner.alternative.multiple.boats.sameaddress');

Route::get('/partner/alternative/multiple/boat/room', function () {
    return view('frontend.partner-alternative-boat-room');
})->name('partner.alternative.multiple.boat.room');

Route::get('/partner/boat/price-per-group', function () {
    return view('frontend.partner-boat-pricepergroup');
})->name('partner.boat.price.per.group');



Route::get('/partner/boat/weekly-rate', function () {
    return view('frontend.partner-boat-weekly-rate');
})->name('partner.boat.weekly.rate');

Route::get('/partner/campsite/weekly-rate', function () {
    return view('frontend.partner-alternative-campsite-weeklyrate');
})->name('partner.campsite.weekly.rate');

Route::get('/partner/tent/single', function () {
    return view('frontend.partner-alternative-tent-single');
})->name('partner.tent.single');

Route::get('/partner/tent/images', function () {
    return view('frontend.partner-alternative-tent-photos');
})->name('partner.tent.images');

Route::get('/partner/campsite/payments', function () {
    return view('frontend.partner-campsite-payment');
})->name('partner.campsite.payments');

Route::get('/partner/tent/payments', function () {
    return view('frontend.partner-alternative-tent-payments');
})->name('partner.tent.payments');

Route::get('/partner/alternative/multiple/tent/room', function () {
    return view('frontend.partner-alternative-tent-room');
})->name('partner.alternative.multiple.tent.room');

Route::get('/partner/privateroom/boat/room', function () {
    return view('frontend.partner-privaterooom-boat-room');
})->name('partner.privateroom.boat.room');

Route::get('/partner/tent/multiple/sameaddress', function () {
    return view('frontend.partner-tent-multiple-sameaddress');
})->name('partner.tent.multiple.sameaddress');

Route::get('/partner/boat/payment', function () {
    return view('frontend.partner-alternative-boat-payments');
})->name('partner.boat.payment');

Route::get('/partner/campsite/bedrooms', function () {
    return view('frontend.partner-campsite-bedroom');
})->name('partner.campsite.bedrooms');

Route::get('/partner/campsite/otherspaces', function () {
    return view('frontend.partner-campsite-otherspaces');
})->name('partner.campsite.otherspaces');

Route::get('/partner/campsite/livingroom', function () {
    return view('frontend.partner-campsite-livingroom');
})->name('partner.campsite.livingroom');

Route::get('/partner/boat/edit', function () {
    return view('frontend.partner-alternative-boat-edit');
})->name('partner.boat.edit');

Route::get('/partner-boat-photos', function () {
    return view('frontend.partner-alternative-boat-images');
})->name('partner.boat.photos');

Route::get('/partner-tent-edit', function () {
    return view('frontend.partner-tent-edit');
})->name('partner.tent.edit');

Route::get('/partner-boat-compltete-registration', function () {
    return view('frontend.partner-boat-complete-registration');
})->name('partner.boat.complete.registration');

Route::get('/partner-privateroom-campsite-room', function () {
    return view('frontend.partner-privateroom-campsite-room');
})->name('partner.privateroom.campsite.room');

Route::get('/partner-privateroom-tent-room', function () {
    return view('frontend.partner-privateroom-tent-room');
})->name('partner.privateroom.tent.room');

Route::get('/partner-tent-compltete-registration', function () {
    return view('frontend.partner-alternative-tent-complete-registration');
})->name('partner.tent.complete.registration');

Route::get('/partner-apartment-multiple', function () {
    return view('frontend.partner-multiple-apartment');
})->name('partner.apartment.multiple');

Route::get('/partner-homes-form2/{id}/{subtype}', [PropertyController::class, 'showHomesForm2'])->name('partner.homes.form.2');

// Route::get('/partner-apartment-multiple-2', function () {
//     return view('frontend.partner-apartments-multiple-2');
// })->name('partner.apartment.multiple.2');

Route::get('/partner-homes-form2', function () {
    return view('frontend.partner-homes-form-2');
})->name('partner.homes.form2');


Route::post('/partner-homes-single/{id?}', [PropertyController::class, 'showPrivateHomesSingle'])->name('partner.homes.single');
Route::post('/partner-homes-multiple/{id?}', [PropertyController::class, 'showPrivateHomesMultiple'])->name('partner.homes.multiple');


Route::get('/partner-homes-rooms/{id}', [PropertyController::class, 'showPrivateHomesRooms'])->name('partner.homes.rooms');
Route::get('/partner-homes-edit/{id}', [PropertyController::class, 'showPrivateHomesEdit'])->name('partner.homes.edit');
Route::get('/partner-homes-payments/{id}', [PropertyController::class, 'showPrivateHomesPayments'])->name('partner.homes.payments');
Route::get('/api/property/{id}/category', [PropertyController::class, 'getPropertyCategory']);
Route::get('/partner-homes-images/{id}', [PropertyController::class, 'showPrivateHomesImages'])->name('partner.homes.images');

Route::get('/partner-apartments-final/{property?}', [PropertyController::class, 'showFinalStep'])->name('partner.apartments.final');

Route::get('/partner-hotels-edit', function () {
    return view('frontend.partner-hotels-edit');
})->name('partner.hotels.edit');

Route::get('/partner-hotels-cancel-policies', function () {
    return view('frontend.partner-hotels-cancel-policies');
})->name('partner.hotels.cancel.policies');

Route::get('/partner-hotels-priceper-group', function () {
    return view('frontend.partner-hotels-price-per-group');
})->name('partner.hotels.price.per.group');

Route::get('/partner-hotels-weekly-rate', function () {
    return view('frontend.partner-hotels-weekly-rate');
})->name('partner.hotels.weekly.rate');

Route::get('/partner-hotels-non-refundable-rate', function () {
    return view('frontend.partner-hotels-non-refundable');
})->name('partner.hotels.non.refundable.rate');



Route::get('/carrentals/registration', function () {
    return view('frontend.carrental-registration');
})->name('partner.carrentals.registration');

Route::get('/carrentals/account/create', function () {
    return view('frontend.carrental-account-create');
})->name('partner.carrentals.account.create');


Route::get('/carrentals/create/password', function () {
    return view('frontend.carrental-create-password');
})->name('partner.carrentals.create.password');

Route::get('/carrentals/enter/password', function () {
    return view('frontend.carrental-enter-password');
})->name('partner.carrentals.enter.password');

Route::get('/carrentals/signin', function () {
    return view('frontend.carrental-signin');
})->name('partner.carrentals.signin');

Route::get('/carrentals/types', function () {
    return view('frontend.carrental-types');
})->name('partner.carrentals.types');

Route::get('/single-car', function () {
    return view('frontend.single-car');
})->name('partner.carrentals.single.car');


Route::get('/carrentals/Addcar', [CarRentalController::class, 'index'])->name('partner.carrentals.addcar');
Route::post('/cars/register-step', [CarRentalController::class, 'registerStep']);

Route::get('/airport-taxi/registration', [AirportTaxiController::class, 'index'])->name('partner.airport.taxi.registration');
Route::post('/taxis/store-step1', [AirportTaxiController::class, 'storeStep1'])->name('taxis.storeStep1');
Route::post('/taxis/store-step2', [AirportTaxiController::class, 'storeStep2'])->name('taxis.storeStep2');
Route::post('/taxis/store-step3', [AirportTaxiController::class, 'storeStep3'])->name('taxis.storeStep3');
Route::post('/taxis/store-step4', [AirportTaxiController::class, 'storeStep4'])->name('taxis.storeStep4');


// Route::get('/partner-hotels-complete-registration', function () {
//     return view('frontend.partner-hotels-complete-registration');
// })->name('partner.hotels.complete.registration');

Route::get('/partner-hotels-multiple', function () {
    return view('frontend.partner-hotels-multiple');
})->name('partner.hotels.multiple');

// Route::get('/email-verify', function () {
//     return view('frontend.verify-email');
// })->name('email.verify');


Route::get('/airport-taxis', function () {
    return view('frontend.airport-taxi');
})->name('airport.taxis');

// routes/web.php
// Route::prefix('traveler')->group(function () {
//     Route::get('/login', [TravelerLoginController::class, 'showLoginForm'])->name('traveler.login');
//     Route::post('/send-code', [TravelerLoginController::class, 'sendCode'])->name('send.code');
//     Route::get('/verify-code', [TravelerLoginController::class, 'showCodeForm'])->name('verify.code.form');
//     Route::post('/verify-code', [TravelerLoginController::class, 'verifyCode'])->name('verify.code');
//     Route::post('/logout', [TravelerLoginController::class, 'logout'])->name('traveler.logout');
//     Route::get('/auth/google', [TravelerLoginController::class, 'redirectToGoogle'])->name('traveler.google.login');
//     Route::get('/auth/google/callback', [TravelerLoginController::class, 'handleGoogleCallback']);
//     Route::get('auth/facebook', [TravelerLoginController::class, 'redirectToFacebook'])->name('traveler.facebook.login');
//     Route::get('auth/facebook/callback', [TravelerLoginController::class, 'handleFacebookCallback']);

//     Route::middleware(['auth:traveler'])->group(function () {
//         Route::get('/dashboard', function () {
//             return view('dashboard');
//         })->name('traveler.dashboard');

//         Route::get('/profile', [TravelerDetailsController::class, 'showTravelerDetails'])->name('traveler.profile');
//         Route::put('/profile/update', [TravelerDetailsController::class, 'updateTravelerDetails'])->name('traveler.profile.update');
//     });
// });

// Partner Registration Routes (Public - No Auth Required)
Route::prefix('partner')->group(function () {
    // Partner Login Routes
    Route::get('/login', [LoginController::class, 'show'])->middleware('App\Http\Middleware\PreventBackHistory')->name('partner.login');
    Route::post('/login', [LoginController::class, 'login'])->name('partner.login.submit');
    Route::get('/sign-in', [LoginController::class, 'showEmailForm'])->middleware('App\Http\Middleware\PreventBackHistory')->name('partner.login.email');
    Route::post('/sign-in', [LoginController::class, 'storeEmail']);
    Route::get('/password', [LoginController::class, 'showPasswordForm'])->middleware('App\Http\Middleware\PreventBackHistory')->name('partner.login.password');
    Route::post('/password', [LoginController::class, 'loginWithPassword']);

    // Show email registration form
    Route::get('/register', [PartnerRegistrationController::class, 'createEmail'])->name('partner.register.email-create');
    Route::get('/register/email', [PartnerRegistrationController::class, 'createEmail'])->name('partner.register.email.form');

    // Handle email registration POST
    Route::post('/register/email', [PartnerRegistrationController::class, 'storeEmail'])->name('partner.register.email');

    // Show contact details form
    Route::get('/register/contact', [PartnerRegistrationController::class, 'createContact'])->name('partner.register.contact-details');

    // Handle contact details POST
    Route::post('/register/contact', [PartnerRegistrationController::class, 'storeContact'])->name('partner.register.contact');

    // Show password creation form
    Route::get('/register/password', [PartnerRegistrationController::class, 'createPassword'])->name('partner.register.password-create');

    // Handle password creation POST
    Route::post('/register/password', [PartnerRegistrationController::class, 'register'])->name('partner.register.password');

    // Show email verification page
    Route::get('/register/verify', function (\Illuminate\Http\Request $request) {
        $email = session('partner_registration.email');
        return view('partner.partner-verify-message', compact('email'));
    })->name('partner.register.verify');

    // Resend verification email (placeholder)
    Route::post('/register/resend', function () {
        return response()->json(['status' => 'success', 'message' => 'Verification email resent (placeholder).']);
    })->name('partner.register.resend');

    Route::get('/register/verify/{token}', [PartnerRegistrationController::class, 'verify'])->name('partner.register.verify.token');

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
});

// Partner Routes (Protected - Auth Required)
Route::prefix('partner')->middleware(['auth', \App\Http\Middleware\PartnerMiddleware::class])->group(function () {
    // Partner Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Partner\DashboardController::class, 'index'])->name('partner.dashboard');

    // Properties
    Route::get('/properties', [\App\Http\Controllers\Partner\PropertyController::class, 'index'])->name('partner.properties');
    Route::get('/bookings', [\App\Http\Controllers\Partner\PropertyController::class, 'bookings'])->name('partner.bookings');

    // Property Listings
    Route::get('/properties/apartments', [\App\Http\Controllers\Partner\PropertyListingController::class, 'apartments'])->name('partner.properties.apartments');
    Route::get('/properties/homes', [\App\Http\Controllers\Partner\PropertyListingController::class, 'homes'])->name('partner.properties.homes');
    Route::get('/properties/hotels', [\App\Http\Controllers\Partner\PropertyListingController::class, 'hotels'])->name('partner.properties.hotels');
    Route::get('/properties/alternative-places', [\App\Http\Controllers\Partner\PropertyListingController::class, 'alternativePlaces'])->name('partner.properties.alternative-places');
    Route::get('/properties/views/{id}', [\App\Http\Controllers\Partner\PropertyListingController::class, 'view'])->name('partner.properties.views');

    // Earnings
    Route::get('/earnings', [\App\Http\Controllers\Partner\EarningsController::class, 'index'])->name('partner.earnings');

    // Messages
    Route::get('/messages', [\App\Http\Controllers\Partner\MessageController::class, 'index'])->name('partner.messages');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Partner\ReviewController::class, 'index'])->name('partner.reviews');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Partner\SettingsController::class, 'index'])->name('partner.settings');
    Route::get('/property_category', [PropertyController::class, 'categories'])->name('partner.property.category');
    Route::get('/property_subcategory/{id}/{property_id?}', [PropertyController::class, 'subcategories'])->name('partner.property.subcategory');
    Route::get('/hotels/rooms/{id}', [PropertyController::class, 'rooms'])->name('partner.hotels.room');
    Route::get('/property_subtype/{id}', [PropertyController::class, 'subtypes'])->name('partner.property.subtype');
    Route::post('/property/register', [PropertyController::class, 'register'])->name('partner.property.register');
    // Show Step 1 form
    Route::get('/property/{category}/step1', [PropertyController::class, 'showStep1'])->name('partner.property.step1.show');

    // Handle Step 1 submission
    Route::post('/partner/property/{category}/step1', [PropertyController::class, 'storeStep1'])->name('partner.property.step1.store');


    // Show Step 2 form
    Route::get('/property/{category}/step2/{property}', [PropertyController::class, 'showStep2'])
        ->name('partner.property.step2');

    Route::get('/property-apartment-2', function () {
        return view('partner.partner-apartment-create-form-2', [
            'property' => null,
            'category' => 'apartment',
            'groupedAmenities' => []
        ]);
    })->name('partner.property.apartment.2');
    Route::get('/property-apartment-1', [\App\Http\Controllers\PropertyController::class, 'apartmentSubcategories'])->name('partner.property.apartment.1');

    Route::get('/list-your-property', function () {
        return view('partner.list-your-property');
    })->name('partner.list-your-property');

    // Partner apartment creation form
    Route::get('/apartment/create', function () {
        return view('partner.partner-apartment-create');
    })->name('partner.apartment.create');

    Route::post('/property-apartment', [\App\Http\Controllers\PropertyController::class, 'storeApartment'])->name('partner.property.apartment.store');

    // Step 2: Show next form and save more details (dynamic for any category, static route name)
    Route::post('/property/{category}/step2/{property}', [PropertyController::class, 'storeStep2'])->name('partner.property.store.step2');
    Route::post('/property/step3/{property}', [PropertyController::class, 'storeStep2'])->name('partner.property.store.step3');
    Route::post('/property/upload-photos', [PropertyController::class, 'uploadPhotos'])->name('partner.property.upload.photos');
    Route::post('/property/save-amenities/{propertyId}', [PropertyController::class, 'saveAmenities']);
    Route::post('/property/save-policy/{property}', [PropertyController::class, 'savePolicy']);
    Route::post('/property/save-languages/{property}', [PropertyController::class, 'saveLanguages']);
    Route::post('/save-rooms/{property}', [PropertyController::class, 'saveRooms']);
    Route::post('/store-verification', [PropertyController::class, 'storePartnerVerification']);
    Route::post('/partner-verification', [PropertyController::class, 'storePartnerVerification']);
    Route::post('/partner/property/{property}/partner-verification', [PropertyController::class, 'storePartnerVerification']);
    Route::post('/partner/property/{property}/verification', [PropertyController::class, 'storePartnerVerification']);

    // Store accommodation, business entity, individual, and alt name details
    Route::post('/accommodation/store', [PropertyController::class, 'storeAccommodationDetails'])->name('partner.accommodation.store');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/partner/login')->with('success', 'You have been logged out.');
    })->name('partner.logout');

    // Partial update for AJAX step-by-step wizard
    Route::patch('/property/{property}', [PropertyController::class, 'updatePartial'])->name('partner.property.update.partial');
    Route::post('/property/{property}/facilities', [PropertyController::class, 'saveFacilities'])->name('partner.property.facilities.store');
    Route::get('/property/{property}/facilities', [PropertyDataController::class, 'getFacilities'])->name('partner.property.facilities.get');
    Route::post('/property/{property}/services', [PropertyController::class, 'saveServices'])->name('partner.property.services.store');
    Route::get('/property/{property}/services', [PropertyDataController::class, 'getServices'])->name('partner.property.services.get');
    Route::post('/partner/property/{property}/services', [PropertyController::class, 'saveServices'])->name('partner.property.services.store.partner');
    Route::patch('/partner/property/{property}/additional-details', [PropertyController::class, 'updateAdditionalDetails'])->name('partner.property.update.additional-details');
    Route::post('/property/{property}/languages', [PropertyController::class, 'saveLanguages'])->name('partner.property.languages.store');
    Route::get('/property/{property}/languages', [PropertyDataController::class, 'getPropertyLanguages'])->name('partner.property.languages.get');
    Route::get('/property/{property}/verification', [PropertyDataController::class, 'getVerification'])->name('partner.property.verification.get');

    // Partner hotels payment route with property ID (must come first to avoid conflicts)
    Route::get('/partner-hotels-payment/{property}', [PropertyController::class, 'showPaymentPage'])->name('partner.hotels.payment.with.property');

    // Partner hotels payment route (without property ID - must come after the parameterized route)
    Route::get('/partner-hotels-payment', function () {
        return view('partner.partner-hotels-payment');
    })->name('partner.hotels.payment');
    Route::get('/partner-hotels-complete-registration', function () {
        return view('partner.partner-hotels-complete-registration');
    })->name('partner.hotels.complete.registration');

    // Add new routes for loading saved data
    Route::get('/property/{property}/details', [PropertyDataController::class, 'getPropertyDetails'])->name('partner.property.details.get');
    Route::get('/property/{property}/amenities', [PropertyDataController::class, 'getAmenities'])->name('partner.property.amenities.get');
    Route::post('/property/{property}/amenities', [PropertyController::class, 'saveAmenities'])->name('partner.property.amenities.store');
    Route::get('/property/{property}/host-profile', [PropertyDataController::class, 'getHostProfile'])->name('partner.property.host-profile.get');
    Route::get('/property/{property}/pricing', [PropertyDataController::class, 'getPricing'])->name('partner.property.pricing.get');
    Route::get('/property/{property}/house-rules', [PropertyDataController::class, 'getHouseRules'])->name('partner.property.house-rules.get');
    Route::get('/property/{property}/availability-settings', [PropertyDataController::class, 'getAvailabilitySettings'])->name('partner.property.availability-settings.get');

    Route::post('/property/{property}/house-rules', [\App\Http\Controllers\PropertyController::class, 'saveHouseRules'])->name('partner.property.house-rules.store');
    Route::post('/property/{property}/availability-settings', [\App\Http\Controllers\PropertyController::class, 'saveAvailabilitySettings'])->name('partner.property.availability-settings.store');
    Route::get('/languages', [PropertyDataController::class, 'getLanguages'])->name('partner.languages.get');
    Route::post('/property/save-additional-details', [PropertyController::class, 'saveAdditionalDetails'])->name('partner.property.save-additional-details');
    Route::post('/property/save-services/{property}', [PropertyController::class, 'saveServices']);
    Route::post('/save-languages/{property}', [PropertyController::class, 'saveLanguages']);
    Route::post('/property/save-payment-method', [PropertyController::class, 'savePaymentMethod'])->name('partner.property.savePaymentMethod');
    Route::post('/property/save-invoicing/{property}', [PropertyController::class, 'saveInvoicing'])->name('partner.property.saveInvoicing');
    Route::post('/property/save-payment-step/{property}', [PropertyController::class, 'savePaymentStep'])->name('partner.property.savePaymentStep');
    Route::post('/property/save-verification/{property}', [PropertyController::class, 'saveVerification'])->name('partner.property.saveVerification');
    Route::patch('/property/complete-payment/{property}', [PropertyController::class, 'completePaymentProcess'])->name('partner.property.completePayment');
});

Route::post('/save-amenities/{propertyId}', [PropertyController::class, 'saveAmenities']);
Route::post('/property/save-address-same', [PropertyController::class, 'saveAddressSame']);
Route::post('/property/save-address-multiple', [PropertyController::class, 'saveAddressMultiple']);
Route::get('/partner-homes-complete-registration/{id}', [PropertyController::class, 'completeHomesRegistration'])->name('partner.homes.complete.registration');

Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::post('/rooms/update-bathroom-details', [RoomController::class, 'updateBathroomDetails']);
Route::post('/save-step-3-amenities', [RoomController::class, 'saveStep3Amenities']);
Route::post('/save-step-4-room-name', [RoomController::class, 'saveStep4RoomName']);
Route::post('/save-step-5-room-prices', [RoomController::class, 'saveStep5RoomPrices']);
Route::post('/save-step-6-room-rate-plans', [RoomController::class, 'storeRatePlans'])->name('rooms.ratePlans');
Route::delete('/rooms/{propertyId}/{roomTypeId}', [RoomController::class, 'destroyByType'])->name('rooms.destroyByType');
Route::post('/rooms/{roomTypeId}', [RoomController::class, 'update'])->name('rooms.update');
Route::post('/properties/{id}/open-for-bookings', [RoomController::class, 'updateBookingStatus']);

Route::post('/store-step', function (\Illuminate\Http\Request $request) {
    session(['current_step' => $request->step]);
    return response()->json(['status' => 'ok']);
});

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

Route::post('/partner/property/step1', [PropertyController::class, 'storeStep1'])->name('partner.property.step1.store_new');
Route::middleware(\App\Http\Middleware\EnsurePartner::class)->group(function () {
    Route::get('/partner/property/test-index', [PropertyController::class, 'index']);
});

Route::post('/property/{property}/update-title', [PropertyController::class, 'updateTitle'])->name('partner.property.update-title');

Route::patch('/partner/property/{property}/additional-details', [PropertyController::class, 'updateAdditionalDetails'])
    ->name('partner.property.update.additional-details.partner');

Route::post('/partner/property/{property}/pricing', [PropertyController::class, 'savePricing'])
    ->name('partner.property.save.pricing');

Route::post('/partner/property/{property}/rate-plans', [PropertyController::class, 'saveRatePlans'])
    ->name('partner.property.save.rate-plans');




require __DIR__ . '/auth.php';


// Admin Portal Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/admin-login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/admin-login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
        Route::get('/admin-registration', [\App\Http\Controllers\Admin\AuthController::class, 'showRegister'])->name('register');
        Route::post('/admin-registration', [\App\Http\Controllers\Admin\AuthController::class, 'register']);
        Route::get('/admin-forgot-password', [\App\Http\Controllers\Admin\AuthController::class, 'showForgotPassword'])->name('forgot-password');
        Route::post('/admin-forgot-password', [\App\Http\Controllers\Admin\AdminPasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/admin-reset-password/{token}', function ($token) {
            return view('admin.admin-reset-password', [
                'token' => $token,
                'email' => request('email')
            ]);
        })->name('password.reset');
        Route::post('/admin-reset-password', [\App\Http\Controllers\Admin\AdminNewPasswordController::class, 'store'])->name('password.store');
    });

    // Protected admin routes
    Route::middleware(['auth:admin', \App\Http\Middleware\AdminMiddleware::class, \App\Http\Middleware\PreventBackHistory::class])->group(function () {
        Route::get('/center', [\App\Http\Controllers\Admin\DashboardController::class, '__invoke'])->name('dashboard');
        Route::post('/exit', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // Customer and Partner detail routes
        Route::get('/customer/{customer}', [\App\Http\Controllers\Admin\CustomerViewController::class, 'show'])->name('customer.view');
        Route::get('/partner/{partner_id}', [\App\Http\Controllers\Admin\PartnerViewController::class, 'show'])->name('partner.view');

        // Customer and Partner detail routes
        Route::get('/customer/{customer_id}', [\App\Http\Controllers\Admin\CustomerViewController::class, 'show'])->name('customer.view');
        Route::get('/partner/{partner_id}', [\App\Http\Controllers\Admin\PartnerViewController::class, 'show'])->name('partner.view');

        // Property managementt
        Route::get('/units', function () {
            return view('admin.admin-apartments');
        })->name('apartments');
        Route::get('/residences', function () {
            return view('admin.admin-homes');
        })->name('homes');
        Route::get('/venues', function () {
            return view('admin.admin-hotels');
        })->name('hotels');
        Route::get('/unique-stays', function () {
            return view('admin.admin-alternative-places');
        })->name('alternative.places');

        // Customer management
        Route::get('/accounts', function () {
            return view('admin.admin-customers');
        })->name('customers');
        Route::post('/account-details', [\App\Http\Controllers\Admin\CustomerViewController::class, 'show'])->name('admin.customer.view');

        // Partner management
        Route::get('/partners', function () {
            return view('admin.admin-partners');
        })->name('partners');
        Route::post('/partner-details', [\App\Http\Controllers\Admin\PartnerViewController::class, 'show'])->name('admin.partner.view');

        // Settings
        Route::get('/settings', function () {
            return view('admin.admin-settings');
        })->name('settings');

        // Super admin only routes
        Route::middleware(\App\Http\Middleware\SuperAdminMiddleware::class)->group(function () {
            Route::get('/pending', [\App\Http\Controllers\Admin\AdminApprovalController::class, 'index'])->name('approvals.index');
            Route::post('/pending/{admin}/approve', [\App\Http\Controllers\Admin\AdminApprovalController::class, 'approve'])->name('approvals.approve');
            Route::post('/pending/{admin}/reject', [\App\Http\Controllers\Admin\AdminApprovalController::class, 'reject'])->name('approvals.reject');
        });
    });
});


Route::get('/partner-home-final-steps', function () {
    return view('frontend.partner-home-final-steps');
})->name('frontend.partner-home-final-steps');


Route::get('/apartment/final', function () {
    return view('frontend.partner-apartment-final');
})->name('partner.apartment.final');





Route::get('/customer-myAccount', function () {
    return view('frontend.customer-myAccount');
})->name('account.myAccount');


Route::get('/rewards-wallet', function () {
    return view('frontend.rewards-wallet');
})->name('rewards.wallet');

Route::get('/my-next-trip', function () {
    return view('frontend.my-next-trip');
})->name('my.next.trip');

Route::get('/bookings-trips', function () {
    return view('frontend.bookings-trips');
})->name('bookings.trips');

Route::get('/my-reviews', function () {
    return view('frontend.reviews');
})->name('reviews');


Route::get('/single-hotel', function () {
    return view('frontend.single-hotel');
})->name('single-hotel');

Route::get('/single-hotels', function () {
    return view('frontend.single-hotels');
})->name('single-hotels');

Route::get('/car-listing', function () {
    return view('frontend.car-listing');
})->name('car-listing');

Route::get('/hotel-listing', function () {
    return view('Customer.hotel-lisitng');
})->name('hotel-listing');

Route::get('/hotel-listing', function () {
    return view('Customer.hotel-lisitng');
})->name('hotel-listing');



// Admin Dashboard Route - Updated to use dynamic controller (public access for testing)
Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, '__invoke']);
Route::view('/admin/rental/taxi', 'frontend.admin.taxi')->name('admin.taxi');
Route::view('/admin/rental/airport', 'frontend.admin.airport')->name('admin.airport');
Route::view('/admin/taxi-details', 'frontend.admin.taxi-details');






Route::get('/partner/apartment/bedrooms/{property}', function ($propertyId) {
    $property = \App\Models\Property::findOrFail($propertyId);
    $bedTypes = \App\Models\BedType::all();

    // Fetch existing bedrooms for this property
    $existingBedrooms = \App\Models\PropertyBedroom::where('property_id', $propertyId)->get();

    // Convert to rooms structure for frontend
    $rooms = [
        'bedroom1' => ['name' => 'Bedroom 1', 'twin' => 0, 'full' => 1, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
        'livingRoom' => ['name' => 'Living room', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0],
        'otherSpaces' => ['name' => 'Other spaces', 'twin' => 0, 'full' => 0, 'queen' => 0, 'king' => 0, 'bunk' => 0, 'sofa' => 0, 'futon' => 0]
    ];

    foreach ($existingBedrooms as $room) {
        $roomKey = strtolower(str_replace(' ', '', $room->name));
        $rooms[$roomKey] = [
            'name' => $room->name,
            'twin' => $room->twin ?? 0,
            'full' => $room->full ?? 0,
            'queen' => $room->queen ?? 0,
            'king' => $room->king ?? 0,
            'bunk' => $room->bunk ?? 0,
            'sofa' => $room->sofa ?? 0,
            'futon' => $room->futon ?? 0
        ];
    }

    return view('partner.partner-apartments-bedrooms', compact('property', 'bedTypes', 'rooms'));
})->name('partner.apartment.bedrooms');

// Temporary redirect for old URL pattern
Route::get('/partner/property/apartment/bedrooms/{property}', function ($propertyId) {
    return redirect('/partner/apartment/bedrooms/' . $propertyId);
});

Route::get('/partner/property/{category}/step3/{property}', function ($category, $propertyId) {
    $property = \App\Models\Property::findOrFail($propertyId);
    $bedTypes = \App\Models\BedType::all();
    return view('partner.partner-apartments-bedrooms', compact('property', 'bedTypes', 'category'));
})->name('partner.property.step3');

Route::post('/partner/property/bedroom/{property}', [PropertyController::class, 'saveBedroom'])->name('partner.property.bedroom.store');

Route::post('/partner/property/{property}/policy', [\App\Http\Controllers\PropertyController::class, 'savePolicy']);

Route::post('/partner/property/{property}/host-profile', [PropertyController::class, 'saveHostProfile']);

Route::get('/partner/property/{property}/check-basic-info', [PropertyController::class, 'checkBasicInfoCompletion'])->name('partner.property.check-basic-info');

Route::post('/partner/property/{property}/pricing', [PropertyController::class, 'savePricing']);
Route::post('/partner/property/{property}/address-type', [PropertyController::class, 'saveAddressType']);



// Apartment pricing-related routes
Route::get('/partner/apartment/non-refundable-rate', function () {
    return view('partner.partner-apartment-non-refundable-rate');
})->name('partner.apartment.non.refundable.rate');

Route::get('/partner/apartment/price/group', function () {
    return view('partner.partner-apartment-priceper-group');
})->name('partner.apartment.price.group');

Route::get('/partner/apartment/pricing/cancel-policies', function () {
    return view('partner.partner-apartment-pricing-cancel-policies');
})->name('partner.apartment.pricing.policies');

Route::get('/partner/apartment/weekly-rate', function () {
    return view('partner.partner-apartment-weekly-rate');
})->name('partner.apartment.weekly.rate');


Route::get('/partner/partner-multiple-apartment/{property}', [PropertyController::class, 'showMultipleApartmentForm'])->name('partner.multiple.apartment');

Route::get('/partner/multiple-apartment/{property?}', [PropertyController::class, 'showMultipleApartmentForm'])->name('partner.multiple.apartment.initial');
Route::get('/partner/multiple-apartment-2/{propertyId}', [PropertyController::class, 'showMultipleApartmentForm2'])->name('partner.multiple.apartment.2');
Route::post('/partner/property/{property}/step1-data', [PropertyController::class, 'saveStep1Data'])->name('partner.property.step1-data');
Route::get('/partner/get-latest-property', [PropertyDataController::class, 'getLatestProperty'])->name('partner.get.latest.property');
Route::post('/partner/property/upload-photos', [PropertyController::class, 'uploadPhotos'])->name('partner.property.upload-photos');
Route::get('/partner/multiple-apartment-3', [PropertyController::class, 'showMultipleApartmentForm3'])->name('partner.multiple.apartment.3');
Route::post('/partner/apartment/pricing/cancel-policies/{property}', [PropertyController::class, 'saveCancelPolicy'])->name('partner.apartment.pricing.cancel-policies.save');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'You have been logged out.');
})->name('logout');

