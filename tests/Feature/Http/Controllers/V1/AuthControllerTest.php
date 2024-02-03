<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function test_can_register(): void
    {
        $payload = [
            'name' => 'Daniel Reis',
            'username' => 'danielreis',
            'password' => 'fodase123',
            'password_confirmation' => 'fodase123',
            'email' => 'danielreis@gmail.com',
        ];

        $this->postJson(route('v1.auth.register'), $payload)
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseHas(User::class, [
            'username' => $payload['username'],
            'email' => $payload['email']
        ]);
    }

    public function test_can_authenticate(): void
    {
        // arrange
        $user = User::factory()->create();

        $payload = [
            'username' => $user->username,
            'password' => 'follow-me-on-twitch'
        ];

        // act
        $response = $this->postJson(route('v1.auth.login'), $payload);

        // assert
        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'expires_at'
            ]);

    }

    public function test_can_send_recovery_account_email(): void
    {
        $user = User::factory()->create();

        $payload = ['email' => $user->email];

        $response = $this->postJson(route('v1.auth.recovery'), $payload);

        $response->assertNoContent();

        $this->assertDatabaseHas('password_reset_tokens', $payload);
    }

    public function test_should_log_recovery_with_wrong_credentials()
    {

        $payload = ['email' => 'danielreis@gmail.com'];

        $response = $this->postJson(route('v1.auth.recovery'), $payload);

        $response->assertNoContent();

        $this->assertDatabaseMissing('password_reset_tokens', $payload);

//        Log::shouldReceive('info')
//            ->once()
//            ->with('Recovery Alert', [
//                'status' => 'passwords.user',
//                'email' => $payload['email'],
//                'ip' => request()->getClientIp()
//            ]);
    }

    public function test_validation_of_reset_token(): void
    {
        Notification::fake();
        /** @var User $user */
        $user = User::factory()->create();

        $this->postJson(route('v1.auth.recovery'), [
            'email' => $user->getEmailForVerification()
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
            $response = $this->getJson(route('v1.auth.validate-token', [
                'token' => $notification->token,
                'email' => $user->getEmailForVerification()
            ]));

            $response->assertNoContent();

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->postJson(route('v1.auth.recovery'), [
            'email' => $user->getEmailForVerification()
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
            $response = $this->postJson(route('v1.auth.reset-password'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertNoContent();

            $this->assertDatabaseMissing('users', [
                'id' => $user->getKey(),
                'password' => $user->password
            ]);

            $this->assertDatabaseMissing('password_reset_tokens', [
                'email' => $user->getEmailForVerification()
            ]);

            return true;
        });
    }
}
