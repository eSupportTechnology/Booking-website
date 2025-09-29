<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarRenter;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = CarRenter::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by account type
        if ($request->filled('account_type')) {
            $query->where('account_type', $request->account_type);
        }

        $providers = $query->withCount(['cars', 'taxis'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('admin.admin-RentalServiceProviders', compact('providers'));
    }

    public function show(CarRenter $provider)
    {
        $provider->load(['cars', 'taxis']);
        return view('admin.admin-RentalServiceProviders-details', compact('provider'));
    }
}