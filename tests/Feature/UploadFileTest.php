<?php

namespace Tests\Feature;

use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->passportInstall();
    }

    /**
     * @test
     */
    public function test_user_can_upload_an_avatar()
    {
        /** @var User $user */
        $user = User::factory()->create();
        Passport::actingAs($user);

        $disk = config('filesystems.default');
        $width = 15;
        $height = 15;
        Storage::fake($disk);
        $file = UploadedFile::fake()->image('avatar.jpg', $width, $height);

        $data = [
            'action' => 'avatar.store',
            'file' => $file,
        ];

        $uri = route('files.store');
        $response = $this->postJson($uri, $data);

        $filePath = sprintf("avatars/%s", $file->hashName());

        $response->assertStatus(201);
        $response->assertJsonPath('data.path', $filePath);
        $response->assertJsonPath('data.meta_data.width', $width);
        $response->assertJsonPath('data.meta_data.height', $height);
        $response->assertJsonStructure(['data' => ['path', 'url', 'meta_data' => ['width', 'height']]]);

        /** @psalm-suppress UndefinedInterfaceMethod */
        Storage::disk($disk)->assertExists($filePath);

        $this->assertDatabaseHas('files', [
            'user_id' => $user->getId(),
            'path' => $filePath,
        ]);
    }
}
