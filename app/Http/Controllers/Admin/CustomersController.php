<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CustomersService;
use App\View\Admin\CustomersViewModel;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function __construct(
        private CustomersService $customersService
    ) {}

    public function view($id)
    {
        $customer = $this->customersService->getCustomerById($id);

        if (!$customer) {
            abort(404);
        }

        return view('admin.admin-customer-view', [
            'customer' => $customer
        ]);
    }

    public function verifyEmail($id)
    {
        $customer = $this->customersService->getCustomerById($id);

        if (!$customer) {
            return response()->json(['success' => false], 404);
        }

        $customer->email_verified_at = now();
        $customer->save();

        return response()->json(['success' => true]);
    }

    public function activateAccount($id)
    {
        $customer = $this->customersService->getCustomerById($id);

        if (!$customer) {
            return response()->json(['success' => false], 404);
        }

        $customer->is_active = true;
        $customer->save();

        return response()->json(['success' => true]);
    }

    public function deactivateAccount($id)
    {
        $customer = $this->customersService->getCustomerById($id);

        if (!$customer) {
            return response()->json(['success' => false], 404);
        }

        $customer->is_active = false;
        $customer->save();

        return response()->json(['success' => true]);
    }

    public function __invoke(Request $request)
    {
        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        
        if (!$admin->isSuperAdmin() && !$admin->can('view_customers')) {
            abort(403, 'You do not have permission to access this page.');
        }
        
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 10;

        $search = $request->input('search');
        $status = $request->input('status');

        $customers = $this->customersService->getCustomersData($perPage, $search, $status);

        $data = [
            'customers' => $customers,
            'perPage' => $perPage,
            'search' => $search,
            'status' => $status
        ];

        $viewModel = new CustomersViewModel($data);

        return view('admin.admin-customers', $viewModel->toArray());
    }
}
