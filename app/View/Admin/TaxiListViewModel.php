<?php

namespace App\View\Admin;

use Illuminate\Pagination\LengthAwarePaginator;

class TaxiListViewModel
{
    public function __construct(
        public LengthAwarePaginator $taxis,
        public array $filters = []
    ) {}

    public function toArray(): array
    {
        return [
            'taxis' => $this->taxis,
            'filters' => $this->filters,
            'statusOptions' => [
                'Active' => 'Active',
                'Inactive' => 'Inactive', 
                'On Trip' => 'On Trip'
            ]
        ];
    }
}