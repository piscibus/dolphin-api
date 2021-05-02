<?php

namespace Tests\Unit\Dolphin\Files\Requests;

use App\Dolphin\Files\Actions\UploadAvatarAction;
use App\Dolphin\Files\Requests\StoreFileRequest;
use PHPUnit\Framework\TestCase;

class StoreFileRequestTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_get_upload_avatar_action()
    {
        $request = new StoreFileRequest(['action' => 'avatar.store']);
        $this->assertEquals(UploadAvatarAction::class, $request->getAction());
    }
}
