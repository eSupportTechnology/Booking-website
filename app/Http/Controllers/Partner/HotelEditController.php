<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Actions\Partner\GetHotelEditDataAction;
use App\Actions\Partner\UpdateHotelDataAction;
use Illuminate\Http\Request;

class HotelEditController extends Controller
{
    public function edit(Property $property, GetHotelEditDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $data = $action->execute($property);
        
        return view('partner.partner-hotels-edit', $data);
    }

    public function update(Property $property, Request $request, UpdateHotelDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $action->execute($property, $request->all());
        
        return redirect()->route('partner.hotels.edit.new', $property)
            ->with('success', 'Hotel updated successfully');
    }
}