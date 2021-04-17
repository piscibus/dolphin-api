<?php

namespace Tests\Feature;

use App\Dolphin\Users\Actions\User\Logout;
use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Laravel\Passport\PersonalAccessTokenResult;
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

    /**
     * @test
     */
    public function test_user_can_logout_from_all_other_devices()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();

        /** @var User $user */
        $user = User::factory()->create();
        $tokens = new Collection();
        for ($i = 0; $i < 3; $i++) {
            $tokens->add($user->issueAccessToken());
        }
        $accessToken = $user->issueAccessToken();

        $uri = route('logout');
        $response = $this->postJson($uri, [
            'other_devices' => 'true'
        ], ['Authorization' => sprintf('Bearer %s', $accessToken->accessToken)]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);

        /** @var PersonalAccessTokenResult $token */
        foreach ($tokens as $token) {
            $this->assertDatabaseHas('oauth_access_tokens', [
                'id' => $token->token->id,
                'revoked' => true,
            ]);
        }

        $this->assertDatabaseHas('oauth_access_tokens', [
            'id' => $accessToken->token->id,
            'revoked' => false,
        ]);
    }
}
