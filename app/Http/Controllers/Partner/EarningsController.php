<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class EarningsController extends Controller
{
    public function index()
    {
        return view('partner.earnings.index');
    }
}