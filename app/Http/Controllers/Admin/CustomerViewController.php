<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerViewController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:users,id'
        ]);

        $customerId = $request->customer_id;

        return view('admin.admin-customer-view', compact('customerId'));
    }
}
