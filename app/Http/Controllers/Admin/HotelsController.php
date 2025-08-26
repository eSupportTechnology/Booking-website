<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HotelsService;
use App\View\Admin\HotelsViewModel;
use Illuminate\Http\Request;

class HotelsController extends Controller
{
    public function __construct(
        private HotelsService $HotelsService
    ) {}

    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $data = $this->HotelsService->getHotelsData($perPage);
        $viewModel = new HotelsViewModel($data);

        return view('admin.admin-hotels', $viewModel->toArray());
    }
}
