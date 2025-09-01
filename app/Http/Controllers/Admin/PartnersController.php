<?php
// app/Http/Controllers/Admin/PartnersController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PartnersService;
use App\View\Admin\PartnersViewModel;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function __construct(
        private PartnersService $partnersService
    ) {}

    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 20, 50]) ? $perPage : 5;

        $paginator = $this->partnersService->getPartnersData($perPage);
        $data = [
            'partners' => $paginator,
            'perPage' => $perPage
        ];
        $viewModel = new PartnersViewModel($data);

        return view('admin.admin-partners', $viewModel->toArray());
    }
}
