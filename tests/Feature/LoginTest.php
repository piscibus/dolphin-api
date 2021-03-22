<?php

namespace Tests\Feature;

use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group emailLogin
     */
    public function test_user_can_login_using_email_and_password()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();

        /** @var User $user */
        $user = User::factory()->create();

        $url = route('emailLogin');
        $response = $this->postJson($url, [
            'email' => $user->getEmail(),
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "id", "name", "email",
                "token" => ["access_token", "token_type", "refresh_token", "expires_in"],
            ],
        ]);
    }
}
