<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Actions\Partner\GetApartmentEditDataAction;
use App\Actions\Partner\UpdateApartmentDataAction;
use Illuminate\Http\Request;

class ApartmentEditController extends Controller
{
    public function edit(Property $property, GetApartmentEditDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $data = $action->execute($property);
        
        return view('partner.partner-apartment-edit', $data);
    }

    public function update(Property $property, Request $request, UpdateApartmentDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $action->execute($property, $request->all());
        
        return redirect()->route('partner.apartments.edit', $property)
            ->with('success', 'Apartment updated successfully');
    }
}