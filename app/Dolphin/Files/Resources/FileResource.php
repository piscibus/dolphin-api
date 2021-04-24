<?php


namespace App\Dolphin\Files\Resources;

use App\Dolphin\Files\Models\File;
use App\Dolphin\Http\Resource;

/**
 * Class FileResource
 * @package App\Dolphin\Files\Resources
 * @mixin File
 */
class FileResource extends Resource
{
    /**
     * Handles the resource transformation into an array
     *
     * @param $request
     * @return array
     */
    protected function handle($request): array
    {
        return [
            'path' => $this->getPath(),
            'url' => $this->getUrl(),
            'meta_data' => $this->getMetaData(),
        ];
    }
}
