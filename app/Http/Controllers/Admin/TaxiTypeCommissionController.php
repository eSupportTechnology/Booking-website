<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxiTypeCommission;
use App\Models\CarRenter;
use Illuminate\Http\Request;

class TaxiTypeCommissionController extends Controller
{
    public function update(Request $request, CarRenter $carRenter)
    {
        $request->validate([
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->commissions as $taxiTypeId => $rate) {
            TaxiTypeCommission::updateOrCreate(
                [
                    'car_renter_id' => $carRenter->id,
                    'taxi_type_id'  => $taxiTypeId,
                ],
                [
                    // null = default 15%
                    'commission_rate' => ($rate === null || $rate == 15) ? null : $rate,
                ]
            );
        }

        return back()->with('success', 'Taxi commission rates updated successfully.');
    }
}

