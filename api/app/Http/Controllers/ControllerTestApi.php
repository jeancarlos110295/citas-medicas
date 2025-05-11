<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;

class ControllerTestApi extends Controller
{
    use ApiResponser;
    
    public function index()
    {
        return $this->successResponse([
            "message" => "Hello from the API"
        ], 200);
    }
}