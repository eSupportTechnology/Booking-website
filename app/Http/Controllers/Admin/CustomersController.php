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

    public function __invoke(Request $request)
    {
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
