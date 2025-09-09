<?php

namespace App\View\Admin;

use App\DTOs\Admin\CommissionAgingDTO;

class CommissionAgingViewModel
{
    public function __construct(
        private CommissionAgingDTO $dto
    ) {}

    public function toArray(): array
    {
        return [
            'dateFrom' => $this->dto->dateFrom,
            'dateTo' => $this->dto->dateTo,
            'partnerId' => $this->dto->partnerId,
            'commissionData' => $this->dto->commissionData,
            'partners' => $this->dto->partners,
            'totals' => $this->dto->totals
        ];
    }
}