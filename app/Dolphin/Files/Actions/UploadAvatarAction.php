<?php

namespace App\Dolphin\Files\Actions;

use App\Dolphin\Files\Actions\Contracts\StoreAction;
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
    private $request;

    /**
     * @var FileRepository
     */
    private $avatars;

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
        list($width, $height) = getimagesize($file->getRealPath());
        $path = $file->storePublicly(self::AVATARS_PATH);
        $file = $this->avatars->create([
            'path' => $path,
            'meta_data' => ['width' => $width, 'height' => $height],
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'disk' => config('filesystems.default'),
            'user_id' => $this->request->user()->getId(),
        ]);
        return new FileResource($file);
    }
}
