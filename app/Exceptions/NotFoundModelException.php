<?php

namespace App\Exceptions;

use Exception;

class NotFoundModelException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 404);
    }
}
