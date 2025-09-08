<?php

namespace App\DTO;

class AuthDTO{
    public function __construct(
        public string $email,
        public string $code,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'],
            $data['code']
        );
    }
}