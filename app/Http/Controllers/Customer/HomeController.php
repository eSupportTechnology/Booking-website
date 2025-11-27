<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function popularCities()
    {
        // Fetch distinct city names from properties table
        $cities = DB::table('properties')
            ->select('city')
            ->distinct()
            ->orderBy('city', 'ASC')
            ->get(); // keep as collection (no toArray)

        // Log only city names
        $cityNames = $cities->pluck('city'); // get only city names
        Log::info('Cities fetched:', ['cities' => $cityNames->toArray()]);

        return view('Customer.home', compact('cities'));
    }
}
