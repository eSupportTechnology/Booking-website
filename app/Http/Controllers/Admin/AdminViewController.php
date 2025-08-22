<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    public function customers()
    {
        $customers = User::where('role', 'customer')->paginate(10);
        return view('admin.admin-customers', compact('customers'));
    }

    public function partners()
    {
        $partners = User::where('role', 'partner')->paginate(10);
        return view('admin.admin-partners', compact('partners'));
    }

    public function apartments()
    {
        $apartments = Property::with(['partner', 'photos'])
            ->where('type', 'apartment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.admin-apartments', compact('apartments'));
    }

    public function homes()
    {
        $homes = Property::with(['partner', 'photos'])
            ->where('type', 'home')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.admin-homes', compact('homes'));
    }

    public function hotels()
    {
        $hotels = Property::with(['partner', 'photos'])
            ->where('type', 'hotel')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.admin-hotels', compact('hotels'));
    }

    public function alternativePlaces()
    {
        $alternativePlaces = Property::with(['partner', 'photos'])
            ->whereIn('type', ['campsite', 'boat', 'tent'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.admin-alternative-places', compact('alternativePlaces'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $type = $request->get('type');

        $query = Property::with(['partner', 'photos'])
            ->where('type', $type);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('partner', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $properties = $query->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $properties
        ]);
    }
}
