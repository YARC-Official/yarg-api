<?php

namespace App\Services;

use App\DTO\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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

    public function sendRecovery(array $credentials): void
    {
        $status = Password::broker(config('fortify.passwords'))
            ->sendResetLink($credentials);

        if ($status !== Password::RESET_LINK_SENT) {
            Log::info('Recovery Alert', [
                'status' => $status,
                'email' => $credentials['email'],
                'ip' => request()->getClientIp()
            ]);
        }
    }

    public function validateToken(string $token, string $email): void
    {
        /** @var User $user */
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$tokenExists) {
            throw ValidationException::withMessages(['token' => 'Invalid Token.']);
        }

        if ($this->tokenExpired($tokenExists->created_at)) {
            throw ValidationException::withMessages(['token' => 'Token Expired.']);
        }

        if (!Hash::check($token, $tokenExists->token)) {
            throw ValidationException::withMessages(['token' => 'Invalid Token.']);
        }
    }

    protected function tokenExpired($createdAt): bool
    {
        return Carbon::parse($createdAt)->addMinutes(config('auth.passwords.users.expire'))->isPast();
    }

    public function resetPassword(array $payload): void
    {
        $this->validateToken($payload['token'], $payload['email']);

        User::query()
            ->where('email', $payload['email'])
            ->update(['password' => Hash::make($payload['password'])]);

        DB::table('password_reset_tokens')
            ->where('email', $payload['email'])
            ->delete();
    }
}
