<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ApartmentsService;
use App\View\Admin\ApartmentsViewModel;
use Illuminate\Http\Request;

class ApartmentsController extends Controller
{
    public function __construct(
        private ApartmentsService $apartmentsService
    ) {}

    public function __invoke(Request $request)
    {
        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        
        if (!$admin->isSuperAdmin() && !$admin->can('view_apartments')) {
            abort(403, 'You do not have permission to access this page.');
        }
        
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $data = $this->apartmentsService->getApartmentsData($perPage);
        $viewModel = new ApartmentsViewModel($data);

        return view('admin.admin-apartments', $viewModel->toArray());
    }
}
