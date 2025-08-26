<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ApartmentsService;
use App\View\Admin\ApartmentsViewModel;

class ApartmentsController extends Controller
{
    public function __construct(
        private ApartmentsService $apartmentsService
    ) {}

    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $perPage = in_array($perPage, [10, 20, 30, 50]) ? $perPage : 15;

        $data = $this->apartmentsService->getApartmentsData($perPage);
        $viewModel = new ApartmentsViewModel($data);

        return view('admin.admin-apartments', $viewModel->toArray());
    }
}
