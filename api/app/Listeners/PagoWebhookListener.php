<?php

namespace App\Listeners;

use Exception;
use App\Models\Cita;
use App\Events\PagoWebhookEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\PaymentGatewayInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class PagoWebhookListener
{
    protected PaymentGatewayInterface $paymentGateway;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PagoWebhookEvent  $event
     * @return void
     */
    public function handle(PagoWebhookEvent $event)
    {
        try{
            Log::info('Listener PagoWebhookListener ejecutado.');
            
            $request = $event->request;

            Log::info( json_encode( $request ) );

            $token = $request['token'];

            $paymentResponse = $this->paymentGateway->getStatus( $token );
            $commerceOrder = $paymentResponse->commerceOrder;
            $status = (int) $paymentResponse->status; // 2 = pago exitoso

            if ($status == 2) {
                $idCita = explode('-', $commerceOrder)[1]; // El id se obtiene de acuerdo al formato de commerceOrder : rand(1100,2000).'-'.$cita->id
                $cita = Cita::find($idCita);

                if ($cita) {
                    $cita->update([
                        'estado_id' => $status,
                    ]);
                }
            }
        }catch (Exception $e) {
            Log::error('Error en PagoWebhookListener: ' . $e->getMessage());
        }
    }
}
