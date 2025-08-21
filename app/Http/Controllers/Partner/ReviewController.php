<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        return view('partner.reviews.index');
    }
}