<?php

namespace App\Http\Controllers\Pagos;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\DTO\PaymentRequestDTO;
use App\Events\PagoWebhookEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class PagoController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->middleware(['auth:sanctum', 'role:paciente'])->only(['store']);

        $this->paymentGateway = $paymentGateway;
    }

    public function store(Cita $cita)
    {
        $paciente = auth()->user();

        $paymentRequest = new PaymentRequestDTO(
            commerceOrder: rand(1100,2000).'-'.$cita->id,
            subject: 'Pago de cita médica',
            amount: $cita->precio,
            customerEmail: $paciente->email,
            urlReturn: route('pagos.exito'),
            urlConfirmation: route('pagos.webhook'),
            paymentMethod: 9
        );

        $paymentResponse = $this->paymentGateway->createPayment($paymentRequest);

        return ResponseBuilder::asSuccess()
            ->withData([
                'token' => $paymentResponse->token,
                'url_pago' => $paymentResponse->redirectUrl."?token=".$paymentResponse->token,
                'orden_flujo' => $paymentResponse->flowOrder
            ])
            ->withHttpCode(201)
            ->build();
    }

    /**
     * Pagina del comercio para redireccion del pagador
     * A esta página Flow redirecciona al pagador pasando vía POST
     * el token de la transacción. En esta página el comercio puede
     * mostrar su propio comprobante de pago
     */
    public function exito(Request $request)
    {
        return ResponseBuilder::asSuccess()
            ->withData([])
            ->withHttpCode(200)
            ->withMessage('¡Gracias! Tu pago fue procesado exitosamente.')
            ->build();
    }

    /**
     * Pagina del comercio para recibir la confirmación del pago
     * Flow notifica al comercio del pago efectuado
     */
    public function webhook(Request $request)
    {
        Log::info('Webhook recibido');

        if( !isset($request->token) ) {
            return ResponseBuilder::asError(500)
                ->withHttpCode(500)
                ->withMessage('No se recibio el token.')
                ->build();
        }

        /**
         * A futuro se puede integrar el flujo de la transaccion
         * en queue en segundo plano
         * por el momento solo se dispara el evento
         */
        event(new PagoWebhookEvent( $request->all() ));

        return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage('Webhook recibido correctamente.')
            ->build();
    }
}
