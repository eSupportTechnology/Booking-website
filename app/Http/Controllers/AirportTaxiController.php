<?php

namespace App\Http\Controllers;

use App\Models\TaxiType;
use Illuminate\Http\Request;

class AirportTaxiController extends Controller
{
    public function index()
    {
        $taxti_types = TaxiType::all();
        return view('airport_taxis.airport-taxi-register', compact('taxti_types'));
    }
}
