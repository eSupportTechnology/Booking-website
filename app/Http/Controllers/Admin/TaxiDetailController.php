<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TaxiService;
use App\View\Admin\TaxiDetailViewModel;

class TaxiDetailController extends Controller
{
    public function __construct(
        private TaxiService $taxiService
    ) {}

    public function __invoke(int $id)
    {
        $taxi = $this->taxiService->getTaxiById($id);
        
        if (!$taxi) {
            abort(404);
        }
        
        $viewModel = new TaxiDetailViewModel($taxi);
        
        return view('admin.admin-taxi-details', $viewModel->toArray());
    }
}