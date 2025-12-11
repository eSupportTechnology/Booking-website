<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarRentalDetailController extends Controller
{
    public function show($id)
    {
        $car = Car::with(['brand', 'model', 'company', 'renter'])
                ->findOrFail($id);

        return view('admin.admin-carrental-details', compact('car'));
    }
}
