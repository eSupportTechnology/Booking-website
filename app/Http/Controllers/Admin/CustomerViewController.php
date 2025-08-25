<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerViewController extends Controller
{
    public function show($customer_id)
    {
        // Validate the ID exists
        validator(['customer_id' => $customer_id], [
            'customer_id' => 'required|integer|exists:users,id'
        ])->validate();

        $customerId = $customer_id;

        return view('admin.admin-customer-view', compact('customerId'));
    }
}
