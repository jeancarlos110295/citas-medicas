<?php

namespace App\DTO;

class PaymentRequestDTO
{
    public function __construct(
        public readonly string $commerceOrder,
        public readonly string $subject,
        public readonly float $amount,
        public readonly string $customerEmail,
        public readonly string $urlReturn,
        public readonly int $paymentMethod,
        public readonly string $urlConfirmation,
    ) {}
}
