<?php

namespace App\DTO\Auth;

use Illuminate\Support\Facades\Hash;

readonly class RegistrationDTO
{
    public function __construct(
        public string $name,
        public string $username,
        public string $email,
        public string $password
    )
    {
    }

    public static function fromRequest(array $request): self
    {
        return new self(
            name: $request['name'],
            username: $request['username'],
            email: $request['email'],
            password: Hash::make($request['password'])
        );
    }

    public function toDatabase(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
