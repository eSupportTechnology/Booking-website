<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerViewController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|integer|exists:users,id'
        ]);
        
        $partnerId = $request->partner_id;
        
        return view('admin.admin-partner-view', compact('partnerId'));
    }
}