<?php

namespace App\DTO;

class PaymentStatusDTO
{
    /**
     * @var string|null $commerceOrder El número de la orden del comercio.
     */
    public readonly ?string $commerceOrder;

    /**
     * @var int|null $status El estado de la orden:
     * 1 - pendiente de pago
     * 2 - pagada
     * 3 - rechazada
     * 4 - anulada
     */
    public readonly ?int $status;

    public function __construct( ?string $commerceOrder, ?int $status ) {
        $this->commerceOrder = $commerceOrder;
        $this->status = $status;
    }
}
