<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\Admin\TaxiListDTO;
use App\Services\Admin\TaxiService;
use App\View\Admin\TaxiListViewModel;
use Illuminate\Http\Request;

class TaxiController extends Controller
{
    public function __construct(
        private TaxiService $taxiService
    ) {}

    public function __invoke(Request $request)
    {
        $dto = TaxiListDTO::fromRequest($request);
        $taxis = $this->taxiService->getTaxiList($dto);
        
        $viewModel = new TaxiListViewModel($taxis, $dto->toArray());
        
        return view('admin.admin-taxi', $viewModel->toArray());
    }
}