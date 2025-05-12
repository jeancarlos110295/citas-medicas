<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ControllerTestApi extends Controller
{    
    public function index(Request $request)
    {
        return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage('API funcionando correctamente.')
            ->withData(
                [
                    'version' => '1.0.0',
                    'author' => 'https://dsprog.com',
                    'email' => 'dsprog@dsprog.com'
                ]
            )
            ->build();
    }
}