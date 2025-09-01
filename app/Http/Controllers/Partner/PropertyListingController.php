<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetPropertyListingsAction;
use App\Actions\Partner\ViewPropertyAction;
use Illuminate\Http\Request;

class PropertyListingController extends Controller
{
    public function apartments(Request $request, GetPropertyListingsAction $action)
    {
        $data = $action->execute('apartments', $request->get('search'), $request->get('status'));
        return view('partner.properties.apartments', $data);
    }

    public function homes(Request $request, GetPropertyListingsAction $action)
    {
        $data = $action->execute('homes', $request->get('search'), $request->get('status'));
        return view('partner.properties.homes', $data);
    }

    public function hotels(Request $request, GetPropertyListingsAction $action)
    {
        $data = $action->execute('hotels', $request->get('search'), $request->get('status'));
        return view('partner.properties.hotels', $data);
    }

    public function alternativePlaces(Request $request, GetPropertyListingsAction $action)
    {
        $data = $action->execute('alternativePlaces', $request->get('search'), $request->get('status'));
        return view('partner.properties.alternative-places', $data);
    }

    public function view(int $id, ViewPropertyAction $action)
    {
        $data = $action->execute($id);
        
        if (!$data['property']) {
            abort(404);
        }
        
        return view('partner.properties.views', $data);
    }
}