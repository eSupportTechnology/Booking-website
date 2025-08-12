<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetMessagesDataAction;

class MessageController extends Controller
{
    public function index(GetMessagesDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.messages.index', $data);
    }
}