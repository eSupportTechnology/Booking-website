<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetEarningsDataAction;

class EarningsController extends Controller
{
    public function index(GetEarningsDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.earnings.index', $data);
    }
}