<?php

namespace App\DTO;

class PaymentResponseDTO
{
    public function __construct(
        public readonly ?string $token,
        public readonly ?string $redirectUrl,
        public readonly ?string $flowOrder,
    ) {}
}
