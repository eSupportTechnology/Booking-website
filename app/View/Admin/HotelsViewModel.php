<?php

namespace App\View\Admin;

// app/View/Admin/HotelsViewModel.php
use Illuminate\Contracts\Support\Htmlable;

readonly class HotelsViewModel
{
    public array $properties;
    public Htmlable $pagination;
    public int $total;
    public int $perPage;

    public function __construct(array $data)
    {
        $this->properties = $data['properties']->all();
        $this->pagination = $data['pagination'];
        $this->total = $data['total'];
        $this->perPage = $data['perPage'] ?? 5;

    }

    public function toArray(): array
    {
        return [
            'properties' => $this->properties,
            'pagination' => $this->pagination,
            'total' => $this->total,
            'perPage' => $this->perPage,
        ];
    }
}
