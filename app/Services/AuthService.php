<?php

namespace App\Services;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegistrationDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\DTO\Auth\TokenValidationDTO;
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

    public function register(RegistrationDTO $registrationDTO): User
    {
        /** @var User $user */
        return User::query()->create($registrationDTO->toDatabase());
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

    public function sendRecovery(string $email): void
    {
        $status = Password::broker(config('fortify.passwords'))
            ->sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            Log::info('Recovery Alert', [
                'status' => $status,
                'email' => $email,
                'ip' => request()->getClientIp()
            ]);
        }
    }

    public function validateToken(TokenValidationDTO $tokenValidationDTO): void
    {
        /** @var User $user */
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $tokenValidationDTO->email)
            ->first();

        if (!$tokenExists) {
            throw ValidationException::withMessages(['token' => 'Invalid Token.']);
        }

        if ($this->tokenExpired($tokenExists->created_at)) {
            throw ValidationException::withMessages(['token' => 'Token Expired.']);
        }

        if (!Hash::check($tokenValidationDTO->token, $tokenExists->token)) {
            throw ValidationException::withMessages(['token' => 'Invalid Token.']);
        }
    }

    protected function tokenExpired($createdAt): bool
    {
        return Carbon::parse($createdAt)->addMinutes(config('auth.passwords.users.expire'))->isPast();
    }

    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): void
    {
        $this->validateToken($resetPasswordDTO->tokenValidation);

        User::query()
            ->where('email', $resetPasswordDTO->tokenValidation->email)
            ->update(['password' => Hash::make($resetPasswordDTO->password)]);

        DB::table('password_reset_tokens')
            ->where('email', $resetPasswordDTO->tokenValidation->email)
            ->delete();
    }
}
