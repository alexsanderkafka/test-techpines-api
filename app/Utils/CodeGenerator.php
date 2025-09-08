<?php

namespace App\Utils;

class CodeGenerator
{
    private static string $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    private static int $codeLength = 5;

    public static function generateCode(): string{
        $code = "";

        $maxIndex = strlen(self::$characters) - 1;

        for($i = 0; $i < self::$codeLength; $i++){
            $index = random_int(0, $maxIndex);  
            $code .= self::$characters[$index];
        }

        return $code;
    }
}