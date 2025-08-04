<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        return view('partner.messages.index');
    }
}