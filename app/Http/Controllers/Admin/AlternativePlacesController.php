<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AlternativePlacesService;
use App\View\Admin\AlternativePlacesViewModel;
use Illuminate\Http\Request;

class AlternativePlacesController extends Controller
{
    public function __construct(
        private AlternativePlacesService $alternativePlacesService
    ) {}

    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $data = $this->alternativePlacesService->getAlternativePlacesData($perPage);
        $viewModel = new AlternativePlacesViewModel($data);

        return view('admin.admin-alternative-places', $viewModel->toArray());
    }
}
