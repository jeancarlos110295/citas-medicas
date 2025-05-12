<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        //Se pueden capturar mas excepciones especificas para controlar la salida de errores
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            return ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage('No existe el recurso solicitado.')
                ->build();
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            return ResponseBuilder::asError(404)
                ->withHttpCode(404)
                ->withMessage('No existe el recurso solicitado.')
                ->build();
        });

        $this->renderable(function (UnauthorizedException $e, Request $request) {
            return ResponseBuilder::asError(403)
                ->withHttpCode(403)
                ->withMessage('No tienes permiso para acceder a este recurso.')
                ->build();
        });

        
    }
}
