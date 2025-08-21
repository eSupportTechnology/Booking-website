<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetDashboardDataAction;

class DashboardController extends Controller
{
    public function index(GetDashboardDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.dashboard', $data);
    }
}