<?php

namespace App\DTO\Auth;

class LoginDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $password
    ) {
    }

    public static function fromRequest(array $request): self
    {
        return new self(
            username: $request['username'],
            password: $request['password']
        );
    }
}
