<?php

namespace App\View\Admin;

use App\DTOs\Admin\AgingReportDTO;

class AgingReportViewModel
{
    public function __construct(
        private AgingReportDTO $dto
    ) {}

    public function toArray(): array
    {
        return [
            'dateFrom' => $this->dto->dateFrom,
            'dateTo' => $this->dto->dateTo,
            'propertyType' => $this->dto->propertyType,
            'status' => $this->dto->status,
            'agingData' => $this->dto->agingData,
            'propertyTypes' => $this->dto->propertyTypes,
            'statuses' => $this->dto->statuses
        ];
    }
}