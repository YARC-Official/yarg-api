<?php

namespace App\DTO\Auth;

readonly class ResetPasswordDTO
{
    public function __construct(
        public TokenValidationDTO $tokenValidation,
        public string $password
    )
    {
    }

    public function fromRequest(array $payload): self
    {
        return new self(
            tokenValidation: new TokenValidationDTO($payload['token'], $payload['email']),
            password: $payload['password']
        );
    }
}
