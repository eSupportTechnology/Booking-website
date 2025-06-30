<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

// You can define your API routes here. For now, it's empty.
// In routes/api.php
Route::post('/property/register', [PropertyController::class, 'register']);
