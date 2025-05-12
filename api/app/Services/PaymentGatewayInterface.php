<?php

namespace App\Services;

use App\DTO\PaymentStatusDTO;
use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;

interface PaymentGatewayInterface
{
    /**
     * Crear un pago en el sistema de pasarela.
     *
     * @param PaymentRequestDTO $request
     * @return PaymentResponseDTO
     */
    public function createPayment(PaymentRequestDTO $request): PaymentResponseDTO;

    /**
     * Obtiene el estado de una orden de pago.
     *
     * @param PaymentRequestDTO $request
     * @return PaymentStatusDTO
     */
    public function getStatus(string $token): PaymentStatusDTO;
}
