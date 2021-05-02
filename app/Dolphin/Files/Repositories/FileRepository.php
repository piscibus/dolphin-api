<?php


namespace App\Dolphin\Files\Repositories;

use App\Dolphin\Files\Models\File;

class FileRepository
{
    /**
     * @var File
     */
    private $model;

    /**
     * AvatarRepository constructor.
     * @param  File  $model
     */
    public function __construct(File $model)
    {
        $this->model = $model;
    }

    /**
     * @param  array  $attributes
     * @return File
     */
    public function create(array $attributes): File
    {
        return File::create($attributes);
    }
}
