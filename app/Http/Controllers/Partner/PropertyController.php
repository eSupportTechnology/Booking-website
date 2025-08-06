<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetPropertyDataAction;
use App\Actions\Partner\GetBookingDataAction;

class PropertyController extends Controller
{
    public function index(GetPropertyDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.properties.index', $data);
    }

    public function bookings(GetBookingDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.properties.bookings', $data);
    }
}