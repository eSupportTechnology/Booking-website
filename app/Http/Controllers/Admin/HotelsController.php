<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HotelsService;
use App\View\Admin\HotelsViewModel;

class HotelsController extends Controller
{
    public function __construct(
        private HotelsService $hotelsService
    ) {}

    public function __invoke()
    {
        $data = $this->hotelsService->getHotelsData();
        $viewModel = new HotelsViewModel($data);
        
        return view('admin.admin-hotels', $viewModel->toArray());
    }
}
