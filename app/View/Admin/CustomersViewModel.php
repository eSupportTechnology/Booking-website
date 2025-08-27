<?php

namespace App\View\Admin;

use App\DTOs\Admin\CustomerListDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class CustomersViewModel
{
    public array $customers;
    public LengthAwarePaginator $pagination;
    public int $total;
    public int $perPage;
    public ?string $search;
    public ?string $status;

    public function __construct(array $data)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $data['customers'];

        $this->customers = collect($paginator->items())
            ->map(fn($user) => CustomerListDto::fromModel($user))
            ->map(fn(CustomerListDto $dto) => [
                'id' => $dto->id,
                'name' => $dto->name,
                'email' => $dto->email,
                'phone' => $dto->phone,
                'status' => $dto->status,
                'registrationDate' => $dto->registrationDate,
                'bookingsCount' => $dto->bookingsCount,
                'reviewsCount' => $dto->reviewsCount,
            ])
            ->all();

        $this->pagination = $paginator;
        $this->total = $paginator->total();
        $this->perPage = $data['perPage'] ?? 10;
        $this->search = $data['search'] ?? null;
        $this->status = $data['status'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'customers' => $this->customers,
            'pagination' => $this->pagination,
            'total' => $this->total,
            'perPage' => $this->perPage,
            'search' => $this->search,
            'status' => $this->status,
        ];
    }
}
