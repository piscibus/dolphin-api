<?php

namespace App\Http\Controllers\Api;

use App\Dolphin\Files\Actions\ActionFactory;
use App\Dolphin\Files\Repositories\FileRepository;
use App\Dolphin\Files\Requests\StoreFileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    /**
     * @param  StoreFileRequest  $request
     * @param  FileRepository  $files
     * @return JsonResponse
     */
    public function store(StoreFileRequest $request, FileRepository $files): JsonResponse
    {
        $action = ActionFactory::createStoreAction($request, $files);
        $response = $action->execute()->response();
        $response->setStatusCode(201);
        return $response;
    }
}
