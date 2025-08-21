<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('partner.settings.index');
    }
}