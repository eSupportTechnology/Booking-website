<?php
// app/Services/Admin/PartnersService.php

namespace App\Services\Admin;

use App\Models\Partner; // Make sure you have a Partner model
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PartnersService
{
    public function getPartnersData(int $perPage = 10): LengthAwarePaginator
    {
        return Partner::with('properties')
            ->withCount('properties')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);
    }
}
