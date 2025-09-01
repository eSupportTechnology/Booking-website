<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetReviewsDataAction;

class ReviewController extends Controller
{
    public function index(GetReviewsDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.reviews.index', $data);
    }
}