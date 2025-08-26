<?php

namespace App\View\Admin;

class HotelsViewModel
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
            'pageTitle' => 'Hotels Listings',
            'breadcrumb' => 'Hotels'
        ];
    }
}
