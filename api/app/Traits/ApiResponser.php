<?php

namespace App\Traits;

trait ApiResponser{

	private function successResponse(array $data = [], int $code = 200)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse(string $message = "", int $code = 500)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}
}