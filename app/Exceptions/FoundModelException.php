<?php

namespace App\Exceptions;

use Exception;

class FoundModelException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 406);
    }
}
