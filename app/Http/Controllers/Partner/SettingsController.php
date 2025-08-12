<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetSettingsDataAction;

class SettingsController extends Controller
{
    public function index(GetSettingsDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.settings.index', $data);
    }
}