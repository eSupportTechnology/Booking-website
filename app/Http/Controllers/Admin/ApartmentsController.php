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
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $data = $this->apartmentsService->getApartmentsData($perPage);
        $viewModel = new ApartmentsViewModel($data);

        return view('admin.admin-apartments', $viewModel->toArray());
    }
}
