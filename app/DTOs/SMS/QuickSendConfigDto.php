<?php

namespace App\DTOs\SMS;

class QuickSendConfigDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $apiKey,
        public readonly string $baseUrl,
        public readonly string $defaultSenderId
    ) {}

    public static function fromConfig(): self
    {
        return new self(
            email: config('services.quicksend.email'),
            apiKey: config('services.quicksend.api_key'),
            baseUrl: config('services.quicksend.base_url', 'https://quicksend.lk/Client/api.php'),
            defaultSenderId: config('services.quicksend.sender_id', 'QKSendDemo')
        );
    }

    public function getBasicAuthCredentials(): array
    {
        return [$this->email, $this->apiKey];
    }

    public function getGetAuthParameters(): array
    {
        return [
            'un' => $this->email,
            'up' => $this->apiKey,
        ];
    }
}
