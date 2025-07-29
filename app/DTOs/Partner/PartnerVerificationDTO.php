<?php
namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PartnerVerificationDTO extends ValidatedDTO
{
    public int $property_id;
    public string $type;
    public ?string $full_name;
    public ?string $national_id;
    public ?string $company_name;
    public ?string $registration_number;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'type' => ['required', 'in:individual,business'],
            'full_name' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'registration_number' => ['nullable', 'string'],
        ];
    }
    protected function casts(): array
    {
        return [
          
        ];
    }
    protected function defaults(): array
    {
        return [
            'full_name' => null,
            'national_id' => null,
            'company_name' => null,
            'registration_number' => null,
        ];
    }
}
