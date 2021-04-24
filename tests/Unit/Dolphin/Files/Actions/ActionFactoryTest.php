<?php


namespace Tests\Unit\Dolphin\Files\Actions;

use App\Dolphin\Files\Actions\ActionFactory;
use App\Dolphin\Files\Actions\UploadAvatarAction;
use App\Dolphin\Files\Models\File;
use App\Dolphin\Files\Repositories\FileRepository;
use App\Dolphin\Files\Requests\StoreFileRequest;
use PHPUnit\Framework\TestCase;

class ActionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_creates_upload_avatar_action()
    {
        $request = new StoreFileRequest(['action' => 'avatar.store']);
        $files = new FileRepository(new File());
        $action = ActionFactory::createStoreAction($request, $files);
        $this->assertInstanceOf(UploadAvatarAction::class, $action);
    }
}
