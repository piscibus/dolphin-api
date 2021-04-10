<?php

namespace Tests\Feature;

use App\Dolphin\Passport\Repositories\ClientRepository;
use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Throwable;

class RefreshTokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws Throwable
     */
    public function test_user_can_issue_access_token_using_a_refresh_token()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();
        $client = (new ClientRepository())->findPasswordClient();

        /** @var User $user */
        $user = User::factory()->create();
        $loginResponse = $this->postJson(route('emailLogin'), [
            'email' => $user->getEmail(),
            'password' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ])->decodeResponseJson();
        $token = $loginResponse['data']['token'];
        $refreshToken = $token['refresh_token'];

        $uri = route('refreshToken');
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '',
        ];
        $response = $this->postJson($uri, $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "token_type",
            "expires_in",
            "access_token",
            "refresh_token"
        ]);
    }
}
