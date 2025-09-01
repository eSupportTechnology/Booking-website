<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CustomersService;
use App\Models\User;

class CustomerViewController extends Controller
{
    public function __construct(
        private CustomersService $customersService
    ) {}

    public function show(User $customer)
    {
        // Ensure this user is a customer (not a partner)
        if ($customer->partner()->exists()) {
            abort(404, 'Customer not found');
        }

        // Load additional relationships
        $customer->load(['bookings', 'reviews', 'travelerDetails']);

        return view('admin.admin-customer-view', compact('customer'));
    }
}
