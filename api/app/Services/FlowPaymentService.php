<?php

namespace App\Services;

use App\DTO\PaymentStatusDTO;
use App\DTO\PaymentRequestDTO;
use App\DTO\PaymentResponseDTO;
use Illuminate\Support\Facades\Http;
use App\Services\PaymentGatewayInterface;

class FlowPaymentService implements PaymentGatewayInterface
{
    protected string $apiUrl;
    protected string $apiKey;
    protected string $secretKey;
    protected string $currency;

    public function __construct()
    {
        $this->apiUrl = config('flowapi.FLOW_URL_SANDBOX');
        $this->apiKey = config('flowapi.FLOW_API_KEY');
        $this->secretKey = config('flowapi.FLOW_SECRET_KEY');
        $this->currency = config('flowapi.FLOW_CURRENCY');
    }

    protected function crearFirma(array $payload): string
    {
        ksort($payload);
        $string = urldecode(http_build_query($payload));
        return hash_hmac('sha256', $string, $this->secretKey);
    }

    public function createPayment(PaymentRequestDTO $request): PaymentResponseDTO
    {
        $payload = [
            'apiKey' => $this->apiKey, //apiKey del comercio
            'commerceOrder' => $request->commerceOrder, //Orden del comercio
            'subject' => $request->subject, //Descripción de la orden
            'amount' => $request->amount, //Monto de la orden
            'currency' => $this->currency, //Moneda de la orden
            'email' => $request->customerEmail, //email del pagador
            'paymentMethod' => $request->paymentMethod, //Para indicar todos los medios de pago utilice el identificador: 9
            'urlConfirmation' => $request->urlConfirmation, //url callback del comercio donde Flow confirmará el pago
            'urlReturn' => $request->urlReturn, //url de retorno del comercio donde Flow redirigirá al pagador
        ];

        $payload["s"] = $this->crearFirma($payload);

        $response = Http::asForm()->post($this->apiUrl . '/payment/create', $payload);

        if(!$response->successful()) {
            throw new \Exception('Error al crear el pago en Flow: ' . $response->body());
        }

        $data = $response->json();

        return new PaymentResponseDTO(
            $data['token'] ?? null,
            $data['url'] ?? null,
            $data['flowOrder'] ?? null
        );
    }

    public function getStatus( string $token) : PaymentStatusDTO {
        $payload = [
            'apiKey' => $this->apiKey, //apiKey del comercio
            'token' => $token, //token de la transacción enviado por Flow
        ];

        $payload["s"] = $this->crearFirma($payload);

        $response = Http::asForm()->get($this->apiUrl . '/payment/getStatus', $payload);

        if(!$response->successful()) {
            throw new \Exception('Error al obtener el estado de la orden, token ('.$token.') : ' . $response->body());
        }

        $data = $response->json();

        return new PaymentStatusDTO(
            $data['commerceOrder'] ?? null,
            $data['status'] ?? null
        );
    }
}
