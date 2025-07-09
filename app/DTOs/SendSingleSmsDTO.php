<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class SendSingleSmsDTO extends Data
{
    public function __construct(
        public string $senderID,
        public string $to,
        public string $msg
    ) {}
    
}

