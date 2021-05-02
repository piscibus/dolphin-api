<?php


namespace App\Dolphin\Files\Actions;

use App\Dolphin\Files\Actions\Contracts\StoreAction;
use App\Dolphin\Files\Repositories\FileRepository;
use App\Dolphin\Files\Requests\StoreFileRequest;

class ActionFactory
{
    /**
     * @param  StoreFileRequest  $request
     * @param  FileRepository  $files
     * @return StoreAction
     */
    public static function createStoreAction(StoreFileRequest $request, FileRepository $files): StoreAction
    {
        $class = $request->getAction();
        return new $class($request, $files);
    }
}
