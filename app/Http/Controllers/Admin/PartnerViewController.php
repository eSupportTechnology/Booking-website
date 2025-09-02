<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerViewController extends Controller
{
    public function show($partner_id)
    {
        // Validate the ID exists
        Validator::make(['partner_id' => $partner_id], [
            'partner_id' => 'required|integer|exists:users,id'
        ])->validate();

        $partner = User::with([
            'partnerPersonalDetail',
            'partner',
            'properties' => function($query) {
                $query->with([
                    'accommodation' => function($query) {
                        $query->with('businessEntities');
                    },
                    'reviews',
                    'photos'
                ]);
            },
            'bookings' => function($query) {
                $query->latest();
            }
        ])
        ->whereHas('partner')
        ->findOrFail($partner_id);

        return view('admin.admin-partner-view', compact('partner'));
    }
}
