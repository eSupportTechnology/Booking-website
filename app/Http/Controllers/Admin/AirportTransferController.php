<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\Admin\AirportTransferListDTO;
use App\Services\Admin\AirportTransferService;
use App\View\Admin\AirportTransferListViewModel;
use Illuminate\Http\Request;

class AirportTransferController extends Controller
{
    public function __construct(
        private AirportTransferService $airportTransferService
    ) {}

    public function __invoke(Request $request)
    {
        $dto = AirportTransferListDTO::fromRequest($request);
        $transfers = $this->airportTransferService->getTransferList($dto);
        
        $viewModel = new AirportTransferListViewModel($transfers, $dto->toArray());
        
        return view('admin.admin-airport', $viewModel->toArray());
    }
}