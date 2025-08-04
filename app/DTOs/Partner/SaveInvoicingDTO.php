<?php

namespace App\DTOs\Partner;

use Spatie\LaravelData\Data;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveInvoicingDTO extends ValidatedDTO
{
    public string $invoice_name;

    public ?string $legal_company_name;

    public ?string $same_address;

    public ?array $address;

    public  function rules(): array
    {
        return [
            'invoice_name' => ['required', 'string'],
            'legal_company_name' => ['nullable', 'string'],
            'same_address' => ['nullable', 'in:yes,no'],
            'street' => ['required_if:same_address,no', 'string'],
            'city' => ['required_if:same_address,no', 'string'],
            'line1' => ['required_if:same_address,no', 'string'],
            'postcode' => ['required_if:same_address,no', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'legal_company_name' => null,
            'same_address' => 'yes',
            'address' => null,
        ];
    }

    protected function casts(): array
    {
        return [
        ];
    }

}

