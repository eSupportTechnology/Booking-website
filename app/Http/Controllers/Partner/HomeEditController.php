<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Actions\Partner\GetHomeEditDataAction;
use App\Actions\Partner\UpdateHomeDataAction;
use Illuminate\Http\Request;

class HomeEditController extends Controller
{
    public function edit(Property $property, GetHomeEditDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $data = $action->execute($property);
        
        return view('partner.partner-homes-edit', $data);
    }

    public function update(Property $property, Request $request, UpdateHomeDataAction $action)
    {
        // Check if user owns the property
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $action->execute($property, $request->all());
        
        return redirect()->route('partner.homes.edit.new', $property)
            ->with('success', 'Home updated successfully');
    }
}