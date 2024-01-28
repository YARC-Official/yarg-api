<?php

namespace App\Services;

use App\DTO\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $payload): User
    {
        $payload['password'] = Hash::make($payload['password']);

        /** @var User $user */
        return User::query()->create($payload);
    }

    public function authenticate(LoginDTO $payload): array
    {

        /** @var User $user */
        $user = User::query()
            ->where('username', $payload->username)
            ->first();

        $passwordMatch = Hash::check($payload->password, $user->password);

        if (!$passwordMatch) {
            throw ValidationException::withMessages(['authentication' => 'Authentication Denied.']);
        }

        $expiresAt = now()->addWeeks(2);
        $token = $user->createToken(
            name: 'auth',
            expiresAt: $expiresAt
        );

        return [
            'access_token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at,
        ];
    }
}
