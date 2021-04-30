<?php

namespace Tests\Feature;

use App\Dolphin\Files\Models\File;
use App\Dolphin\Users\Models\Profile;
use App\Dolphin\Users\Models\User;
use Database\Factories\FileFactory;
use Database\Factories\ProfileFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ShowProfileTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function test_user_can_show_his_profile()
    {
        $this->withoutExceptionHandling();
        $this->passportInstall();

        /** @var User $user */
        $user = User::factory()->create();
        Passport::actingAs($user);

        /** @var FileFactory $avatarFactory */
        $avatarFactory = File::factory();
        /** @var File $avatar */
        $avatar = $avatarFactory->avatar()->create(['user_id' => $user->getId()]);

        /** @var ProfileFactory $profileFactory */
        $profileFactory = Profile::factory();
        /** @var Profile $profile */
        $profile = $profileFactory->create([
            'user_id' => $user->getId(),
            'avatar_id' => $avatar->getId(),
        ]);

        $uri = route('myProfile');
        $response = $this->getJson($uri);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $profile->getId());
        $response->assertJsonPath('data.user_id', $user->getId());
        $response->assertJsonPath('data.name', $user->getName());
        $response->assertJsonPath('data.avatar', $user->getProfile()->getPublicAvatar());
    }
}
