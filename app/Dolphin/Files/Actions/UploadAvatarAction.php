<?php

namespace App\Dolphin\Files\Actions;

use App\Dolphin\Files\Actions\Contracts\StoreAction;
use App\Dolphin\Files\Models\File;
use App\Dolphin\Files\Repositories\FileRepository;
use App\Dolphin\Files\Requests\StoreFileRequest;
use App\Dolphin\Files\Resources\FileResource;
use App\Dolphin\Http\Action;

class UploadAvatarAction implements Action, StoreAction
{
    private const AVATARS_PATH = 'avatars';

    /**
     * @var StoreFileRequest
     */
    private StoreFileRequest $request;

    /**
     * @var FileRepository
     */
    private FileRepository $avatars;

    /**
     * UploadAvatarAction constructor.
     * @param  StoreFileRequest  $request
     * @param  FileRepository  $avatars
     */
    public function __construct(StoreFileRequest $request, FileRepository $avatars)
    {
        $this->request = $request;
        $this->avatars = $avatars;
    }

    /**
     * Executes the requested action
     *
     * @return FileResource
     */
    public function execute(): FileResource
    {
        $file = $this->request->getFile();
        $path = $this->upload();
        $file = $this->avatars->create([
            'path' => $path,
            'meta_data' => $this->getMetaData(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'disk' => config('filesystems.default'),
            'user_id' => $this->request->user()->getId(),
        ]);
        return new FileResource($file);
    }

    /**
     * @return array
     */
    private function getMetaData(): array
    {
        $file = $this->request->getFile();
        list($width, $height) = getimagesize($file->getRealPath());
        return compact('width', 'height');
    }

    /**
     * @return string
     */
    private function upload(): string
    {
        if ($this->shouldUpload()) {
            return (string) $this->request->getFile()->storePublicly(self::AVATARS_PATH);
        }
        return File::DEV_AVATAR_ASSET;
    }

    /**
     * @return bool
     */
    private function shouldUpload(): bool
    {
        return config('app.env') !== 'local';
    }
}
