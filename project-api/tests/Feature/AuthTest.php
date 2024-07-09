<?php

namespace Tests\Features;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @return void
     */
    public function test_returns_token_on_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'test123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);

        $data = $response->decodeResponseJson();

        $this->assertNotEmpty($data['token']);

        $this->assertAuthenticatedAs($user);
    }
}
