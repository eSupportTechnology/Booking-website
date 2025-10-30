<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SMSController;

Route::post('/send-sms', [SMSController::class, 'send']);
Route::post('/verify-otp', [SMSController::class, 'verify']);
// You can define your API routes here. For now, it's empty.
// In routes/api.php
Route::post('/property/register', [PropertyController::class, 'register']);

Route::post('/convert-price', [App\Http\Controllers\Api\CurrencyController::class, 'convertPrice']);
