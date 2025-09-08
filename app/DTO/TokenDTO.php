<?php

namespace App\DTO;

use App\Models\Music;

class TokenDTO{
    public function __construct(
        public string $token,
    ){}
}