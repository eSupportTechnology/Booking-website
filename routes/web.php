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



Route::get('/login/email', [LoginController::class, 'showEmailForm'])->name('login.email');
Route::post('/login/email', [LoginController::class, 'storeEmail']);

Route::get('/login/password', [LoginController::class, 'showPasswordForm'])->name('login.password');
Route::post('/login/password', [LoginController::class, 'loginWithPassword']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);

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
    return view('frontend.partner-hotels-photos');
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


Route::post('/partner-homes-single', [PropertyController::class, 'showPrivateHomesSingle'])->name('partner.homes.single');
Route::post('/partner-homes-multiple', [PropertyController::class, 'showPrivateHomesMultiple'])->name('partner.homes.multiple');


Route::get('/partner-homes-rooms/{id}', [PropertyController::class, 'showPrivateHomesRooms'])->name('partner.homes.rooms');
Route::get('/partner-homes-edit/{id}', [PropertyController::class, 'showPrivateHomesEdit'])->name('partner.homes.edit');
Route::get('/partner-homes-payments/{id}', [PropertyController::class, 'showPrivateHomesPayments'])->name('partner.homes.payments');
Route::get('/partner-homes-images/{id}', [PropertyController::class, 'showPrivateHomesImages'])->name('partner.homes.images');

Route::get('/partner-apartments-final/{property?}', [PropertyController::class, 'showFinalStep'])->name('partner.apartments.final');

Route::get('/partner-hotels-edit', function () {
    return view('frontend.partner-hotels-edit');
})->name('partner.hotels.edit');

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
    Route::get('/login', [LoginController::class, 'show'])->name('partner.login');
    Route::post('/login', [LoginController::class, 'login'])->name('partner.login.submit');
    Route::get('/sign-in', [LoginController::class, 'showEmailForm'])->name('partner.login.email');
    Route::post('/sign-in', [LoginController::class, 'storeEmail']);
    Route::get('/password', [LoginController::class, 'showPasswordForm'])->name('partner.login.password');
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
Route::prefix('partner')->middleware('auth')->group(function () {
    Route::get('/property_category', [PropertyController::class, 'categories'])->name('partner.property.category');
    Route::get('/property_subcategory/{id}', [PropertyController::class, 'subcategories'])->name('partner.property.subcategory');
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


Route::get('/admin/dashboard', function () {
    return view('frontend.admin.dashboard');
})->name('admin.dashboard');


Route::get('/admin/customers', function () {
    return view('frontend.admin.customers');
})->name('admin.customers');

Route::get('/admin/customer-view', function () {
    return view('frontend.admin.customer-view');
});


















Route::get('/customer-myAccount', function () {
    return view('frontend.customer-myAccount');
})->name('account.myAccount');


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
