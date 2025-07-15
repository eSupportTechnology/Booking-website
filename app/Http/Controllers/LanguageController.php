<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request){
        Log::info('Language change request received', ['lang' => $request->lang]);
        $lang = $request->lang;

        Session::put("locale", $lang);
        return redirect()->back()->with('success', 'Language changed successfully!');
    }
}
