<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Customer\CustomerPersonalDetailsController;

Route::post('/send-sms', [SMSController::class, 'send']);
Route::post('/verify-otp', [SMSController::class, 'verify']);

// Profile image upload (uses auth from session)
Route::post('/profile/image', [CustomerPersonalDetailsController::class, 'updateProfileImage'])
    ->middleware('web');
// You can define your API routes here. For now, it's empty.
// In routes/api.php
Route::post('/property/register', [PropertyController::class, 'register']);

Route::post('/convert-price', [App\Http\Controllers\Api\CurrencyController::class, 'convertPrice']);
