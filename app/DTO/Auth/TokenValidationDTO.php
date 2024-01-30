<?php

namespace App\DTO\Auth;

readonly class TokenValidationDTO
{
    public function __construct(
        public string $token,
        public string $email
    )
    {
    }

}
