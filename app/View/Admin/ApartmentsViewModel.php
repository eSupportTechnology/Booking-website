<?php

namespace App\View\Admin;

// app/View/Admin/ApartmentsViewModel.php

readonly class ApartmentsViewModel
{
    public array $properties;
    public $pagination;
    public int $total;
    public int $perPage;

    public function __construct(array $data)
    {
        $this->properties = $data['properties'];
        $this->pagination = $data['pagination'];
        $this->total = $data['total'];
        $this->perPage = $data['perPage'] ?? 15;
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
