<?php

use App\Http\Controllers\SMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::prefix('sms')->group(function () {
    Route::post('/send', [SMSController::class, 'sendSms']);
    Route::post('/send-get', [SMSController::class, 'sendSmsGet']);
});

// use App\Http\Controllers\SmController;

// Route::post('/send-sms', [SmController::class, 'send']);

// You can define your API routes here. For now, it's empty.
// In routes/api.php
Route::post('/property/register', [PropertyController::class, 'register']);
