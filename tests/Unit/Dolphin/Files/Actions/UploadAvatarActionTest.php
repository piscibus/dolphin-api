<?php

namespace Tests\Unit\Dolphin\Files\Actions;

use App\Dolphin\Files\Actions\UploadAvatarAction;
use App\Dolphin\Files\Models\File;
use App\Dolphin\Files\Repositories\FileRepository;
use App\Dolphin\Files\Requests\StoreFileRequest;
use App\Dolphin\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadAvatarActionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function test_it_fakes_upload_if_running_on_local_environment()
    {
        Storage::fake();
        $user = User::factory()->create();

        $request = new StoreFileRequest([], [], [], [], ['file' => UploadedFile::fake()->image('avatar.jpg')]);
        $request->setUserResolver(fn() => $user);

        $file = new File();
        $files = new FileRepository($file);
        $action = new UploadAvatarAction($request, $files);

        $resource = $action->execute();
        $body = $resource->toArray($request);

        $this->assertEquals(asset(File::DEV_AVATAR_ASSET), $body['url']);
    }
}
