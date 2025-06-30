<?php

namespace App\Actions\SMS;

use App\DTOs\SendSmsRequestDto;
use InvalidArgumentException;

class ValidatePhoneNumberAction
{
    public function execute(string $phoneNumber): string
    {
        $formattedNumber = $this->formatPhoneNumber($phoneNumber);

        if (!$this->isValidPhoneNumber($formattedNumber)) {
            throw new InvalidArgumentException('Invalid phone number format. Expected format: 07XXXXXXXX');
        }

        return $formattedNumber;
    }

    private function formatPhoneNumber(string $phoneNumber): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($cleaned) === 9 && substr($cleaned, 0, 1) === '7') {
            $cleaned = '0' . $cleaned;
        }

        return $cleaned;
    }

    private function isValidPhoneNumber(string $phoneNumber): bool
    {
        return preg_match('/^07[0-9]{8}$/', $phoneNumber) === 1;
    }
}
