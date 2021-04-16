<?php

namespace Tests\Feature;

use App\Dolphin\Users\Actions\User\Logout;
use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function test_user_can_logout()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();

        /** @var User $user */
        $user = User::factory()->create();
        $accessToken = $user->issueAccessToken();

        $uri = route('logout');
        $response = $this->postJson($uri, [], ['Authorization' => sprintf('Bearer %s', $accessToken->accessToken)]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertSee(Logout::LOGGED_OUT_MESSAGE);
        $this->assertDatabaseHas('oauth_access_tokens', [
            'id' => $accessToken->token->id,
            'revoked' => true,
        ]);
    }
}
