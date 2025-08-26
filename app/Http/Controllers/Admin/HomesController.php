<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HomesService;
use App\View\Admin\HomesViewModel;
use Illuminate\Http\Request;

class HomesController extends Controller
{
    public function __construct(
        private HomesService $HomesService
    ) {}

    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $data = $this->HomesService->getHomesData($perPage);
        $viewModel = new HomesViewModel($data);

        return view('admin.admin-homes', $viewModel->toArray());
    }
}
