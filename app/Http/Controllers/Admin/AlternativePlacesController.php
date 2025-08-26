<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AlternativePlacesService;
use App\View\Admin\AlternativePlacesViewModel;

class AlternativePlacesController extends Controller
{
    public function __construct(
        private AlternativePlacesService $alternativePlacesService
    ) {}

    public function __invoke()
    {
        $data = $this->alternativePlacesService->getAlternativePlacesData();
        $viewModel = new AlternativePlacesViewModel($data);
        
        return view('admin.admin-alternative-places', $viewModel->toArray());
    }
}
