<?php

// app/View/Admin/PartnersViewModel.php

namespace App\View\Admin;

use Illuminate\Contracts\Support\Htmlable;

readonly class PartnersViewModel
{
    public array $partners;
    public Htmlable $pagination;
    public int $perPage;

    public function __construct(array $data)
    {
        $this->partners = $data['partners']->map(fn ($partner) => [
            'id' => $partner->id,
            'name' => $partner->name ?? $partner->user?->name ?? 'N/A',
            'email' => $partner->email ?? $partner->user?->email ?? 'N/A',
            'phone' => $partner->phone ?? 'N/A',
            'status' => $partner->is_verified ? 'Active' : 'Pending verification',
            'propertyCount' => $partner->properties_count ?? 0,
            'createdAt' => $partner->created_at->format('Y-m-d'),
        ])->all();

        $this->pagination = $data['partners']; // This is LengthAwarePaginator
        $this->perPage = $data['perPage'] ?? 5;
    }

    public function toArray(): array
    {
        return [
            'partners' => $this->partners,
            'pagination' => $this->pagination,
            'perPage' => $this->perPage,
        ];
    }
}
