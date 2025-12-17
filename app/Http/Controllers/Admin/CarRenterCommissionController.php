<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarRenter;
use App\Models\VehicleTypeCommission;

class CarRenterCommissionController extends Controller
{
    /**
     * Update commission rates per vehicle type for a car renter
     */
    public function update(Request $request, $carRenterId)
    {
        $request->validate([
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $carRenter = CarRenter::findOrFail($carRenterId);

        foreach ($request->commissions as $vehicleTypeId => $rate) {
            VehicleTypeCommission::updateOrCreate(
                [
                    'car_renter_id' => $carRenter->id,
                    'vehicle_type_id' => $vehicleTypeId,
                ],
                [
                    // Store NULL if default (15%)
                    'commission_rate' => ($rate == 15 || $rate === null) ? null : $rate,
                ]
            );
        }

        return back()->with('success', 'Vehicle type commission rates updated successfully.');
    }
}
