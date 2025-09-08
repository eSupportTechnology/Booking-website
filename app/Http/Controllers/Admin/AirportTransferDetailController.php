<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AirportTransferService;
use App\View\Admin\AirportTransferDetailViewModel;

class AirportTransferDetailController extends Controller
{
    public function __construct(
        private AirportTransferService $airportTransferService
    ) {}

    public function __invoke(int $id)
    {
        $transfer = $this->airportTransferService->getTransferById($id);
        
        if (!$transfer) {
            abort(404);
        }
        
        $viewModel = new AirportTransferDetailViewModel($transfer);
        
        return view('admin.admin-airport-details', $viewModel->toArray());
    }
}