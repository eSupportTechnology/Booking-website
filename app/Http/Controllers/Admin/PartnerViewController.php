<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerViewController extends Controller
{
    public function show($partner_id)
    {
        // Validate the ID exists
        validator(['partner_id' => $partner_id], [
            'partner_id' => 'required|integer|exists:users,id'
        ])->validate();

        $partnerId = $partner_id;

        return view('admin.admin-partner-view', compact('partnerId'));
    }
}
