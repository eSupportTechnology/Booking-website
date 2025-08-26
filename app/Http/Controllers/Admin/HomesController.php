<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HomesService;
use App\View\Admin\HomesViewModel;

class HomesController extends Controller
{
    public function __construct(
        private HomesService $homesService
    ) {}

    public function __invoke()
    {
        $data = $this->homesService->getHomesData();
        $viewModel = new HomesViewModel($data);
        
        return view('admin.admin-homes', $viewModel->toArray());
    }
}
