<?php

namespace App\View\Admin;

class AlternativePlacesViewModel
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
            'pageTitle' => 'Alternative Places Listings',
            'breadcrumb' => 'Alternative Places'
        ];
    }
}
