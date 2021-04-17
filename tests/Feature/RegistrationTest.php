<?php

namespace Tests\Feature;

use App\Dolphin\Passport\Repositories\ClientRepository;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class RegistrationTest
 * @package Tests\Feature
 */
class RegistrationTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @test
     */
    public function test_user_can_register_using_email_and_password()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();

        $faker = Factory::create();
        $email = $faker->email;
        $client = (new ClientRepository())->findPasswordClient();

        $data = [
            'email' => $email,
            'password' => $faker->password,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ];

        $response = $this->postJson(route('emailRegistration'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data" => [
                "id", "name", "email",
                "token" => ["access_token", "token_type", "refresh_token", "expires_in"],
            ],
        ]);

        $this->assertDatabaseHas('users', compact('email'));
    }

    /**
     * @test
     */
    public function test_registration_fails_on_using_invalid_client_credentials()
    {
        $this->passportInstall();

        $email = $this->faker->email;
        $data = [
            'email' => $email,
            'password' => $this->faker->password,
            'name' => $this->faker->name,
            'client_id' => 1,
            'client_secret' => $this->faker->password,
        ];

        $response = $this->postJson(route('emailRegistration'), $data);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('users', ['email' => $email]);
    }
}
