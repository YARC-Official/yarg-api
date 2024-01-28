<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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
}
