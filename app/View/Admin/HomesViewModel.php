<?php

namespace App\View\Admin;

class HomesViewModel
{
    public function __construct(
        private array $data
    ) {}

    public function toArray(): array
    {
        return [
            'properties' => $this->data['properties'],
            'pagination' => $this->data['pagination'],
            'total' => $this->data['total'],
            'pageTitle' => 'Homes Listings',
            'breadcrumb' => 'Homes'
        ];
    }
}
