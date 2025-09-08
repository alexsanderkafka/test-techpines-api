<?php

namespace App\Exceptions;

use Exception;

class InvalidCodeException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 403);
    }
}
