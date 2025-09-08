<?php

namespace App\View\Admin;

use Illuminate\Pagination\LengthAwarePaginator;

class AirportTransferListViewModel
{
    public function __construct(
        public LengthAwarePaginator $transfers,
        public array $filters = []
    ) {}

    public function toArray(): array
    {
        return [
            'transfers' => $this->transfers,
            'filters' => $this->filters,
            'statusOptions' => [
                'Scheduled' => 'Scheduled',
                'Completed' => 'Completed',
                'Cancelled' => 'Cancelled'
            ]
        ];
    }
}