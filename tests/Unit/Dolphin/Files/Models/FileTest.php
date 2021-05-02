<?php


namespace Tests\Unit\Dolphin\Files\Models;

use App\Dolphin\Files\Models\File;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_get_fake_url_in_unit_testing_and_local_environment()
    {
        $file = new File();
        $file->setPath('remote/path/file.ext');
        $this->assertEquals(asset(File::DEV_AVATAR_ASSET), $file->getUrl());
    }
}
