<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetPropertyDataAction;
use App\Actions\Partner\GetBookingDataAction;
use App\Actions\Partner\GetPropertyByTypeAction;

class PropertyController extends Controller
{
    public function index(GetPropertyDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.properties.index', $data);
    }

    public function apartments(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('apartments');
        
        return view('partner.properties.apartments', $data);
    }

    public function homes(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('homes');
        
        return view('partner.properties.homes', $data);
    }

    public function hotels(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('hotels');
        
        return view('partner.properties.hotels', $data);
    }

    public function alternativePlaces(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('alternative-places');
        
        return view('partner.properties.alternative-places', $data);
    }

    public function bookings(GetBookingDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.properties.bookings', $data);
    }
}