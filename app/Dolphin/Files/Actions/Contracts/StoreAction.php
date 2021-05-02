<?php

namespace App\Dolphin\Files\Actions\Contracts;

use App\Dolphin\Files\Resources\FileResource;
use App\Dolphin\Http\Action;

interface StoreAction extends Action
{
    /**
     * @inheritDoc
     * @return FileResource
     */
    public function execute(): FileResource;
}
