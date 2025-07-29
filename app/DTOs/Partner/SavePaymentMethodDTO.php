<?php

namespace App\DTOs\Partner;

use Illuminate\Http\Request;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SavePaymentMethodDTO extends ValidatedDTO
{
    /** @var string */
    public string $paymentMethod;

    /** @var string|null */
    public ?string $cardNumber;

    /** @var string|null */
    public ?string $expiryDate;

    /** @var string|null */
    public ?string $cvv;

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'payment_method' => ['required', 'in:online,credit'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'property_id' => 0,
            'payment_method' => '',
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
